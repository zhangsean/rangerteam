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
<?php js::set('mode', $mode);?>
<li id='bysearchTab'><a href='#'><i class='icon-search icon'></i>&nbsp;<?php echo $lang->search->common;?></a></li>
<div id='querybox' class='<?php if($mode == 'bysearch') echo 'show';?>'></div>
<div id='menuActions'>
  <?php echo html::a(inlink('create'), "<i class='icon-plus'></i> {$lang->contact->create}", "class='btn btn-primary'")?>
</div>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-group"></i> <?php echo $lang->contact->list;?></strong>
  </div>
  <table class='table table-hover table-striped tablesorter table-data' id='contactList'>
    <thead>
      <tr class='text-center'>
        <?php $vars = "mode={$mode}&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}";?>
        <th class='w-60px'> <?php commonModel::printOrderLink('id',       $orderBy, $vars, $lang->contact->id);?></th>
        <th class='w-100px text-left'><?php commonModel::printOrderLink('realname', $orderBy, $vars, $lang->contact->realname);?></th>
        <th class="text-left"><?php commonModel::printOrderLink('customer', $orderBy, $vars, $lang->contact->customer);?></th>
        <th class='w-60px'> <?php commonModel::printOrderLink('gender',   $orderBy, $vars, $lang->contact->gender);?></th>
        <th class='w-200px text-left'><?php commonModel::printOrderLink('phone',    $orderBy, $vars, $lang->contact->phone . $lang->slash . $lang->contact->mobile);?></th>
        <th class='w-200px'><?php commonModel::printOrderLink('email',    $orderBy, $vars, $lang->contact->email);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('qq',       $orderBy, $vars, $lang->contact->qq);?></th>
        <th class='w-200px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($contacts as $contact):?>
    <tr class='text-center'>
      <td><?php echo $contact->id;?></td>
      <td class='text-left'><?php echo html::a(inlink('view', "contactID=$contact->id"), $contact->realname);?></td>
      <td class='text-left'><?php if(isset($customers[$contact->customer])) echo html::a($this->createLink('customer', 'view', "customerID=$contact->customer"), $customers[$contact->customer]);?></td>
      <td><?php echo isset($lang->contact->genderList[$contact->gender]) ? $lang->contact->genderList[$contact->gender] : '';?></td>
      <td class='text-left'><?php echo $contact->phone . ' ' . $contact->mobile;?></td>
      <td><a href="mailto:<?php echo $contact->email;?>"><?php echo $contact->email;?></a></td>
      <td><a href="tencent://Message/?Uin=<?php echo $contact->qq;?>&websiteName=<?php echo $this->config->company->name?>&Menu=yes" target="_blank"><?php echo $contact->qq;?></a></td>
      <td class='operate'>
        <?php echo html::a($this->createLink('action', 'createRecord', "objectType=contact&objectID={$contact->id}&customer={$contact->customer}"), $lang->contact->record, "data-toggle='modal' data-type='iframe' data-icon='comment-alt'");?>
        <?php echo html::a($this->createLink('address', 'browse', "objectType=contact&objectID=$contact->id"), $lang->contact->address, "data-toggle='modal'");?>
        <?php echo html::a($this->createLink('contact', 'edit', "contactID=$contact->id"), $lang->edit);?>
        <?php echo html::a($this->createLink('contact', 'vcard', "contactID=$contact->id"), $lang->contact->qrcode, "class='iframe' data-width='390' data-icon='qrcode'");?>
        <?php echo "<div class='dropdown'><a data-toggle='dropdown' href='javascript:;'>" . $this->lang->more . "<span class='caret'></span> </a><ul class='dropdown-menu pull-right'>";?>
        <?php echo '<li>' . html::a($this->createLink('resume', 'browse', "contactID=$contact->id"), $lang->contact->resume, "data-toggle='modal'") . '</li>';?>
        <?php echo '<li>' . html::a($this->createLink('contact', 'delete', "contactID=$contact->id"), $lang->delete, "class='reloadDeleter'") . '</li>';?>
        <?php echo '</ul></div>';?>
      </td>
    </tr>
    <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='10'><?php $pager->show();?></td></tr></tfoot>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
