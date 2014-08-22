<?php
/**
 * The edit view file of project module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     project 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<?php include '../../../sys/common/view/datepicker.html.php';?>
<form method='post' id='ajaxForm' action='<?php echo inlink('edit', "projectID={$project->id}")?>'>
  <table class='table-form w-p90'>
    <tr>
      <th class='w-80px'><?php echo $lang->project->name;?></th>
      <td><div class='col-xs-7'> <?php echo html::input('name', $project->name, "class='form-control'");?></div></td>
    </tr>
    <tr>
      <th><?php echo $lang->project->begin;?></th>
      <td><div class='col-xs-7'> <?php echo html::input('begin', $project->begin, "class='form-control form-date'");?> </div> </td>
    </tr>
    <tr>
      <th><?php echo $lang->project->end;?></th>
      <td><div class='col-xs-7'><?php echo html::input('end', $project->end, "class='form-control form-date'");?></div></td>
    </tr>
    <tr>
      <th><?php echo $lang->project->desc;?></th>
      <td><div class='col-xs-12'><?php echo html::textarea('desc', $project->desc, "class='form-control w-p100' rows='5'");?></div></td>
    </tr>
    <tr><th></th><td><?php echo html::submitButton();?></td></tr>
  </table>
</form>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
