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
<?php include '../../common/view/header.admin.html.php';?>
<div class="col-md-12">
  <form method='post' class='form-inline mb-10px form-search pull-right'>
    <div class="input-group w-200px">
      <?php echo html::input('query', $query, "class='form-control text-2 search-query' placeholder='{$lang->user->inputUserName}'"); ?>
      <span class="input-group-btn">
        <?php echo html::submitButton($lang->user->searchUser,"btn btn-primary"); ?>
      </span>
    </div>
  </form>
  <div class='c-both'></div>
  <table class='table table-hover table-striped'>
    <caption><?php echo $lang->user->list;?></caption>
    <thead>
      <tr class='a-center'>
        <th class='w-60px'><?php echo $lang->user->id;?></th>
        <th class='w-100px'><?php echo $lang->user->realname;?></th>
        <th class='w-100px'><?php echo $lang->user->nickname;?></th>
        <th class='w-80px'><?php echo $lang->user->account;?></th>
        <th class='w-60px'><?php echo $lang->user->gender;?></th>
        <th class='a-left'><?php echo $lang->user->company;?></th>
        <th class='w-150px'><?php echo $lang->user->join;?></th>
        <th class='w-80px'><?php echo $lang->user->visits;?></th>
        <th class='w-150px'><?php echo $lang->user->last;?></th>
        <th class='w-250px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($users as $user):?>
    <tr class='a-center'>
      <td><?php echo $user->id;?></td>
      <td><?php echo $user->realname;?></td>
      <td><?php echo $user->nickname;?></td>
      <td><?php echo $user->account;?></td>
      <td><?php $gender = $user->gender; echo $lang->user->genderList->$gender;?></td>
      <td class='a-left'><?php echo $user->company;?></td>
      <td><?php echo $user->join;?></td>
      <td><?php echo $user->visits;?></td>
      <td><?php echo $user->last;?></td>
      <td class='operate'>
        <?php echo html::a($this->createLink('user', 'edit', "account=$user->account"), $lang->edit);?>
        <div class="btn-group">
          <a  class="dropdown-toggle" data-toggle="dropdown"><?php echo $lang->user->forbid?> <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
          <?php foreach($lang->user->forbidDate as $date => $title):?>
            <li><?php echo html::a($this->createLink('user', 'forbid', "userID={$user->id}&date=$date"), $title, "class='forbider'");?></li>
          <?php endforeach;?>
          </ul>
        </div>
      </td>
    </tr>
    <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='10' class='a-right'><?php $pager->show();?></td></tr></tfoot>
  </table>
</div>

<?php include '../../common/view/footer.admin.html.php';?>
