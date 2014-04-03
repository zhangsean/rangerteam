<?php
/**
 * The contact front view file of block module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
*/
?>
<?php $contact = $this->loadModel('company')->getContact();?>
<div id='contact' class='panel panel-block'>
  <div class='panel-heading'>
    <h4><i class='icon-phone'></i> <?php echo $block->title;?></h4>
  </div>
  <div class='panel-body'>
    <dl class='dl-horizontal'>
    <?php foreach($contact as $item => $value):?>
      <dt><?php echo $this->lang->company->$item . $this->lang->colon;?></dt>
      <dd><?php echo $value;?></dd>
    <?php endforeach;?>
    </dl>
  </div>
</div>
