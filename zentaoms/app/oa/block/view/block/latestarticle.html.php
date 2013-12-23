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
    if($firstCategory) $moreLink = html::a(helper::createLink('article', 'browse', "category=$firstCategory->id", "category=$firstCategory->alias"), $this->lang->more, "class='text-link'");
}
?>
<?php if(isset($content->image)):?>
<div class='panel panel-block'>
  <div class='panel-heading'>
    <h4><i class='icon-th'></i> <?php echo $block->title;?></h4>
  </div>
  <div class='panel-body'>
    <div class='items'>
    <?php
    foreach($articles as $article):
    $category = array_shift($article->categories);
    $url = helper::createLink('article', 'view', "id=$article->id", "category={$category->alias}&name=$article->alias");
    ?>
      <div class='item'>
        <div class='item-heading'><strong><?php echo html::a($url, $article->title);?></strong></div>
        <div class='item-content'>
          <div class='media'>
            <?php 
            if(!empty($article->image))
            {
                $title = $article->image->primary->title ? $article->image->primary->title : $article->title;
                echo html::a($url, html::image($article->image->primary->smallURL, "title='{$title}' class='thumbnail'" ));
            }
            ?>
          </div>
          <div class='text small text-muted'><strong class='text-important'><i class='icon-time'></i> <?php echo substr($article->addedDate, 0, 10);?></strong> &nbsp;<?php echo $article->summary;?></div>
        </div>
      </div>
      <?php endforeach;?>
    </div>
  </div>
</div>
<?php else:?>
<div class='panel panel-block'>
  <div class='panel-heading'><div class='pull-right'><?php echo $moreLink; ?></div> <h4><i class='icon-list-ul'></i> <?php echo $block->title;?></h4></div>
  <div class='panel-body'>
    <ul class='ul-list'>
      <?php foreach($articles as $article): ?>
      <?php 
      $category = array_shift($article->categories);
      $url = helper::createLink('article', 'view', "id={$article->id}", "category={$category->alias}&name={$article->alias}");
      ?>
      <li>
        <?php echo html::a($url, $article->title, "title='{$article->title}'");?>
      </li>
      <?php endforeach;?>
    </ul>
  </div>
</div>
<?php endif;?>
