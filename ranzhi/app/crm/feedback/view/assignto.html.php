<?php
/**
 * The assignTo view file of feedback module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     feedback
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<div class="modal-dialog" style="width:700px;">
  <div class="modal-content">
    <div class="modal-header">
      <?php echo html::closeButton();?>
      <h4 class="modal-title"><i class="icon-cog"></i> <?php echo $lang->feedback->assign; ?></h4>
    </div>
    <div class="modal-body">
      <form method='post' id='ajaxModalForm' action='<?php echo $this->createLink('feedback', 'assignTo', "issueID=$issueID")?>'>
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
            <td><?php echo html::submitButton();?></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php include '../../../sys/common/view/footer.lite.html.php';?>
