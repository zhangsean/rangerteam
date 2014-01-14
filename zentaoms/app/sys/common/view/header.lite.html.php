<?php
/**
 * The header.lite view of common module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}
$webRoot   = $config->webRoot;
$jsRoot    = $webRoot . "js/";
$themeRoot = $webRoot . "theme/";
?>
<!DOCTYPE html>
<html>
<head profile="http://www.w3.org/2005/10/profile">
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php
  if(!isset($title)) $title  = '';
  if(!empty($title)) $title .= $lang->minus;
  echo html::title($title . $lang->zentaoms);

  js::exportConfigVars();
  if($config->debug)
  {
      js::import($jsRoot . 'jquery/min.js');
      js::import($jsRoot . 'zui/min.js');
      js::import($jsRoot . 'zentao.js');
      js::import($jsRoot . 'my.js');
      css::import($themeRoot . 'zui/css/min.css');
      css::import($themeRoot . 'default/style.css');
      css::import($themeRoot . 'default/admin.css');
  }
  else
  {
      css::import($themeRoot . 'default/all.css');
      js::import($jsRoot     . 'all.js');
  }

  if(RUN_MODE == 'admin') css::import($themeRoot . 'default/admin.css');
  if(isset($pageCSS)) css::internal($pageCSS);
?>
<!--[if lt IE 9]>
<?php
js::import($jsRoot . 'html5shiv/min.js');
js::import($jsRoot . 'respond/min.js');
?>
<![endif]-->
<?php js::set('lang', $lang->js);?>
</head>
<body>
