<?php
/**
 * The model file of webapp module of ZenTaoCMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Yidong Wang <Yidong@cnezsoft.com>
 * @package     webapp
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class webappModel extends model
{

    /**
     * The api agent(use snoopy).
     * 
     * @var object   
     * @access public
     */
    public $agent;

    /**
     * The api root.
     * 
     * @var string
     * @access public
     */
    public $apiRoot;

    /**
     * The construct function.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setAgent();
        $this->setApiRoot();
        $this->loadModel('tree');
    }

    /**
     * Set the api agent.
     * 
     * @access public
     * @return void
     */
    public function setAgent()
    {
        $this->agent = $this->app->loadClass('snoopy');
    }

    /**
     * Set the apiRoot.
     * 
     * @access public
     * @return void
     */
    public function setApiRoot()
    {
        $this->apiRoot = $this->config->webapp->apiRoot;
    }

    /**
     * Fetch data from an api.
     * 
     * @param  string    $url 
     * @access public
     * @return mixed
     */
    public function fetchAPI($url)
    {
        $url .= '?lang=' . str_replace('-', '_', $this->app->getClientLang());
        $this->agent->fetch($url);
        $result = json_decode($this->agent->results);

        if(!isset($result->status)) return false;
        if($result->status != 'success') return false;
        if(isset($result->data) and md5($result->data) != $result->md5) return false;
        if(isset($result->data)) return json_decode($result->data);
    }

    /**
     * Get webapp modules from the api.
     * 
     * @access public
     * @return string|bool
     */
    public function getModulesByAPI()
    {
        $requestType = $this->config->requestType;
        $webRoot     = helper::safe64Encode($this->config->webRoot . $this->app->appName . '/');
        $apiURL      = $this->apiRoot . 'apiGetmodules-' . $requestType . '-' . $webRoot . '.json';
        $data = $this->fetchAPI($apiURL);
        if(isset($data->modules)) return $data->modules;
        return false;
    }

    /**
     * Get webapps by some condition.
     * 
     * @param  string    $type 
     * @param  mixed     $param 
     * @access public
     * @return array|bool
     */
    public function getAppsByAPI($type, $param, $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $apiURL = $this->apiRoot . "apiGetApps-$type-$param-$recTotal-$recPerPage-$pageID.json";
        $data   = $this->fetchAPI($apiURL);
        return $data;
    }

    /**
     * Get a app info by API 
     * 
     * @param  int    $webappID 
     * @access public
     * @return void
     */
    public function getAppInfoByAPI($webappID)
    {
        $apiURL = $this->apiRoot . "apiGetAppInfo-$webappID.json";
        $data   = $this->fetchAPI($apiURL);
        return $data;
    }

    /**
     * Add downloads of webapp by api.
     * 
     * @param  int    $webappID 
     * @access public
     * @return void
     */
    public function addDownloadByAPI($webappID)
    {
        $apiURL = $this->apiRoot . "downloadApp-$webappID.json";
        $data   = $this->fetchAPI($apiURL);

        return $data;
    }

    /**
     * Get webapps by status.
     * 
     * @param  string    $status 
     * @access public
     * @return array
     */
    public function getLocalApps($key = 'code')
    {
        $webapps = $this->dao->select('*')->from(TABLE_ENTRY)
            ->where('integration')->eq(0)
            ->fetchAll($key);
        return $webapps;
    }

    /**
     * install  
     * 
     * @param  int    $webappID 
     * @access public
     * @return void
     */
    public function install($webappID)
    {
        $webapp   = $this->getAppInfoByAPI($webappID);
        $webapp   = $webapp->webapp;
        $size     = explode('x', $webapp->size);
        $open     = $webapp->target == 'blank' ? 'blank' : 'iframe';
        $maxOrder = $this->dao->select('`order`')->from(TABLE_ENTRY)->orderBy('order_desc')->limit(1)->fetch('order');

        $entry = new stdclass();
        $entry->code        = $webapp->id;
        $entry->name        = $webapp->name;
        $entry->open        = $open;
        $entry->login       = $webapp->url;
        $entry->control     = 'simple';
        $entry->size        = 'custom';
        $entry->width       = $size[0];
        $entry->height      = $size[1];
        $entry->position    = 'default';
        $entry->ip          = '*';
        $entry->visible     = 0;
        $entry->buildin     = 0;
        $entry->integration = 0;
        $entry->key         = md5(time());
        $entry->order       = $maxOrder + 10;
        if($entry->size == 'custom') $entry->size = helper::jsonEncode(array('width' => (int)$entry->width, 'height' => (int)$entry->height));

        $this->app->loadConfig('entry');
        $this->dao->insert(TABLE_ENTRY)
            ->data($entry, $skip = 'width,height,files')
            ->autoCheck()
            ->batchCheck($this->config->entry->require->create, 'notempty')
            ->check('code', 'unique')
            ->check('code', 'code')
            ->exec();

        $this->addDownloadByAPI($webappID);
        if(dao::isError()) return false;
        return $webappID;
    }

    /**
     * getSelfMenu 
     * 
     * @access public
     * @return string
     */
    public function getSelfMenu()
    {
        $searchLink = inlink('obtain', 'type=bySearch');
        $inputKey   = html::input('key', $this->post->key, "class='form-control' placeholder='{$this->lang->webapp->bySearch}'");
        $subButton  = html::submitButton('<i class="icon-search"></i>', '', '');
        $obtainType  = array();
        $obtainType[1] = html::a(inlink('obtain', 'type=byUpdatedTime'), $this->lang->webapp->byUpdatedTime, '', "class='list-group-item' id='byupdatedtime'");
        $obtainType[2] = html::a(inlink('obtain', 'type=byAddedTime'),   $this->lang->webapp->byAddedTime, '', "class='list-group-item' id='byaddedtime'");
        $obtainType[3] = html::a(inlink('obtain', 'type=byDownloads'),   $this->lang->webapp->byDownloads, '', "class='list-group-item' id='bydownloads'");
        $moduleTree = $this->getModulesByAPI();
        $content = <<<EOT
<div>
  <form class='side-search mgb-20' method='post' action='{$searchLink}'>
    <div class="input-group">
      {$inputKey}
      <span class="input-group-btn">
        <button type='submite' id='submit' class='btn btn-submit'><i class='icon-serch'></i></button>
      </span>
    </div>
  </form>
  <div class='list-group'>
    {$obtainType[1]}{$obtainType[2]}{$obtainType[3]}
  </div>
  <div class='panel panel-sm'>
    <div class='panel-heading'>{$this->lang->webapp->byCategory}</div>
    <div class='panel-body'>
      {$moduleTree}
    </div>
  </div>
</div>
EOT;
        return $content;
    }
}
