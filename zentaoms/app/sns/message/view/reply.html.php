<div class='bg-white box'>
  <form id='replyForm' method='post' action="<?php echo inlink('reply', "messageID={$message->id}");?>">
    <table class='table table-form'>
      <caption class='pl-10px'><?php echo $lang->message->reply . ':' . $message->from;?></caption>
      <tr>
        <th class='w-80px'><?php echo $lang->message->from;?></th>
        <td><?php echo html::input('from', $this->app->user->realname, "class='text-1'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->message->content;?></th>
        <td><?php echo html::textarea('content', $this->app->user->realName, "class='text-1' rows='5'");?></td>
      </tr>
      <tr><td></td><td><?php echo html::submitButton();?></td></tr>
    </table>
  </form>
</div>
<?php if(isset($pageJS)) js::execute($pageJS);?>
