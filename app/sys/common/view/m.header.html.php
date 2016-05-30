<?php
/**
 * The header mobile view of common module of RanZhi.
 *
 * @copyright   Copyright 2009-2016 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     common 
 * @version     $Id: header.lite.html.php 3299 2015-12-02 02:10:06Z daitingting $
 * @link        http://www.ranzhico.com
 */

if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}
$bodyClass = 'with-appbar-top with-appnav-top';
include 'm.header.lite.html.php';
?>

<?php
$entriesList  = $this->loadModel('entry')->getEntries('mobile');
$currentEntry = isset($entriesList[$entryID]) ? $entriesList[$entryID] : $entriesList['dashboard'];
?>
<header id='appbar' class='appbar heading primary affix dock-top dock-auto'>
  <a class='title' data-display='dropdown' data-target='#appMenu' data-backdrop='true' data-placement='beside-bottom-start'>
    <div class="avatar" data-skin='<?php echo $currentEntry->code ?>'>
      <?php
      if($currentEntry->logo) echo '<img src="' . $currentEntry->logo . '">';
      else if($currentEntry->icon) echo '<i class="icon ' . $currentEntry->icon . '"></i>';
      ?>
    </div>
    <span><?php echo $currentEntry->name ?></span>
    <i class="icon icon-caret-down"></i>
  </a>
  <nav class='nav'>
    <a data-target='#userMenu' data-backdrop='true' data-display data-placement='beside-bottom-end' class='has-padding-sm'>
      <?php commonModel::printUserAvatar('circle');?>
    </a>
  </nav>
</header>

<nav class='appnav affix dock-top nav skin-<?php echo $currentEntry->code ?>-pale nav-secondary'>
  <?php
  if($currentEntry->id === 'dashboard')
  {
      echo html::a($this->createLink('index', 'index'), $lang->home, $this->moduleName == 'index' && $this->methodName == 'index' ? "class='active'" : '');
      echo commonModel::createDashboardMenu('mobile');
  }
  else echo commonModel::createMainMenu($this->moduleName, 'mobile');
  ?>
</nav>

<div id='appMenu' class='list layer hidden fade dock-top dock-left'>
<?php foreach ($entriesList as $entry):?>
  <a class='item<?php if($entry->id == $currentEntry->id) echo ' active' ?>' href='<?php echo $entry->url ?>'>
    <div class="avatar" data-skin='<?php echo $entry->code ?>'>
      <?php
      if($entry->logo) echo '<img src="' . $entry->logo . '">';
      else if($entry->icon) echo '<i class="icon ' . $entry->icon . '"></i>';
      ?>
    </div>
    <div class='title'><?php echo $entry->name ?></div>
  </a>
<?php endforeach; ?>
</div>

<div id='userMenu' class='list compact layer hidden fade dock-top dock-right'>
  <a class='item multi-lines gray-pale'>
    <?php commonModel::printUserAvatar('circle');?>
    <div class='content'>
      <div class='title'><?php echo empty($app->user->realname) ? ('@' . $app->user->account) : $app->user->realname ?></div>
      <div class='subtitle'><?php echo $lang->user->profile ?></div>
    </div>
  </a>
  <div class='divider no-margin'></div>
  <div class='item'>
    <i class='icon icon-globe muted'></i>
    <div class="content">
      <nav class='nav lang-menu dock'>
        <?php foreach($config->langs as $key => $value):?>
          <a data-value='<?php echo $key; ?>'<?php if($key === $this->app->getClientLang()) echo ' class="active"' ?>><?php echo $value; ?></a>
        <?php endforeach;?>
      </nav>
    </div>
  </div>
  <div class='divider no-margin'></div>
  <a class='item' href='<?php echo $this->createLink('misc', 'about');?>' data-display='modal' data-placement='bottom'><i class='icon icon-info-sign muted'></i> <span class='title'><?php echo $lang->index->about?></span></a>
  <div class='divider no-margin'></div>
  <?php echo html::a($this->createLink('user', 'logout'), "<i class='icon icon-signout muted'></i> <span class='title'>{$lang->logout}</span>", "class='item'")?>
</div>
