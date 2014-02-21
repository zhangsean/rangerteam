<?php
/**
 * The view file for view method of feedback module of ZenTaoMS.
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
<h5><?php echo $lang->feedback->title . ': ' . ' #' . $issue->id . ' ' . $issue->title;?></h5>
<div class='col-md-8'>
  <fieldset>
    <legend><?php echo $lang->feedback->desc?></legend>
    <?php echo htmlspecialchars_decode($issue->desc)?>
  </fieldset>
  <p>
    <?php
    echo html::a(inlink('assignTo', "issueID=$issue->id"), $lang->assign, "data-toggle='modal'");
    if($issue->status != 'transfered') echo html::a(inlink('transfer', "issueID=$issue->id"), $lang->feedback->transfer);
    if($issue->status != 'replied')echo html::a('#replyDiv', $lang->feedback->reply, "id='replyLink'");
    if($issue->status == 'replied')echo html::a('#doubtDiv', $lang->feedback->doubt, "id='doubtLink'");
    echo html::a(inlink('close', "issueID=$issue->id"), $lang->close, "data-toggle='modal'");
    echo html::a(inlink('edit', "issueID=$issue->id"), $lang->edit);
    echo html::a(inlink('delete', "issueID=$issue->id"), $lang->delete, "class='deleter'");
    ?>
  </p>
  <?php include '../../../sys/common/view/action.html.php';?>
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
  <fieldset>
    <legend><?php echo $lang->feedback->legendBasic?></legend>
    <dl class='dl-horizontal'>
      <dt><?php echo $lang->feedback->product?></dt>
      <dd><?php echo $products[$issue->product]?></dd>
      <dt><?php echo $lang->feedback->customer?></dt>
      <dd><?php echo $customers[$issue->customer]?></dd>
      <dt><?php echo $lang->feedback->contact?></dt>
      <dd><?php echo $contacts[$issue->contact]?></dd>
      <dt><?php echo $lang->feedback->pri?></dt>
      <dd><?php echo $lang->feedback->priList[$issue->pri]?></dd>
      <dt><?php echo $lang->feedback->status?></dt>
      <dd><?php echo $lang->feedback->statusList[$issue->status]?></dd>
    </dl>
  </fieldset>
  <fieldset>
    <legend><?php echo $lang->feedback->legendEffort?></legend>
    <dl class='dl-horizontal'>
      <dt><?php echo $lang->feedback->addedBy?></dt>
      <dd><?php echo $users[$issue->addedBy] . $lang->at . $issue->addedDate;?></dd>
      <dt><?php echo $lang->feedback->assignedTo?></dt>
      <dd><?php if($issue->assignedTo) echo $users[$issue->assignedTo] . $lang->at . $issue->assignedDate;?></dd>
      <dt><?php echo $lang->feedback->transferedBy?></dt>
      <dd><?php if($issue->transferedBy) echo $users[$issue->transferedBy] . $lang->at . $issue->transferedDate;?></dd>
      <dt><?php echo $lang->feedback->closedBy?></dt>
      <dd><?php if($issue->closedBy) echo $users[$issue->closedBy] . $lang->at . $issue->closedDate;?></dd>
      <dt><?php echo $lang->feedback->closedReason?></dt>
      <dd><?php if($issue->closedReason) echo $lang->feedback->closedReasonList[$issue->closedReason]?></dd>
      <dt><?php echo $lang->feedback->editedBy?></dt>
      <dd><?php if($issue->closedBy) echo $users[$issue->editedBy] . $lang->at . $issue->editedDate;?></dd>
    </dl>
  </fieldset>
</div>
<?php include '../../common/view/footer.html.php';?>
