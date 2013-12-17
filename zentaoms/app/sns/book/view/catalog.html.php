<?php
/**
 * The create book view file of book of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Tingting Dai<daitingting@xirangit.com>
 * @package     book
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php'; ?>
<?php js::set('path', json_encode($node ? explode(',', $node->path) : 0));?>
<form id='ajaxForm' method='post'>
  <table class='table table-hover table-striped'>
    <caption><?php echo $node->title . $lang->book->catalog;?></caption>
    <thead>
      <tr class='a-center'>
        <th class='w-p10'><?php echo $lang->book->type;?></th>
        <th class='w-p10'><?php echo $lang->book->author;?></th>
        <th><?php echo $lang->book->title;?></th>
        <th class='w-p30'><?php echo $lang->book->alias;?></th>
        <th class='w-p10'><?php echo $lang->book->keywords;?></th>
        <th class='w-80px'><?php echo $lang->actions; ?></th>
      </tr>
    </thead>

    <tbody>
      <?php foreach($children as $child):?>
      <tr class='v-middle a-center'>
        <td><?php echo html::select("type[$child->id]",    $lang->book->typeList, $child->type, "class='select-1'");?></td>
        <td><?php echo html::input("author[$child->id]",   $child->author,   "class='text-1'");?></td>
        <td><?php echo html::input("title[$child->id]",    $child->title,    "class='text-1'");?></td>
        <td><?php echo html::input("alias[$child->id]",    $child->alias,    "class='text-1'");?></td>
        <td><?php echo html::input("keywords[$child->id]", $child->keywords, "class='text-1'");?></td>
        <td>
          <?php echo html::hidden("order[$child->id]", $child->order, "class='order'");?>
          <?php echo html::hidden("mode[$child->id]", 'update');?>
          <i class='icon-arrow-up'></i><i class='icon-arrow-down'></i>
        </td>
      </tr>
      <?php endforeach;?>

      <?php for($i = 0; $i < BOOK::NEW_CATALOG_COUNT ; $i ++):?>
      <tr class='v-middle a-center'>
        <td><?php echo html::select("type[]", $lang->book->typeList, '', "class='select-1'");?></td>
        <td><?php echo html::input("author[]", $app->user->realname, "class='text-1'");?></td>
        <td><?php echo html::input("title[]", '', "class='text-1'");?></td>
        <td><?php echo html::input("alias[]", '', "class='text-1' placeholder='{$lang->alias}'");?></td>
        <td><?php echo html::input("keywords[]", '', "class='text-1'");?></td>
        <td>
          <?php echo html::hidden("order[]", '', "class='order'");?>
          <?php echo html::hidden("mode[]", 'new');?>
          <i class='icon-arrow-up'></i> <i class='icon-arrow-down'></i>
        </td>
      </tr>
      <?php endfor;?>
    </tbody>

    <tfoot>
      <tr>
        <td colspan='5' class='a-center'>
          <?php echo html::submitButton() . html::hidden('referer', $this->server->http_referer);?>
        </td>
      </tr>
    </tfoot>

  </table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
