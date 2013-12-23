<?php
/**
 * The post view file of thread module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     thread
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>

<?php $common->printPositionBar($board);?>

<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-edit'></i> <?php echo $lang->thread->postTo . ' [ ' . $board->name . ' ]'; ?></strong></div>
  <div class='panel-body'>
    <form method='post' class='form-horizontal' id='threadForm' enctype='multipart/form-data'>
      <div class='form-group'>
        <label class='col-md-1 col-sm-2 control-label'><?php echo $lang->thread->title;?></label>
        <div class='col-md-9 col-sm-8'><?php echo html::input('title', '', "class='form-control'");?></div>
        <?php if($canManage): ?>
        <div class='col-md-2 col-sm-2'>
          <div class='checkbox'>
              <label>
                <?php echo "<input type='checkbox' name='readonly' value='1'/><span>{$lang->thread->readonly}</span>" ?>
              </label>
          </div>
          <?php  ?>
        </div>
        <?php endif; ?>
      </div>
      <div class='form-group'>
        <label class='col-md-1 col-sm-2 control-label'><?php echo $lang->thread->content;?></label>
        <div class='col-md-11 col-sm-10'><?php echo html::textarea('content', '', "rows='15' class='form-control'");?></div>
      </div>
      <div class='form-group'>
        <label class='col-md-1 col-sm-2 control-label'><?php echo $lang->thread->file;?></label>
        <div class='col-md-7 col-sm-8 col-xs-11'><?php echo $this->fetch('file', 'buildForm');?></div>
      </div>
      <div class='form-group' id='captchaBox' style='display:none'></div>
      <div class='form-group'>
        <label class='col-md-1 col-sm-2'></label>
        <div class='col-md-11 col-sm-10'><?php echo html::submitButton();?></div>
      </div>
    </form>
  </div>
</div>


</form>
<?php include '../../common/view/footer.html.php';?>
