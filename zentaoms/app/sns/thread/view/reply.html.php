<?php $i = 1 + ($pager->pageID - 1) * $pager->recPerPage;?>
<?php foreach($replies as $reply):?>
<div id = "<?php echo $reply->id;?>" class="panel panel-default thread reply <?php echo $i%2!=0?'striped':'';?>">
  <div class="panel-heading">
    <div class="muted"><?php echo $reply->addedDate;?></div>
    <div class="panel-actions"><strong>#<?php echo $i++;?></strong></div>
  </div>
  <div class="panel-body no-padding">
    <table class='table'>
      <tr>
        <td class='speaker'>
          <?php
          $speaker = $speakers[$reply->author];
          printf($lang->thread->lblSpeaker, $speaker->account, $speaker->visits, $speaker->shortJoin, $speaker->shortLast);
          ?>
        </td>
        <td id='<?php echo $reply->id;?>'>
          <?php echo $reply->content;?>
          <div><?php $this->reply->printFiles($reply, $this->thread->canManage($board->id, $reply->author));?></div>
        </td>
      </tr>
      <tr> 
        <td class='speaker'></td>
        <td class='a-right'>
          <div class='f-right'>
            <?php 
            if($reply->editor) printf($lang->thread->lblEdited, $reply->editor, $reply->editedDate);
            if($this->app->user->account != 'guest')
            {
                echo html::a('#reply', $lang->reply->common, "class='replyTO'");
                if($this->thread->canManage($board->id, $reply->author)) echo html::a($this->createLink('reply', 'edit', "replyID=$reply->id"), $lang->edit);
                if($this->thread->canManage($board->id)) echo html::a($this->createLink('reply', 'delete', "replyID=$reply->id"), $lang->delete, "class='deleter'");
            }
            else
            {
                echo html::a($this->createLink('user', 'login', 'referer=' . helper::safe64Encode($this->app->getURI(true))) . '#reply', $lang->reply->common);;
            }
            ?>
          </div>  
        </td>
      </tr>
    </table>  
  </div>
</div>
<?php endforeach;?>

<?php $pager->show('right', 'short');?>

<?php if($this->session->user->account != 'guest'):?>
  <form method='post' enctype='multipart/form-data' id='replyForm' action='<?php echo $this->createLink('reply', 'post', "thread=$thread->id");?>'>
    <?php 
    echo "<div class='w-p100' id='reply'>" . html::textarea('content', '', "rows='6' class='area-1'") . "</div>";
    echo "<div class='c-both'></div>";
    echo $this->fetch('file', 'buildForm');
    echo "<div id='captchaBox' style='display:none;'></div>";
    echo html::submitButton();

    echo html::hidden('recTotal',   $pager->recTotal);
    echo html::hidden('recPerPage', $pager->recPerPage);
    echo html::hidden('pageID',     $pager->pageTotal);
    ?>
  </form>
<?php endif;?>
