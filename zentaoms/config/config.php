<?php
/**
 * The config file of ZenTaoMS.
 *
 * Don't modify this file directly, copy the item to my.php and change it.
 *
 * @copyright   Copyright 2009-2013 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     config
 * @version     $Id$
 * @link        http://www.zentao.net
 */
/* Judge class config and function getWebRoot exists or not, make sure php shells can work. */
if(!class_exists('config')){class config{}}
if(!function_exists('getWebRoot')){function getWebRoot(){}}

/* Basic settings. */
$config = new config();
$config->version      = '0.1';             // The version of zentaoms. Don't change it.
$config->charset      = 'UTF-8';           // The charset of zentaoms.
$config->cookieLife   = time() + 2592000;  // The cookie life time.
$config->timezone     = 'Asia/Shanghai';   // The time zone setting, for more see http://www.php.net/manual/en/timezones.php
$config->cookiePath   = '/';               // The path of cookies.
$config->webRoot      = getWebRoot();      // The web root.
$config->checkVersion = true;              // Auto check for new version or not.

/* The request settings. */
$config->requestType = 'PATH_INFO';       // The request type: PATH_INFO|GET, if PATH_INFO, must use url rewrite.
$config->pathType    = 'clean';           // If the request type is PATH_INFO, the path type.
$config->requestFix  = '/';               // The divider in the url when PATH_INFO.
$config->moduleVar   = 'm';               // requestType=GET: the module var name.
$config->methodVar   = 'f';               // requestType=GET: the method var name.
$config->viewVar     = 't';               // requestType=GET: the view var name.
$config->sessionVar  = 'sid';             // requestType=GET: the session var name.

/* Supported views. */
$config->views = ',html,json,mhtml,'; 

/* Supported languages. */
$config->langs['zh-cn'] = '中文简体';
$config->langs['zh-tw'] = '中文繁體';
$config->langs['en']    = 'English';

/* Supported charsets. */
$config->charsets['zh-cn']['utf-8'] = 'UTF-8';
$config->charsets['zh-cn']['gbk']   = 'GBK';
$config->charsets['zh-tw']['utf-8'] = 'UTF-8';
$config->charsets['zh-tw']['big5']  = 'BIG5';
$config->charsets['en']['utf-8']    = 'UTF-8';

/* Default settings. */
$config->default = new stdclass();
$config->default->view   = 'html';        // Default view.
$config->default->lang   = 'en';          // Default language.
$config->default->theme  = 'default';     // Default theme.
$config->default->module = 'index';       // Default module.
$config->default->method = 'index';       // Default method.

/* Upload settings. */
$config->file = new stdclass();
$config->file->dangers = 'php,jsp,py,rb,asp,'; // Dangerous files.
$config->file->maxSize = 1024 * 1024;          // Max size.

/* Master database settings. */
$config->db = new stdclass();
$config->db->persistant     = false;     // Pconnect or not.
$config->db->driver         = 'mysql';   // Must be MySQL. Don't support other database server yet.
$config->db->encoding       = 'UTF8';    // Encoding of database.
$config->db->strictMode     = false;     // Turn off the strict mode of MySQL.
//$config->db->emulatePrepare = true;    // PDO::ATTR_EMULATE_PREPARES
//$config->db->bufferQuery    = true;     // PDO::MYSQL_ATTR_USE_BUFFERED_QUERY

/* Slave database settings. */
$config->slaveDB = new stdclass();
$config->slaveDB->persistant = false;      
$config->slaveDB->driver     = 'mysql';    
$config->slaveDB->encoding   = 'UTF8';     
$config->slaveDB->strictMode = false;      
$config->slaveDB->checkCentOS= true;       

/* Include the custom config file. */
$configRoot = dirname(__FILE__) . DIRECTORY_SEPARATOR;
$myConfig   = $configRoot . 'my.php';
if(file_exists($myConfig)) include $myConfig;

/* Tables for basic system. */
define('TABLE_CONFIG',    'sys_config');
define('TABLE_USER',      'sys_user');
define('TABLE_GROUP',     'sys_group');
define('TABLE_GROUPPRIV', 'sys_groupPriv');
define('TABLE_USERGROUP', 'sys_userGroup');
define('TABLE_USERQUERY', 'sys_userQuery');
define('TABLE_ACTION',    'sys_action');
define('TABLE_FILE',      'sys_file');
define('TABLE_HISTORY',   'sys_history');
define('TABLE_TREE',      'sys_tree');
define('TABLE_EXTENSION', 'sys_extension`');
define('TABLE_WEBAPP',    'sys_webapp`');
define('TABLE_LANG',      'sys_lang`');

/* Tables for ips. */
define('TABLE_ENTRY', 'ips_entry');
define('TABLE_SSO',   'ips_sso');

/* Tables for crm. */
define('TABLE_PRODUCT', 'crm_product`');

/* Tables for oa. */
define('TABLE_TODO',     'oa_todo`');
define('TABLE_PROJECT',  'oa_project`');
define('TABLE_TASK',     'oa_task`');
define('TABLE_EFFORT',   'oa_effort`');
define('TABLE_RELATION', 'oa_relation');
define('TABLE_ARTICLE',  'oa_article');
define('TABLE_BLOCK',    'oa_block');
define('TABLE_BOOK',     'oa_book');
define('TABLE_LAYOUT',   'oa_layout');

/* Tables for sns. */
define('TABLE_TAG',     'sns_tag');
define('TABLE_THREAD',  'sns_thread');
define('TABLE_REPLY',   'sns_reply');
define('TABLE_MESSAGE', 'sns_message');

/* The mapping list of object and tables. */
$config->objectTables['product'] = TABLE_PRODUCT;
$config->objectTables['project'] = TABLE_PROJECT;
$config->objectTables['task']    = TABLE_TASK;
$config->objectTables['user']    = TABLE_USER;
$config->objectTables['todo']    = TABLE_TODO;

/* Include extension config files. */
$extConfigFiles = glob($configRoot . 'ext/*.php');
if($extConfigFiles) foreach($extConfigFiles as $extConfigFile) include $extConfigFile;
