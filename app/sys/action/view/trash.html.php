<?php
/**
 * The trash view file of action module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     action
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><?php echo $lang->action->trash;?></strong>
    <span class='panel-actions pull-right'>
      <?php if($type == 'hidden') echo html::a(inLink('trash', "type=all"),    $lang->goback, "class='btn'");?>
      <?php if($type == 'all')    echo html::a(inLink('trash', "type=hidden"), "<i class='icon-eye-close'></i> " . $lang->action->hidden, "class='btn btn-primary'");?>
    </span>
  </div>
  <table class='table table-hover tablesorter'>
    <?php $vars = "type=$type&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}"; ?>
    <thead>
      <tr class='class-center'>
        <th class='w-90px'><?php commonModel::printOrderLink('objectType', $orderBy, $vars, $lang->action->objectType);?></th>
        <th class='w-90px'><?php commonModel::printOrderLink('objectID',   $orderBy, $vars, $lang->action->objectID);?></th>
        <th><?php echo $lang->action->objectName;?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('actor',     $orderBy, $vars, $lang->action->actor);?></th>
        <th class='w-150px'><?php commonModel::printOrderLink('date',      $orderBy, $vars, $lang->action->date);?></th>
        <th class='w-100px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($trashes as $action):?>
      <?php $module = $action->objectType == 'case' ? 'testcase' : $action->objectType;?>
      <tr class='text-center'>
        <td><?php echo zget($lang->action->objectTypes, $action->objectType, '');?></td>
        <td><?php echo $action->objectID;?></td>
        <td class='text-left'><?php echo html::a($this->createLink($module, 'view', "id=$action->objectID"), $action->objectName);?></td>
        <td><?php echo $users[$action->actor];?></td>
        <td><?php echo $action->date;?></td>
        <td>
          <?php
          commonModel::printLink('action', 'undelete', "actionid=$action->id", $lang->action->undelete, 'hiddenwin');
          if($type == 'all') commonModel::printLink('action', 'hideOne',  "actionid=$action->id", $lang->action->hideOne, 'hiddenwin');
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan='3'>
          <?php if($trashes and $type == 'all'):?>
          <?php echo html::a(inlink('hideAll'), $lang->action->hideAll, "id='hideAll' class='btn'");?>
          <span class=''><?php echo $lang->action->trashTips;?></span>
          <?php endif;?>
        </td>
        <td colspan='3'>
          <?php $pager->show();?>
        </td>
      </tr>
    </tfoot>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
