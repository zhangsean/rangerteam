<?php
/**
 * The category front view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Yidong wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
?>
<?php
$this->loadModel('tree');
$block->content = json_decode($block->content);
$type           = str_replace('tree', '', strtolower($block->type));
$browseLink     = $type == 'article' ? 'createBrowseLink' : 'create' . ucfirst($type) . 'BrowseLink';
?>
<?php if($block->content->showChildren):?>
<?php $treeMenu = $this->tree->getTreeMenu($type, 0, array('treeModel', $browseLink));?>
<div class='box radius panel panel-default'> 
  <div class='panel-heading'><h4><?php echo $block->title;?></h4></div>
  <?php echo $treeMenu;?>
</div>
<?php else:?>
<?php $topCategories = $this->tree->getChildren(0, $type);?>
<div class='list-group'> 
  <strong class='list-group-item list-group-title'><?php echo $block->title;?></strong>
  <?php
  foreach($topCategories as $topCategory)
  {
      $browseLink = helper::createLink($type, 'browse', "categoryID={$topCategory->id}", "category={$topCategory->alias}");
      echo html::a($browseLink, "<i class='icon-folder-close-alt '></i>" . $topCategory->name, "id='category{$topCategory->id}' class='list-group-item'");
  }
  ?>
</div>
<?php endif;?>
