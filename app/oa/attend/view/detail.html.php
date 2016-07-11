<?php
/**
 * The detail view file of attend module of RanZhi.
 *
 * @copyright   Copyright 2009-2016 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      liugang <liugang@cnezsoft.com>
 * @package     attend 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/treeview.html.php';?>
<?php $lang->attend->abbrStatusList['rest'] = '';?>
<div id='menuActions'>
  <?php commonModel::printLink('attend', 'export', "date=$currentYear$currentMonth", "{$lang->attend->export}", "class='iframe btn btn-primary'")?>
</div>
<div class='with-side'>
  <div class='side'>
    <div class='panel panel-sm'>
      <div class='panel-body'>
        <ul class='tree' data-collapsed='true'>
          <?php foreach($yearList as $year):?>
          <li class='<?php echo $year == $currentYear ? 'active' : ''?>'>
            <?php commonModel::printLink('attend', 'detail', "date=$year&type=year", $year);?>
            <ul>
              <?php foreach($monthList[$year] as $month):?>
              <li class='<?php echo ($year == $currentYear and $month == $currentMonth) ? 'active' : ''?>'>
                <?php commonModel::printLink('attend', 'detail', "date=$year$month&type=month", $year . $month);?>
              </li>
              <?php endforeach;?>
            </ul>
          </li>
          <?php endforeach;?>
        </ul>
      </div>
    </div>
  </div>
  <div class='main'>
    <div class='panel'>
      <div class='panel-heading text-center'>
        <strong><?php echo $currentYear . $lang->year . $currentMonth . $lang->month . $lang->attend->report;?></strong>
      </div>
      <table class='table table-data table-bordered text-center table-fixed'>
        <thead>
          <tr class='text-center'>
            <th class='w-80px'><?php echo $lang->user->dept;?></th>
            <th class='w-80px'><?php echo $lang->user->realname;?></th>
            <th class='w-120px'><?php echo $lang->attend->date;?></th>
            <th class='w-80px'><?php echo $lang->attend->dayName;?></th>
            <th class='w-100px'><?php echo $lang->attend->status;?></th>
            <th class='w-100px'><?php echo $lang->attend->signIn;?></th>
            <th class='w-100px'><?php echo $lang->attend->signOut;?></th>
            <th class='w-200px'><?php echo $lang->attend->ip;?></th>
          </tr>
        </thead>
        <?php foreach($attends as $dept => $deptAttends):?>
          <?php foreach($deptAttends as $account => $userAttends):?>
            <?php for($day = 1; $day <= $dayNum; $day++):?>
            <?php $currentDate = date("Y-m-d", strtotime("{$currentYear}-{$currentMonth}-{$day}"));?>
            <tr>
              <td><?php echo isset($users[$account]) ? $deptList[$users[$account]->dept] : ''?></td>
              <td class='valign-middle'><?php echo isset($users[$account]) ? $users[$account]->realname : '';?></td>
              <td><?php echo $currentDate;?></td>
              <td><?php echo $lang->datepicker->dayNames[(int)date('w', strtotime($currentDate))];?>
              <td>
                <?php echo $lang->attend->statusList[$userAttends[$currentDate]->status]?>
                <?php if(strpos('leave,trip,overtime', $userAttends[$currentDate]->status) !== false and $userAttends[$currentDate]->desc) echo ' ' . $userAttends[$currentDate]->desc . 'h';?>
              </td>
              <td><?php echo $userAttends[$currentDate]->signIn;?></td>
              <td><?php echo $userAttends[$currentDate]->signOut;?></td>
              <td><?php echo $userAttends[$currentDate]->ip;?></td>
            </tr>
            <?php endfor;?>
          <?php endforeach;?>
        <?php endforeach;?>
      </table>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
