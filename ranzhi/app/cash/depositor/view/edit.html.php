<?php 
/**
 * The edit view file of depositor module of RanZhi.
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
    <strong><i class="icon-plus"></i> <?php echo $lang->depositor->edit;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form w-p60'>
        <tr>
          <th class='w-120px'><?php echo $lang->depositor->type;?></th>
          <td><?php echo html::select('type', $lang->depositor->typeList, $depositor->type, "class='form-control' disabled");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->depositor->abbr;?></th>
          <td><?php echo html::input('abbr', $depositor->abbr, "class='form-control'");?></td>
        </tr>
        <?php if($depositor->type != 'cash'):?>
        <?php if($depositor->type == 'bank'):?>
        <tr>
          <th><?php echo $lang->depositor->branchProvider;?></th>
          <td><?php echo html::input('provider', $depositor->provider, "class='form-control'");?></td>
        </tr>
        <?php else:?>
        <tr>
          <th><?php echo $lang->depositor->serviceProvider;?></th>
          <td><?php echo html::select('provider', $lang->depositor->providerList, $depositor->provider, "class='form-control'");?></td>
        </tr> 
        <?php endif;?>
        <tr>
          <th><?php echo $lang->depositor->title;?></th>
          <td><?php echo html::input('title', $depositor->title, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->depositor->account;?></th>
          <td><?php echo html::input('account', $depositor->account, "class='form-control'");?></td>
        </tr>
        <?php if($depositor->type == 'bank'):?>
        <tr>
          <th><?php echo $lang->depositor->bankcode;?></th>
          <td><?php echo html::input('bankcode', $depositor->bankcode, "class='form-control'");?></td>
        </tr>
        <?php endif;?>
        <tr>
          <th><?php echo $lang->depositor->public;?></th>
          <td><?php echo html::radio('public', $lang->depositor->publicList, $depositor->public);?></td>
        </tr>
        <?php endif;?>
        <tr>
          <th><?php echo $lang->depositor->currency;?></th>
          <td><?php echo html::input('currency', $depositor->currency, "class='form-control'");?></td>
        </tr>
        <tr>
          <th></th>
          <td><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
