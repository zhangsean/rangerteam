<?php
/**
 * The edit reply view file of block module of RanZhi.
 *
 * @copyright   Copyright 2009-2016 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $Id: edit.html.php 4029 2016-08-26 06:50:41Z liugang $
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<?php js::set('boardID', $board->id);?>
<div class='row'>
  <div class='col-md-2'>
    <ul class="nav nav-primary nav-stacked">
      <?php foreach($boards as $parentBoard):?>
      <li class="nav-heading"><?php echo $parentBoard->name;?></li>
      <?php foreach($parentBoard->children as $childBoard):?>
      <li><?php echo html::a($this->createLink('forum', 'board', "id=$childBoard->id"), $childBoard->name, "id='board{$childBoard->id}'");?></li>
      <?php endforeach;?>
      <?php endforeach;?>
    </ul>
  </div>
  <div class='col-md-10'>
    <div class='panel'>
      <div class='panel-heading'><strong><i class='icon-edit'></i> <?php echo $lang->reply->edit;?></strong></div>
      <div class='panel-body'>
        <form method='post' class='form-horizontal' id='ajaxForm' enctype='multipart/form-data'>
          <div class='form-group'>
            <label class='col-md-1 col-sm-2 control-label'><?php echo $lang->reply->content;?></label>
            <div class='col-md-11 col-sm-10'><?php echo html::textarea('content', $reply->content, "rows='15' class='form-control'");?></div>
          </div>
          <div class='form-group'>
            <label class='col-md-1 col-sm-2 control-label'><?php echo $lang->thread->file;?></label>
            <div class='col-md-7 col-sm-8 col-xs-11'>
              <?php
              $this->reply->printFiles($reply, $canManage = true);
              echo $this->fetch('file', 'buildForm');
              ?>
            </div>
          </div>
          <div class='form-group'>
            <label class='col-md-1 col-sm-2'></label>
            <div class='col-md-11 col-sm-10'><?php echo html::submitButton() . ' &nbsp; ' . html::backButton();?></div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
