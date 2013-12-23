<?php include '../../common/view/header.admin.html.php'; ?>
<div class='panel'>
  <div class='panel-heading'><strong><i class="icon-comments-alt"></i> <?php echo $lang->forum->threadList;?></strong></div>
  <table class='table table-hover table-striped'>
    <thead>
      <tr class='text-center'>
        <th style='width: 70px'><?php echo $lang->thread->id;?></th>
        <th style='width: 80px'><?php echo $lang->thread->status;?></th>
        <th><?php echo $lang->thread->title;?></th>
        <th style='width: 50px'><?php echo $lang->thread->author;?></th>
        <th style='width: 100px'><?php echo $lang->thread->postedDate;?></th>
        <th style='width: 60px'><?php echo $lang->thread->views;?></th>
        <th style='width: 60px'><?php echo $lang->thread->replies;?></th>
        <th style='width: 150px'><?php echo $lang->thread->lastReply;?></th>
        <th style='width: 100px'><?php echo $lang->actions;?></th>
      </tr>  
    </thead>
    <tbody>
      <?php foreach($threads as $thread):?>
      <tr class='text-center'>
        <td><?php echo $thread->id;?></td>
        <td class='text-left'><?php echo $thread->hidden ? '<span class="text-warning"><i class="icon-eye-close"></i> ' . $lang->thread->statusList['hidden'] .'</span>' : '<span class="text-success"><i class="icon-ok-sign"></i> ' . $lang->thread->statusList['normal'] . '</span>';?></td>
        <td class='text-left'>
          <?php
          $iconRoot = $themeRoot . 'default/images/forum/';
          echo $thread->isNew ? "<span class='new-board'>&nbsp;</span>" : "<span class='common-board'>&nbsp;</span>";
          echo html::a(commonModel::createFrontLink('thread', 'view', "threadID=$thread->id"), $thread->title, "target='_blank'");
          ?>
        </td>
        <td><?php echo $thread->author;?></td>
        <td><?php echo substr($thread->addedDate, 5, -3);?></td>
        <td><?php echo $thread->views;?></td>
        <td><?php echo $thread->replies;?></td>
        <td class='text-left'><?php if($thread->replies) echo substr($thread->repliedDate, 5, -3) . ' ' . $thread->repliedBy;?></td>  
        <td>
        <?php echo html::a($this->createLink('thread', 'delete', "threadID=$thread->id"), $lang->delete, "class='reload'"); ?>
        <?php 
        if($thread->hidden)
        {
            echo html::a($this->createLink('thread', 'show', "threadID=$thread->id"), $lang->thread->show, "class='reload'"); 
        }
        else
        {
            echo html::a($this->createLink('thread', 'hide', "threadID=$thread->id"), $lang->thread->hide, "class='reload'"); 
        }
        ?>
      </td>
      </tr>  
      <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='9'><?php $pager->show();?></td></tr></tfoot>
  </table>
</div>
<?php include '../../common/view/footer.admin.html.php'; ?>
