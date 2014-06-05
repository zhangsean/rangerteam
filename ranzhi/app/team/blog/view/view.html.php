<?php
/**
 * The view file of blog view method of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include './header.html.php'; ?>
<?php $root = '<li>' . $this->lang->currentPos . $this->lang->colon .  html::a($this->inlink('index'), $lang->home) . '</li>'; ?>
<?php js::set('articleID', $article->id);?>
<?php js::set('categoryID', $category->id);?>
  <div class='col-md-9'>
    <div class='article'>
      <header>
        <h1><?php echo $article->title;?></h1>
        <dl class='dl-inline'>
          <dd data-toggle='tooltip' data-placement='top' data-original-title='<?php printf($lang->article->lblAddedDate, formatTime($article->createdDate));?>'><i class="icon-time icon-large"></i> <?php echo formatTime($article->createdDate);?></dd>
          <dd data-toggle='tooltip' data-placement='top' data-original-title='<?php printf($lang->article->lblAuthor, $article->author);?>'><i class='icon-user icon-large'></i> <?php echo $article->author; ?></dd>
          <?php if(!$article->original):?>
          <dt><?php echo $lang->article->lblSource; ?></dt>
          <dd><?php $article->copyURL ? print(html::a($article->copyURL, $article->copySite, "target='_blank'")) : print($article->copySite); ?></dd>
          <?php endif; ?>
        </dl>
      </header>
      <?php if($article->summary) echo "<div class='summary'><strong>{$lang->article->summary}</strong>$lang->colon$article->summary</div>";?>
      <p><?php echo $article->content;?></p>
      <div class='article-file'><?php $this->loadModel('article')->printFiles($article->files);?></div>
      <?php if($article->keywords) echo "<div class='keywords'><strong>{$lang->article->keywords}</strong>$lang->colon$article->keywords</div>";?>
      <?php extract($prevAndNext);?>
      <div class='row f-12px mt-10px'>
        <div class='col-md-6 text-left'> <?php $prev ? print($lang->article->prev . $lang->colon . html::a(inlink('view', "id=$prev->id", "category={$category->alias}&name={$prev->alias}"), $prev->title)) : print($lang->article->none);?></div>
        <div class='col-md-6 text-right'><?php $next ? print($lang->article->next . $lang->colon . html::a(inlink('view', "id=$next->id", "category={$category->alias}&name={$next->alias}"), $next->title)) : print($lang->article->none);?></div>
      </div>
    </div>
    <div id='commentBox'></div>
    <?php echo html::a('', '', "name='comment'");?>
  </div>
<?php include './footer.html.php';?>
