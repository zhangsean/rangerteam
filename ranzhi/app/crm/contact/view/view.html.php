<?php 
/**
 * The view of view function of contact module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     contact 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'><strong><?php echo $lang->contact->view;?></strong></div>
  <div class='panel-body'>
    <ul id="myTab" class="nav nav-tabs" style="margin-bottom: 20px">
      <li class="active"><a href="#basic" data-toggle="tab"><?php echo $lang->contact->basicInfo;?></a></li>
      <li><a href="#contactInfo" data-toggle="tab"><?php echo $lang->contact->contactInfo;?></a></li>
      <li><a href="#resume" data-toggle="tab"><?php echo $lang->contact->resume;?></a></li>
      <li><a href="#address" data-toggle="tab"><?php echo $lang->contact->address;?></a></li>
      <li><a href="#history" data-toggle="tab"><?php echo $lang->history;?></a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane fade active in" id="basic">
        <div class='col-md-8'>
          <table class='table table-form'>
            <tr>
              <th class='w-100px'><?php echo $lang->contact->realname;?></th>
              <td><?php echo $contact->realname;?></td>
            </tr>
            <tr>
              <th><?php echo $lang->contact->nickname;?></th>
              <td><?php echo $contact->nickname;?></td>
            </tr>
            <tr>
              <th><?php echo $lang->contact->customer;?></th>
              <td>
                <?php
                 echo $customers[$contact->customer];
                if($contact->maker) echo " ({$lang->contact->maker})";
                ?>
              </td>
            </tr>
            <tr>
              <th><?php echo $lang->contact->birthday;?></th>
              <td><?php echo $contact->birthday;?></td>
            </tr>
            <tr>
              <th><?php echo $lang->contact->gender;?></th>
              <td><?php echo zget($lang->contact->genderList, $contact->gender, '');?></td>
            </tr>
            <tr>
              <th><?php echo $lang->contact->createdDate;?></th>
              <td><?php echo $contact->createdDate;?></td>
            </tr>
            <tr>
              <th><?php echo $lang->contact->desc;?></th>
              <td><?php echo $contact->desc;?></td>
            </tr>
            <tr>
              <th><?php echo $lang->contact->site;?></th>
              <td><?php if($contact->site and $contact->site != 'http://') echo html::a($contact->site, $contact->site, "target='blank'");?></td>
            </tr>
          </table>
          <div class='action text-center'>
            <?php
            echo html::a(inlink('edit', "contactID=$contact->id"), $lang->edit, "class='btn'");
            echo html::a(inlink('delete', "contactID=$contact->id"), $lang->delete, "class='deleter btn'");
            echo html::a(inlink('browse'), $lang->goback, "class='btn'");
            ?>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="contactInfo">
        <table class='table table-form'>
          <tr>
            <th class='w-100px'><?php echo $lang->contact->email;?></th>
            <td><?php echo $contact->email;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->contact->mobile;?></th>
            <td><?php echo $contact->mobile;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->contact->phone;?></th>
            <td><?php echo $contact->phone;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->contact->skype;?></th>
            <td><?php echo $contact->skype;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->contact->qq;?></th>
            <td><?php echo $contact->qq;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->contact->weixin;?></th>
            <td><?php echo $contact->weixin;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->contact->weibo;?></th>
            <td><?php if($contact->weibo and $contact->weibo != 'http://weibo.com/') echo $contact->weibo;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->contact->wangwang;?></th>
            <td><?php echo $contact->wangwang;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->contact->yahoo;?></th>
            <td><?php echo $contact->yahoo;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->contact->gtalk;?></th>
            <td><?php echo $contact->gtalk;?></td>
          </tr>
        </table>
      </div>
      <div class="tab-pane fade" id="resume">
        <table class='table table-bordered table-hover table-data'>
          <thead>
            <tr class='text-center'>
              <th><?php echo $lang->resume->customer?></th>
              <th><?php echo $lang->resume->dept?></th>
              <th><?php echo $lang->resume->title?></th>
              <th class='w-100px'><?php echo $lang->resume->join?></th>
              <th class='w-100px'><?php echo $lang->resume->left?></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($resumes as $resume):?>
            <tr class='text-center'>
              <td><?php echo $customers[$resume->customer]?></td>
              <td><?php echo $resume->dept?></td>
              <td><?php echo $resume->title?></td>
              <td><?php echo $resume->join?></td>
              <td><?php echo $resume->left?></td>
            </tr>
          <?php endforeach;?>
          </tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="address">
        <table class='table table-hover table-bordered table-data'>
          <thead>
            <tr class='text-center'>
              <th class='w-150px'><?php echo $lang->address->title?></th>
              <th class='text-left'><?php echo $lang->address->location?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($addresses as $address):?>
            <tr class='text-center'>
              <td><?php echo $address->title?></td>
              <td class='text-left'><?php echo $address->country . ' ' . $address->province . ' ' . $address->city . ' ' . $address->location;?></td>
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
