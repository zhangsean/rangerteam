<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
  <strong><i class="icon-list-ul"></i> <?php echo $lang->field->browse;?></strong>
  <div class='panel-actions'><?php echo html::a($this->inlink('create', "productID={$productID}"), '<i class="icon-plus"></i> ' . $lang->field->create, 'class="btn btn-primary"');?></div>
  </div>
  <table class='table table-hover table-striped tablesorter'>
    <thead>
      <tr class='text-center'>
        <th style='width: 60px'><?php echo $lang->field->id;?></th>
        <th><?php echo $lang->field->name;?></th>
        <th><?php echo $lang->field->field;?></th>
        <th style='width: 160px'><?php echo $lang->field->createDate;?></th>
        <th style='width: 60px'><?php echo $lang->field->type;?></th>
        <th style='width: 60px'><?php echo $lang->field->status;?></th>
        <th style='width: 200px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($fields as $field):?>
      <tr class='text-center'>
        <td><?php echo $field->id;?></td>
        <td class='text-left'><?php echo $field->name;?></td>
        <td><?php echo $field->createDate;?></td>
        <td><?php echo $lang->field->typeList[$field->type];?></td>
        <td><?php echo $lang->field->statusList[$field->status];?></td>
        <td>
          <?php
          echo html::a($this->createLink('field', 'edit', "fieldID=$field->id"), $lang->edit);
          echo html::a($this->createLink('field', 'delete', "fieldID=$field->id"), $lang->delete, "class='deleter'");
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
