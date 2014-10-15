<?php
/**
 * The edit view file of file module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     file 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<div class='bg-white radius'>
<form method='post' enctype='multipart/form-data' id='fileForm' action='<?php echo $this->createLink('file', 'edit', "fileID=$file->id")?>'>
<table class='table table-form'>
  <caption><?php echo $lang->file->edit;?></caption>
  <tr>
    <th class='w-200px'><?php echo $lang->file->title;?></th> 
    <td><?php echo html::input('title',$file->title, "class='text-1'");?></td>
  </tr>
  <tr>
    <th><?php echo $lang->file->editFile;?></th>
    <td><?php echo html::file('upFile');?></td>
  </tr>
  <tr>
    <th></th>
    <td><?php echo html::submitButton() . html::commonButton($lang->goback, 'btn btn-default goback')?></td>
  </tr>

</table>
</form>
</div>
<script>
$(function()
{
    $.setAjaxForm('#fileForm', function(data){$.reloadAjaxModal();}); 
    $('.goback').click(function(){$.reloadAjaxModal();})
})
</script>
