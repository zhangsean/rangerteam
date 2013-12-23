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
<div class='panel panel-block'>
  <div class='panel-heading'>
    <h4><i class='icon-th'></i> <?php echo $block->title?></h4>
  </div>
  <div class='panel-body'>
    <div class='cards cards-borderless'>
      <?php foreach($products as $product):?>
      <?php 
      $productCategory = array_shift($product->categories);
      $url = helper::createLink('product', 'view', "id=$product->id", "category={$productCategory->alias}&name=$product->alias");
      $title = $product->image->primary->title ? $product->image->primary->title : $product->name;
      ?>
      <?php if(!empty($product->image)): ?>
      <div class='col-md-12 col-sm-4 col-xs-6'>
        <a class='card' href="<?php echo $url;?>">
          <div class='media'><?php echo html::image($product->image->primary->middleURL, "title='{$title}' alt='{$product->name}'"); ?></div>
          <strong class='card-heading'>
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
            <?php echo $product->name; ?>
          </strong>
        </a>
      </div>
      <?php endif;?>
      <?php endforeach;?>
    </div>
  </div>
</div>
<?php else:?>
<div class='panel panel-block'>
  <div class='panel-heading'><h4><i class='icon-list-ul'></i> <?php echo $block->title;?></h4></div>
  <div class='panel-body'>
    <ul class='ul-list'>
      <?php foreach($products as $product):?>
      <?php 
      $category = array_shift($product->categories);
      $url = helper::createLink('product', 'view', "id=$product->id", "category={$productCategory->alias}&name=$product->alias");
        $title = $product->image->primary->title ? $product->image->primary->title : $product->name;
      ?>
      <li>
        <span class='text-latin pull-right'>
        <?php
        if($product->promotion != 0)
        {
            if($product->price != 0)
            {
                echo "<small class='text-muted'><i class='icon-yen'></i></small> ";
                echo "<del><small class='text-muted'>" . $product->price . "</small></del>";
            }
            echo "&nbsp; <small class='text-muted'><i class='icon-yen'></i></small> ";
            echo "<strong class='text-danger'>" . $product->promotion . "</strong>";
        }
        else if($product->price != 0)
        {
            echo "&nbsp; <small class='text-muted'><i class='icon-yen'></i></small> ";
            echo "<strong class='text-important'>" . $product->price . "</strong>";
        }
        ?>
        </span>
        <?php echo html::a($url, $product->name);?>
      </li>
      <?php endforeach;?>
    </ul>
  </div>
</div>
<?php endif;?>
