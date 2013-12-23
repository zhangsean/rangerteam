<?php
/**
 * The about front view file of block module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
?>
<?php $slides = $this->loadModel('slide')->getList();?>
<?php if($slides):?>
<div id='slide' class='carousel slide' data-ride='carousel'>
  <div class='carousel-inner'>
    <?php foreach($slides as $slide):?>
    <div class='item'>
      <?php 
      $addLink2Image = $slide->url != '' and $slide->label == '';
      $addLink2Image ? print(html::a($slide->url, html::image($slide->image))) : print(html::image($slide->image));
      ?>
      <div class='carousel-caption'>
        <h2><?php echo $slide->title;?></h2>
        <div class='lead'><?php echo $slide->summary;?></div>
        <?php if(trim($slide->label) != '') echo html::a($slide->url, $slide->label, "class='btn btn-lg btn-primary'");?>
      </div>
    </div>
    <?php endforeach;?>
  </div>
  <a class='left carousel-control' href='#slide' data-slide='prev'>
    <i class='icon-prev'></i>
  </a>
  <a class='right carousel-control' href='#slide' data-slide='next'>
    <i class='icon-next'></i>
  </a>
</div>
<?php endif;?>
