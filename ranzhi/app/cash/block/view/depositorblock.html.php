<?php
/**
 * The project list block view file of block module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<table class='table table-form table-data block-depositor table-fixed'>
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
    </td>
  </tr>
</table>
<script>$('.block-order').dataTable();</script>
