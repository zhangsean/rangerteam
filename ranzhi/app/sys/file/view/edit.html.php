<?php
/**
 * The edit view file of file module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     file 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.modal.html.php';?>
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
<?php include '../../common/view/footer.modal.html.php';?>
