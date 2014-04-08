<?php
/**
 * The edit view file of file module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     file 
 * @version     $Id$
 * @link        http://www.ranzhi.co
 */
?>
<?php include '../../common/view/header.modal.html.php';?>
<div class="modal-dialog" style="width:450px;">
  <div class="modal-content">
    <div class="modal-header">
      <?php echo html::closeButton();?>
      <h4 class="modal-title"><i class="icon-cog"></i> <?php echo $lang->file->edit; ?></h4>
    </div>
    <div class="modal-body">
      <form method='post' enctype='multipart/form-data' id='ajaxModalForm' action='<?php echo $this->createLink('file', 'edit', "fileID=$file->id")?>'>
        <table class='table table-form'>
          <tr>
            <th class='w-100px'><?php echo $lang->file->title;?></th> 
            <td><?php echo html::input('title',$file->title, "class='text-1'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->file->editFile;?></th>
            <td><?php echo html::file('upFile');?></td>
          </tr>
          <tr>
            <th></th>
            <td><?php echo html::submitButton()?></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
