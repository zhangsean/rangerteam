<?php 
/**
 * The browse redords view file of order module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     order 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
  <div class='panel-heading'>
    <strong><i class="icon-list-ul"></i> <?php echo $lang->order->list;?></strong>
    <div class='panel-actions pull-right'><?php echo html::a($this->inlink('createRecord', "orderID={$order->id}"), '<i class="icon-plus"></i> ' . $lang->order->record->create, "class='btn btn-primary' data-toggle='modal'");?></div>
  </div>
  <table class='table table-hover table-striped tablesorter table-data'>
    <thead>
      <th class='w-120px'><?php echo $lang->order->record->contact;?></th>
      <th><?php echo $lang->order->record->comment;?></th>
      <th class='w-120px'><?php echo $lang->order->record->actor;?></th>
      <th class='w-150px'><?php echo $lang->order->record->date;?></th>
      <th class='w-150px'><?php echo $lang->actions;?></th>
    </thead>
    <tbody>
      <?php foreach($records as $record):?>
      <tr>
        <td><?php echo $contacts[$record->extra];?></td>
        <td><?php echo $record->comment;?></td>
        <td><?php echo $users[$record->actor];?></td>
        <td><?php echo $record->date;?></td>
        <td><?php echo html::a(inlink('editRecord', "id={$record->id}"), $lang->edit, "data-toggle='modal'");?></td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='4'><?php echo $pager->get();?></td></tr></tfoot>
  </table>
<?php include '../../common/view/footer.html.php';?>
