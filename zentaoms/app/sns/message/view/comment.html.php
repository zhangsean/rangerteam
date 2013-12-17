<?php
js::set('objectType', $objectType);
js::set('objectID',   $objectID);
css::internal($pageCSS);
?>
<?php if(isset($comments) and $comments):?>
<div id='commentList' class='commentList radius-top'> 
  <div class='box-title'><?php echo $lang->message->list;?></div>
  <div class='box-content'>
    <a name='first'></a>
    <?php foreach($comments as $number => $comment):?>
      <div id='<?php echo $comment->id?>' class='comment'>
        <div class='comment-head'><strong>#<?php echo ($startNumber + $number + 1)?> &nbsp;<?php echo $comment->from;?></strong> &nbsp; <span class='gray'><?php echo $comment->date;?></span></div>
        <?php echo nl2br($comment->content);?>
          <?php if(!empty($replies[$comment->id])):?>
          <dl class='alert alert-info'>
          <?php foreach($replies[$comment->id] as $reply) printf($lang->message->replyItem, $reply->from, $reply->date, $reply->content);?>
          </dl>
          <?php endif;?>

      </div>
    <?php endforeach;?>
    <div id='pager'><?php $pager->show('right', 'shortest');?></div>
    <div class='c-right'></div>
  </div>
</div>  
<?php endif;?>
<div class='cont'>
  <form method='post' id='commentForm' action="<?php echo $this->createLink('message', 'post', 'type=comment');?>">
    <table class='table table-form'>
      <caption><?php echo $lang->message->post;?></caption>
      <tbody>
        <tr>
          <th class='w-80px v-middle'><?php echo $lang->message->from;?></th>
          <td> 
          <?php 
          $from = $this->session->user->account == 'guest' ? '' : $this->session->user->account;
          $email  = $this->session->user->account == 'guest' ? '' : $this->session->user->email;
          echo html::input('from', $from, "class='text-1'");
          ?>
          </td>
        </tr>
        <tr>
          <th class='v-middle'><?php echo $lang->message->email;?></th>
          <td><?php echo html::input('email', $email, "class='text-1'");?></td>
        </tr>
        <tr>
          <th class='v-middle'><?php echo $lang->message->content;?></th>
          <td>
          <?php 
          echo html::textarea('content', '', "class='area-1' rows='3'");
          echo html::hidden('objectType', $objectType);
          echo html::hidden('objectID', $objectID);
          ?>
          </td>
        </tr>
        <tr id='captchaBox' style="display:none;"><td colspan='2'></td></tr>  
        <tr><td></td><td><div class=''><?php echo html::submitButton();?></div></td></tr>
      </tbody>
    </table>
  </form>
</div>
<?php js::execute($pageJS);?>
