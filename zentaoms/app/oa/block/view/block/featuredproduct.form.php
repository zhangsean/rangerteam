<?php
/**
 * The featured product form view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
?>
<?php include '../../common/view/chosen.html.php';?>
<?php $products = $this->loadModel('product')->getPair(0);?>
<tr>
  <th><?php echo $lang->block->product;?></th>
  <td><?php echo html::select('params[product]', $products, isset($block) ? $block->content->product : '', "class='text-4 form-control'");?></td>
</tr>
