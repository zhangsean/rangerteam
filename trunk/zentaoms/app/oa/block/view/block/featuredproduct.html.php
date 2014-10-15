<?php
/**
 * The featured product front view file of block module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
*/
?>
<?php 
$content  = json_decode($block->content);
$product  = $this->loadModel('product')->getByID($content->product);
?>
<?php if(!empty($product)):?>
<?php
$category = array_shift($product->categories);
$alias    = !empty($category) ? $category->alias : '';
$url      = helper::createLink('product', 'view', "id={$product->id}", "category={$alias}&name={$product->alias}");
?>
<div class='panel panel-block'>
  <div class='panel-body'>
    <a class='card' href="<?php echo $url;?>">
      <div class='media'><?php echo html::image($product->image->primary->middleURL, "title='{$title}' alt='{$product->name}'"); ?></div>
      <div class='card-heading'>
        <span class='pull-right text-latin'>
        <?php
        if($product->promotion != 0)
        {
            if($product->price != 0)
            {
                echo "<del class='text-muted'><i class='icon-yen'></i> " . $product->price .'</del>';
            }
            echo "&nbsp;&nbsp;<span class='text-muted'><i class='icon-yen'></i></span> ";
            echo "<strong class='text-danger'>" . $product->promotion . '</strong>';
        }
        else
        {
            if($product->price != 0)
            {
                echo "<span class='text-muted'><i class='icon-yen'></i></span> ";
                echo "<strong class='text-important'>" . $product->price . '</strong>&nbsp;&nbsp;';
            }
        }
        ?>
        </span>
        <strong><?php echo $product->name; ?></strong>
      </div>
      <div class='card-content text-muted'><?php echo helper::substr($product->summary, 80);?></div>
    </a>
  </div>
</div>
<?php endif;?>
