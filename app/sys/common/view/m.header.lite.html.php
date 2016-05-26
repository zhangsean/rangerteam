<?php
/**
 * The header.lite mobile view of common module of RanZhi.
 *
 * @copyright   Copyright 2009-2016 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     common 
 * @version     $Id: header.lite.html.php 3299 2015-12-02 02:10:06Z daitingting $
 * @link        http://www.ranzhico.com
 */

if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}
$webRoot      = $config->webRoot;
$jsRoot       = $webRoot . "mobile/js/";
$cssRoot      = $webRoot . "mobile/css/";
?>
<!DOCTYPE html>
<html lang='<?php echo $this->app->getClientLang();?>'>
<head profile="http://www.w3.org/2005/10/profile">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php
  echo html::icon($webRoot . 'favicon.ico');

  if(!isset($title)) $title  = '';
  if(!empty($title)) $title .= $lang->minus;
  echo html::title($title . $lang->ranzhi);

  js::exportConfigVars();
  if(isset($this->app->entry->id)) js::set('entryID', $this->app->entry->id);
  if(RUN_MODE != 'upgrade' and RUN_MODE != 'install' and !isset($this->app->entry->id) and ($this->app->user->admin == 'super')) js::set('entryID', 'superadmin');
  if(RUN_MODE != 'upgrade' and RUN_MODE != 'install' and !isset($this->app->entry->id) and ($this->moduleName == 'my' or $this->moduleName == 'todo')) js::set('entryID', 'dashboard');
  if($config->debug)
  {
      js::import($jsRoot . 'mzui.min.js');
      js::import($jsRoot . 'ranzhi.js');
      css::import($cssRoot . 'mzui.min.css');
  }
  else
  {
      js::import($jsRoot . 'all.js');
      css::import($cssRoot . 'all.css');
  }

  if(isset($pageCSS)) css::internal($pageCSS);
  ?>
</head>
<body class='m-<?php echo $this->app->getModuleName() . '-' . $this->app->getMethodName() ?>'>
