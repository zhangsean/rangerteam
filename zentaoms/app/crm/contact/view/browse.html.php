<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-group"></i> <?php echo $lang->contact->list;?></strong>
  </div>
  <table class='table table-hover table-striped table-bordered'>
    <thead>
      <tr class='text-center'>
        <th class='w-id'><?php echo $lang->contact->id;?></th>
        <th class='w-150px'><?php echo $lang->contact->customer;?></th>
        <th class='w-100px'><?php echo $lang->contact->realname;?></th>
        <th class='w-id'><?php echo $lang->contact->gender;?></th>
        <th class='w-120px'><?php echo $lang->contact->phone;?></th>
        <th class='w-120px'><?php echo $lang->contact->mobile;?></th>
        <th class='w-200px'><?php echo $lang->contact->email;?></th>
        <th class='w-100px'><?php echo $lang->contact->qq;?></th>
        <th class='w-100px'><?php echo $lang->contact->weixin;?></th>
        <th><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($contacts as $contact):?>
    <tr class='text-center'>
      <td><?php echo $contact->id;?></td>
      <td><?php echo $customers[$contact->customer];?></td>
      <td><?php echo $contact->realname;?></td>
      <td><?php echo isset($lang->contact->genderList[$contact->gender]) ? $lang->contact->genderList[$contact->gender] : '';?></td>
      <td><?php echo $contact->phone;?></td>
      <td><?php echo $contact->mobile;?></td>
      <td><?php echo $contact->email;?></td>
      <td><?php echo $contact->qq;?></td>
      <td><?php echo $contact->weixin;?></td>
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
