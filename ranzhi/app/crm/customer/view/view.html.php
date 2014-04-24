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
<?php
include '../../common/view/header.html.php';
$objectType = 'customer';
$objectID   = $customer->id;
?>
<div class='panel'>
  <div class='panel-heading'><strong><i class="icon-list-info"></i> <?php echo $lang->customer->view;?></strong></div>
  <div class='panel-body'>
    <ul id="myTab" class="nav nav-tabs" style="margin-bottom: 20px">
      <li class="active"><a href="#basic" data-toggle="tab"><?php echo $lang->customer->basic;?></a></li>
      <li><a href="#contact" data-toggle="tab"><?php echo $lang->customer->contact;?></a></li>
      <li><a href="#contract" data-toggle="tab"><?php echo $lang->customer->contract;?></a></li>
      <li><a href="#order" data-toggle="tab"><?php echo $lang->customer->order;?></a></li>
      <li><a href="#address" data-toggle="tab"><?php echo $lang->customer->address;?></a></li>
      <li><a href="#history" data-toggle="tab"><?php echo $lang->history;?></a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane fade active in" id="basic">
          <div class='col-md-8'>
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
          </div>
      </div>
      <div class="tab-pane fade" id="contact">
        <table class='table table-bordered table-hover table-data'>
          <thead>
            <tr class='text-center'>
              <th class='w-60px'><?php echo $lang->customer->id;?></th>
              <th><?php echo $lang->customer->contact;?></th>
              <th><?php echo $lang->customer->phone;?></th>
              <th><?php echo $lang->customer->email;?></th>
              <th><?php echo $lang->customer->qq;?></th>
              <th><?php echo $lang->actions;?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($contacts as $contact):?>
            <tr class='text-center'>
              <td><?php echo $contact->id;?></td>
              <td><?php echo $contact->realname;?></td>
              <td><?php echo $contact->phone;?></td>
              <td><?php echo $contact->email;?></td>
              <td><?php echo $contact->qq;?></td>
              <td><?php echo html::a($this->createLink('contact', 'edit', "contactID={$contact->id}"), $lang->edit);?></td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="contract">
        <table class='table table-hover table-bordered table-data'>
          <thead>
            <tr class='text-center'>
              <th class='w-60px'><?php echo $lang->customer->id;?></th>
              <th><?php echo $lang->customer->name;?></th>
              <th><?php echo $lang->actions;?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($contracts as $id => $contract):?>
            <tr class='text-center'>
              <td><?php echo $id;?></td>
              <td><?php echo $contract;?></td>
              <td><?php echo html::a($this->createLink('contract', 'edit', "contractID={$id}"), $lang->edit);?></td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="order">
        <table class='table table-bordered table-hover table-data'>
          <thead>
            <tr class='text-center'>
              <th class='w-60px'><?php echo $lang->customer->id;?></th>
              <th><?php echo $lang->customer->name;?></th>
              <th><?php echo $lang->actions;?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($orders as $id => $order):?>
            <tr class='text-center'>
              <td><?php echo $id;?></td>
              <td><?php echo $order;?></td>
              <td><?php echo html::a($this->createLink('order', 'edit', "orderID={$id}"), $lang->edit);?></td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="address">
        <table class='table table-hover table-bordered table-data'>
          <thead>
            <tr class='text-center'>
              <th class='w-150px'><?php echo $lang->address->title;?></th>
              <th><?php echo $lang->address->location;?></th>
              <th class='w-100px'><?php echo $lang->actions;?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($addresses as $address):?>
            <tr>
              <td><?php echo $address->title?></td>
              <td><?php echo $address->country . ' ' . $address->province . ' ' . $address->city . ' ' . $address->location;?></td>
              <td><?php echo html::a($this->createLink('address', 'edit', "id=$address->id"), $lang->edit);?></td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="history"><?php include "../../../sys/common/view/action.html.php";?></div>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
