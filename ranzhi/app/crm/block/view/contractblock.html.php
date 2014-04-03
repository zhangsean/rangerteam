<?php
/**
 * The contract block view file of block module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<table class='table table-data table-hover' id='crmBlockContract'>
  <tr>
    <th class='w-id text-center'><?php echo $lang->contract->id?></th>
    <th><?php echo $lang->contract->name?></th>
    <th><?php echo $lang->contract->amount?></th>
  </tr>
  <?php foreach($contracts as $id => $contract):?>
  <?php $appid = ($this->get->app == 'sys' and isset($_GET['entry'])) ? "class='app-btn' data-id='{$this->get->entry}'" : ''?>
  <tr data-url='<?php echo $this->createLink('contract', 'view', "id=$id"); ?>' <?php echo $appid?>>
    <td class='text-center'><?php echo $id?></td>
    <td class='nobr'><strong><?php echo $contract->name;?></strong></td>
    <td><strong class='text-danger'><?php echo $contract->amount?></strong></td>
  </tr>
  <?php endforeach;?>
</table>
<script>if(!$.ipsStart) $('#crmBlockContract').dataTable();</script>
