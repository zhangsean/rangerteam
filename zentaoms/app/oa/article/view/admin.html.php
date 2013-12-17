<?php
/**
 * The admin view file of article of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<table class='table table-bordered table-hover table-striped tablesorter'>
  <?php if($type == 'blog'):?>
  <caption><?php echo $lang->blog->list;?><span class='pull-right mr-10px'><?php echo html::a($this->inlink('create', "type={$type}&category={$categoryID}"), $lang->blog->create);?></span></caption>
  <?php elseif($type == 'page'):?>
  <caption><?php echo $lang->page->list;?><span class='pull-right mr-10px'><?php echo html::a($this->inlink('create', "type={$type}&category={$categoryID}"), $lang->page->create);?></span></caption>
  <?php else:?>
  <caption><?php echo $lang->article->list;?><span class='pull-right mr-10px'><?php echo html::a($this->inlink('create', "type={$type}&category={$categoryID}"), $lang->article->create);?></span></caption>
  <?php endif;?>
  <thead>
    <tr class='a-center'>
      <?php $vars = "type=$type&categoryID=$categoryID&corderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}";?>
      <th class='w-60px'> <?php commonModel::printOrderLink('id',        $orderBy, $vars, $lang->article->id);?></th>
      <th>                <?php commonModel::printOrderLink('title',     $orderBy, $vars, $lang->article->title);?></th>
      <?php if($type != 'page'):?>
      <th class='w-p20'>  <?php commonModel::printOrderLink('category',  $orderBy, $vars, $lang->article->category);?></th>
      <?php endif;?>
      <th class='w-80px'> <?php commonModel::printOrderLink('status',    $orderBy, $vars, $lang->article->status);?></th>
      <th class='w-160px'><?php commonModel::printOrderLink('addedDate', $orderBy, $vars, $lang->article->addedDate);?></th>
      <th class='w-60px'> <?php commonModel::printOrderLink('views',     $orderBy, $vars, $lang->article->views);?></th>
      <th class='w-150px'><?php echo $lang->actions;?></th>
    </tr>
  </thead>
  <tbody>
    <?php $maxOrder = 0; foreach($articles as $article):?>
    <tr class='a-center'>
      <td><?php echo $article->id;?></td>
      <td class='a-left'><?php echo $article->title;?></td>
      <?php if($type != 'page'):?>
      <td class='a-left'><?php foreach($article->categories as $category) echo $category->name . ' ';?></td>
      <?php endif;?>
      <td><?php echo $lang->article->statusList[$article->status];?></td>
      <td><?php echo $article->addedDate;?></td>
      <td><?php echo $article->views;?></td>
      <td>
        <?php
        echo html::a($this->createLink('article', 'edit', "articleID=$article->id&type=$article->type"), $lang->edit);
        echo html::a($this->createLink('file', 'browse', "objectType=article&objectID=$article->id"), $lang->article->files, "data-toggle='modal' data-width='1000'");
        echo html::a($this->createLink('article', 'delete', "articleID=$article->id"), $lang->delete, 'class="deleter"');
        echo html::a($this->article->createPreviewLink($article->id), $lang->preview, "target='_blank'");
        ?>
      </td>
    </tr>
    <?php endforeach;?>
  </tbody>
  <tfoot><tr><td colspan='7'><?php $pager->show();?></td></tr></tfoot>
</table>
<?php include '../../common/view/footer.admin.html.php';?>
