<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
  <strong><i class="icon-list-ul"></i> <?php echo $lang->product->field->admin;?></strong>
  <div class='panel-actions'><?php echo html::a($this->inlink('createField', "productID={$productID}"), '<i class="icon-plus"></i> ' . $lang->product->field->create, 'class="btn btn-primary"');?></div>
  </div>
  <table class='table table-hover table-striped tablesorter'>
    <thead>
      <tr class='text-center'>
        <th><?php echo $lang->product->field->field;?></th>
        <th><?php echo $lang->product->field->name;?></th>
        <th style='width: 160px'><?php echo $lang->product->field->control;?></th>
        <th ><?php echo $lang->product->field->options;?></th>
        <th ><?php echo $lang->product->field->default;?></th>
        <th style='width: 200px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($fields as $field):?>
      <tr class='text-center'>
        <td class='text-left'><?php echo $field->field;?></td>
        <td class='text-left'><?php echo $field->name;?></td>
        <td><?php echo $lang->product->field->controlTypeList[$field->control];?></td>
        <td><?php echo $field->options;?></td>
        <td><?php echo $field->default;?></td>
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
