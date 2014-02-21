<?php
/**
 * The assignTo view file of feedback module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     feedback
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<div class='panel'>
  <div class="panel-heading"><strong><?php echo $lang->feedback->assign?></strong></div>
  <form method='post' id='ajaxForm'>
    <table class='table table-form'>
      <tr>
        <th class='w-100px'><?php echo $lang->feedback->assignedTo?></th>
        <td><?php echo html::select('assignedTo', $users, '', "class='form-control chosen'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->comment?></th>
        <td><?php echo html::textarea('comment')?></td>
      </tr>
      <tr>
        <th></th>
        <td><?php echo html::submitButton() . html::backButton();?></td>
      </tr>
    </table>
  </form>
</div>
<?php include '../../common/view/footer.html.php';?>
