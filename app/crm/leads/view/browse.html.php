<?php 
/**
 * The browse view file of contact module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     contact 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php js::set('mode', $mode);?>
<?php js::set('origin', $origin);?>
<li id='bysearchTab'><?php echo html::a('#', "<i class='icon-search icon'></i>" . $lang->search->common)?></li>
<div id='menuActions'>
  <?php commonModel::printLink('leads', 'apply', '', $lang->contact->apply, "class='jsoner btn btn-primary'");?>
  <?php commonModel::printLink('contact', 'import', '', $lang->importIcon . $lang->import, "class='btn btn-primary' data-toggle='modal'");?>
  <?php if(commonModel::hasPriv('contact', 'export')):?>
  <div class='btn-group'>
    <button data-toggle='dropdown' class='btn btn-primary dropdown-toggle' type='button'><?php echo $lang->exportIcon . $lang->export;?> <span class='caret'></span></button>
    <ul id='exportActionMenu' class='dropdown-menu'>
      <li><?php commonModel::printLink('contact', 'export', "mode=all&orderBy={$orderBy}", $lang->exportAll, "class='iframe' data-width='700'");?></li>
      <li><?php commonModel::printLink('contact', 'export', "mode=thisPage&orderBy={$orderBy}", $lang->exportThisPage, "class='iframe' data-width='700'");?></li>
      <li><?php commonModel::printLink('contact', 'exportTemplate', '', $lang->exportTemplate, "class='iframe' data-width='700'");?></li>
    </ul>
  </div>
  <?php endif;?>
</div>
<div class='panel'>
  <table class='table table-hover table-striped tablesorter table-data table-fixed' id='contactList'>
    <thead>
      <tr class='text-center'>
        <?php $vars = "mode={$mode}&origin={$origin}&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}";?>
        <th class='w-60px'> <?php commonModel::printOrderLink('id', $orderBy, $vars, $lang->contact->id);?></th>
        <th class='w-100px text-left'><?php commonModel::printOrderLink('realname', $orderBy, $vars, $lang->contact->realname);?></th>
        <th class="text-left"><?php commonModel::printOrderLink('company', $orderBy, $vars, $lang->contact->company);?></th>
        <th class='w-60px'> <?php commonModel::printOrderLink('gender', $orderBy, $vars, $lang->contact->gender);?></th>
        <th class='w-200px text-left'><?php commonModel::printOrderLink('phone', $orderBy, $vars, $lang->contact->phone . $lang->slash . $lang->contact->mobile);?></th>
        <th class='w-200px'><?php commonModel::printOrderLink('email', $orderBy, $vars, $lang->contact->email);?></th>
        <th class='w-100px visible-lg'><?php commonModel::printOrderLink('qq', $orderBy, $vars, $lang->contact->qq);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('origin', $orderBy, $vars, $lang->contact->origin);?></th>
        <th class='w-200px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($contacts as $contact):?>
    <tr class='text-center'>
      <td><?php echo $contact->id;?></td>
      <td class='text-left'><?php echo html::a(inlink('view', "contactID=$contact->id"), $contact->realname);?></td>
      <td class='text-left'><?php echo $contact->company;?></td>
      <td><?php echo isset($lang->genderList->{$contact->gender}) ? $lang->genderList->{$contact->gender} : '';?></td>
      <td class='text-left'><?php echo $contact->phone . ' ' . $contact->mobile;?></td>
      <td><?php echo html::mailto($contact->email, $contact->email)?></td>
      <td class='visible-lg'><?php echo empty($contact->qq) ? '' : html::a("tencent://Message/?Uin={$contact->qq}&websiteName=RanZhi&Menu=yes", $contact->qq, "target='_blank'")?></td>
      <td><?php echo $contact->origin;?></td>
      <td class='operate'>
        <?php
        commonModel::printLink('action',  'createRecord', "objectType=contact&objectID={$contact->id}", $lang->contact->record, "data-toggle='modal' data-type='iframe' data-icon='comment-alt'");
        commonModel::printLink('address', 'browse', "objectType=contact&objectID=$contact->id", $lang->contact->address, "data-toggle='modal'");
        commonModel::printLink('leads', 'edit', "contactID=$contact->id", $lang->edit);
        commonModel::printLink('contact', 'transform', "contactID=$contact->id", $lang->confirm, "data-toggle='modal'");
        commonModel::printLink('contact', 'ignore', "contactID=$contact->id", $lang->ignore, "class='reload'");
        ?>
      </td>
    </tr>
    <?php endforeach;?>
    </tbody>
  </table>
  <div class='table-footer'><?php $pager->show();?></div>
</div>
<?php include '../../common/view/footer.html.php';?>
