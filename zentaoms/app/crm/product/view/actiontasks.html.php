<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->product->action->adminConditions;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th><?php echo $lang->product->task->role;?></th>
          <th><?php echo $lang->product->task->date;?></th>
          <th><?php echo $lang->product->task->name;?></th>
        </tr>
        <?php foreach($action->tasks as $task):?>
        <tr>
          <th><?php echo html::select('role[]', $roles, $task->role, "class='form-control'");?></th>
          <td class='w-150px'><?php echo html::input("date[]", $task->date, "class='form-control'")?></td>
          <td><?php echo html::input("name[]", $task->name, "class='form-control'")?></td>
          <td>
            <?php echo html::a('javascript:;', $lang->add, "class='plus'")?>
            <?php echo html::a('javascript:;', $lang->delete, "class='condition-deleter'")?>
          </td>
        </tr>
        <?php endforeach;?>
        <tr>
          <td colspan='3'><?php echo html::submitButton();?></td>
        </tr>
      </table>
      <table class='hide'>
        <tr id='originTR'>
          <th><?php echo html::select('role[]', $roles, '', "class='form-control'");?></th>
          <td class='w-150px'><?php echo html::input('date[]', '', "class='form-control'")?></td>
          <td><?php echo html::input('name[]', '', "class='form-control'")?></td>
          <td>
            <?php echo html::a('javascript:;', $lang->add, "class='plus'")?>
            <?php echo html::a('javascript:;', $lang->delete, "class='condition-deleter'")?>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
