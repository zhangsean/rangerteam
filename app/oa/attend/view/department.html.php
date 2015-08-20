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
<?php js::set('company', $company)?>
<div id='menuActions'>
  <?php commonModel::printLink('oa.attend', 'export', "data=$currentYear$currentMonth&company=$company", "{$lang->attend->export}", "class='iframe btn btn-primary'")?>
</div>
<div class='row'>
  <div class='col-xs-2'>
    <div class='panel panel-sm'>
      <div class='panel-body'>
        <ul class='tree' data-collapsed='true'>
          <?php foreach($yearList as $year):?>
          <li class='<?php echo $year == $currentYear ? 'active' : ''?>'>
            <?php commonModel::printLink('attend', 'department', "date=$year&company=$company", $year);?>
            <ul>
              <?php foreach($monthList[$year] as $month):?>
              <li class='<?php echo ($year == $currentYear and $month == $currentMonth) ? 'active' : ''?>'>
                <?php commonModel::printLink('attend', 'department', "date=$year$month&company=$company", $year . $month);?>
              </li>
              <?php endforeach;?>
            </ul>
          </li>
          <?php endforeach;?>
        </ul>
      </div>
    </div>
  </div>
  <div class='col-xs-10'>
    <div class='panel'>
      <div class='panel-heading text-center'>
        <strong><?php echo $currentYear . $lang->year . $currentMonth . $lang->month . $lang->attend->report;?></strong>
      </div>
      <table class='table table-data table-bordered text-center table-fixed'>
        <thead>
          <tr class='text-center'>
            <th rowspan='2' class='w-40px valign-middle'><?php echo $lang->user->id;?></th>
            <th rowspan='2' class='w-80px valign-middle'><?php echo $lang->user->dept;?></th>
            <th rowspan='2' class='w-80px valign-middle'><?php echo $lang->user->realname;?></th>
            <?php for($day = 1; $day <= $dayNum; $day++):?>
            <th><?php echo $day?></th>
            <?php endfor;?>
          </tr>
          <tr class='text-center'>
            <?php $weekOffset = date('w', strtotime("$currentYear-$currentMonth-01")) - 1;?>
            <?php for($day = 1; $day <= $dayNum; $day++):?>
            <th><?php echo $lang->datepicker->dayNames[($day + $weekOffset) % 7]?></th>
            <?php endfor;?>
          </tr>
        </thead>
        <?php foreach($attends as $account => $userAttends):?>
        <tr>
          <td><?php echo isset($users[$account]) ? $users[$account]->id : '';?></td>
          <td><?php echo isset($users[$account]) ? $deptList[$users[$account]->dept] : ''?></td>
          <td><?php echo isset($users[$account]) ? $users[$account]->realname : '';?></td>
          <?php for($day = 1; $day <= $dayNum; $day++):?>
          <?php $currentDate = date("Y-m-d", strtotime("{$currentYear}-{$currentMonth}-{$day}"));?>
          <td>
            <?php if(isset($userAttends[$currentDate])):?>
            <span class='attend-<?php echo $userAttends[$currentDate]->status?>'><?php echo $lang->attend->abbrStatusList[$userAttends[$currentDate]->status]?></span>
            <?php endif;?>
          </td>
          <?php endfor;?>
        </tr>
        <?php endforeach;?>
      </table>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
