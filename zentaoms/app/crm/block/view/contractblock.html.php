<?php
/**
 * The contract block view file of block module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<table class='table'>
  <tr>
    <th class='w-id'><?php echo $lang->contract->id?></th>
    <th><?php echo $lang->contract->name?></th>
    <th><?php echo $lang->contract->amount?></th>
  </tr>
  <?php foreach($contracts as $id => $contract):?>
  <tr>
    <td><?php echo $id?></td>
    <td class='nobr'><?php echo html::a($this->createLink('contract', 'view', "id=$id"), $contract->name, "title=$contract->name");?></td>
    <td><?php echo $contract->amount?></td>
  </tr>
  <?php endforeach;?>
</table>
