<?php
/**
 * The personal view file of attend module of Ranzhi.
 *
 * @copyright   Copyright 2009-2015 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL
 * @author      chujilu <chujilu@cnezsoft.com>
 * @package     attend
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<table class='table table-data table-bordered text-center'>
  <thead>
    <tr><th class='text-center' colspan="<?php echo $dayNum + 3?>"><?php echo $currentYear . $lang->year . $currentMonth . $lang->month . $lang->attend->report;?></th></tr>
  </thead>
  <tr>
    <th rowspan='2'><?php echo $lang->user->id;?></th>
    <th rowspan='2'><?php echo $lang->user->dept;?></th>
    <th rowspan='2'><?php echo $lang->user->realname;?></th>
    <?php for($day = 1; $day <= $dayNum; $day++):?>
    <th><?php echo $day?></th>
    <?php endfor;?>
  </tr>
  <tr>
    <?php $weekOffset = date('w', strtotime("$currentYear-$currentMonth-01")) - 1;?>
    <?php for($day = 1; $day <= $dayNum; $day++):?>
    <th><?php echo $lang->datepicker->dayNames[($day + $weekOffset) % 7]?></th>
    <?php endfor;?>
  </tr>
  <?php foreach($attends as $account => $userAttends):?>
  <tr>
    <td><?php echo isset($users[$account]) ? $users[$account]->id : '';?></td>
    <td><?php echo $deptList[$currentDept]->name?></td>
    <td><?php echo isset($users[$account]) ? $users[$account]->realname : '';?></td>
    <?php for($day = 1; $day <= $dayNum; $day++):?>
    <?php $currentDate = $day < 10 ? "{$currentYear}-{$currentMonth}-0{$day}" : "{$currentYear}-{$currentMonth}-{$day}";?>
    <td>
      <?php if(isset($userAttends[$currentDate])):?>
      <span class='attend-<?php echo $userAttends[$currentDate]->status?>'><?php echo $userAttends[$currentDate]->status?></span>
      <?php endif;?>
    </td>
    <?php endfor;?>
  </tr>
  <?php endforeach;?>
</table>
<?php include '../../common/view/footer.html.php';?>
