<?php
/**
 * The index view file of dashboard module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     dashboard
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='dashboard dashboard-draggable panels-container ' id='dashboard'>
  <div class='dashboard-actions clearfix'>
    <div class='pull-right'><a class='btn' href='<?php echo $this->createLink("block", "admin"); ?>' data-toggle='modal'><i class='icon-plus'></i> 添加区块</a></div>
  </div>
  <div class='row'>
    <div class='col-sm-6 col-md-4'>
      <div class='panel' data-name='' data-url='<?php echo $this->createLink('block', 'index', 'contract') ?>'>
        <div class='panel-heading'>
          Contract
          <div class='panel-actions'>
            <button class='btn btn-mini refresh-panel'><i class='icon-repeat'></i></button>
            <div class='dropdown'>
              <button class='btn btn-mini' data-toggle='dropdown'><span class='caret'></span></button>
              <ul class='dropdown-menu pull-right'>
                <li><a data-toggle='modal' href="<?php echo $this->createLink("block", "admin", 'contract'); ?>" class='edit-block window-btn' data-name='<?php echo 'Contract'; ?>' data-icon='icon-pencil'><i class='icon-pencil'></i> <?php echo $lang->edit; ?></a></li>
                <li><a href='javascript:;' class='remove-panel'><i class='icon-remove'></i> <?php echo $lang->close; ?></a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class='panel-body no-padding'></div>
      </div>
    </div>
    <div class='col-sm-6 col-md-4'>
      <div class='panel' data-name='' data-url='<?php echo $this->createLink('block', 'index', 'order') ?>'>
        <div class='panel-heading'>
          Order
          <div class='panel-actions'>
            <button class='btn btn-mini refresh-panel'><i class='icon-repeat'></i></button>
            <div class='dropdown'>
              <button class='btn btn-mini' data-toggle='dropdown'><span class='caret'></span></button>
              <ul class='dropdown-menu pull-right'>
                <li><a data-toggle='modal' href='<?php echo $this->createLink("block", "admin", 'order'); ?>' class='edit-block window-btn' data-name='<?php echo 'Order'; ?>' data-icon='icon-pencil'><i class='icon-pencil'></i> <?php echo $lang->edit; ?></a></li>
                <li><a href='javascript:;' class='remove-panel'><i class='icon-remove'></i> <?php echo $lang->close; ?></a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class='panel-body no-padding'></div>
      </div>
    </div>
    <div class='col-sm-6 col-md-4'>
      <div class='panel' data-name='' data-url='<?php echo $this->createLink('block', 'index', 'task') ?>'>
        <div class='panel-heading'>
          Task
          <div class='panel-actions'>
            <button class='btn btn-mini refresh-panel'><i class='icon-repeat'></i></button>
            <div class='dropdown'>
              <button class='btn btn-mini' data-toggle='dropdown'><span class='caret'></span></button>
              <ul class='dropdown-menu pull-right'>
                <li><a data-toggle='modal' href='<?php echo $this->createLink("block", "admin", "task"); ?>' class='edit-block window-btn' data-name='<?php echo 'Task'; ?>' data-icon='icon-pencil'><i class='icon-pencil'></i> <?php echo $lang->edit; ?></a></li>
                <li><a href='javascript:;' class='remove-panel'><i class='icon-remove'></i> <?php echo $lang->close; ?></a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class='panel-body no-padding'></div>
      </div>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
