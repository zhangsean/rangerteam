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
<form method='post' id='ajaxModalForm' action='<?php echo $this->createLink('contract', 'items', "contractID=$contractID")?>'>
  <table class='table table-form'>
    <tr>
      <th><?php echo $lang->contract->items;?></th>
      <td><?php echo html::textarea('items', $contract->items, "class='form-control'");?></td>
    </tr>
    <?php if(!empty($files)):?>
    <tr>
      <th></th>
      <td>
        <?php foreach($files as $file):?>
        <?php
        if($file->isImage)
        {
            echo html::a($this->createLink('file', 'download', "id=$file->id&mouse=left"), html::image($file->smallURL, "class='image-items' title='{$file->title}'"), "class='file-items' target='_blank'");
        }
        else
        {
            echo html::a($this->createLink('file', 'download', "id=$file->id"), "{$file->title}.{$file->extension}", "class='file-items' target='_blank'");
        }
        ?>
        <?php endforeach;?>
      </td>
    </tr>
    <?php endif;?>
    <tr>
      <th><?php echo $lang->files;?></th>
      <td><?php echo $this->fetch('file', 'buildForm');?></td>
    </tr>
    <tr>
      <th></th>
      <td><?php echo html::submitButton();?></td>
    </tr>
  </table>
</form>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
