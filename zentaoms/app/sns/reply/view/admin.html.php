<?php include '../../common/view/header.admin.html.php'; ?>
<table class='table table-hover table-bordered table-striped' id="replyList">
  <caption><?php echo $lang->reply->list;?></caption>
  <thead>
    <tr class='a-center'>
      <th class='w-60px'><?php echo $lang->reply->id;?></th>
      <th><?php echo $lang->reply->content;?></th>
      <th class='w-50px'><?php echo $lang->reply->author;?></th>
      <th class='w-100px'><?php echo $lang->reply->addedDate;?></th>
      <th class='w-80px a-center'><?php echo $lang->actions;?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($replies as $reply):?>
    <tr class='a-center'>
      <td><?php echo $reply->id;?></td>
      <td class='a-left'>
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
<?php include '../../common/view/footer.admin.html.php'; ?>
