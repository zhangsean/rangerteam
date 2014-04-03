<?php
/**
 * The view file for view method of feedback module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     feedback
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<div class='col-md-8'>
  <div class="panel">
    <div class="panel-heading"><strong><i class="icon-question-sign"></i> <?php echo $lang->feedback->title . ': ' . ' #' . $issue->id . ' ' . $issue->title;?></strong></div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-8">
          <h5 class="header-dividing"><?php echo $lang->feedback->legendBasic?></h5>
          <table class='table table-borderless table-condensed table-form'>
            <tr>
              <th class='w-80px'><?php echo $lang->feedback->status?></th>
              <td class='w-150px'><?php echo $lang->feedback->statusList[$issue->status]?></td>
              <th class='w-100px'><?php echo $lang->feedback->product?></th>
              <td><?php echo $products[$issue->product]?></td>
            </tr>
            <tr>
              <th><?php echo $lang->feedback->pri?></th>
              <td><span class='pri pri-<?php echo $issue->pri;?> active'><?php echo $lang->feedback->priList[$issue->pri]?></span></td>
              <th><?php echo $lang->feedback->customer?></th>
              <td><?php echo $customers[$issue->customer]?></td>
            </tr>
            <tr>
              <th><?php echo $lang->feedback->contact?></th>
              <td><?php echo $contacts[$issue->contact]?></td>
            </tr>
          </table>
          <h5 class="header-dividing"><?php echo $lang->feedback->desc?></h5>
          <?php echo htmlspecialchars_decode($issue->desc)?>
        </div>
        <div class="col-sm-4">
          <h5 class="header-dividing"><?php echo $lang->feedback->legendEffort?></h5>
          <table class='table table-borderless table-condensed table-form'>
            <tr>
              <th class='w-80px'><?php echo $lang->feedback->addedBy?></th>
              <td><?php echo $users[$issue->addedBy] . $lang->at . $issue->addedDate;?></td>
            </tr>
            <tr>
              <th><?php echo $lang->feedback->addedBy?></th>
              <td><?php echo $users[$issue->addedBy] . $lang->at . $issue->addedDate;?></td>
            </tr>
            <tr>
              <th><?php echo $lang->feedback->assignedTo?></th>
              <td><?php if($issue->assignedTo) echo $users[$issue->assignedTo] . $lang->at . $issue->assignedDate;?></td>
            </tr>
            <tr>
              <th><?php echo $lang->feedback->transferedBy?></th>
              <td><?php if($issue->transferedBy) echo $users[$issue->transferedBy] . $lang->at . $issue->transferedDate;?></td>
            </tr>
            <tr>
              <th><?php echo $lang->feedback->closedBy?></th>
              <td><?php if($issue->closedBy) echo $users[$issue->closedBy] . $lang->at . $issue->closedDate;?></td>
            </tr>
            <tr>
              <th><?php echo $lang->feedback->closedReason?></th>
              <td><?php if($issue->closedReason) echo $lang->feedback->closedReasonList[$issue->closedReason]?></td>
            </tr>
            <tr>
              <th><?php echo $lang->feedback->editedBy?></th>
              <td><?php if($issue->closedBy) echo $users[$issue->editedBy] . $lang->at . $issue->editedDate;?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="panel-footer">
    <?php
    echo html::a(inlink('assignTo', "issueID=$issue->id"), $lang->assign, "data-toggle='modal' class='btn'");
    if($issue->status != 'transfered') echo html::a(inlink('transfer', "issueID=$issue->id"), $lang->feedback->transfer, "class='btn'");
    if($issue->status != 'replied')echo html::a('#replyDiv', $lang->feedback->reply, "id='replyLink' class='btn'");
    if($issue->status == 'replied')echo html::a('#doubtDiv', $lang->feedback->doubt, "id='doubtLink' class='btn'");
    echo html::a(inlink('close', "issueID=$issue->id"), $lang->close, "data-toggle='modal' class='btn'");
    echo html::a(inlink('edit', "issueID=$issue->id"), $lang->edit, "class='btn'");
    echo html::a(inlink('delete', "issueID=$issue->id"), $lang->delete, "class='deleter btn'");
    ?>      
    </div>
  </div>
  <?php if($issue->status != 'replied'):?>
  <div class='hide' id='replyDiv'>
    <form method='post' id='ajaxForm' action='<?php echo inlink('reply', "issueID=$issue->id")?>'>
      <p><?php echo html::textarea('reply');?></p>
      <p><?php echo html::submitButton();?></p>
    </form>
  </div>
  <?php else:?>
  <div class='hide' id='doubtDiv'>
    <form method='post' id='ajaxForm' action='<?php echo inlink('doubt', "issueID=$issue->id")?>'>
      <p><?php echo html::textarea('doubt');?></p>
      <p><?php echo html::submitButton();?></p>
    </form>
  </div>
  <?php endif;?>
</div>
<div class='col-md-4'>
<?php include '../../../sys/common/view/action.html.php';?>
</div>
<?php include '../../common/view/footer.html.php';?>
