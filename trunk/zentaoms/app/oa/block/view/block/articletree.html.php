<?php
/**
 * The category front view file of block module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
*/
?>
<?php
$this->loadModel('tree');
$block->content = json_decode($block->content);
$type           = str_replace('tree', '', strtolower($block->type));
$browseLink     = 'create' . ucfirst($type) . 'BrowseLink';
?>
<?php if($block->content->showChildren):?>
<?php $treeMenu = $this->tree->getTreeMenu($type, 0, array('treeModel', $browseLink));?>
<div class='panel panel-block'>
  <div class='panel-heading'><h4><i class='icon-sitemap'></i> <?php echo $block->title;?></h4></div>
  <div class='panel-body'><?php echo $treeMenu;?></div>
</div>
<?php else:?>
<?php $topCategories = $this->tree->getChildren(0, $type);?>
<div class='panel panel-block'>
  <div class='panel-heading'>
    <h4><i class='icon-folder-close'></i> <?php echo $block->title;?></h4>
  </div>
  <div class='panel-body'>
    <ul class='nav nav-secondary nav-stacked'>
      <?php
      foreach($topCategories as $topCategory){
          $browseLink = helper::createLink($type, 'browse', "categoryID={$topCategory->id}", "category={$topCategory->alias}");
          if($category->name==$topCategory->name)
          {
              echo "<li class='active'>" . html::a($browseLink, "<i class='icon-folder-open-alt '></i> &nbsp;" . $topCategory->name, "id='category{$topCategory->id}'") . '</li>';
          }
          else
          {
              echo '<li>' . html::a($browseLink, "<i class='icon-folder-close-alt '></i> &nbsp;" . $topCategory->name, "id='category{$topCategory->id}'") . '</li>';
          }
      }
      ?>
    </ul>
  </div>
</div>
<?php endif;?>
