<?php
/**
 * The model file of common module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     common
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class commonModel extends model
{
    /**
     * Do some init functions.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->startSession();
        $this->setUser();
        $this->loadConfigFromDB();
    }

    /**
     * Load configs from database and save it to config->system and config->personal.
     * 
     * @access public
     * @return void
     */
    public function loadConfigFromDB()
    {
        /* Get configs of system and current user. */
        $account = isset($this->app->user->account) ? $this->app->user->account : '';
        if($this->config->db->name) $config  = $this->loadModel('setting')->getSysAndPersonalConfig($account);
        $this->config->system   = isset($config['system']) ? $config['system'] : array();
        $this->config->personal = isset($config[$account]) ? $config[$account] : array();

        /* Overide the items defined in config/config.php and config/my.php. */
        if(isset($this->config->system->common))
        {
            foreach($this->config->system->common as $record)
            {   
                if($record->section)
                {
                    if(!isset($this->config->{$record->section})) $this->config->{$record->section} = new stdclass();
                    if($record->key) $this->config->{$record->section}->{$record->key} = $record->value;
                }
                else
                {
                    if(!$record->section) $this->config->{$record->key} = $record->value;
                }
            }
        }
    }

    /**
     * Start the session.
     * 
     * @access public
     * @return void
     */
    public function startSession()
    {
        $sessionName = $this->config->sessionVar;
        session_name($sessionName);
        session_start();

        /* Check the user's IP exclude guest. */
        if(isset($_SESSION['user']) and $this->session->user->account != 'guest' and $this->session->user->ip != $this->server->remote_addr)
        {
            session_destroy();
            $referer  = helper::safe64Encode($this->app->getURI(true));
            die(js::locate(helper::createLink('user', 'login', "referer=$referer")));
        }
    }

    /**
     * Check the priviledge.
     * 
     * @access public
     * @return void
     */
    public function checkPriv()
    {
        $module = $this->app->getModuleName();
        $method = $this->app->getMethodName();

        if($this->isOpenMethod($module, $method)) return true;

        /* If no $app->user yet, go to the login pae. */
        if($this->app->user->account == 'guest')
        {
            $referer  = helper::safe64Encode($this->app->getURI(true));
            die(js::locate(helper::createLink('user', 'login', "referer=$referer")));
        }

        /* Check the priviledge. */
        if(!commonModel::hasPriv($module, $method)) $this->deny($module, $method);
    }

    /**
     * Check current user has priviledge to the module's method or not.
     * 
     * @param mixed $module     the module
     * @param mixed $method     the method
     * @static
     * @access public
     * @return bool
     */
    public static function hasPriv($module, $method)
    {
        global $app, $config;
        if($app->user->admin == 'super') return true;

        if(RUN_MODE == 'admin')
        {
            if($app->user->admin != 'super') return false;
        }

        $rights  = $app->user->rights;
        if(isset($rights[strtolower($module)][strtolower($method)])) return true;
        return false;
    }

    /**
     * Show the deny info.
     * 
     * @param mixed $module     the module
     * @param mixed $method     the method
     * @access public
     * @return void
     */
    public function deny($module, $method)
    {
        if(helper::isAjaxRequest()) exit;
        $vars = "module=$module&method=$method";
        if(isset($_SERVER['HTTP_REFERER']))
        {
            $referer  = helper::safe64Encode($_SERVER['HTTP_REFERER']);
            $vars .= "&referer=$referer";
        }
        $denyLink = helper::createLink('user', 'deny', $vars);
        die(js::locate($denyLink));
    }

    /** 
     * Judge a method of one module is open or not?
     * 
     * @param  string $module 
     * @param  string $method 
     * @access public
     * @return bool
     */
    public function isOpenMethod($module, $method)
    {   
        if($module == 'user' and strpos(',login|logout|deny|resetpassword|checkresetkey', $method)) return true;
        if($module == 'api'  and $method == 'getsessionid') return true;
        if($module == 'misc'  and $method == 'ping') return true;
        if($module == 'sso'  and strpos(',auth|check', $method)) return true;

        if($this->loadModel('user')->isLogon() and stripos($method, 'ajax') !== false) return true;

        return false;
    }   

    /**
     * Create the main menu.
     * 
     * @param  string $currentModule 
     * @static
     * @access public
     * @return string
     */
    public static function createMainMenu($currentModule)
    {
        global $app, $lang;

        /* Set current module. */
        if(isset($lang->menuGroups->$currentModule)) $currentModule = $lang->menuGroups->$currentModule;

        $string = "<ul class='nav navbar-nav'>\n";

        /* Print all main menus. */
        foreach($lang->menu->{$app->appName} as $moduleName => $moduleMenu)
        {
            $class = $moduleName == $currentModule ? " class='active'" : '';
            list($label, $module, $method, $vars) = explode('|', $moduleMenu);

            if(commonModel::hasPriv($module, $method))
            {
                $link  = helper::createLink($module, $method, $vars);
                $string .= "<li$class><a href='$link'>$label</a></li>\n";
            }
        }

        $string .= "</ul>\n";
        return $string;
    }

    /**
     * Create the module menu.
     * 
     * @param  string $currentModule 
     * @static
     * @access public
     * @return void
     */
    public static function createModuleMenu($currentModule)
    {
        global $lang, $app;

        if(!isset($lang->$currentModule->menu)) return false;

        $string = "<ul class='nav nav-primary nav-stacked leftmenu affix'>\n";

        /* Get menus of current module and current method. */
        $moduleMenus   = $lang->$currentModule->menu;  
        $currentMethod = $app->getMethodName();

        /* Cycling to print every menus of current module. */
        foreach($moduleMenus as $methodName => $methodMenu)
        {
            if(is_array($methodMenu)) 
            {
                $methodAlias = $methodMenu['alias'];
                $methodLink  = $methodMenu['link'];
            }
            else
            {
                $methodAlias = '';
                $methodLink  = $methodMenu;
            }

            /* Split the methodLink to label, module, method, vars. */
            list($label, $module, $method, $vars) = explode('|', $methodLink);
            $label .= '<i class="icon-chevron-right"></i>';

            if(commonModel::hasPriv($module, $method))
            {
                $class = '';
                if($module == $currentModule && $method == $currentMethod) $class = " class='active'";
                if($module == $currentModule && strpos($methodAlias, $currentMethod) !== false) $class = " class='active'";
                $string .= "<li{$class}>" . html::a(helper::createLink($module, $method, $vars), $label) . "</li>\n";
            }
        }

        $string .= "</ul>\n";
        return $string;
    }

    /**
     * Create menu for managers.
     * 
     * @access public
     * @return string
     */
    public static function createManagerMenu()
    {
        global $app, $lang , $config;

        $string  = '<ul class="nav navbar-nav navbar-right">';
        $string .= sprintf('<li>%s</li>', html::a($config->webRoot, '<i class="icon-home icon-large"></i> ' . $lang->frontHome, "target='_blank' class='navbar-link'"));
        $string .= sprintf('<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user icon-large"></i> %s <b class="caret"></b></a>', $app->user->realname);
        $string .= sprintf('<ul class="dropdown-menu"><li>%s</li><li>%s</li></ul>', html::a(helper::createLink('user', 'changePassword'), $lang->changePassword, "data-toggle='modal'"), html::a(helper::createLink('user','logout'), $lang->logout));
        $string .= '</li></ul>';

        return $string;
    }

    /**
     * Print the link contains orderBy field.
     *
     * This method will auto set the orderby param according the params. For example, if the order by is desc,
     * will be changed to asc.
     *
     * @param  string $fieldName    the field name to sort by
     * @param  string $orderBy      the order by string
     * @param  string $vars         the vars to be passed
     * @param  string $label        the label of the link
     * @param  string $module       the module name
     * @param  string $method       the method name
     * @static
     * @access public
     * @return void
     */
    public static function printOrderLink($fieldName, $orderBy, $vars, $label, $module = '', $method = '')
    {
        global $lang, $app;
        if(empty($module)) $module = $app->getModuleName();
        if(empty($method)) $method = $app->getMethodName();
        $className = 'header';

        if(strpos($orderBy, $fieldName) !== false)
        {
            if(stripos($orderBy, 'desc') !== false)
            {
                $orderBy   = str_ireplace('desc', 'asc', $orderBy);
                $className = 'headerSortUp';
            }
            elseif(stripos($orderBy, 'asc')  !== false)
            {
                $orderBy = str_ireplace('asc', 'desc', $orderBy);
                $className = 'headerSortDown';
            }
        }
        else
        {
            $orderBy   = $fieldName . '_' . 'asc';
            $className = 'header';
        }

        $link = helper::createLink($module, $method, sprintf($vars, $orderBy));
        echo "<div class='$className'>" . html::a($link, $label) . '</div>';
    }

    /**
     * Set the user info.
     * 
     * @access public
     * @return void
     */
    public function setUser()
    {
        if($this->session->user) return $this->app->user = $this->session->user;

        /* Create a guest account. */
        $user           = new stdclass();
        $user->id       = 0;
        $user->account  = 'guest';
        $user->realname = 'guest';
        $user->admin    = RUN_MODE == 'cli' ? 'super' : 'no';
        $user->rights   = $this->config->rights->guest;

        $this->session->set('user', $user);
        $this->app->user = $this->session->user;
    }

    /**
     * Get the run info.
     * 
     * @param mixed $startTime  the start time of this execution
     * @access public
     * @return array    the run info array.
     */
    public function getRunInfo($startTime)
    {
        $info['timeUsed'] = round(getTime() - $startTime, 4) * 1000;
        $info['memory']   = round(memory_get_peak_usage() / 1024, 1);
        $info['querys']   = count(dao::$querys);
        return $info;
    }

    /**
     * Print top bar.
     * 
     * @static
     * @access public
     * @return void
     */
    public static function printTopBar()
    {
        global $lang, $app;

        printf($lang->todayIs, date(DT_DATE4));
        if(isset($app->user)) echo $app->user->realname . ' ';
        if(isset($app->user) and $app->user->account != 'guest')
        {
            echo html::a(helper::createLink('user', 'logout'), $lang->logout);
        }
        else
        {
            echo html::a(helper::createLink('user', 'login'), $lang->login);
        }

        echo '&nbsp;|&nbsp; ';
        echo html::a(helper::createLink('misc', 'about'), $lang->aboutZenTao, '', "class='about'");
        echo $lang->agileTraining;
        echo $lang->donate;

        echo '&nbsp;|&nbsp;';
        echo html::select('', $app->config->langs, $app->cookie->lang,  'onchange="selectLang(this.value)"');
        echo html::select('', $app->lang->themes,  $app->cookie->theme, 'onchange="selectTheme(this.value)"');
    }

    /**
     * Print the main menu.
     * 
     * @param  string $moduleName 
     * @static
     * @access public
     * @return void
     */
    public static function printMainmenu($moduleName, $methodName = '')
    {
        global $app, $lang;
        echo "<ul>\n";
 
        /* Set the main main menu. */
        $mainMenu = $moduleName;
        if(isset($lang->menugroup->$moduleName)) $mainMenu = $lang->menugroup->$moduleName;

        $activeName = $app->getViewType() == 'mhtml' ? 'ui-btn-active' : 'active';

        /* Print all main menus. */
        foreach($lang->menu->{$app->appName} as $menuKey => $menu)
        {
            $active = $menuKey == $mainMenu ? "class='$activeName'" : '';
            $link = explode('|', $menu);
            list($menuLabel, $module, $method) = $link;
            $vars = isset($link[3]) ? $link[3] : '';

            if(commonModel::hasPriv($module, $method))
            {
                $link  = helper::createLink($module, $method, $vars);
                echo "<li $active><a href='$link' $active id='menu$menuKey'>$menuLabel</a></li>\n";
            }
        }

    }

    /**
     * Print the search box.
     * 
     * @static
     * @access public
     * @return void
     */
    public static function printSearchBox()
    {
        global $app, $lang;
        $moduleName  = $app->getModuleName();
        $methodName  = $app->getMethodName();
        $searchObject = $moduleName;

        if($moduleName == 'product')
        {
            if($methodName == 'browse') $searchObject = 'story';
        }
        elseif($moduleName == 'project')
        {
            if(strpos('task|story|bug|build', $methodName) !== false) $searchObject = $methodName;
        }
        elseif($moduleName == 'my' or $moduleName == 'user')
        {
            $searchObject = $methodName;
        }

        echo "<li id='searchbox'>"; 
        echo html::select('searchType', $lang->searchObjects, $searchObject);
        echo html::input('searchQuery', $lang->searchTips, "onclick=this.value='' onkeydown='if(event.keyCode==13) shortcut()' class='w-80px'");
		echo "<a href='javascript:shortcut();return false;' id='objectSwitcher' class='icon-circle-arrow-right'></a>";
        echo "</li>";
        echo "</ul>\n";
    }

    /**
     * Print the module menu.
     * 
     * @param  string $moduleName 
     * @static
     * @access public
     * @return void
     */
    public static function printModuleMenu($moduleName)
    {
        global $lang, $app;

        if(!isset($lang->$moduleName->menu)) {echo "<ul></ul>"; return;}

        /* Get the sub menus of the module, and get current module and method. */
        $submenus      = $lang->$moduleName->menu;  
        $currentModule = $app->getModuleName();
        $currentMethod = $app->getMethodName();

        /* Sort the subMenu according to menuOrder. */
        if(isset($lang->$moduleName->menuOrder))
        {
            $menus = $submenus;
            $submenus = new stdclass();

            ksort($lang->$moduleName->menuOrder, SORT_ASC);
            if(isset($menus->list)) 
            {
                $submenus->list = $menus->list; 
                unset($menus->list);
            }
            foreach($lang->$moduleName->menuOrder as $order)  
            {
                if(($order != 'list') && isset($menus->$order))
                {
                    $subOrder = $menus->$order;
                    unset($menus->$order);
                    $submenus->$order = $subOrder;
                }
            }
            foreach($menus as $key => $menu)
            {
                $submenus->$key = $menu; 
            }
        }

        /* The beginning of the menu. */
        echo "<ul>\n";

        /* Cycling to print every sub menus. */
        foreach($submenus as $subMenuKey => $submenu)
        {
            /* Init the these vars. */
            $link      = $submenu;
            $subModule = '';
            $alias     = '';
            $float     = '';
            $active    = '';
            $target    = '';

            if(is_array($submenu)) extract($submenu);   // If the sub menu is an array, extract it.

            /* Print the menu. */
            if(strpos($link, '|') === false)
            {
                echo "<li>$link</li>\n";
            }
            else
            {
                $link = explode('|', $link);
                list($label, $module, $method) = $link;
                $vars = isset($link[3]) ? $link[3] : '';
                if(commonModel::hasPriv($module, $method))
                {
                    /* Is the currentModule active? */
                    $subModules = explode(',', $subModule);
                    if(in_array($currentModule,$subModules) and $float != 'right') $active = 'active';
                    if($module == $currentModule and ($method == $currentMethod or strpos(",$alias,", ",$currentMethod,") !== false) and $float != 'right') $active = 'active';
                    echo "<li class='$float $active'>" . html::a(helper::createLink($module, $method, $vars), $label, $target, "id=submenu$subMenuKey") . "</li>\n";
                }
            }
        }
        echo "</ul>\n";
    }

    /**
     * Print the bread menu.
     * 
     * @param  string $moduleName 
     * @param  string $position 
     * @static
     * @access public
     * @return void
     */
    public static function printBreadMenu($moduleName, $position)
    {
        global $lang;
        $mainMenu = $moduleName;
        if(isset($lang->menugroup->$moduleName)) $mainMenu = $lang->menugroup->$moduleName;
        echo html::a(helper::createLink('my', 'index'), $lang->zentaoPMS) . $lang->arrow;
        if($moduleName != 'index')
        {
            if(!isset($lang->menu->$mainMenu)) return;
            list($menuLabel, $module, $method) = explode('|', $lang->menu->$mainMenu);
            echo html::a(helper::createLink($module, $method), $menuLabel);
        }
        else
        {
            echo $lang->index->common;
        }
        if(empty($position)) return;
        echo $lang->arrow;
        foreach($position as $key => $link)
        {
            echo $link;
            if(isset($position[$key + 1])) echo $lang->arrow;
        }
    }

    /**
     * Print the link for notify file.
     * 
     * @static
     * @access public
     * @return void
     */
    public static function printNotifyLink()
    {
        if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)
        {
            global $app, $lang;
            $notifyFile = $app->getBasePath() . 'www/data/notify/notify.zip';

            if(!file_exists($notifyFile)) return false;
            echo html::a(helper::createLink('misc', 'downNotify'), $lang->downNotify);
        }
    }

    /**
     * Get the full url of the system.
     * 
     * @static
     * @access public
     * @return string
     */
    public static function getSysURL()
    {
        global $config;
        $httpType = isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == 'on' ? 'https' : 'http';
        $httpHost = $_SERVER['HTTP_HOST'];
        return "$httpType://$httpHost";
    }

    /**
     * Get client IP.
     * 
     * @access public
     * @return void
     */
    public function getIP()
    {
        if(getenv("HTTP_CLIENT_IP"))
        {
            $ip = getenv("HTTP_CLIENT_IP");
        }
        elseif(getenv("HTTP_X_FORWARDED_FOR"))
        {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        }
        elseif(getenv("REMOTE_ADDR"))
        {
            $ip = getenv("REMOTE_ADDR");
        }
        else
        {
            $ip = "Unknow";
        }

        return $ip;
    }

    /**
     * Create front link for admin MODEL.
     *
     * @param string       $module
     * @param string       $method
     * @param string|array $vars
     * @param string|array $alias
     * return string 
     */
    public static function createFrontLink($module, $method, $vars = '', $alias = '')
    {
        if(RUN_MODE == 'front') return helper::createLink($module, $method, $vars, $alias);

        global $config;

        $config->requestType = $config->frontRequestType;
        $link = helper::createLink($module, $method, $vars, $alias);
        $link = str_replace('admin.php', 'index.php', $link);
        $config->requestType = 'GET';

        return $link;
    }
}
