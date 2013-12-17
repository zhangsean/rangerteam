<div class='panel panel-default thread'>
  <div class='panel-heading'>
    <h4><i class='icon-comment-alt'></i> <?php echo $thread->title; ?></h4>
    <div class='muted'><?php echo $thread->addedDate;?></div>
    <div class='panel-actions'><?php if($thread->readonly) echo "<span class='label label-info'><i class='icon-lock'></i> " . $lang->thread->readonly . "</span> &nbsp;"; ?></div>
  </div>
  <div class='panel-body no-padding'>
    <table class='table'>
      <tbody>
        <tr>
          <td class='speaker'>
            <?php
            $speaker = $speakers[$thread->author];
            printf($lang->thread->lblSpeaker, $speaker->account, $speaker->visits, $speaker->shortJoin, $speaker->shortLast);
            ?>
          </td>
          <td id='<?php echo $thread->id;?>'>
            <?php echo $thread->content;?>
            <div><?php $this->thread->printFiles($thread, $this->thread->canManage($board->id, $thread->author));?></div>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr> 
          <td class='a-right' colspan="2" id='manageBox'>
            <div id='manageMenu'>
              <?php 
              if($thread->editor) printf($lang->thread->lblEdited, $thread->editor, $thread->editedDate);
              if($this->app->user->account != 'guest')
              {
                  if(!$thread->readonly) echo html::a('#reply', $lang->reply->common);
                  if($this->thread->canManage($board->id, $thread->author)) echo html::a(inlink('edit', "threadID=$thread->id"), $lang->edit);

                  if($this->thread->canManage($board->id))
                  {
                      echo $lang->thread->sticks[$thread->stick] . ' ';
                      foreach($lang->thread->sticks as $stick => $label)
                      {
                          if($thread->stick != $stick) echo html::a(inlink('stick', "thread=$thread->id&stick=$stick"), $label, "class='jsoner'");
                      }
                      echo html::a(inlink('hide',   "threadID=$thread->id"), $lang->thread->hide, "class='jsoner'");
                      echo html::a(inlink('delete', "threadID=$thread->id"), $lang->delete, "class='deleter'");
                  }
              }    
              else
              {
                  echo html::a($this->createLink('user', 'login', 'referer=' . helper::safe64Encode($this->app->getURI(true))) . '#reply', $lang->reply->common);;
              }
              ?>
            </div>
          </td>
        </tr>
      </tfoot>      
    </table>
  </div>
</div>
