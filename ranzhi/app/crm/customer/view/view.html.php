<?php 
/**
 * The info file of customer module of RanZhi.
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
<div class='row'>
  <div class='col-md-8'>
    <div class='panel'>
      <div class='panel-heading'><strong><i class="icon-list-info"></i> <?php echo $lang->customer->view;?></strong></div>
      <div class='panel-body'>
        <table class='table table-form table-data'>
          <tr>
            <th class='w-80px'><?php echo $lang->customer->name;?></th>
            <td><?php echo $customer->name;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->customer->level;?></th>
            <td><?php echo $lang->customer->levelList[$customer->level];?></td>
          </tr>
          <tr>
            <th><?php echo $lang->customer->status;?></th>
            <td><?php echo $lang->customer->statusList[$customer->status];?></td>
          </tr>
          <tr>
            <th><?php echo $lang->customer->size;?></th>
            <td><?php echo $lang->customer->sizeList[$customer->size];?></td>
          </tr>
          <tr>
            <th><?php echo $lang->customer->type;?></th>
            <td><?php echo $lang->customer->typeList[$customer->type];?></td>
          </tr>
          <tr>
            <th><?php echo $lang->customer->industry;?></th>
            <td><?php echo $customer->industry;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->customer->area;?></th>
            <td><?php echo $customer->area;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->customer->intension;?></th>
            <td><?php echo $customer->intension;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->customer->desc;?></th>
            <td><?php echo $customer->desc;?></td>
          </tr>
        </table>
         <div class='action text-center'>
           <?php
           echo html::a(inlink('edit', "customerID=$customer->id"), $lang->edit, "class='btn'");
           echo html::a(inlink('delete', "customerID=$customer->id"), $lang->delete, "class='deleter btn'");
           echo html::a(inlink('browse'), $lang->goback, "class='btn'");
           ?>
         </div>
      </div>
    </div>
    <?php echo $this->fetch('action', 'history', "objectType=customer&objectID={$customer->id}&customer={$customer->id}")?>
  </div>
  <div class='col-md-4'>  
    <div class='panel'>
      <div class='panel-heading'><strong><i class="icon-list-info"></i> <?php echo $lang->customer->contact;?></strong></div>
      <div class='panel-body'>
        <table class='table table-form table-data'>
          <tr class='text-left'>
            <th><?php echo $lang->contact->realname;?></th>
            <th><?php echo $lang->contact->phone;?></th>
            <th><?php echo $lang->contact->email;?></th>
            <th><?php echo $lang->contact->qq;?></th>
          </tr>
          <?php foreach($contacts as $contact):?>
          <tr class='text-left'>
            <td><?php echo $contact->realname;?></td>
            <td><?php echo $contact->phone;?></td>
            <td><?php echo $contact->email;?></td>
            <td><?php echo $contact->qq;?></td>
          </tr>
          <?php endforeach;?>
        </table>
      </div>
    </div>
    <div class='panel'>
      <div class='panel-heading'><strong><i class="icon-list-info"></i> <?php echo $lang->customer->contract;?></strong></div>
      <div class='panel-body'>
        <table class='table table-form table-data'>
          <tr class='text-left'>
            <th><?php echo $lang->contract->name;?></th>
            <th><?php echo $lang->contract->amount;?></th>
            <th><?php echo $lang->contract->status;?></th>
          </tr>
          <?php foreach($contracts as $contract):?>
          <tr>
            <td><?php echo $contract->name;?></td>
            <td><?php echo $contract->amount;?></td>
            <td><?php echo $lang->contract->statusList[$contract->status];?></td>
          </tr>
          <?php endforeach;?>
        </table>
      </div>
    </div>
    <div class='panel'>
      <div class='panel-heading'><strong><i class="icon-list-info"></i> <?php echo $lang->customer->order;?></strong></div>
      <div class='panel-body'>
        <table class='table table-form table-data'>
          <tr class='text-left'>
            <th><?php echo $lang->order->product;?></th>
            <th><?php echo $lang->order->status;?></th>
          </tr>
          <?php foreach($orders as $order):?>
          <tr>
            <td><?php echo $products[$order->product];?></td>
            <td><?php echo $lang->order->statusList[$order->status];?></td>
          </tr>
          <?php endforeach;?>
        </table>
      </div>
    </div>
    <div class='panel'>
      <div class='panel-heading'><strong><?php echo $lang->customer->address;?></strong></div>
      <div class='panel-body'>
        <table class='table table-form table-data'>
          <?php foreach($addresses as $address):?>
          <tr>
            <td><?php echo $address->title . $lang->colon . $address->country . ' ' . $address->province . ' ' . $address->city . ' ' . $address->location;?></td>
          </tr>
          <?php endforeach;?>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
