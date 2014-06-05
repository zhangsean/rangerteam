<?php include '../../common/view/header.html.php'; ?>
<div id='boards'>
<?php foreach($boards as $parentBoard):?>
  <div class='panel'>
    <div class='panel-heading'>
      <strong><i class='icon-comments icon-large'></i> <?php echo $parentBoard->name;?></strong>
    </div>
    <table class='table table-hover table-striped'>
      <tbody>
        <tr>
          <?php $count = count($parentBoard);?>
          <?php $i = 0;?>
          <?php foreach($parentBoard->children as $childBoard):?>
          <?php $i++;?>
          <td class='border' width='33%'>
            <table class='board'>
              <tbody>
                <tr class='board'>
                  <td class='w-20px'><?php echo $this->forum->isNew($childBoard) ? "<span class='text-success'><i class='icon-comment icon-large'></i></span>" : "<span class='text-muted'><i class='icon-comment icon-large'></i></span>"; ?></td>
                  <td><?php echo html::a(inlink('board', "id=$childBoard->id", "category={$childBoard->alias}"), $childBoard->name);?>（<?php echo $lang->forum->threadCount . $lang->colon . $childBoard->threads . ' ' . $lang->forum->postCount . $lang->colon . $childBoard->posts;?>）</td>
                </tr>
                <tr class='board'>
                  <td colspan='2'>
                  <?php 
                  if($childBoard->postedBy)
                  {
                      $postedDate = substr($childBoard->postedDate, 5, -3); 
                      $postedBy   =  html::a($this->createLink('thread', 'locate', "threadID={$childBoard->postID}&replyID={$childBoard->replyID}"), $childBoard->postedBy);;
                      echo sprintf($lang->forum->lastPost, $postedDate, $postedBy);
                  }
                  else
                  {
                      echo $lang->forum->noPost;
                  }
                  ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
          <?php if(($i % 3) == 0) echo $i == $count ? "</tr>" : "</tr><tr>";?>
          <?php endforeach;?>
          <?php 
            if(($i % 3) == 1) echo "<td class='border'></td><td class='border'></td></tr>"; 
            if(($i % 3) == 2) echo "<td class='border'></td></tr>";
          ?>
        </tr>
      </tbody>
    </table>
  </div>
<?php endforeach;?>
</div>
<?php include '../../common/view/footer.html.php'; ?>
