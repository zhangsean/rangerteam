<?php
/**
 * The reply view file of reply module of RanZhi.
 *
 * @copyright   Copyright 2009-2016 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     reply
 * @version     $Id: reply.html.php 4029 2016-08-26 06:50:41Z liugang $
 * @link        http://www.ranzhico.com
 */
?>
<?php if($this->thread->hasManagePriv($this->app->user->account, $board->owners)) $config->thread->editor->editreply['tools'] = 'full'; ?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<form method='post' id='ajaxForm' enctype='multipart/form-data'>
<table class='table table-form'>
  <caption><?php echo $lang->thread->editReply;?></caption>
  <tr>
    <th class='w-100px'><?php echo $lang->reply->content;?></th>
    <td>
      <?php echo html::textarea('content', htmlspecialchars($reply->content), "rows=20 class='area-1' tabindex=1");?>
    </td>
  </tr>
  <tr>
    <th><?php echo $lang->thread->file;?></th>
    <td>
    <?php
    if($reply->files)
    {
        foreach($reply->files as $file) echo html::a($file->fullURL, $file->title . '.' . $file->extension, "target='_blank'") . ' ' . html::linkButton('Ｘ', inlink('deleteFile', "fileID=$file->id&objectID=$reply->id&objectType=reply"), 'btn btn-default', '', 'hiddenwin');
    }
    echo $this->fetch('file', 'buildForm');
    ?>
    </td>
  </tr>
  <tr>
    <th></th>
    <td colspan='2' align='center'><?php echo html::submitButton('', 'btn btn-primary', 'onclick="return checkGarbage(\'content\')" tabindex=2' ) . html::backButton();?></td></tr>
</table>
</form>
<?php include '../../common/view/footer.html.php';?>
