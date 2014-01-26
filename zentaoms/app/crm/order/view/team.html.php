<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
  <strong><i class="icon-list-ul"></i> <?php echo $lang->order->team;?></strong>
  </div>
  <table class='table table-hover table-striped tablesorter'>
    <thead>
      <tr class='text-center'>
        <th style='width: 300px'><?php echo $lang->team->account;?></th>
        <th style='width: 100px'><?php echo $lang->team->role;?></th>
        <th style='width: 160px'><?php echo $lang->team->join;?></th>
        <th style='width: 200px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($teamMembers as $member):?>
      <tr class='text-center'>
        <td><?php echo $member->realname;?></td>
        <td><?php echo $roles[$member->role];?></td>
        <td><?php echo substr($member->join,2)?></td>
        <td><?php echo html::a($this->inLink('unlinkMember', "orderID=$order->id&account=$member->account"), $lang->delete, "class='deleter'");?></td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot>
    <tr>
      <td colspan='4'><div class='text-right'><?php echo html::a($this->inlink('managemembers', "orderID=$order->id"), $lang->order->manageMembers);?></div></td>
    </tr>
    </tfoot>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
