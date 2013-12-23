<?php
/**
 * The create view file of user module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user 
 * @version     $Id: create.html.php 2605 2013-12-23 09:12:58Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/treeview.html.php';?>
<div class="col-md-12">
  <div class='col-md-2'>
    <div class='panel'>
      <div class='panel-heading'><strong><i class="icon-sitemap"></i> <?php echo $lang->dept->common;?></strong></div>
      <div class='panel-body'><div id='treeMenuBox'><?php echo $treeMenu . html::a($this->createLink('tree', 'browse', "type=dept"), $lang->dept->edit, "class='pull-right'");?></div></div>
    </div>
  </div>
  <div class='col-md-10'>
    <div class="panel">
      <div class="panel-heading"><strong><i class="icon-plus"></i> <?php echo $lang->user->create;?></strong></div>
      <div class='panel-body'>
        <form method='post' id='ajaxForm' class='form-inline form-horizontal' role="form">
          <table class='table table-form'>
            <tr>
              <th style='width:100px'><?php echo $lang->user->dept;?></th>
              <td style='width:40%'><?php echo html::select('dept', $depts, '', "class='form-control'");?></td><td></td>
            </tr>  
            <tr>
              <th><?php echo $lang->user->account;?></th>
              <td><?php echo html::input('account', '', "class='form-control'");?></td><td></td>
            </tr>  
            <tr>
              <th><?php echo $lang->user->realname;?></th>
              <td><?php echo html::input('realname', '', "class='form-control'");?></td><td></td>
            </tr>  
            <tr>
              <th><?php echo $lang->user->email;?></th>
              <td><?php echo html::input('email', '', "class='form-control'");?></td><td></td>
            </tr>  
            <tr>
              <th><?php echo $lang->user->password;?></th>
              <td><?php echo html::password('password1', '', "class='form-control' autocomplete='off'")?></td><td></td>
            </tr>  
            <tr>
              <th><?php echo $lang->user->password2;?></th>
              <td><?php echo html::password('password2', '', "class='form-control'");?></td><td></td>
            </tr>  
            <tr>
              <th><?php echo $lang->user->role;?></th>
              <td><?php echo html::select('role', $lang->user->roleList, '', "class='form-control'");?></td><td></td>
            </tr>  
            <tr>
              <th><?php echo $lang->user->gendar;?></th>
              <td><?php unset($lang->user->gendarList->u); echo html::radio('gendar', $lang->user->gendarList, '');?></td><td></td>
            </tr>  
            <tr>
              <th><?php echo $lang->user->company;?></th>
              <td><?php echo html::input('company', $config->company->name, "class='form-control'");?></td><td></td>
            </tr>  
            <tr>
              <th><?php echo $lang->user->address;?></th>
              <td colspan='2'><?php echo html::input('address', '', "class='form-control'");?></td>
            </tr>  
            <tr>
              <th><?php echo $lang->user->mobile;?></th>
              <td><?php echo html::input('mobile', '', "class='form-control'");?></td><td></td>
            </tr>  
            <tr>
              <th><?php echo $lang->user->phone;?></th>
              <td><?php echo html::input('phone', '', "class='form-control'");?></td><td></td>
            </tr>  
            <tr>
              <th><?php echo $lang->user->qq;?></th>
              <td><?php echo html::input('qq', '', "class='form-control'");?></td><td></td>
            </tr>  
            <tr>
              <th><?php echo $lang->user->gtalk;?></th>
              <td><?php echo html::input('gtalk', '', "class='form-control'");?></td><td></td>
            </tr>  
            <tr><th></th><td colspan='2'><?php echo html::submitButton();?></td></tr>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php'; ?>
