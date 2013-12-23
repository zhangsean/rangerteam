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
<div id='about' class='panel panel-block'>
  <div class='panel-heading'>
    <h4><i class='icon-group'></i> <?php echo $block->title;?></h4>
  </div>
  <div class='panel-body'>
    <?php echo $this->config->company->desc;?>
    <?php echo html::a(helper::createLink('company', 'index'), $this->lang->more . $this->lang->raquo);?>
  </div>
</div>
