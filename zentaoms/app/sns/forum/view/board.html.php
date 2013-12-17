<?php include '../../common/view/header.html.php'; ?>
<?php include '../../common/view/treeview.html.php'; ?>
<?php $common->printPositionBar($board);?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h4><i class="icon-comments-alt icon-large"></i>&nbsp;
    <?php 
    echo $board->name; 
    if($board->moderators) printf(" &nbsp;<span class='moderators'>" . $lang->forum->lblOwner . '</span>', trim($board->moderators, ','));
    ?>
    </h4>
    <div class="panel-actions panel-actions-sm">
      <?php if($this->forum->canPost($board)) echo html::a($this->createLink('thread', 'post', "boardID=$board->id"), '<i class="icon-pencil icon-large"></i>&nbsp;&nbsp;' . $lang->forum->post, "class='btn btn-primary btn-wider'");?>
    </div>
  </div>
  <div class="panel-body no-padding">
    <table class='table table-hover table-striped'>
      <thead>
        <tr class='a-center'>
          <th class='a-center' colspan='2'><?php echo $lang->thread->title;?></th>
          <th class='w-50px'><?php echo $lang->thread->author;?></th>
          <th class='w-100px'><?php echo $lang->thread->postedDate;?></th>
          <th class='w-50px'><?php echo $lang->thread->views;?></th>
          <th class='w-50px'><?php echo $lang->thread->replies;?></th>
          <th class='w-200px'><?php echo $lang->thread->lastReply;?></th>
        </tr>  
      </thead>
      <tbody>
        <?php foreach($sticks as $thread):?>
        <tr class='a-center'>
          <td class='w-10px red'><span class='sticky-thread'><i class="icon-comment-alt icon-large"></i></span></td>
          <td class='a-left'>
            <?php echo html::a($this->createLink('thread', 'view', "id=$thread->id"), $thread->title);?>
            <?php echo "<span class='label label-danger'>{$lang->thread->stick}</span> "?>
          </td>
          <td class='a-left'><?php echo $thread->author;?></td>
          <td><?php echo substr($thread->addedDate, 5, -3);?></td>
          <td><?php echo $thread->views;?></td>
          <td><?php echo $thread->replies;?></td>
          <td class='a-left'>
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
        <tr class='a-center'>
          <td class='w-10px'><?php echo $thread->isNew ? "<span class='new-board'><i class='icon-comment-alt icon-large'></i></span>" : "<span class='common-board'><i class='icon-comment-alt icon-large'></i></span>";?></td>
          <td class='a-left'><?php echo html::a($this->createLink('thread', 'view', "id=$thread->id"), $thread->title);?></td>
          <td class='a-left w-50px'><?php echo $thread->author;?></td>
          <td class='w-100px'><?php echo substr($thread->addedDate, 5, -3);?></td>
          <td class='w-30px'><?php echo $thread->views;?></td>
          <td class='w-30px'><?php echo $thread->replies;?></td>
          <td class='a-left w-150px'>
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
</div>
<?php include '../../common/view/footer.html.php'; ?>
