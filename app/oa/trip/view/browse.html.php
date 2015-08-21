<?php
/**
 * The browse view file of trip module of Ranzhi.
 *
 * @copyright   Copyright 2009-2015 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL
 * @author      chujilu <chujilu@cnezsoft.com>
 * @package     trip
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php js::set('type', $type)?>
<div id='menuActions'>
  <?php commonModel::printLink('oa.trip', 'create', "", "{$lang->create}", "data-toggle='modal' class='btn btn-primary'")?>
</div>
<div class='row'>
  <div class='col-xs-2'>
    <div class='panel panel-sm'>
      <div class='panel-body'>
        <ul class='tree' data-collapsed='true'>
          <?php foreach($yearList as $year):?>
          <li class='<?php echo $year == $currentYear ? 'active' : ''?>'>
            <?php commonModel::printLink('trip', 'browse', "type=$type&date=$year", $year);?>
            <ul>
              <?php foreach($monthList[$year] as $month):?>
              <li class='<?php echo ($year == $currentYear and $month == $currentMonth) ? 'active' : ''?>'>
                <?php commonModel::printLink('trip', 'browse', "type=$type&date=$year$month", $year . $month);?>
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
      <table class='table table-data table-hover text-center table-fixed'>
        <thead>
          <tr class='text-center'>
            <th class='w-80px'> <?php echo $lang->trip->id;?></th>
            <th class='w-80px'> <?php echo $lang->trip->name;?></th>
            <th class='w-150px'><?php echo $lang->trip->begin;?></th>
            <th class='w-150px'><?php echo $lang->trip->end;?></th>
            <th class='w-80px'><?php echo $lang->trip->createdBy;?></th>
            <th><?php echo $lang->trip->desc;?></th>
            <th class='w-150px'><?php echo $lang->actions;?></th>
          </tr>
        </thead>
        <?php foreach($tripList as $trip):?>
        <tr>
          <td><?php echo $trip->id;?></td>
          <td><?php echo $trip->name;?></td>
          <td><?php echo $trip->begin . ' ' . $trip->start;?></td>
          <td><?php echo $trip->end . ' ' . $trip->finish;?></td>
          <td><?php echo zget($users, $trip->createdBy);?></td>
          <td><?php echo $trip->desc;?></td>
          <td>
            <?php echo html::a($this->createLink('oa.trip', 'edit', "id=$trip->id"), $lang->edit, "data-toggle='modal'");?>
            <?php echo html::a($this->createLink('oa.trip', 'delete', "id=$trip->id"), $lang->delete, "class='deleter'");?>
          </td>
        </tr>
        <?php endforeach;?>
      </table>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
