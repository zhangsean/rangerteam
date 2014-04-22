<?php
/**
 * The items view file of contract module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     contract
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
  <table class='table table-form'>
    <tr>
      <th class='w-100px'><?php echo $lang->contract->items;?></th>
      <td><?php echo $contract->items;?></td>
    </tr>
    <tr>
      <th><?php echo $lang->files;?></th>
      <td><?php echo $this->fetch('file', 'printFiles', array('files' => $files, 'fieldset' => 'false'))?></td>
    </tr>
    <tr>
      <th></th>
      <td><?php echo html::a(inlink('edit', "contractID=$contract->id"), "<i class='icon-pencil'></i> " . $lang->edit, "class='btn'");?></td>
    </tr>
  </table>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
