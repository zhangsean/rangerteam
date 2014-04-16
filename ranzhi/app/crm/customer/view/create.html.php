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
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->customer->create;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm' class='form-condensed'>
      <div class='row'>
        <div class='col-md-8'>
          <fieldset class='fieldset-primary'>
            <table class='table table-form'>
              <tr class='text-left'>
                <th><?php echo $lang->customer->name;?></th>
              </tr>
              <tr>
                <td><?php echo html::input('name', '', "class='form-control'");?></td>
              </tr>
            </table>
          </fieldset>
          <fieldset>
            <legend><?php echo $lang->customer->basicInfo; ?></legend>
            <table class='table table-form'>
              <tr>
                <th class='w-80px'><?php echo $lang->customer->type;?></th>
                <td><?php echo html::select("type", $lang->customer->typeList, '', "class='form-control'");?></td>
                <th class='w-80px'><?php echo $lang->customer->size;?></th>
                <td><?php echo html::select('size', $lang->customer->sizeList, '', "class='form-control'");?></td>
              </tr>
              <tr>
                <th><?php echo $lang->customer->industry;?></th>
                <td><?php echo html::input('industry', '', "class='form-control'");?></td>
                <th><?php echo $lang->customer->area;?></th>
                <td><?php echo html::input('area', '', "class='form-control'");?></td>
              </tr>
              <tr>
                <th><?php echo $lang->customer->status;?></th>
                <td><?php echo html::select("status", $lang->customer->statusList, '', "class='form-control'");?></td>
                <th><?php echo $lang->customer->level;?></th>
                <td><?php echo html::input('level', '', "class='form-control'");?></td>
              </tr>
              <tr>
                <th><?php echo $lang->customer->intension;?></th>
                <td colspan='3'><?php echo html::textarea('intension', '', "class='form-control' rows=2");?></td>
              </tr>
            </table>
          </fieldset>
          <fieldset class='collapsed'>
            <legend><?php echo $lang->customer->moreInfo; ?></legend>
            <table class='table table-form'>
              <tr>
                <th class='w-80px'><?php echo $lang->customer->site;?></th>
                <td><?php echo html::input('site', '', "class='form-control'");?></td>
                <th class='w-80px'><?php echo $lang->customer->weibo;?></th>
                <td><?php echo html::input('weibo', '', "class='form-control'");?></td>
              </tr>
              <tr>
                <th><?php echo $lang->customer->weixin;?></th>
                <td><?php echo html::input('weixin', '', "class='form-control'");?></td>
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
