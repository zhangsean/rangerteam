<?php
/**
 * The product form view file of block module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
?>
<?php include '../../common/view/chosen.html.php';?>
<?php $categories = $this->loadModel('tree')->getOptionMenu('product');?>
<tr>
  <th><?php echo $lang->block->categories;?></th>
  <td><?php echo html::select('params[category][]', $categories, isset($block) ? $block->content->category : '', "class='text-4 form-control chosen' multiple='multiple'");?></td>
</tr>
<tr>
  <th><?php echo $lang->block->limit;?></th>
  <td><?php echo html::input('params[limit]', isset($block->content->limit) ? $block->content->limit : '', "class='text-4 form-control'");?></td>
</tr>
<tr>
  <th><?php echo $lang->block->showImage;?></th>
  <td><input type='checkbox' name='params[image]' <?php if(isset($block->content->image) && $block->content->image) echo 'checked';?> value='1' /></td>
</tr>
