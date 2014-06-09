<?php
/**
 * The colleague view file of user module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     User
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php
include $app->getModuleRoot() . 'common/view/header.html.php';
include '../../common/view/treeview.html.php';
js::set('deptID', $deptID);
?>
<div class="col-md-12">
  <div class='col-md-2'>
    <div class='panel'>
      <div class='panel-heading'><strong><i class="icon-building"></i> <?php echo $lang->dept->common;?></strong></div>
      <div class='panel-body'>
        <div id='treeMenuBox'><?php echo $treeMenu;?></div>
        <?php echo html::a($this->inlink('create'), $lang->user->create, "class='btn btn-primary btn-xs'");?>
        <?php echo html::a($this->createLink('tree', 'browse', "type=dept"), $lang->dept->edit, "class='btn btn-primary btn-xs'");?>
        <?php echo html::a($this->createLink('setting', 'lang', "module=user&field=roleList"), $lang->user->role, "class='btn btn-primary btn-xs'");?>
      </div>
    </div>
  </div>
  <div class='col-md-10'>
    <div class="row">
      <div class='clearfix'>
        <div class="panel">
          <div class="panel-heading">
            <strong><i class="icon-group"></i> <?php echo $lang->user->list;?></strong>
            <div class="pull-right col-md-3 search">
              <form method='post' class='form-inline form-search'>
                <div class="input-group">
                  <?php echo html::input('query', $query, "class='form-control search-query' placeholder='{$lang->user->inputUserName}'"); ?>
                  <span class="input-group-btn">
                    <?php echo html::submitButton($lang->user->searchUser,"btn btn-primary"); ?>
                  </span>
                </div>
              </form>
            </div>
          </div>
          <div class='panel-body'>
            <?php foreach($users as $user):?>
            <div class='col-md-4'>
              <div class='panel'>
                <table class='table table-bordered table-contact'>
                  <tr>
                    <th class='w-100px text-center alert v-middle'>
                      <?php if($user->admin == 'super'):?>
                      <span ><i class='icon-user text-muted'></i></span>
                      <?php endif;?>
                      <span class='lead'><?php echo $user->realname;?></span>
                      <span><?php $gender = $user->gender; echo $lang->user->genderList->$gender;?></span>
                      <div><?php echo $user->account;?></div>
                    </th>
                    <td>
                      <?php if($user->dept or $user->role) echo "<div><i class='icon-home'></i> {$depts[$user->dept]} {$lang->user->roleList[$user->role]}</div>";?>
                      <?php if($user->phone or $user->mobile) echo "<div><i class='icon-phone-sign'></i> $user->phone $user->mobile</div>";?>
                      <?php if($user->qq) echo "<div class='f-14'><i class='icon-qq'></i> $user->qq</div>";?>
                      <?php if($user->email) echo "<div class='f-14'><i class='icon-envelope-alt'></i> $user->email </div>";?>
                      <?php if($user->address) echo "<div class='f-14'><i class='icon-address'></i> $user->address </div>";?>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            <?php endforeach;?>
            <?php $pager->show();?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include '../../../team/common/view/footer.html.php'; ?>
