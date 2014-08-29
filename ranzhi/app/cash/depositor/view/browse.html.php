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
    <strong><i class="icon-group"></i> <?php echo $lang->depositor->browse;?></strong>
    <div class='panel-actions pull-right'>
      <?php echo html::a(inlink('create'), "<i class='icon-plus'></i> {$lang->depositor->create}", "class='btn btn-primary' data-toggle='modal'")?>
    </div>
  </div>
  <div class='panel-body'>
    <div class="cards">
      <?php foreach($depositors as $depositor):?>
      <div class='col-md-4 col-sm-6'>
        <div class='card card-depositor'>
          <div class='card-heading <?php echo $depositor->type;?>'>
            <div class='info'><span class='label' title='<?php echo $lang->depositor->type?>'><i class='icon'></i> <?php echo $lang->depositor->typeList[$depositor->type]?></span></div>
            <h4 class='title'><?php echo $depositor->abbr;?></h4>
            <div class='subtitle'>
              <?php if($depositor->type != 'cash' && !empty($depositor->title) && $depositor->title != $depositor->abbr):?>
              <span class='cell text-muted' title='<?php echo $lang->depositor->title;?>'><?php echo $depositor->title;?></span>
              <?php endif;?>
              <span class='cell text-special' title='<?php echo $lang->depositor->currency?>'><?php echo $currencyList[$depositor->currency]?></span>
              <?php if($depositor->type != 'cash'):?>
              <span class='cell text-<?php echo ($depositor->public == '0' ? 'important' : 'sucess') ?>' title='<?php echo $lang->depositor->public;?>'><?php echo $lang->depositor->publicList[$depositor->public];?></span>
              <?php endif;?>
            </div>
          </div>
          <?php if($depositor->type != 'cash'):?>
          <div class='card-caption'>
            <?php if($depositor->type == 'bank') echo "<dl class='dl-horizontal'><dt>{$lang->depositor->bankProvider} {$lang->colon} </dt><dd>$depositor->provider </dd></dl>";?>
            <?php if($depositor->type == 'online') echo "<dl class='dl-horizontal'><dt>{$lang->depositor->serviceProvider} {$lang->colon} </dt><dd>{$lang->depositor->providerList[$depositor->provider]} </dd></dl>";?>
            <?php echo "<dl class='dl-horizontal'><dt>{$lang->depositor->account} {$lang->colon} </dt><dd>$depositor->account</dd></dl>";?>
            <?php if($depositor->type == 'bank') echo "<dl class='dl-horizontal'><dt>{$lang->depositor->bankcode} {$lang->colon} </dt><dd>$depositor->bankcode</dd></dl>";?>
          </div>
          <?php endif;?>
          <div class='card-actions'>
            <div class='pull-right'>
              <?php echo html::a(inlink('edit', "depositorID=$depositor->id"), $lang->edit, "data-toggle='modal'");?>
              <?php echo html::a(inlink('check', "depositorID=$depositor->id"), $lang->depositor->check);?>
              <?php if($depositor->status == 'normal') echo html::a(inlink('forbid', "depositorID=$depositor->id"), $lang->depositor->forbid, "data-toggle=modal");?>
              <?php if($depositor->status == 'disable') echo html::a(inlink('activate', "depositorID=$depositor->id"), $lang->depositor->activate, "data-toggle=modal");?>
            </div>
            <?php echo "<small class='text-muted'>{$lang->depositor->status}{$lang->colon} </small><span class='text-" . ($depositor->status == 'normal' ? 'success': 'danger') . "'>{$lang->depositor->statusList[$depositor->status]}</span>";?>
          </div>
        </div>
      </div>
      <?php endforeach;?>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
