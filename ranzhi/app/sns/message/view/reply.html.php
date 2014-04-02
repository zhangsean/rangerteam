<div class='modal-dialog' style='width: 580px'>
  <div class='modal-content'>
    <div class='modal-header'>
      <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
      <h4 class='modal-title' id='myModalLabel'><i class='icon-mail-reply'></i> <?php echo $lang->message->reply . ':' . $message->from;?></h4>
    </div>
    <div class='modal-body'>
      <form id='replyForm' method='post' action="<?php echo inlink('reply', "messageID={$message->id}");?>">
        <table class='table table-form'>
          <tr>
            <th style='width: 80px'><?php echo $lang->message->from;?></th>
            <td><?php echo html::input('from', $this->app->user->realname, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->message->content;?></th>
            <td><?php echo html::textarea('content', $this->app->user->realName, "class='form-control' rows='5'");?></td>
          </tr>
          <tr><td></td><td><?php echo html::submitButton();?></td></tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php if(isset($pageJS)) js::execute($pageJS);?>
