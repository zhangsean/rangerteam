<?php
/**
 * The admin browse view file of tag module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan<guanxiying@xirangit.com>
 * @package     tag
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/chosen.html.php';?>
<div class="col-md-12">
  <form method='post' class='form-inline mb-10px form-search'>
    <div class='input-group w-p40'>
      <?php echo html::select('tags[]', $tagOptions, $this->post->tags, "multiple='multiple' class='form-control chosen  search-query' placeholder='{$lang->tag->inputTag}'"); ?>
      <span class="input-group-btn"> <?php echo html::submitButton($lang->search, 'btn btn-primary'); ?> </span>
    </div>
  </form>
  <table class='table table-hover table-bordered table-striped tablesorter'>
    <caption><?php echo $lang->tag->admin;?></caption>
    <thead>
      <tr class='a-center'>
        <?php $vars = "orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}";?>
        <th class='w-p20'> <?php commonModel::printOrderLink('tag',  $orderBy, $vars, $lang->tag->common);?></th>
        <th class='w-80px'><?php commonModel::printOrderLink('rank', $orderBy, $vars, $lang->tag->rank);?></th>
        <th>               <?php commonModel::printOrderLink('link', $orderBy, $vars, $lang->tag->link);?></th>
        <th class='w-120px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($tags as $tag):?>
      <tr class='a-center v-middle'>
        <td><?php echo $tag->tag;?></td>
        <td><?php echo $tag->rank;?></td>
        <td class='a-left'><?php echo $tag->link;?></td>
        <td> <?php echo html::a($this->createLink('tag', 'link', "id=$tag->id"), $lang->tag->editLink, "data-toggle='modal'"); ?> </td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='4'><?php $pager->show();?></td></tr></tfoot>
  </table>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
