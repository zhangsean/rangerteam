<?php 
include '../../common/view/header.html.php';

$path = array_keys($category->pathNames);
js::set('path',  json_encode($path));

include '../../common/view/treeview.html.php';
?>
<?php echo $common->printPositionBar($category);?>
<div class='row'>
  <div class='col-md-9'>
    <div class='box radius'>
      <h4 class='title'><?php echo $category->name;?></h4>
      <ul class="media-list">
      <?php foreach($articles as $article):?>
      <?php $url = inlink('view', "id=$article->id", "category={$category->alias}&name=$article->alias");?>
        <li class="media">
          <div class='media-body'>
            <div class='image-box'>
              <?php 
              if(!empty($article->image))
              {
                  $title = $article->image->primary->title ? $article->image->primary->title : $article->title;
                  echo html::a($url, html::image($article->image->primary->smallURL, "title='{$title}' class='thumbnail'" ));
              }
              else
              {
                  echo html::a($url, html::image($themeRoot . 'default/images/main/noimage.gif', "class='thumbnail'" ));
              }
            ?>
            </div>
            <h3 class='media-heading'><small class='pull-right gray'><i class="icon-time"></i> <?php echo substr($article->addedDate, 0, 10);?></small><?php echo html::a($url, $article->title);?></h3>
            <p><?php echo helper::substr($article->summary, 120, '...');?></p>
          </div>
        </li>
      <?php endforeach;?>
      </ul>
      <div class='w-p95 pd-10px clearfix'><?php $pager->show('right', 'short');?></div>
      <div class='c-both'></div>
    </div>
  </div>
  <div class='col-md-3'><?php $this->block->printRegion($layouts, 'article_browse', 'side');?></div>
</div>
<?php include '../../common/view/footer.html.php';?>
