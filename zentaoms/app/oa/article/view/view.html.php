<?php 
include '../../common/view/header.html.php'; 
include '../../common/view/treeview.html.php'; 

/* set categoryPath for topNav highlight. */
js::set('path',  json_encode($article->path));
js::set('articleID', $article->id);
?>
<?php $common->printPositionBar($category, $article);?>
<div class='row'>
  <div class='col-md-9'>
    <div class='box radius'>
      <div class='content' id="articleContent">
        <h1 class='a-center'><?php echo $article->title;?></h1>
        <div class='f-12px mb-10px a-center'>
          <?php
          printf($lang->article->lblAddedDate, $article->addedDate);
          printf($lang->article->lblAuthor,    $article->author);
          if($article->original)
          {
              echo "<strong>{$lang->article->originalList[$article->original]}</strong> &nbsp;&nbsp;";
          }
          else
          {
              printf($lang->article->lblSource);
              $article->copyURL ? print(html::a($article->copyURL, $article->copySite, "target='_blank'")) : print($article->copySite); 
          }
          printf($lang->article->lblViews, $article->views);

          if(!empty($this->config->oauth->sina))
          {
              $sina = json_decode($this->config->oauth->sina);
              if($sina->widget) echo $sina->widget; 
          }
          ?>
        </div>
        <?php if($article->summary):?>
        <div class='summary'><strong><?php echo $lang->article->summary;?></strong><?php echo $lang->colon . $article->summary;?></div>
        <?php endif;?>
        <p><?php echo $article->content;?></p>
        <div class='article-file mt-10px'><?php $this->article->printFiles($article->files);?></div>
        <?php if($article->keywords):?>
        <div class='keywords'><strong><?php echo $lang->article->keywords;?></strong><?php echo $lang->colon . $article->keywords;?></div>
        <?php endif;?>
        <?php extract($prevAndNext);?>
        <div class='row f-12px mt-20px'>
          <div class='col-sm-5 a-left'> <?php $prev ? print($lang->article->prev . $lang->colon . html::a(inlink('view', "id=$prev->id", "category={$category->alias}&name={$prev->alias}"), $prev->title)) : print($lang->article->none);?></div>
          <div class="col-sm-2 text-center"><a href="#articleContent"><i class="icon-arrow-up"></i> <?php echo $lang->article->back2Top; ?></a></div>
          <div class='col-sm-5 a-right'><?php $next ? print($lang->article->next . $lang->colon . html::a(inlink('view', "id=$next->id", "category={$category->alias}&name={$next->alias}"), $next->title)) : print($lang->article->none);?></div>
        </div>
      </div>
    </div>
    <div id='commentBox'><?php echo $this->fetch('message', 'comment', "objectType=article&objectID={$article->id}");?></div>
    <?php echo html::a('', '', "name='comment'");?>
  </div>
  <div class='col-md-3'><?php $this->block->printRegion($layouts, 'article_view', 'side');?></div>
</div>
<?php include '../../common/view/footer.html.php'; ?>
