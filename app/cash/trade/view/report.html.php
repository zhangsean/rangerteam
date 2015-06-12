<?php
/**
 * The report view file of trade module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     trade
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php include '../../../sys/common/view/chart.html.php';?>
<div class='panel panel-sm'>
  <div class='panel-heading'><strong><?php echo $lang->trade->report->common;?></strong></div>
  <div class='panel-body'>
  <table class='table active-disabled'>
    <tr>
      <td colspan='3'>
        <div class='chart-wrapper text-center'>
          <h5><?php echo $currentYear . $lang->trade->report->annualCaption . '(' . $currencyList[$currency] . ')';?></h5>
          <div class='chart-canvas'><canvas height='260' width='800' id='myLineChart'></canvas></div>
        </div>
      </td>
      <td class='w-400px'>
        <div class='table-wrapper'>
          <table id='lineChart' class='table table-condensed table-hover table-striped table-bordered table-chart' data-chart='line' data-target='#myLineChart' data-animation='false'>
            <caption class='text-center'><?php echo html::select('year', $tradeYears, isset(array_flip($tradeYears)[$currentYear]) ? array_flip($tradeYears)[$currentYear] : '') . $lang->trade->report->annualCaption . ' ' . html::select('currency', $currencyList, $currency);?></caption>
            <thead>
              <tr class='text-center'>
                <th><?php echo $lang->trade->report->month;?></th>
                <th class='chart-label-in'><i class='chart-color-dot-in icon-circle'></i> <?php echo $lang->trade->in;?></th>
                <th class='chart-label-out'><i class='chart-color-dot-out icon-circle'></i> <?php echo $lang->trade->out;?></th>
                <th class='chart-label-profit'><i class='chart-color-dot-profit icon-circle'></i> <?php echo $lang->trade->profit . '/' . $lang->trade->loss;?></th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($annualChartDatas as $month => $annualChartData):?>
            <tr class='text-center'>
              <td class='chart-label'><?php echo $month == 'all' ? $lang->trade->total : $month;?></td>
              <td class='chart-value-in'><?php echo $annualChartData['in'];?></td>
              <td class='chart-value-out'><?php echo $annualChartData['out'];?></td>
              <td class='chart-value-profit'><?php echo $annualChartData['profit'];?></td>
            </tr>
            <?php endforeach;?>
            </tbody>
          </table>
        </div>
      </td>
    </tr>
  </table>
  <div class='panel' id='monthlyChart'>
    <div class='panel-heading'><strong><?php echo html::select('month', $tradeMonths, isset(array_flip($tradeMonths)[$currentMonth]) ? array_flip($tradeMonths)[$currentMonth] : '') . $lang->trade->report->monthlyCaption;?></strong></div>
    <div class='panel-body'>
      <?php foreach($monthlyChartDatas as $type => $chartDatas):?>
      <table class='table active-disabled'>
        <caption class='text-left'><strong><?php echo $lang->trade->$type . $lang->trade->report->monthlyCaption;?></strong></caption>
        <tr class='text-top'>
          <?php foreach($chartDatas as $groupBy => $datas):?>
          <td>
            <div class='chart-wrapper text-center'>
              <h5><?php echo $lang->trade->report->chartList[$groupBy];?></h5>
              <div class='chart-canvas'><canvas id="<?php echo 'chart-' . $type . '-' . $groupBy;?>" width='320' height='140' data-responsive='true'></canvas></div>
            </div>
          </td>
          <td class='w-300px'>
            <div style="overflow:auto;" class='table-wrapper'>
            <table class='table table-condensed table-hover table-striped table-bordered table-chart' data-chart='pie' data-target="<?php echo '#chart-' . $type . '-' . $groupBy;?>" data-animation='false'>
                <caption class='text-left'><?php echo $lang->trade->report->chartList[$groupBy];?></caption>
                <thead>
                  <tr>
                    <th class='w-20px'></th>
                    <th><?php echo $lang->trade->$groupBy;?></th>
                    <th><?php echo $lang->trade->money;?></th>
                    <th class='w-50px'><?php echo $lang->report->percent;?></th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($datas as $data):?>
                <tr class='text-center'>
                  <td class='chart-color'><i class='chart-color-dot icon-circle'></i></td>
                  <td class='chart-label'><?php echo $data->name;?></td>
                  <td class='chart-value'><?php echo $data->value;?></td>
                  <td><?php echo ($data->percent * 100) . '%';?></td>
                </tr>
                <?php endforeach;?>
                </tbody>
              </table>
            </div>
          </td>
          <?php endforeach;?>
        </tr>
      </table>
      <?php endforeach;?>
    </div>
  </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
