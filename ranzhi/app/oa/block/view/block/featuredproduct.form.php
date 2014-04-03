<?php
/**
 * The featured product form view file of block module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
*/
?>
<?php include '../../common/view/chosen.html.php';?>
<?php $products = $this->loadModel('product')->getPair(0);?>
<tr>
  <th><?php echo $lang->block->product;?></th>
  <td><?php echo html::select('params[product]', $products, isset($block) ? $block->content->product : '', "class='text-4 form-control'");?></td>
</tr>
