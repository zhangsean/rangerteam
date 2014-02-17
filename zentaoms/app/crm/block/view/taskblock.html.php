<table class='table'>
  <tr>
    <th class='w-50px'><?php echo $lang->task->id?></th>
    <th class='w-20px'><?php echo $lang->task->lblPri?></th>
    <th><?php echo $lang->task->name?></th>
    <th><?php echo $lang->task->deadline?></th>
    <th><?php echo $lang->task->type?></th>
    <th><?php echo $lang->task->status?></th>
  </tr>
  <?php foreach($tasks as $id => $task):?>
  <tr>
    <td><?php echo $id;?></td>
    <td><?php echo $lang->task->priList[$task->pri];?></td>
    <td><?php echo html::a($this->createLink('task', 'view', "taskID=$id"), $task->name);?></td>
    <td><?php echo $task->deadline;?></td>
    <td><?php echo $lang->task->typeList[$task->type];?></td>
    <td><?php echo $lang->task->statusList[$task->status];?></td>
  </tr>
  <?php endforeach;?>
</table>
