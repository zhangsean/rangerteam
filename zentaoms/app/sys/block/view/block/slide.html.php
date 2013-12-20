<?php
/**
 * The about front view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Yidong wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
?>
<?php $slides = $this->loadModel('slide')->getList();?>
<?php if($slides):?>
<div id='slide' class='carousel slide'>
  <div class='carousel-inner'>
    <?php foreach($slides as $slide):?>
    <div class='item'>
      <?php 
      $addLink2Image = $slide->url != '' and $slide->label == '';
      $addLink2Image ? print(html::a($slide->url, html::image($slide->image))) : print(html::image($slide->image));
      ?>
      <div class='container'>
        <div class='carousel-caption'>
          <h2><?php echo $slide->title;?></h2>
          <div class='lead'><?php echo $slide->summary;?></div>
          <?php if(trim($slide->label) != '') echo html::a($slide->url, $slide->label, "class='btn btn-lg btn-primary'");?>
        </div>
      </div>
    </div>
    <?php endforeach;?>
  </div>
  <?php echo html::a('#slide', $this->lang->prev, "class='left carousel-control' data-slide='prev'")?>
  <?php echo html::a('#slide', $this->lang->next, "class='right carousel-control' data-slide='next'")?>
</div>
<?php endif;?>
