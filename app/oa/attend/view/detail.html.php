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
<?php include '../../../sys/common/view/chosen.html.php';?>
<?php include '../../../sys/common/view/datepicker.html.php';?>
<?php $lang->attend->abbrStatusList['rest'] = '';?>
<div id='menuActions'>
  <?php commonModel::printLink('attend', 'exportDetail', "date=$currentYear$currentMonth", "{$lang->attend->export}", "class='iframe btn btn-primary'")?>
</div>
<div class='with-side'>
  <div class='side'>
    <div class='panel'>
      <div class='panel-heading'><strong><?php echo $currentYear . $lang->year . $lang->attend->detail;?></strong></div>
      <div class='panel-body'>
      <?php 
        $lastmonth = $currentYear == date('Y') ? date('m') : 12;
        for($month = 1; $month <= $lastmonth; $month++)
        {
            $class = $month == $currentMonth ? 'btn-primary' : '';
            $month = $month < 10 ? '0' . $month : $month;
            echo "<div class='col-xs-3 monthDIV'>" . html::a(inlink('detail', "date=$currentYear$month"), $month . $lang->month, "class='btn btn-mini $class'") . '</div>';
        }
      ?>
      </div>
    </div>
    <div class='panel'>
      <div class='panel-heading'><strong><?php echo $lang->attend->search;?></strong></div>
      <div class='panel-body'>
        <form id='searchForm' method='post' action='<?php echo inlink('detail');?>'>
          <div class='form-group'>
            <div class='input-group'>
              <span class='input-group-addon'><?php echo $lang->user->dept;?></span>
              <?php echo html::select('dept', $deptList, $dept, "class='form-control chosen'");?>
            </div>
          </div>
          <div class='form-group'>
            <div class='input-group'>
              <span class='input-group-addon'><?php echo $lang->attend->user;?></span>
              <?php echo html::select('account', $userList, $account, "class='form-control chosen'");?>
            </div>
          </div>
          <div class='form-group'>
            <div class='input-group'>
              <span class='input-group-addon'><?php echo $lang->attend->date;?></span>
              <?php echo html::input('date', $date, "class='form-control form-month'");?>
            </div>
          </div>
          <div class='form-group'><?php echo html::submitButton($lang->attend->search);?></div>
        </form>
      </div>
    </div>
  </div>
  <div class='main'>
    <div class='panel'>
      <div class='panel-heading text-center'>
        <?php $fileName = $currentYear . $lang->year . $currentMonth . $lang->month . $lang->attend->detail;?>
        <?php if($account) $fileName = isset($users[$account]) ? $users[$account]->realname . ' - ' . $fileName : $fileName;?>
        <?php if($dept)    $fileName = isset($deptList[$dept]) ? $deptList[$dept] . ' - ' . $fileName : $fileName;?>
        <strong><?php echo $fileName;?></strong>
      </div>
      <table class='table table-data table-bordered text-center table-fixed'>
        <thead>
          <tr class='text-center'>
            <th class='w-80px'><?php echo $lang->user->dept;?></th>
            <th class='w-80px'><?php echo $lang->attend->user;?></th>
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
