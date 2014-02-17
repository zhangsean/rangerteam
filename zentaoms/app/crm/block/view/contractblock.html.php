<table class='table'>
  <tr>
    <th class='w-id'><?php echo $lang->contract->id?></th>
    <th><?php echo $lang->contract->name?></th>
    <th><?php echo $lang->contract->amount?></th>
  </tr>
  <?php foreach($contracts as $id => $contract):?>
  <tr>
    <td><?php echo $id?></td>
    <td class='nobr'><?php echo html::a($this->createLink('contract', 'view', "id=$id"), $contract->name, "title=$contract->name");?></td>
    <td><?php echo $contract->amount?></td>
  </tr>
  <?php endforeach;?>
</table>
