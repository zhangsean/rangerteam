<?php
/**
 * The edit view file of user module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php
if(RUN_MODE == 'front' && strpos($app->getModuleRoot(), 'sys') == false)
{
    include $app->getModuleRoot() . 'common/view/header.html.php';
}
else
{
    include '../../common/view/header.admin.html.php';
}
include '../../common/view/treeview.html.php';
?>
<div class="col-md-12">
  <div class='col-md-2'>
    <div class='panel'>
      <div class='panel-heading'><strong><i class="icon-sitemap"></i> <?php echo $lang->dept->common;?></strong></div>
      <div class='panel-body'>
        <div id='treeMenuBox'>
          <?php echo $treeMenu ?>
          <div class='text-right'><?php echo html::a($this->inlink('create'), $lang->user->create)?></div>
          <div class='text-right'><?php echo html::a($this->createLink('tree', 'browse', "type=dept"), $lang->dept->edit);?></div>
        </div>
      </div>
    </div>
  </div>
  <div class='col-md-10'>
    <div class="panel">
      <div class="panel-heading"><strong><i class="icon-edit"></i> <?php echo $lang->user->edit;?></strong></div>
      <div class='panel-body'>
        <form method='post' id='ajaxForm' class='form-inline form-horizontal'>
          <table class='table table-form'>
            <tr>
              <th style='width:100px;'><?php echo $lang->user->realname;?></th>
              <td><?php echo html::input('realname', $user->realname, "class='form-control'");?></td>
            </tr>
            <tr>
              <th><?php echo $lang->user->email;?></th>
              <td><?php echo html::input('email', $user->email, "class='form-control'");?></td>
            </tr>
            <tr>
              <th><?php echo $lang->user->password;?></th>
              <td><?php echo html::password('password1', '', "class='form-control'");?></td>
            </tr>
            <tr>
              <th><?php echo $lang->user->password2;?></th>
              <td><?php echo html::password('password2', '', "class='form-control'");?></td>
            </tr>
            <tr>
              <th><?php echo $lang->user->address;?></th>
              <td><?php echo html::input('address', $user->address, "class='form-control'");?></td>
            </tr>
            <tr>
              <th><?php echo $lang->user->zipcode;?></th>
              <td><?php echo html::input('zipcode', $user->zipcode, "class='form-control'");?></td>
            </tr>
            <tr>
              <th><?php echo $lang->user->mobile;?></th>
              <td><?php echo html::input('mobile', $user->mobile, "class='form-control'");?></td>
            </tr>
            <tr>
              <th><?php echo $lang->user->phone;?></th>
              <td><?php echo html::input('phone', $user->phone, "class='form-control'");?></td>
            </tr>
            <tr>
              <th><?php echo $lang->user->qq;?></th>
              <td><?php echo html::input('qq', $user->qq, "class='form-control'");?></td>
            </tr>
            <tr>
              <th><?php echo $lang->user->gtalk;?></th>
              <td><?php echo html::input('gtalk', $user->gtalk, "class='form-control'");?></td>
            </tr>
            <tr>
              <th></th>
              <td><?php echo html::submitButton();?></td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
if(strpos($app->getModuleRoot(), 'sys') == false)
{
    include $app->getModuleRoot() . 'common/view/footer.html.php';
}
else
{
    include '../../common/view/footer.admin.html.php';
}
?>
