<?php include '../../common/view/header.html.php';?>
<?php include $this->app->getBasePath() . 'app/sys/common/view/chosen.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->product->field->create;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th class='w-100px'><?php echo $lang->product->field->name;?></th>
          <td><?php echo html::input('name', $field->name, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->product->field->field;?></th>
          <td><?php echo html::input('field', $field->field, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->product->field->control;?></th>
          <td><?php echo html::select("control", $lang->product->field->controlTypeList, $field->control, "class='form-control select-3'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->product->field->options;?></th>
          <td><?php echo html::textarea("options", $field->options, "class='form-control' placeholder='{$lang->product->field->optionsPlaceholder}'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->product->field->default;?></th>
          <td><?php echo html::textarea('default', $field->default, "rows='2' placeholder='{$lang->product->field->optionsPlaceholder}' class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->product->field->rules;?></th>
          <td><?php echo html::select('rules[]', $lang->product->field->rulesList, $field->rules, "multiple class='chosen form-control'");?></td>
        </tr>
        <tr>
          <th></th>
          <td><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php js::set('fieldID', $field->id)?>
<?php include '../../common/view/footer.html.php';?>
