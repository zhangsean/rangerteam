<?php
/**
 * The model file of mail module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     setting
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php
class settingModel extends model
{
    //-------------------------------- methods for get, set and delete setting items. ----------------------------//
    
    /**
     * Get value of an item.
     * 
     * @param  string   $paramString    see parseItemParam();
     * @access public
     * @return misc
     */
    public function getItem($paramString)
    {
        return $this->createDAO($this->parseItemParam($paramString), 'select')->fetch('value');
    }

    /**
     * Get some items.
     * 
     * @param  string   $paramString    see parseItemParam();
     * @access public
     * @return array
     */
    public function getItems($paramString)
    {
        return $this->createDAO($this->parseItemParam($paramString), 'select')->fetchAll('id');
    }

    /**
     * Set value of an item. 
     * 
     * @param  string      $path     system.sys.common.global.sn or system.sys.common.sn 
     * @param  string      $value 
     * @access public
     * @return void
     */
    public function setItem($path, $value = '')
    {
        $level   = substr_count($path, '.');
        $section = '';
        if($level <= 2) return false;
        if($level == 3) list($owner, $app, $module, $key) = explode('.', $path);
        if($level == 4) list($owner, $app, $module, $section, $key) = explode('.', $path);

        $item = new stdclass();
        $item->owner   = $owner;
        $item->app     = $app;
        $item->module  = $module;
        $item->section = $section;
        $item->key     = $key;
        $item->value   = $value;

        $this->dao->replace(TABLE_CONFIG)->data($item)->exec();
    }

    /**
     * Batch set items, the example:
     * 
     * $path = 'system.mail';
     * $items->turnon = true;
     * $items->smtp->host = 'localhost';
     *
     * @param  string         $path   like system.sys.mail 
     * @param  array|object   $items  the items array or object, can be mixed by one level or two levels.
     * @access public
     * @return bool
     */
    public function setItems($path, $items)
    {
        foreach($items as $key => $item)
        {
            if(is_array($item) or is_object($item))
            {
                $section = $key;
                foreach($item as $subKey => $subItem)
                {
                    $this->setItem($path . '.' . $section . '.' . $subKey, $subItem);
                }
            }
            else
            {
                $this->setItem($path . '.' . $key, $item);
            }
        }

        if(!dao::isError()) return true;
        return false;
    }

    /**
     * Delete items.
     * 
     * @param  string   $paramString    see parseItemParam();
     * @access public
     * @return void
     */
    public function deleteItems($paramString)
    {
        $this->createDAO($this->parseItemParam($paramString), 'delete')->exec();
    }

    /**
     * Parse the param string for select or delete items.
     * 
     * @param  string    $paramString     owner=xxx&app=sys&module=common&key=sn and so on.
     * @access public
     * @return array
     */
    public function parseItemParam($paramString)
    {
        /* Parse the param string into array. */
        parse_str($paramString, $params); 

        /* Init fields not set in the param string. */
        $fields = 'owner,app,module,section,key';
        $fields = explode(',', $fields);
        foreach($fields as $field) if(!isset($params[$field])) $params[$field] = '';

        return $params;
    }

    /**
     * Create a DAO object to select or delete one or more records.
     * 
     * @param  array  $params     the params parsed by parseItemParam() method.
     * @param  string $method     select|delete.
     * @access public
     * @return object
     */
    public function createDAO($params, $method = 'select')
    {
        return $this->dao->$method('*')->from(TABLE_CONFIG)->where('1 = 1')
            ->beginIF($params['owner'])->andWhere('owner')->in($params['owner'])->fi()
            ->beginIF($params['app'])->andWhere('app')->in($params['app'])->fi()
            ->beginIF($params['module'])->andWhere('module')->in($params['module'])->fi()
            ->beginIF($params['section'])->andWhere('section')->in($params['section'])->fi()
            ->beginIF($params['key'])->andWhere('`key`')->in($params['key'])->fi();
    }

    /**
     * Get config of system and one user.
     *
     * @param  string $account 
     * @access public
     * @return array
     */
    public function getSysAndPersonalConfig($account = '')
    {
        $owner   = 'system,' . ($account ? $account : '');
        $app     = 'sys,' . $this->app->getAppName();
        $records = $this->dao->select('*')->from(TABLE_CONFIG)
            ->where('owner')->in($owner)
            ->andWhere('app')->in($app)
            ->orderBy('id')
            ->fetchAll('id');
        if(!$records) return array();

        /* Group records by owner and module. */
        $config = array();
        foreach($records as $record)
        {
            if(!isset($record->module)) return array();    // If no module field, return directly.
            if(empty($record->module)) continue;

            if(!isset($config[$record->owner])) $config[$record->owner] = new stdclass();
            if(!isset($config[$record->owner]->{$record->module})) $config[$record->owner]->{$record->module} = new stdclass();
            if($record->section)
            {
                if(!isset($config[$record->owner]->{$record->module}->{$record->section})) $config[$record->owner]->{$record->module}->{$record->section} = new stdclass();
                $config[$record->owner]->{$record->module}->{$record->section}->{$record->key} = $record;
            }
            else
            {
                $config[$record->owner]->{$record->module}->{$record->key} = $record;
            }
        }
        return $config;
    }

    //-------------------------------- methods for version and sn. ----------------------------//
   
    /**
     * Get the version of current zentaopms.
     * 
     * Since the version field not saved in db. So if empty, return 1.1.
     *
     * @access public
     * @return void
     */
    public function getVersion()
    {
        $version = isset($this->config->global->version) ? $this->config->global->version : '1.1';    // No version, set as 1.0.
        return $version;
    }

    /**
     * Update version 
     * 
     * @param  string    $version 
     * @access public
     * @return void
     */
    public function updateVersion($version)
    {
        return $this->setItem('system.sys.common.global.version', $version);
    }
}
