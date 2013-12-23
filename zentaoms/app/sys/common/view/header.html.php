<?php
/**
 * The header view of common module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}
include 'header.lite.html.php';
js::set('lang', $lang->js);
?>
<div class='page-container'>
  <?php if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0') !== false ) exit($lang->IE6Alert); ?>
  <header id='header' class='clearfix'>
    <div id='headTitle'>
      <?php if(isset($config->site->logo)):?>
      <?php $logo = json_decode($config->site->logo);?>
      <div id='siteLogo'>
        <?php echo html::a($this->config->webRoot, html::image($logo->webPath, "class='logo' title='{$this->config->company->name}'"));?>
      </div>
      <?php else: ?>
      <div id='siteName'><h2><?php echo $config->site->name;?></h2></div>
      <?php endif;?>
      <div id='siteSlogan'><span><?php echo $this->config->site->slogan;?></span></div>
    </div>
  </header>
