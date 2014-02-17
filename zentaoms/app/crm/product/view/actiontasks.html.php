<?php 
/**
 * The actiontask view of product module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     product 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->product->action->adminTasks;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <thead>
          <tr class='text-center'>
            <td><?php echo $lang->product->task->role;?></td>
            <td><?php echo $lang->product->task->date;?></td>
            <td><?php echo $lang->product->task->name;?></td>
            <td></td>
          </tr>
        </thead>
        <?php foreach($action->tasks as $task):?>
        <tr>
          <td><?php echo html::select('role[]', array_combine($roles, $roles), $task->role, "class='form-control'");?></td>
          <td class='w-150px'><?php echo html::input('date[]', $task->date, "class='form-control form-date'");?></td>
          <td><?php echo html::input("name[]", $task->name, "class='form-control'")?></td>
          <td>
            <?php echo html::a('javascript:;', $lang->add, "class='plus'")?>
            <?php echo html::a('javascript:;', $lang->delete, "class='condition-deleter'")?>
          </td>
        </tr>
        <?php endforeach;?>
        <tr><td colspan='4'><?php echo html::submitButton();?></td></tr>
      </table>
    </form>
    <table class='hide'>
      <tr id='originTR'>
        <td><?php echo html::select('role[]', $roles, '', "class='form-control'");?></td>
        <td class='w-150px'><?php echo html::input('date[]', '', "class='form-control form-date'");?></td>
        <td><?php echo html::input('name[]', '', "class='form-control'")?></td>
        <td>
          <?php echo html::a('javascript:;', $lang->add, "class='plus'")?>
          <?php echo html::a('javascript:;', $lang->delete, "class='condition-deleter'")?>
        </td>
      </tr>
    </table>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
