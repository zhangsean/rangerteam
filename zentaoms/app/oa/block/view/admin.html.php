<?php
/**
 * The browse view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<table class='table table-bordered table-hover table-striped'>
  <caption>
    <div class='f-left'><?php echo $lang->block->browseBlocks;?></div>
    <div class='f-right'><?php echo html::a(inlink('create'), $lang->block->create);?></div>
  </caption>
  <tr class='a-center'>
    <th class='w-100px a-center'><?php echo $lang->block->id;?></th>
    <th><?php echo $lang->block->title;?></th>
    <th><?php echo $lang->block->type;?></th>
    <th class='w-200px'><?php echo $lang->actions;?></th>
  </tr>
  <?php foreach($blocks as $block):?>
  <tr class='a-center'>
    <td><?php echo $block->id;?></td>
    <td class='a-left'><?php echo $block->title;?></td>
    <td><?php echo $lang->block->typeList[$block->type];?></td>
    <td>
      <?php 
      echo html::a(inlink('edit',   "blockID=$block->id"), $lang->edit);
      echo html::a(inlink('delete', "blockID=$block->id"), $lang->delete, "class='deleter'");
      ?>
    </td>
  </tr>
  <?php endforeach;?>
  <tr>
    <td colspan='4'> <?php echo $pager->get(); ?> </td>
  </tr>
</table>
<?php include '../../common/view/footer.admin.html.php';?>
