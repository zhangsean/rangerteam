<?php include '../../common/view/header.html.php';?>
<?php js::set('userRoles', $userRoles);?>
<?php js::set('roles', array_flip($roles));?>
<div class='panel'>
  <div class='panel-heading'>
  <strong><i class="icon-list-ul"></i> <?php echo $lang->order->manageMembers;?></strong>
  </div>
  <form method='post' id='ajaxForm'>
    <table class='table table-hover table-striped tablesorter'>
      <thead>
        <tr class='text-center'>
          <th style='width: 300px'><?php echo $lang->team->account;?></th>
          <th style='width: 300px'><?php echo $lang->team->role;?></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1;?>
        <?php foreach($currentMembers as $member):?>
        <?php if(!isset($users[$member->account])) continue; $realname = $users[$member->account];?>
        <?php unset($users[$member->account]);?>
        <tr class='text-center'>
          <td><input type='text' name='realnames[]' id='account<?php echo $i;?>' value='<?php echo $realname;?>' class='form-control' readonly /></td>
          <td><?php echo html::select('roles[]', $roles, $member->role, "class='form-control'");?></td>
          <td>
            <input type='hidden' name='modes[]' value='update' />
            <input type='hidden' name='accounts[]' value='<?php echo $member->account;?>' />
          </td>
        </tr>
        <?php $i ++;?>
        <?php endforeach;?>
        
        <?php
        $count = count($users) - 1;
        if($count > ORDERMODEL::LINK_MEMBERS_ONE_TIME) $count = ORDERMODEL::LINK_MEMBERS_ONE_TIME;
        ?>

        <?php for($j = 0; $j < $count; $j ++):?>
        <tr class='text-center'>
          <td><?php echo html::select('accounts[]', $users, '', "class='form-control account'");?></td>
          <td><?php echo html::select("roles[]", $roles, '', "class='form-control role'");?></td>
          <td><input type='hidden' name='modes[]' value='create'/></td>
        </tr>
        <?php $i ++;?>
        <?php endfor;?>
      </tbody>
      <tfoot><tr><td colspan='2'><td><?php echo html::submitButton();?></td></td></tr>
      </tfoot>
    </table>
  </form>
</div>
<?php include '../../common/view/footer.html.php';?>
