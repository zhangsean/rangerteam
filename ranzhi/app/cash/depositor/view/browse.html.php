<?php 
/**
 * The browse view file of depositor module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     depositor 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-group"></i> <?php echo $lang->depositor->list;?></strong>
    <div class='panel-actions pull-right'>
      <?php echo html::a(inlink('create'), "<i class='icon-plus'>{$lang->depositor->create}</i>", "class='btn btn-primary' data-toggle='modal'")?>
    </div>
  </div>
  <div class='panel-body'>
    <?php foreach($depositors as $depositor):?>
    <div class='col-md-4'>
    <div class='panel'>
      <table class='table'>
        <tr>
          <td>
            <div class='lead'><?php echo $depositor->abbr;?></div>
            <div class='info'>
            <?php echo "<div><strong>{$lang->depositor->type} {$lang->colon} </strong>{$lang->depositor->typeList[$depositor->type]}</div>";?>
            <?php if($depositor->type != 'cash'):?>
            <?php echo "<div><strong>{$lang->depositor->title} {$lang->colon} </strong>$depositor->title</div>";?>
            <?php if($depositor->type == 'bank') echo "<div><strong>{$lang->depositor->bankProvider} {$lang->colon} </strong>$depositor->provider </div>";?>
            <?php if($depositor->type == 'online') echo "<div><strong>{$lang->depositor->serviceProvider} {$lang->colon} </strong>{$lang->depositor->providerList[$depositor->provider]} </div>";?>
            <?php echo "<div><strong>{$lang->depositor->account} {$lang->colon} </strong>$depositor->account</div>";?>
            <?php if($depositor->type == 'bank') echo "<div><strong>{$lang->depositor->bankcode} {$lang->colon} </strong>$depositor->bankcode</div>";?>
            <?php if($depositor->type != 'cash') echo "<div><strong>{$lang->depositor->public} {$lang->colon} </strong>{$lang->depositor->publicList[$depositor->public]}</div>";?>
            <?php endif;?>
            <?php echo "<div><strong>{$lang->depositor->currency} {$lang->colon} </strong>{$lang->depositor->currencyList[$depositor->currency]}</div>";?>
            <?php echo "<div><strong>{$lang->depositor->status} {$lang->colon} </strong>{$lang->depositor->statusList[$depositor->status]}</div>";?>
            </div>
            <div class='pull-right'>
              <?php echo html::a(inlink('edit', "depositorID=$depositor->id"), $lang->edit, "data-toggle='modal'");?>
              <?php echo html::a(inlink('check', "depositorID=$depositor->id"), $lang->depositor->check);?>
              <?php if($depositor->status == 'normal') echo html::a(inlink('forbid', "depositorID=$depositor->id"), $lang->depositor->forbid, "data-toggle=modal");?>
              <?php if($depositor->status == 'disable') echo html::a(inlink('activate', "depositorID=$depositor->id"), $lang->depositor->activate, "data-toggle=modal");?>
            </div>
          </td>
        </tr>
      </table>
    </div>
    </div>
    <?php endforeach;?>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
