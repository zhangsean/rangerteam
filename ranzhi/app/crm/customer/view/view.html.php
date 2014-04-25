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
            <td colspan='3'><?php echo $customer->name;?></td>
          </tr>
          <tr>
            <th class='w-80px'><?php echo $lang->customer->level;?></th>
            <td class='w-p40'><?php echo $lang->customer->levelList[$customer->level];?></td>
            <th class='w-80px'><?php echo $lang->customer->status;?></th>
            <td class='w-p40'><?php echo $lang->customer->statusList[$customer->status];?></td>
          </tr>
          <tr>
            <th><?php echo $lang->customer->size;?></th>
            <td><?php echo $lang->customer->sizeList[$customer->size];?></td>
            <th><?php echo $lang->customer->type;?></th>
            <td><?php echo $lang->customer->typeList[$customer->type];?></td>
          </tr>
          <tr>
            <th><?php echo $lang->customer->industry;?></th>
            <td><?php echo $customer->industry;?></td>
            <th><?php echo $lang->customer->area;?></th>
            <td><?php echo $customer->area;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->customer->weibo;?></th>
            <td><?php echo $customer->weibo;?></td>
            <th><?php echo $lang->customer->weixin;?></th>
            <td><?php echo $customer->weixin;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->customer->site;?></th>
            <td colspan='3'><?php echo $customer->site;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->customer->intension;?></th>
            <td colspan='3'><?php echo $customer->intension;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->customer->desc;?></th>
            <td colspan='3'><?php echo $customer->desc;?></td>
          </tr>
        </table>
      </div>
      <div class='panel-footer'>
        <?php
        echo html::a(inlink('edit', "customerID=$customer->id"), $lang->edit, "class='btn'");
        echo html::a(inlink('delete', "customerID=$customer->id"), $lang->delete, "class='deleter btn'");
        echo html::a(inlink('browse'), $lang->goback, "class='btn'");
        ?>
      </div>
    </div>
    <?php echo $this->fetch('action', 'history', "objectType=customer&objectID={$customer->id}&customer={$customer->id}")?>
  </div>
  <div class='col-md-4'>  
    <div class='panel'>
      <div class='panel-heading'><strong><i class="icon-list-info"></i> <?php echo $lang->customer->contact;?></strong></div>
      <div class='panel-body'>
        <table class='table table-hover table-striped table-data table-contact'>
          <?php foreach($contacts as $contact):?>
          <tr>
            <td>
              <dl>
                <dt <?php if($contact->maker) echo "class='text-danger'";?>>
                  <?php echo $contact->realname;?>
                </dt>
                <dd>
                  <small class='w-70px'> <?php echo $lang->resume->dept . $lang->colon; ?></small>
                  <strong><?php echo $contact->dept;?></strong>
                  <small> <?php echo $lang->resume->title . $lang->colon; ?></small>
                  <strong><?php echo $contact->title;?></strong>
                </dd>
                <?php foreach($config->contact->contactWayList as $item):?>
                <?php if(!empty($contact->{$item})):?>
                <dd>
                  <small class='w-70px'><?php echo $lang->contact->{$item} . $lang->colon;?></small>
                  <strong><?php echo $contact->{$item};?></strong>
                </dd>
                <?php endif;?>
                <?php endforeach;?>
              </dl>
            </td>
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
