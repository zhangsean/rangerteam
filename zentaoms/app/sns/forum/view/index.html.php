<?php include '../../common/view/header.html.php'; ?>
<?php $common->printPositionBar();?>
<div id="boards">
<?php foreach($boards as $parentBoard):?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4><i class="icon-comments icon-large"></i> <?php echo $parentBoard->name;?></h4>
    </div>
    <div class="panel-body no-padding">
      <table class='table table-hover table-striped'>
        <thead>
          <tr class='a-center'>
            <th colspan='2'>&nbsp;<?php echo $lang->forum->board;?></th>
            <th><?php echo $lang->forum->owners;?></th>
            <th><?php echo $lang->forum->threadCount;?></th>
            <th><?php echo $lang->forum->postCount;?></th>
            <th><?php echo $lang->forum->lastPost;?></th>
          </tr>  
        </thead>
        <tbody>
          <?php foreach($parentBoard->children as $childBoard):?>
          <tr valign='middle' class='a-center'>
            <td class='w-20px'><?php echo $this->forum->isNew($childBoard) ? "<span class='new-board'><i class='icon-comment icon-large'></i></span>" : "<span class='common-board'><i class='icon-comment icon-large'></i></span>"; ?></td>
            <td class='a-left'>
              <strong><?php echo html::a(inlink('board', "id=$childBoard->id", "category={$childBoard->alias}"), $childBoard->name);?></strong><br />
              <i><?php echo $childBoard->desc;?></i>
            </td>
            <td class='w-50px strong'><nobr><?php echo trim($childBoard->moderators, ',');?></nobr></td>
            <td class='w-70px'><?php echo $childBoard->threads;?></td>
            <td class='w-70px'><?php echo $childBoard->posts;?></td>
            <td class='w-150px a-left'>
              <?php
              if($childBoard->postedBy)
              {
                  echo substr($childBoard->postedDate, 5, -3) . ' '; 
                  echo html::a($this->createLink('thread', 'locate', "threadID={$childBoard->postID}&replyID={$childBoard->replyID}"), $childBoard->postedBy);;
              }
              ?>
            </td>
          </tr>  
          <?php endforeach;?>
        </tbody>
      </table>    
    </div>
  </div>
<?php endforeach;?>   
</div>
<?php include '../../common/view/footer.html.php'; ?>
