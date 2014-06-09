<?php
/**
 * The side view file of thread module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     thread
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<div class='col-md-2'>
  <?php foreach($boards as $parentBoard):?>
  <div class='panel'>
    <div class='panel-heading'>
      <strong><i class='icon-comments-alt icon-large'></i>&nbsp;<?php echo $parentBoard->name;?></strong>
    </div>
    <div class='panel-body'>
      <ul class='boards'>
        <?php foreach($parentBoard->children as $childBoard):?>
        <li><?php echo html::a($this->createLink('forum', 'board', "id=$childBoard->id"), $childBoard->name, "id='board{$childBoard->id}'");?></li>
        <?php endforeach;?>
      </ul>
    </div>
  </div>
  <?php endforeach;?>
</div>
