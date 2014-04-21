<?php 
/**
 * The browse view file of contact module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     contact 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-group"></i> <?php echo $lang->contact->list;?></strong>
  </div>
  <table class='table table-hover table-striped table-bordered tablesorter table-data'>
    <thead>
      <tr class='text-center'>
        <?php $vars = "orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}";?>
        <th class='w-60px'> <?php commonModel::printOrderLink('id',       $orderBy, $vars, $lang->contact->id);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('customer', $orderBy, $vars, $lang->contact->customer);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('realname', $orderBy, $vars, $lang->contact->realname);?></th>
        <th class='w-60px'> <?php commonModel::printOrderLink('gender',   $orderBy, $vars, $lang->contact->gender);?></th>
        <th class='w-120px'><?php commonModel::printOrderLink('phone',    $orderBy, $vars, $lang->contact->phone);?></th>
        <th class='w-120px'><?php commonModel::printOrderLink('mobile',   $orderBy, $vars, $lang->contact->mobile);?></th>
        <th class='w-200px'><?php commonModel::printOrderLink('email',    $orderBy, $vars, $lang->contact->email);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('qq',       $orderBy, $vars, $lang->contact->qq);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('weixin',   $orderBy, $vars, $lang->contact->weixin);?></th>
        <th><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($contacts as $contact):?>
    <tr class='text-center'>
      <td><?php echo $contact->id;?></td>
      <td><?php echo $customers[$contact->customer];?></td>
      <td><?php echo $contact->realname;?></td>
      <td><?php echo isset($lang->contact->genderList[$contact->gender]) ? $lang->contact->genderList[$contact->gender] : '';?></td>
      <td><?php echo $contact->phone;?></td>
      <td><?php echo $contact->mobile;?></td>
      <td><?php echo $contact->email;?></td>
      <td><?php echo $contact->qq;?></td>
      <td><?php echo $contact->weixin;?></td>
      <td class='operate'>
        <?php echo html::a($this->createLink('resume', 'browse', "contactID=$contact->id"), $lang->contact->resume, "data-toggle='modal'"); ?>
        <?php echo html::a($this->createLink('contact', 'edit', "contactID=$contact->id"), $lang->edit); ?>
        <?php echo html::a($this->createLink('contact', 'delete', "contactID=$contact->id"), $lang->delete, "class='deleter'"); ?>
      </td>
    </tr>
    <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='10'><?php $pager->show();?></td></tr></tfoot>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
