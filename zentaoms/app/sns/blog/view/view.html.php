<?php
/**
 * The view file of blog view method of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php 
include './header.html.php';
$path = array_keys($category->pathNames);
js::set('path',  json_encode($path));
js::set('categoryID', $category->id);
js::set('articleID', $article->id);
include '../../common/view/treeview.html.php';
?>
<?php
$root = '<li>' . $this->lang->currentPos . $this->lang->colon .  html::a($this->inlink('index'), $lang->home) . '</li>';
$common->printPositionBar($category, $article, '', $root);
?>
<div class='row'>
  <div class='col-md-9'>
    <div class='content-box clearfix radius'>
      <div class='dater pull-right'><?php echo date('Y/m/d', strtotime($article->addedDate));?></div>
      <h1 class='text-center'><?php echo $article->title;?></h1>
      <div class='text-center info'>
        <?php
        printf($lang->article->lblAuthor,    $article->author);
        if($article->original)
        {
            echo "<strong>{$lang->article->originalList[$article->original]}</strong>";
        }
        else
        {
            printf($lang->article->lblSource);
            $article->copyURL ? print(html::a($article->copyURL, $article->copySite, "target='_blank'")) : print($article->copySite); 
        }
        printf($lang->article->lblViews, $article->views);
        ?>
      </div>
      <?php if($article->summary) echo "<div class='summary'><strong>{$lang->article->summary}</strong>$lang->colon$article->summary</div>";?>
      <p><?php echo $article->content;?></p>
      <div class='article-file'><?php $this->loadModel('article')->printFiles($article->files);?></div>
      <?php if($article->keywords) echo "<div class='keywords'><strong>{$lang->article->keywords}</strong>$lang->colon$article->keywords</div>";?>
      <?php extract($prevAndNext);?>
      <div class='row f-12px mt-10px'>
        <div class='col-md-6 a-left'> <?php $prev ? print($lang->article->prev . $lang->colon . html::a(inlink('view', "id=$prev->id", "category={$category->alias}&name={$prev->alias}"), $prev->title)) : print($lang->article->none);?></div>
        <div class='col-md-6 a-right'><?php $next ? print($lang->article->next . $lang->colon . html::a(inlink('view', "id=$next->id", "category={$category->alias}&name={$next->alias}"), $next->title)) : print($lang->article->none);?></div>
      </div>
    </div>
    <div id='commentBox'></div>
    <?php echo html::a('', '', "name='comment'");?>
  </div>
  <?php include './side.html.php';?>
</div>
<?php include './footer.html.php';?>
