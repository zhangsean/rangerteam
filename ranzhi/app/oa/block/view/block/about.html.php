<?php
/**
 * The about front view file of block module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
*/
?>
<div id='about' class='panel panel-block'>
  <div class='panel-heading'>
    <h4><i class='icon-group'></i> <?php echo $block->title;?></h4>
  </div>
  <div class='panel-body'>
    <?php echo $this->config->company->desc;?>
    <?php echo html::a(helper::createLink('company', 'index'), $this->lang->more . $this->lang->raquo);?>
  </div>
</div>
