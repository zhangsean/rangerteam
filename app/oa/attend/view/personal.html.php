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
<div class='with-side'>
  <div class='side'>
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
  <div class='main'>
    <div class='row'>
      <?php $startDate = strtotime('this week', strtotime("$currentYear-$currentMonth-01"))?>
      <?php $endDate   = strtotime('last day of this month', strtotime("$currentYear-$currentMonth-01"))?>
      <?php $endDate   = (date('w', $endDate) == 0) ? $endDate : strtotime("+6 day this week", $endDate)?>
      <?php $weekIndex = 0;?>
      <?php while($startDate <= $endDate):?>
      <div class='col-xs-4'>
        <?php $dayIndex = date('w', $startDate);?>
        <?php if($dayIndex == 1):?>
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
        <?php endif;?>
              <?php $currentDate = date("Y-m-d", $startDate);?>
              <?php if(isset($attends[$currentDate])):?>
              <?php $status = $attends[$currentDate]->status;?>
              <tr class="attend-<?php echo $status?> <?php echo (date('m', $startDate) == $currentMonth) ? '' : 'otherMonth'?>" title='<?php echo $lang->attend->statusList[$status]?>'>
                <td><?php echo $currentDate;?></td>
                <td><?php echo $lang->datepicker->dayNames[$dayIndex]?></td>
                <?php $url = $this->createLink('attend', 'edit', "date=" . str_replace('-', '', $currentDate));?>
                <td class='attend-signin'>
                  <?php $signIn = substr($attends[$currentDate]->signIn, 0, 5);?>
                  <?php if(strpos(',late,both,absent,', $status) !== false) $signIn = html::a($url, $signIn . " <i class='icon icon-edit'></i>" , "data-toggle='modal' data-width='500px' data-title='{$lang->attend->edit}'");?>
                  <?php echo $signIn;?>
                </td>
                <td class='attend-signout'>
                  <?php $signOut = substr($attends[$currentDate]->signOut, 0, 5);?>
                  <?php if(strpos(',early,both,absent,', $status) !== false) $signOut = html::a($url, $signOut . " <i class='icon icon-edit'></i>" , "data-toggle='modal' data-width='500px' data-title='{$lang->attend->edit}'");?>
                  <?php echo $signOut;?>
                </td>
              </tr>
              <?php else:?>
              <tr class="<?php echo (date('m', $startDate) == $currentMonth) ? '' : 'otherMonth'?>">
                <td><?php echo $currentDate;?></td>
                <td><?php echo $lang->datepicker->dayNames[$dayIndex]?></td>
                <td></td>
                <td></td>
              </tr>
              <?php endif;?>
        <?php if($dayIndex == 0):?>
            </table>
          </div>
        </div>
        <?php $weekIndex += 1;?>
        <?php endif;?>
        <?php $startDate = strtotime('+1 day', $startDate);?>
      </div>
      <?php endwhile;?>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
