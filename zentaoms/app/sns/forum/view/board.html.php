<?php include '../../common/view/header.html.php'; ?>
<?php include '../../common/view/treeview.html.php'; ?>
<?php $this->block->printRegion($layouts, 'forum_board', 'header');?>
<?php $common->printPositionBar($board);?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class='icon-comments-alt icon-large'></i>&nbsp;
    <?php echo $board->name; ?>
    </strong>
    <?php if($board->moderators) printf(" &nbsp;<span class='moderators'>" . $lang->forum->lblOwner . '</span>', trim($board->moderators, ',')); ?>
    <div class='panel-actions'>
      <?php if($this->forum->canPost($board)) echo html::a($this->createLink('thread', 'post', "boardID=$board->id"), '<i class="icon-pencil icon-large"></i>&nbsp;&nbsp;' . $lang->forum->post, "class='btn btn-info'");?>
    </div>
  </div>
  <table class='table table-hover table-striped'>
    <thead>
      <tr class='text-center'>
        <th colspan='2'><?php echo $lang->thread->title;?></th>
        <th style='width:50px'><?php echo $lang->thread->author;?></th>
        <th style='width:100px'><?php echo $lang->thread->postedDate;?></th>
        <th style='width:50px'><?php echo $lang->thread->views;?></th>
        <th style='width:50px'><?php echo $lang->thread->replies;?></th>
        <th style='width:200px'><?php echo $lang->thread->lastReply;?></th>
      </tr>  
    </thead>
    <tbody>
      <?php foreach($sticks as $thread):?>
      <tr class='text-center'>
        <td style='width: 10px'><span class='sticky-thread text-danger'><i class="icon-comment-alt icon-large"></i></span></td>
        <td class='text-left'>
          <?php echo html::a($this->createLink('thread', 'view', "id=$thread->id"), $thread->title);?>
          <?php echo "<span class='label label-danger'>{$lang->thread->stick}</span> "?>
        </td>
        <td class='text-left'><strong><?php echo $thread->author;?></strong></td>
        <td><?php echo substr($thread->addedDate, 5, -3);?></td>
        <td><?php echo $thread->views;?></td>
        <td><?php echo $thread->replies;?></td>
        <td class='text-left'>
          <?php 
          if($thread->replies)
          {
              echo substr($thread->repliedDate, 5, -3) . ' ';
              echo html::a($this->createLink('thread', 'locate', "threadID={$thread->id}&replyID={$thread->replyID}"), $thread->repliedBy);;
          }
          ?>
        </td>  
      </tr>
      <?php unset($threads[$thread->id]);?>
      <?php endforeach;?>

      <?php foreach($threads as $thread):?>
      <tr class='text-center'>
        <td style='width:10px'><?php echo $thread->isNew ? "<span class='text-success'><i class='icon-comment-alt icon-large'></i></span>" : "<span class='text-muted'><i class='icon-comment-alt icon-large'></i></span>";?></td>
        <td class='text-left'><?php echo html::a($this->createLink('thread', 'view', "id=$thread->id"), $thread->title);?></td>
        <td style='width:50px' class='text-left'><strong><?php echo $thread->author;?></strong></td>
        <td style='width:100px'><?php echo substr($thread->addedDate, 5, -3);?></td>
        <td style='width:30px'><?php echo $thread->views;?></td>
        <td style='width:30px'><?php echo $thread->replies;?></td>
        <td style='width:150px' class='text-left'>
          <?php 
          if($thread->replies)
          {
              echo substr($thread->repliedDate, 5, -3) . ' ';
              echo html::a($this->createLink('thread', 'locate', "threadID={$thread->id}&replyID={$thread->replyID}"), $thread->repliedBy);;
          }
          ?>
        </td>  
      </tr>  
      <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='7'><?php $pager->show('right', 'short');?></td></tr></tfoot>
  </table>
</div>
<?php $this->block->printRegion($layouts, 'forum_board', 'footer');?>
<?php include '../../common/view/footer.html.php'; ?>
