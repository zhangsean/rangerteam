<?php
/**
 * The project list block view file of block module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<table class='table table-data table-hover table-fixed'>
  <?php foreach($depositors as $id => $depositor):?>
  <?php $provider = $depositor->type == 'bank' ? $depositor->provider : $lang->depositor->providerList[$depositor->provider] ?>
  <tr>
     <td> <?php echo $depositor->title;?></td>
     <td> <?php echo $depositor->account;?></td>
     <td class='w-160px'><?php echo $provider;?> </td>
  </tr>
  <?php endforeach;?>
</table>
