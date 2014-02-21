<?php
/**
 * The finish view file of task module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     task
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><?php echo $task->name;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th><?php echo $lang->task->consumed;?></th>
          <td><?php echo html::input('consumed', $task->consumed ? $task->consumed : '', "class='form-control' autocomplete='off'")?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->assignedTo;?></th>
          <td><?php echo html::select('assignedTo', $users, $task->createdBy, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->task->finishedDate;?></th>
          <td><?php echo html::input('finishedDate', helper::now(), "class='form-control form-datetime'");?></td>
        </tr>
        <tr>
          <th></th>
          <td><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
</body>
</html>
