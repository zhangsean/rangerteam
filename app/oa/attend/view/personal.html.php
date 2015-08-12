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
            <?php $currentDate = $day < 10 ? "{$currentYear}-{$currentMonth}-0{$day}" : "{$currentYear}-{$currentMonth}-{$day}";?>
            <?php if(isset($attends[$currentDate])):?>
            <tr class="attend-<?php echo $attends[$currentDate]->status?>">
              <td><?php echo $currentDate;?></td>
              <td><?php echo $attends[$currentDate]->dayName;?></td>
              <td class='attend-signin'><?php echo substr($attends[$currentDate]->signIn, 10);?></td>
              <td class='attend-signout'><?php echo substr($attends[$currentDate]->signOut, 10);?></td>
            </tr>
            <?php else:?>
            <tr>
              <td><?php echo $currentDate;?></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <?php endif;?>
          <?php endfor;?>
        </table>
      </div>
    </div>
  </div>
  <?php endfor;?>
</div>
<?php include '../../common/view/footer.html.php';?>

