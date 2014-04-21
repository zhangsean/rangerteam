<?php 
/**
 * The create view file of customer module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     customer 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->customer->create;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='customerForm' class='form-condensed'>
      <div class='row'>
        <div class='col-md-8'>
          <fieldset class='fieldset-primary'>
            <table class='table table-form'>
              <tr class='text-left'><th><?php echo $lang->customer->name;?></th></tr>
              <tr><td><?php echo html::input('name', '', "class='form-control'");?></td></tr>
            </table>
          </fieldset>
          <fieldset>
            <legend><?php echo $lang->customer->basicInfo; ?></legend>
            <table class='table table-form'>
              <tr>
                <th class='w-80px'><?php echo $lang->customer->contact;?></th>
                <td><?php echo html::input('contact', '', "class='form-control'");?></td>
                <th class='w-80px'><?php echo $lang->customer->phone;?></th>
                <td><?php echo html::input('phone', '', "class='form-control'");?></td>
              </tr>
              <tr>
                <th><?php echo $lang->customer->email;?></th>
                <td><?php echo html::input('email', '', "class='form-control'");?></td>
                <th><?php echo $lang->customer->qq;?></th>
                <td><?php echo html::input('qq', '', "class='form-control'");?></td>
              </tr>
              <tr>
                <th><?php echo $lang->customer->type;?></th>
                <td><?php echo html::select("type", $lang->customer->typeList, '', "class='form-control'");?></td>
                <th><?php echo $lang->customer->size;?></th>
                <td><?php echo html::select('size', $lang->customer->sizeList, '', "class='form-control'");?></td>
              </tr>
              <tr>
                <th><?php echo $lang->customer->status;?></th>
                <td><?php echo html::select("status", $lang->customer->statusList, '', "class='form-control'");?></td>
                <th><?php echo $lang->customer->level;?></th>
                <td><?php echo html::select('level', $lang->customer->levelList, 0, "class='form-control'");?></td>
              </tr>
            </table>
          </fieldset>
        </div>
        <div class='col-md-4'>
          <table class='table table-form'>
            <tr>
              <th class='text-left'><?php echo $lang->customer->desc;?></th>
            </tr>
            <tr>
              <td><?php echo html::textarea('desc', '', "rows='6' class='form-control'");?></td>
            </tr>
          </table>
        </div>
      </div>
      <?php echo html::submitButton();?>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
