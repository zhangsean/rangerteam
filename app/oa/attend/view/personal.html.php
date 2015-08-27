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
<div class='row'>
  <div class='col-xs-2'>
    <div class='panel panel-sm'>
      <div class='panel-body'>
        <ul class='tree' data-collapsed='true'>
          <?php foreach($yearList as $year):?>
          <li class='<?php echo $year == $currentYear ? 'active' : ''?>'>
            <?php commonModel::printLink('attend', 'personal', "date=$year", $year);?>
            <ul>
              <?php foreach($monthList[$year] as $month):?>
              <li class='<?php echo ($year == $currentYear and $month == $currentMonth) ? 'active' : ''?>'>
                <?php commonModel::printLink('attend', 'personal', "date=$year$month", $year . $month);?>
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
    <div class='row'>
      <?php $weekOffset = date('w', strtotime("$currentYear-$currentMonth-01")) - 1;?>
      <?php for($weekIndex = 0; $weekIndex < $weekNum; $weekIndex++):?>
      <div class='col-xs-4'>
        <div class='panel'>
          <div class='panel-heading'>
            <strong><?php echo $lang->attend->weeks[$weekIndex];?></strong>
          </div>
          <div class='panel-body no-padding'>
            <table class='table table-data table-fixed text-center'>
              <tr>
                <th><?php echo $lang->attend->date;?></th>
                <th class='text-center'><?php echo $lang->attend->dayName;?></th>
                <th class='text-center'><?php echo $lang->attend->signIn;?></th>
                <th class='text-center'><?php echo $lang->attend->signOut;?></th>
              </tr>
              <?php $startDay = $weekIndex * 7 + 1;?>
              <?php for($day = $startDay; $day <= $dayNum and $day < $startDay + 7; $day++):?>
                <?php 
                  $currentDate = date("Y-m-d", strtotime("{$currentYear}-{$currentMonth}-{$day}"));
                  $status = isset($attends[$currentDate]) ? $attends[$currentDate]->status : '';
                ?>
                <tr class="attend-<?php echo $status?>">
                  <td><?php echo $currentDate;?></td>
                  <td><?php echo $lang->datepicker->dayNames[($day + $weekOffset) % 7]?></td>
                  <?php if(isset($attends[$currentDate])):?>
                  <?php $url = $this->createLink('oa.attend', 'edit', "date=" . str_replace('-', '', $currentDate));?>
                  <td class='attend-signin'>
                    <?php $signIn = substr($attends[$currentDate]->signIn, 0, 5);?>
                    <?php if(strpos(',late,both,absent,', $status) !== false) $signIn = html::a($url, $signIn . " <i class='icon icon-edit'></i>" , "data-toggle='modal' data-type='iframe' data-title='{$lang->attend->edit}'");?>
                    <?php echo $signIn;?>
                  </td>
                  <td class='attend-signout'>
                    <?php $signOut = substr($attends[$currentDate]->signOut, 0, 5);?>
                    <?php if(strpos(',early,both,absent,', $status) !== false) $signOut = html::a($url, $signOut . " <i class='icon icon-edit'></i>" , "data-toggle='modal' data-type='iframe' data-title='{$lang->attend->edit}'");?>
                    <?php echo $signOut;?>
                  </td>
                  <?php else:?>
                  <td></td>
                  <td></td>
                  <?php endif;?>
                </tr>
              <?php endfor;?>
            </table>
          </div>
        </div>
      </div>
      <?php endfor;?>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
