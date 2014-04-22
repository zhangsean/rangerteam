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
<div class='row'>
  <div class='col-md-8'>
    <div class='panel'>
      <div class='panel-heading'><strong><?php echo $lang->contact->view;?></strong></div>
      <div class='panel-body'>
        <fieldset class='fieldset-primary'>
          <table class='table table-form'>
            <tr class='text-left'>
              <th><?php echo $lang->contact->realname;?></th>
              <th><?php echo $lang->contact->nickname;?></th>
            </tr>
            <tr>
              <td><?php echo $contact->realname;?></td>
              <td><?php echo $contact->nickname;?></td>
            </tr>
          </table>
        </fieldset>
        <fieldset>
          <legend><?php echo $lang->contact->basicInfo; ?></legend>
          <table class='table table-form'>
            <tr>
              <th class='w-100px'><?php echo $lang->contact->customer;?></th>
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
              <td><?php if($contact->site) echo html::a($contact->site, $contact->site, "target='blank'");?></td>
            </tr>
          </table>
        </fieldset>
        <fieldset>
          <legend><?php echo $lang->contact->contactInfo; ?></legend>
          <table class='table table-form'>
            <tr>
              <th class='w-80px'><?php echo $lang->contact->email;?></th>
              <td><?php echo $contact->email;?></td>
              <th class='w-80px'><?php echo $lang->contact->mobile;?></th>
              <td><?php echo $contact->mobile;?></td>
            </tr>
            <tr>
              <th><?php echo $lang->contact->phone;?></th>
              <td><?php echo $contact->phone;?></td>
              <th><?php echo $lang->contact->skype;?></th>
              <td><?php echo $contact->skype;?></td>
            </tr>
            <tr>
              <th><?php echo $lang->contact->qq;?></th>
              <td><?php echo $contact->qq;?></td>
              <th><?php echo $lang->contact->weixin;?></th>
              <td><?php echo $contact->weixin;?></td>
            </tr>
            <tr>
              <th><?php echo $lang->contact->weibo;?></th>
              <td><?php echo $contact->weibo;?></td>
              <th><?php echo $lang->contact->wangwang;?></th>
              <td><?php echo $contact->wangwang;?></td>
            </tr>
            <tr>
              <th><?php echo $lang->contact->yahoo;?></th>
              <td><?php echo $contact->yahoo;?></td>
              <th><?php echo $lang->contact->gtalk;?></th>
              <td><?php echo $contact->gtalk;?></td>
            </tr>
          </table>
        </fieldset>
        <div class='action text-center'>
          <?php
          echo html::a(inlink('edit', "contactID=$contact->id"), $lang->edit, "class='btn'");
          echo html::a(inlink('delete', "contactID=$contact->id"), $lang->delete, "class='deleter btn'");
          echo html::a(inlink('browse'), $lang->goback, "class='btn'");
          ?>
        </div>
        <fieldset>
          <legend><?php echo $lang->contact->resume;?></legend>
          <?php if($resumes):?>
          <table class='table table-hover'>
            <tr class='text-center'>
              <th><?php echo $lang->resume->customer?></th>
              <th><?php echo $lang->resume->dept?></th>
              <th><?php echo $lang->resume->title?></th>
              <th class='w-100px'><?php echo $lang->resume->join?></th>
              <th class='w-100px'><?php echo $lang->resume->left?></th>
            </tr>
            <?php foreach($resumes as $resume):?>
            <tr class='text-center'>
              <td><?php echo $customers[$resume->customer]?></td>
              <td><?php echo $resume->dept?></td>
              <td><?php echo $resume->title?></td>
              <td><?php echo $resume->join?></td>
              <td><?php echo $resume->left?></td>
            </tr>
            <?php endforeach;?>
          </table>
          <?php endif;?>
        </fieldset>
        <fieldset>
          <legend><?php echo $lang->contact->address;?></legend>
          <?php if($addresses):?>
          <table class='table table-hover'>
            <tr class='text-center'>
              <th class='w-150px'><?php echo $lang->address->title?></th>
              <th class='text-left'><?php echo $lang->address->location?></th>
            </tr>
            <?php foreach($addresses as $address):?>
            <tr class='text-center'>
              <td><?php echo $address->title?></td>
              <td class='text-left'><?php echo $address->country . ' ' . $address->country . ' ' . $address->city . ' ' . $address->location;?></td>
            </tr>
            <?php endforeach;?>
          </table>
          <?php endif;?>
        </fieldset>
      </div>
    </div>
  </div>
  <div class='col-md-4'><?php include "../../../sys/common/view/action.html.php";?></div>
</div>
<?php include '../../common/view/footer.html.php';?>
