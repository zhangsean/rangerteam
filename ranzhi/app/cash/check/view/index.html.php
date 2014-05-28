<?php 
/**
 * The browse view file of check module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     check 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<?php include '../../../sys/common/view/datepicker.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-group"></i> <?php echo $lang->check->common;?></strong>
  </div>
  <div class='panel-body'> 
    <form method='post' id='ajax-form' class='form-inline'>
      <table class="table table-form w-p100">
        <tr>
          <th class='w-60px'><?php echo $lang->check->depositor;?></th>
          <td><?php echo html::select('depositor', $depositorList, '', "class='form-control chosen' multiple");?></td>
          <th class='w-100px'><?php echo $lang->check->start;?></th>
          <td class='w-200px'><?php echo html::select('start', $dateOptions, '', "class='form-control'");?></td>
          <th class='w-100px'><?php echo $lang->check->end;?></th>
          <td class='w-200px'><?php echo html::select('end', $dateOptions, '', "class='form-control'");?></td>
          <td class='w-80px'><?php echo html::submitButton($lang->check->common);?></td>
        </tr>
      </table>
    </form>
    <?php if(!empty($results)):?>
    <div>
      <table class='table table-hover table-striped tablesorter table-data'>
        <thead>
          <tr>
            <th><?php echo $lang->check->depositor;?></th>
            <th><?php echo $lang->check->originValue;?></th>
            <th><?php echo $lang->check->computedValue;?></th>
            <th><?php echo $lang->check->actualValue;?></th>
            <th><?php echo $lang->check->result;?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($results as $depositorID => $result):?>
          <?php $class = $result->computed == $result->actual ? '' : 'text-error';?>
          <?php $diff  = $result->computed - $result->actual;?>
          <tr class='<?php echo $class;?>'>
            <td><?php echo zget($depositorList, $depositorID); ?></td>
            <td><?php echo $result->origin;?></td>
            <td><?php echo $result->computed;?></td>
            <td><?php echo $result->actual;?></td>
            <?php if($diff == 0):?>
            <td><?php echo $lang->check->success;?></td>
            <?php endif;?>
            <?php if($diff > 0):?>
            <td><?php printf($lang->check->overfllow, $diff);?></td>
            <?php endif;?>
           <?php if($diff < 0):?>
            <td><?php printf($lang->check->less, $diff);?></td>
            <?php endif;?>
          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
    </div>
    <?php endif;?>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
