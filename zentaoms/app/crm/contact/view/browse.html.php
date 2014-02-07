<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-group"></i> <?php echo $lang->contact->list;?></strong>
  </div>
  <table class='table table-hover table-striped table-bordered'>
    <thead>
      <tr class='text-center'>
        <th><?php echo $lang->contact->id;?></th>
        <th><?php echo $lang->contact->realname;?></th>
        <th><?php echo $lang->contact->nickname;?></th>
        <th><?php echo $lang->contact->gender;?></th>
        <th><?php echo $lang->contact->email;?></th>
        <th><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($contacts as $contact):?>
    <tr class='text-center'>
      <td><?php echo $contact->id;?></td>
      <td><?php echo $contact->realname;?></td>
      <td><?php echo $contact->nickname;?></td>
      <td><?php echo isset($lang->contact->genderList[$contact->gender]) ? $lang->contact->genderList[$contact->gender] : '';?></td>
      <td><?php echo $contact->email;?></td>
      <td class='operate'>
        <?php echo html::a($this->createLink('contact', 'edit', "contactID=$contact->id"), $lang->edit); ?>
        <?php echo html::a($this->createLink('contact', 'delete', "contactID=$contact->id"), $lang->delete, "class='deleter'"); ?>
      </td>
    </tr>
    <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='12'><?php $pager->show();?></td></tr></tfoot>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
