<?php
/**
 * The batch create view of trade module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     trade
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php include '../../../sys/common/view/datepicker.html.php';?>
<form id='ajaxForm' method='post'>
  <div class='panel'>
    <div class='panel-heading'><strong><?php echo $lang->trade->batchCreate;?></strong></div>
    <table class='table table-form'>
      <thead>
        <tr class='text-center'>
          <th class='w-60px'><?php echo $lang->trade->id;?></th> 
          <th class='w-150px'><?php echo $lang->trade->type;?></th> 
          <th><?php echo $lang->trade->depositor;?> <span class='required'></span></th>
          <th class='w-160px'><?php echo $lang->trade->money;?></th>
          <th class='w-160px'><?php echo $lang->trade->handlers;?></th>
          <th class='w-150px'><?php echo $lang->trade->date;?></th>
          <th class='w-300px'><?php echo $lang->trade->desc;?></th>
        </tr>
      </thead>

      <?php for($i = 0; $i < $config->trade->batchCreate; $i++):?>
      <tr>
        <td class='text-center'><?php echo $i+1;?></td>
        <td><?php echo html::select("type[$i]", $lang->trade->typeList, '', "class='form-control'");?></td>
        <td><?php echo html::select("depositor[$i]", $depositors, '', "class='form-control'");?></td>
        <td><?php echo html::input("money[$i]", '', "class='form-control'");?></td>
        <td><?php echo html::select("handlers[$i]", $users, '', "class=form-control");?></td>
        <td><?php echo html::input("date[$i]", '', "class='form-control form-date'");?></td>
        <td><?php echo html::textarea("desc[$i]", '', "rows='1' class='form-control'");?></td>
      </tr>
      <?php endfor;?>
      <tr><td colspan='6' class='text-center'><?php echo html::submitButton() . html::backButton();?></td></tr>
    </table>
  </div>
</form>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
