<?php include '../../common/view/header.admin.html.php'; ?>
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-comments'></i> <?php echo $lang->reply->list;?></strong></div>
  <table class='table table-hover table-bordered table-striped' id='replyList'>
    <thead>
      <tr class='text-center'>
        <th style='width: 60px'><?php echo $lang->reply->id;?></th>
        <th><?php echo $lang->reply->content;?></th>
        <th style='width: 70px'><?php echo $lang->reply->author;?></th>
        <th style='width: 100px'><?php echo $lang->reply->addedDate;?></th>
        <th style='width: 80px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($replies as $reply):?>
      <tr class='text-center'>
        <td><?php echo $reply->id;?></td>
        <td class='text-left'>
          <?php 
          echo html::a(commonModel::createFrontLink('thread', 'locate', "threadID={$reply->thread}&replyID={$reply->id}"), $reply->content);;
          ?>
        </td>
        <td><?php echo $reply->author;?></td>
        <td><?php echo substr($reply->addedDate, 5, -3);?></td>
        <td>
          <?php echo html::a($this->createLink('reply', 'delete', "replyID=$reply->id"), $lang->delete, "class='reloadDeleter'"); ?>
        </td>
      </tr>  
      <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='8'><?php $pager->show();?></td></tr></tfoot>
  </table>
</div>
<?php include '../../common/view/footer.admin.html.php'; ?>
