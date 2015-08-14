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
<div id='menuActions'>
    <div class='date dropdown'>
      <button type='button' class='btn btn-sm btn-default dropdown-toggle' data-toggle='dropdown'><?php echo $currentYear . $lang->year . $currentMonth . $lang->month;?> <span class="caret"></span></button>
      <ul class='dropdown-menu pull-right'>
        <?php foreach($yearList as $year):?>
        <li class='dropdown-submenu'>
          <?php echo html::a("javascript:void(0)", $year);?>
          <ul class='dropdown-menu'>
            <?php foreach($monthList[$year] as $month):?>
            <li><?php echo html::a(helper::createLink('attend', 'personal', "date=$year$month"), $month . $lang->month);?></li>
            <?php endforeach;?>
          </ul>
        </li>
        <?php endforeach;?>
      </ul>
    </div>

</div>
<div class='row'>
  <?php $weekOffset = date('w', strtotime("$currentYear-$currentMonth-01")) - 1;?>
  <?php for($weekIndex = 0; $weekIndex < $weekNum; $weekIndex++):?>
  <div class='col-xs-3'>
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
                <?php if(strpos(',late,both,absent,', $status) !== false) $signIn = html::a($url, $signIn . " <i class='icon icon-edit'></i>" , "data-toggle='modal' data-type='iframe' data-title='{$lang->attend->manual}'");?>
                <?php echo $signIn;?>
              </td>
              <td class='attend-signout'>
                <?php $signOut = substr($attends[$currentDate]->signOut, 0, 5);?>
                <?php if(strpos(',early,both,absent,', $status) !== false) $signOut = html::a($url, $signOut . " <i class='icon icon-edit'></i>" , "data-toggle='modal' data-type='iframe' data-title='{$lang->attend->manual}'");?>
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
<?php include '../../common/view/footer.html.php';?>

