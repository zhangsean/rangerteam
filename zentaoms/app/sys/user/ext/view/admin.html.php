<?php
/**
 * The admin view file of user module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Yangyang Shi <shiyangyangwork@yahoo.cn>
 * @package     User
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../../common/view/header.admin.html.php';?>
<div class="col-md-12">
  <form method='post' class='form-inline mb-10px form-search pull-right'>
    <div class="input-group w-200px">
      <?php echo html::input('key', $key, "class='form-control text-2 search-query' placeholder='{$lang->user->inputUserName}'"); ?>
      <span class="input-group-btn">
        <?php echo html::submitButton($lang->user->searchUser,"btn btn-primary"); ?>
      </span>
    </div>
  </form>
  <div class='c-both'></div>
  <div class='col-md-2'>
    <table class='table table-striped'>
      <caption><?php echo $lang->dept->common?></caption>
      <tr>
        <td>
        <?php
        echo $treeMenu;
        echo html::a($this->createLink('tree', 'browse', "type=dept"), $lang->dept->edit, "class='pull-right'");
        ?>
        </td>
      </tr>
    </table>
  </div>
  <div class='col-md-10'>
    <table class='table table-hover table-striped fixed'>
      <caption>
        <?php
        echo $lang->user->list;
        echo '<span class="pull-right mr-10px">' . html::a(inlink('create'), $lang->user->create) . '</span>';
        ?>
      </caption>
      <thead>
        <tr class='a-center'>
          <th class='w-60px'><?php echo $lang->user->id;?></th>
          <th class='w-130px'><?php echo $lang->user->dept;?></th>
          <th class='w-80px'><?php echo $lang->user->realname;?></th>
          <th class='w-80px'><?php echo $lang->user->account;?></th>
          <th class='w-60px'><?php echo $lang->user->gender;?></th>
          <th class='w-80px'><?php echo $lang->user->role;?></th>
          <th class='w-150px'><?php echo $lang->user->email;?></th>
          <th class='w-100px'><?php echo $lang->user->mobile;?></th>
          <th class='w-100px'><?php echo $lang->user->join;?></th>
          <th class='w-80px'><?php echo $lang->user->visits;?></th>
          <th class='w-150px'><?php echo $lang->user->last;?></th>
          <th><?php echo $lang->actions;?></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($users as $user):?>
      <tr class='a-center'>
        <td><?php echo $user->id;?></td>
        <?php $dept = isset($depts[$user->dept]) ? $depts[$user->dept] : ''?>
        <td class="a-left" title="<?php echo $dept?>"><?php echo $dept;?></td>
        <td title="<?php echo $user->realname?>"><?php echo $user->realname;?></td>
        <td title="<?php echo $user->account?>"><?php echo $user->account;?></td>
        <td><?php $gender = $user->gender; echo $lang->user->gender->$gender;?></td>
        <td><?php echo $lang->user->roleList[$user->role];?></td>
        <td title="<?php echo $user->email?>"><?php echo $user->email;?></td>
        <td title="<?php echo $user->mobile?>"><?php echo $user->mobile;?></td>
        <td><?php echo substr($user->join, 0, 10);?></td>
        <td><?php echo $user->visits;?></td>
        <td><?php echo $user->last;?></td>
        <td>
        <?php
        echo html::a(inlink('edit', "account=$user->account"), $lang->edit);
        echo html::a(inlink('delete', "account=$user->account"), $lang->delete, "class='deleter'");
        ?>
        </td>
      </tr>
      <?php endforeach;?>
      </tbody>
      <tfoot><tr><td colspan='12' class='a-right'><?php $pager->show();?></td></tr></tfoot>
    </table>
  </div>
</div>

<?php if($deptID != 0):?>
<script>
$('#category<?php echo $deptID?>').addClass('active');
</script>
<?php endif;?>
<?php include '../../../common/view/treeview.html.php';?>
<?php include '../../../common/view/footer.admin.html.php';?>
