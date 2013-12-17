<?php include '../../common/view/header.html.php';?>
<?php $common->printPositionBar($article->origins);?>
<div class='box radius'>
  <div class='content'>
    <h1 class='a-center'><?php echo $article->title;?></h1>
    <div class='a-center mb-10px'>
      <div class='f-12px'>
      <?php
      printf($lang->book->lblAddedDate, $article->addedDate);
      printf($lang->book->lblAuthor,    $article->author);
      printf($lang->book->lblViews,     $article->views);
      ?>
      </div>
    </div>
    <?php if($article->summary) echo "<div class='summary'><strong>{$lang->book->summary}</strong>$lang->colon$article->summary</div>";?>
    <div>
      <?php echo $content;?>
      <div class='article-file mt-10px'><?php $this->book->printFiles($article->files);?></div>
    </div>
    <?php if($article->keywords) echo "<div class='keywords'><strong>{$lang->book->keywords}</strong>$lang->colon$article->keywords</div>";?>
    <?php extract($prevAndNext);?>
    <div class='row f-12px mt-10px'>
      <div class='col-md-4 a-left'> <?php $prev ? print($lang->book->prev . $lang->colon . html::a(inlink('read', "id=$prev->id", "book={$book->alias}&node={$prev->alias}"), $prev->title)) : print($lang->book->none);?></div>
      <div class='col-md-4 a-center'><?php echo html::a(inlink('browse', "bookID={$parent->id}", "book={$book->alias}&node={$parent->alias}"), $lang->book->chapter);?></div>
      <div class='col-md-4 a-right'><?php $next ? print($lang->book->next . $lang->colon . html::a(inlink('read', "id=$next->id", "book={$book->alias}&node={$next->alias}"), $next->title)) : print($lang->book->none);?></div>
    </div>
  </div>
</div>
<div id='commentBox'><?php echo $this->fetch('message', 'comment', "objectType=book&objectID=$article->id");?></div>
<?php include '../../common/view/footer.html.php'; ?>
