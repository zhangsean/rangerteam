<?php
/**
 * The browse view file of contract module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     contract
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php js::set('mode', $mode);?>
<div class='panel'>
  <div class='panel-heading'>
  <strong><i class="icon-list-ul"></i> <?php echo $lang->contract->list;?></strong>
  <div class='panel-actions pull-right'><?php echo html::a($this->inlink('create'), '<i class="icon-plus"></i> ' . $lang->contract->create, "class='btn btn-primary'");?></div>
  </div>
  <table class='table table-hover table-striped tablesorter table-data' id='contractList'>
    <thead>
      <tr class='text-center'>
        <?php $vars = "mode={$mode}&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}";?>
        <th class='w-60px'> <?php commonModel::printOrderLink('id',          $orderBy, $vars, $lang->contract->id);?></th>
        <th>                <?php commonModel::printOrderLink('name',        $orderBy, $vars, $lang->contract->name);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('amount',      $orderBy, $vars, $lang->contract->amount);?></th>
        <th class='w-100px'><?php commonModel::printOrderLink('createdDate', $orderBy, $vars, $lang->contract->createdDate);?></th>
        <th class='w-60px'> <?php commonModel::printOrderLink('return',      $orderBy, $vars, $lang->contract->return);?></th>
        <th class='w-60px'> <?php commonModel::printOrderLink('delivery',    $orderBy, $vars, $lang->contract->delivery);?></th>
        <th class='w-60px'> <?php commonModel::printOrderLink('status',      $orderBy, $vars, $lang->contract->status);?></th>
        <th class='w-180px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($contracts as $contract):?>
      <tr class='text-center' data-url='<?php echo inlink('view', "contractID=$contract->id"); ?>'>
        <td><?php echo $contract->id;?></td>
        <td class='text-left'><?php echo $contract->name;?></td>
        <td class='text-right'><?php echo zget($currencySign, $contract->currency, '') . $contract->amount;?></td>
        <td><?php echo substr($contract->createdDate, 0, 10);?></td>
        <td><?php echo $lang->contract->returnList[$contract->return];?></td>
        <td><?php echo $lang->contract->deliveryList[$contract->delivery];?></td>
        <td class='<?php echo "contract-{$contract->status}";?>'><?php echo $lang->contract->statusList[$contract->status];?></td>
        <td><?php echo $this->contract->buildOperateMenu($contract) ?></td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot>
      <tr>
        <td class='text-middle' colspan='2'>
          <div class='text-danger'>
            <?php
            foreach($totalAmount as $currency => $amount)
            {
                if($amount['contract'] == 0 and $amount['return'] == 0) continue;
                printf($lang->contract->totalAmount, $currencyList[$currency], $amount['contract'], $amount['return']);
            }
            ?>
          </div>
        </td>
        <td colspan='7'><?php $pager->show();?></td>
      </tr>
    </tfoot>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
