<?php
/**
 * The report view file of product module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     product
 * @version     $Id: report.html.php 1594 2011-03-13 07:27:55Z wwccss $
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='row'>
  <div class='col-md-3 col-lg-2'>
    <div class='panel panel-sm'>
      <div class='panel-heading'>
        <strong><?php echo $lang->report->select;?></strong>
      </div>
      <div class='panel-body' style='padding-top:0'>
        <form method='post'>
          <?php echo html::checkBox('charts', $lang->report->{$module}->chartList, $checkedCharts, '', 'block');?>
          <p><?php echo html::selectButton();?></p>
          <p><?php echo html::submitButton($lang->report->create);?></p>
        </form>
      </div>
    </div>
  </div>
  <div class='col-md-9 col-lg-10'>
    <div class='panel panel-sm'>
      <div class='panel-heading'>
        <strong><?php echo $lang->report->common;?></strong>
      </div>
      <table class='table active-disabled'>
        <?php foreach($charts as $chartType => $chartContent):?>
        <tr valign='top'>
          <td><?php echo $chartContent;?></td>
          <td width='300'>
            <div style="height:<?php echo $lang->report->options->height . 'px';?>; overflow:auto">
              <div class='panel'>
                <div class='panel-heading'>
                  <strong><?php echo $tips['caption'][$chartType]?></strong>
                </div>
                <table class='table table-condensed table-hover table-striped table-bordered'>
                  <thead>
                    <tr class='text-center'>
                      <th><?php echo $tips['item'][$chartType];?></th>
                      <th><?php echo $tips['value'][$chartType];?></th>
                      <th><?php echo $lang->report->percent;?></th>
                    </tr>
                  </thead>
                  <?php foreach($datas[$chartType] as $key => $data):?>
                  <tr class='text-center'>
                    <td><?php echo $data->name;?></td>
                    <td><?php echo $data->value;?></td>
                    <td><?php echo ($data->percent * 100) . '%';?></td>
                  </tr>
                  <?php endforeach;?>
                </table>
              </div>
            </div>
          </td>
        </tr>
        <?php endforeach;?>
      </table>
    </div>
  </div>
</div>
<?php echo $renderJS;?>
<?php include '../../common/view/footer.html.php';?>
