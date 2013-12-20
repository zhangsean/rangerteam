<?php
/**
 * The hot product front view file of block module of chanzhiEPS.
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
$content  = json_decode($block->content);
$type     = str_replace('product', '', strtolower($block->type));
$method   = 'get' . $type;
$products = $this->loadModel('product')->$method($content->category, $content->limit);?>
<?php if(isset($content->image)):?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h4 class='title'><?php echo $block->title?></h4>
  </div>
  <div class="panel-body">
    <ul class="media-list">
      <?php foreach($products as $product):?>
      <li class='media'>
        <?php 
        $productCategory = array_shift($product->categories);
        $url = helper::createLink('product', 'view', "id=$product->id", "category={$productCategory->alias}&name=$product->alias");
        $title = $product->image->primary->title ? $product->image->primary->title : $product->name;
        if(empty($product->image)) 
        {
            echo html::a($url, html::image($themeRoot . 'default/images/main/noimage.gif', "title='{$title}' class='adaptive'"), "class='media-image'");
        }
        else
        {
            echo html::a($url, html::image($product->image->primary->middleURL, "title='{$title}' class='adaptive'"), "class='media-image'");
        }
        ?>
        <div class='media-body'>
          <h5 class='media-heading'><?php echo html::a($url, $product->name);?></h5>
          <?php if($product->promotion != 0 && $product->price != 0):?>
          <p>
            <del><?php echo $lang->RMB . $product->price;?></del>
            <em><?php echo $lang->RMB . $product->promotion;?></em>
          </p>
          <?php elseif($product->promotion == 0 && $product->price != 0):?>
          <p><em><?php echo $lang->product->price . $lang->RMB . $product->price;?></em></p>
          <?php elseif($product->promotion != 0 && $product->price == 0):?>
          <p><em><?php echo $lang->product->promotion . $lang->RMB . $product->promotion;?></em></p>
          <?php endif;?>
        </div>
      </li>
      <?php endforeach;?>
    </ul>      
  </div>
</div>
<?php else:?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h4 class='title'><?php echo $block->title?></h4>
  </div>
  <div class="panel-body">
    <ul class="mg-zero pd-zero">
      <?php foreach($products as $product):?>
      <li>
        <?php 
        $productCategory = array_shift($product->categories);
        $url = helper::createLink('product', 'view', "id=$product->id", "category={$productCategory->alias}&name=$product->alias");
        $title = $product->image->primary->title ? $product->image->primary->title : $product->name;
        ?>
        <i class='icon-chevron-right'></i><?php echo html::a($url, $product->name);?>
      </li>
      <?php endforeach;?>
    </ul>      
  </div>
</div>
<?php endif;?>
