<?php
/**
 * The index view file of blog module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php 
include 'header.html.php';
$path = $category ? array_keys($category->pathNames) : array();
if(!empty($path))         js::set('path',  $path);
if(!empty($category->id)) js::set('categoryID', $category->id );
?>
<div class='col-md-9'>
  <div class='panel list'>
    <section class='items'>
      <?php foreach($articles as $article):?>
      <div class='item'>
        <div class='item-heading'>
          <div class="text-muted pull-right">
            <span title="<?php echo $users[$article->author];?>"><i class='icon-user'></i> <?php echo $users[$article->author];?></span> &nbsp; 
            <span title="<?php echo $lang->article->createdDate;?>"><i class='icon-time'></i> <?php echo substr($article->createdDate, 0, 10);?></span>&nbsp; 
          </div>
          <h4><?php echo html::a(inlink('view', "id={$article->id}"), $article->title);?></h4>
        </div>
        <div class='item-content'>
          <?php if(!empty($article->image)):?>
          <div class='media pull-right'>
            <?php
            $title = $article->image->primary->title ? $article->image->primary->title : $article->title;
            echo html::a($url, html::image($article->image->primary->smallURL, "title='{$title}' class='thumbnail'" ));
            ?>
          </div>
          <?php endif;?>
          <div class='text'><?php echo helper::subStr(strip_tags($article->content), 250, '...');?></div>
          <div class='text pull-right'>
            <?php echo html::a($this->createLink('article', 'edit', "articleID={$article->id}&type=blog"), $lang->edit);?>
            <?php echo html::a($this->createLink('article', 'delete', "articleID={$article->id}"), $lang->delete, "class='deleter'");?>
          </div>
        </div>
      </div>
      <?php endforeach;?>
    </section>
    <footer class='clearfix'><?php $pager->show('right');?></footer>
  </div>
</div>
<?php include 'footer.html.php';?>
