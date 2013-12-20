<?php
/**
 * The latest article front view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
?>
<?php 
/* Set $themRoot. */
$themeRoot = $this->config->webRoot . 'theme/';

/* Decode the content and get articles. */
$content  = json_decode($block->content);
$method   = 'get' . ucfirst(str_replace('article', '', strtolower($block->type)));
$articles = $this->loadModel('article')->$method(empty($content->category) ? 0 : $content->category, $content->limit);

/* Compute the more link. */
$moreLink = '';
if($articles)
{
    reset($articles);
    $firstArticle  = current($articles);
    $firstCategory = $this->loadModel('tree')->getByID($firstArticle->category);
    if($firstCategory) $moreLink = html::a(helper::createLink('article', 'browse', "category=$firstCategory->id", "category=$firstCategory->alias"), $this->lang->more, "class='f-right'");
}
?>
<?php if(isset($content->image)):?>
<div class='box radius'>
  <h4 class='title'><?php echo $block->title . $moreLink;?></h4>
  <ul class="media-list">
    <?php 
    foreach($articles as $article):
    $category = array_shift($article->categories);
    $url = helper::createLink('article', 'view', "id=$article->id", "category={$category->alias}&name=$article->alias");
    ?>
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
        <h4 class='media-heading'> <?php echo html::a($url, $article->title);?> <span class='label label-default'><?php echo substr($article->addedDate, 0, 10);?></span> </h4>
        <p><?php echo $article->summary;?></p>
      </div>
      <hr>
    </li>
    <?php endforeach;?>
  </ul>
</div>
<?php else:?>
<div class="panel panel-default">
  <div class="panel-heading"><h4><?php echo $block->title . $moreLink;?></h4></div>
  <div class="panel-body">
    <ul class='mg-zero pd-zero'>
      <?php foreach($articles as $article): ?>
      <?php 
      $category = array_shift($article->categories);
      $url = helper::createLink('article', 'view', "id={$article->id}", "category={$category->alias}&name={$article->alias}");
      ?>
      <li class='latest-news'>
        <i class='icon-chevron-right'></i>
        <?php echo html::a($url, $article->title, "class='latest-news' title='{$article->title}'");?>
      </li>
      <?php endforeach;?>
    </ul>
  </div>
</div>
<?php endif;?>
