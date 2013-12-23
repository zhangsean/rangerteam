<?php include '../../common/view/header.html.php'; ?>
<?php $this->block->printRegion($layouts, 'forum_index', 'header');?>
<?php $common->printPositionBar();?>
<div id='boards'>
<?php foreach($boards as $parentBoard):?>
  <div class='panel'>
    <div class='panel-heading'>
      <strong><i class='icon-comments icon-large'></i> <?php echo $parentBoard->name;?></strong>
    </div>
    <table class='table table-hover table-striped'>
      <thead>
        <tr class='text-center'>
          <th colspan='2'>&nbsp;<?php echo $lang->forum->board;?></th>
          <th><?php echo $lang->forum->owners;?></th>
          <th><?php echo $lang->forum->threadCount;?></th>
          <th><?php echo $lang->forum->postCount;?></th>
          <th><?php echo $lang->forum->lastPost;?></th>
        </tr>  
      </thead>
      <tbody>
        <?php foreach($parentBoard->children as $childBoard):?>
        <tr class='text-center text-middle'>
          <td style='width: 20px'><?php echo $this->forum->isNew($childBoard) ? "<span class='text-success'><i class='icon-comment icon-large'></i></span>" : "<span class='text-muted'><i class='icon-comment icon-large'></i></span>"; ?></td>
          <td class='text-left'>
            <strong><?php echo html::a(inlink('board', "id=$childBoard->id", "category={$childBoard->alias}"), $childBoard->name);?></strong><br />
            <small class='text-muted'><?php echo $childBoard->desc;?></small>
          </td>
          <td style='width: 50px'><strong><nobr><?php echo trim($childBoard->moderators, ',');?></nobr></strong></td>
          <td style='width: 70px'><?php echo $childBoard->threads;?></td>
          <td style='width: 70px'><?php echo $childBoard->posts;?></td>
          <td style='width: 150px' class='text-left'>
            <?php
            if($childBoard->postedBy)
            {
                echo substr($childBoard->postedDate, 5, -3) . '<br/>'; 
                echo html::a($this->createLink('thread', 'locate', "threadID={$childBoard->postID}&replyID={$childBoard->replyID}"), $childBoard->postedBy);;
            }
            ?>
          </td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
<?php endforeach;?>
</div>
<?php $this->block->printRegion($layouts, 'forum_index', 'footer');?>
<?php include '../../common/view/footer.html.php'; ?>
