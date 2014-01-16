<?php include '../../common/view/header.html.php';?>
<?php include $this->app->getBasePath() . 'app/sys/common/view/chosen.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->field->create;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th class='w-100px'><?php echo $lang->field->name;?></th>
          <td colspan='2'><?php echo html::input('name', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->field->field;?></th>
          <td colspan='2'><?php echo html::input('field', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->field->control;?></th>
          <td><?php echo html::select("control", $lang->field->controlTypeList, '', "class='form-control select-3'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->field->options;?></th>
          <td><?php echo html::textarea("options", '', "class='form-control' placeholder='{$lang->field->optionsPlaceholder}'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->field->default;?></th>
          <td colspan='2'><?php echo html::textarea('default', '', "rows='2' placeholder='{$lang->field->optionsPlaceholder}' class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->field->rules;?></th>
          <td colspan='2'><?php echo html::select('rules', $lang->field->rulesList, '', "rows='2' multiple class='chosen form-control'");?></td>
        </tr>
        <tr>
          <th></th>
          <td colspan='2'><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
