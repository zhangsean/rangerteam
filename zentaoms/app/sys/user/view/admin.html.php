<?php
/**
 * The admin view file of user module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yangyang Shi <shiyangyangwork@yahoo.cn>
 * @package     User
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/treeview.html.php';?>
<div class="col-md-12">
  <div class="limit-width">
    <div class="row">
      <div class="col-sm-offset-8 col-sm-4 col-md-offset-9 col-md-3">
        <div class="panel">
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
    </div>
    <div class='clearfix'>
      <div class='col-md-2'>
        <div class='panel'>
          <div class='panel-heading'><strong><i class="icon-sitemap"></i> <?php echo $lang->dept->common;?></strong></div>
          <div class='panel-body'><div id='treeMenuBox'><?php echo $treeMenu . html::a($this->createLink('tree', 'browse', "type=dept"), $lang->dept->edit, "class='pull-right'");?></div></div>
        </div>
      </div>
      <div class='col-md-10'>
        <div class="panel">
          <div class="panel-heading">
            <strong><i class="icon-group"></i> <?php echo $lang->user->list;?></strong>
            <span class='pull-right mr-10px'><?php echo html::a($this->inlink('create'), $lang->user->create);?></span>
          </div>
          <table class='table table-hover table-striped table-bordered'>
            <thead>
              <tr class='text-center'>
                <th><?php echo $lang->user->id;?></th>
                <th><?php echo $lang->user->realname;?></th>
                <th><?php echo $lang->user->nickname;?></th>
                <th><?php echo $lang->user->account;?></th>
                <th><?php echo $lang->user->gender;?></th>
                <th class='text-left'><?php echo $lang->user->dept;?></th>
                <th><?php echo $lang->user->join;?></th>
                <th><?php echo $lang->user->visits;?></th>
                <th><?php echo $lang->user->last;?></th>
                <th><?php echo $lang->user->ip;?></th>
                <th><?php echo $lang->user->status;?></th>
                <th><?php echo $lang->actions;?></th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($users as $user):?>
            <tr class='text-center'>
              <td><?php echo $user->id;?></td>
              <td><?php echo $user->realname;?></td>
              <td><?php echo $user->nickname;?></td>
              <td><?php echo $user->account;?></td>
              <td><?php $gender = $user->gender; echo $lang->user->gendarList->$gender;?></td>
              <td><?php echo $user->dept;?></td>
              <td><?php echo $user->join;?></td>
              <td><?php echo $user->visits;?></td>
              <td><?php echo $user->last;?></td>
              <td><?php echo $user->ip;?></td>
              <td>
              <?php if($user->fails > 4 and $user->locked > helper::now()) echo $lang->user->statusList->locked;?>
              <?php if($user->fails <= 4 and $user->locked > helper::now()) echo $lang->user->statusList->forbidden;?>
              <?php if($user->locked <= helper::now()) echo $lang->user->statusList->normal;?>
              </td>
              <td class='operate'>
                <?php echo html::a($this->createLink('user', 'edit', "account=$user->account"), $lang->edit); ?>
                <div class="btn-group">
                  <a class="dropdown-toggle" data-toggle="dropdown"><?php echo $lang->user->forbid?> <span class="caret"></span></a>
                  <ul class="dropdown-menu pull-right" role="menu">
                  <?php foreach($lang->user->forbidDate as $date => $title):?>
                    <li><?php echo html::a($this->createLink('user', 'forbid', "userID={$user->id}&date=$date"), $title, "class='forbider'");?></li>
                  <?php endforeach;?>
                  </ul>
                </div>
              </td>
            </tr>
            <?php endforeach;?>
            </tbody>
            <tfoot><tr><td colspan='12'><?php $pager->show();?></td></tr></tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if($deptID != 0):?>
<script>
$('#category<?php echo $deptID?>').addClass('red');
</script>
<?php endif;?>
<?php include '../../common/view/footer.admin.html.php';?>
