<?php
/**
 * The side common view file of blog module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php $treeMenu = $this->tree->getTreeMenu('blog', 0, array('treeModel', 'createBlogBrowseLink'));?>
<div class='col-md-2'>
  <div class='panel'> 
    <?php echo html::a(inlink('create'), $lang->blog->create, "class='btn btn-primary btn-lg btn-block'");?>
  </div>
  <div class='panel'> 
    <div class='panel-body'> <?php echo $treeMenu;?> </div>
    <?php if(count($tags) > 1):?>
    <div class='panel-body div-tags'>
      <?php foreach($tags as $tag):?>
      <?php if($tag) echo html::a(inlink('index', 'category=0&author=&month=&tag=' . $tag), $tag, "class='label label-info'");?>
      <?php endforeach;?>
    </div>
    <?php endif;?>

    <?php if(count($authors) > 1):?>
    <div class='panel-body'>
      <?php foreach($authors as $author):?>
      <?php echo html::a(inlink('index', "category=0&author={$author->account}"), $author->realname, "class='label label-success'");?>
      <?php endforeach;?>
    </div>
    <?php endif;?>

    <?php if(count($months) > 1):?>
    <div class='panel-body'>
      <ul class="nav nav-stacked ul-months">
        <?php foreach(array_keys($months) as $month):?>
        <li><?php echo html::a(inlink('index', 'category=0&author=&month=' . str_replace('-', '_', $month)), $month);?></li>
        <?php endforeach;?>
      </ul>
    </div>
    <?php endif;?>

  </div>
</div>
