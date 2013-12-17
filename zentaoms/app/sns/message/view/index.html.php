<?php
/**
 * The index view file of message module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     message
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='row'>
  <div class='col-md-9'>
    <?php if(!empty($messages)):?>
    <div class='box radius'> 
      <h4 class='title'><i class="icon-comments-alt"></i> <?php echo $lang->message->list;?></h4>
      <ul class="media-list">
        <li><a name='first'></a></li>
        <?php foreach($messages as $number => $message):?>
        <li id='<?php echo $message->id?>' class='media'>
          <div class="icon-stack icon"><i class="icon-comment icon-stack-base"></i><strong class="icon-content">#<?php echo ($startNumber + $number + 1)?></strong></div>
          <div class="pull-right"><span class="text-muted"><?php echo $message->date;?></span></div>
          <div><strong><?php echo $message->from;?></strong></div>
          <div class="content"><?php echo nl2br($message->content);?></div>
          <?php if(!empty($replies[$message->id])):?>
          <dl class='alert alert-info'>
          <?php foreach($replies[$message->id] as $reply) printf($lang->message->replyItem, $reply->from, $reply->date, $reply->content);?>
          </dl>
          <?php endif;?>
        </li>
        <?php endforeach;?>
      </ul>
      <div class='w-p95 pd-10px clearfix'><div id='pager'><?php $pager->show('right', 'shorter');?></div></div>
    </div>  
    <?php endif;?>
    <div class='cont'>
      <form method='post' class='form-inline' id='commentForm' action="<?php echo $this->createLink('message', 'post', 'type=message');?>">
        <table class='table table-form'>
          <caption><?php echo $lang->message->post;?></caption>
          <tbody>
            <tr>
              <th class='w-80px v-middle'><?php echo $lang->message->from;?></th>
              <td> 
                <?php 
                $from  = $this->session->user->account == 'guest' ? '' : $this->session->user->account;
                $phone = $this->session->user->account == 'guest' ? '' : $this->session->user->phone;
                $qq    = $this->session->user->account == 'guest' ? '' : $this->session->user->qq;
                $email = $this->session->user->account == 'guest' ? '' : $this->session->user->email;
                echo html::input('from', $from, "class='text-4'");
                ?>
              </td>
            </tr>
            <tr>
              <th class='v-middle'><?php echo $lang->message->phone;?></th>
              <td><?php echo html::input('phone', $phone, "class='text-4'");?></td>
            </tr>
            <tr>
              <th class='v-middle'><?php echo $lang->message->qq;?></th>
              <td><?php echo html::input('qq', $qq, "class='text-4'");?></td>
            </tr>
            <tr>
              <th class='v-middle'><?php echo $lang->message->email;?></th>
              <td><?php echo html::input('email', $email, "class='text-4'");?></td>
            </tr>
           <tr>
              <th class='v-middle'><?php echo $lang->message->content;?></th>
              <td>
                <?php 
                echo html::textarea('content', '', "class='area-1' rows='3'");
                echo html::hidden('objectType', 'message');
                echo html::hidden('objectID', 0);
                ?>
              </td>
            </tr>
            <tr>
              <th><?php echo $lang->message->public;?></th>
              <td><input type='checkbox' name='public' value='1' checked='checked'  /></td>
            </tr>
            <tr id='captchaBox' style="display:none;"></tr>  
            <tr><td></td><td><div class=''><?php echo html::submitButton();?></div></td></tr>
          </tbody>
        </table>
      </form>
    </div>
  </div>
  <div class='col-md-3'><?php $this->block->printRegion($layouts, 'message_index', 'side');?></div>
</div>
<?php include '../../common/view/footer.html.php';?>
