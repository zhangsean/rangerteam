<?php
/**
 * The associate contact file of customer module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     customer
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<form id='linkContactForm' method='post' action='<?php echo inlink('linkContact', "customerID=$customerID")?>'>
  <table class='table table-form'>
    <tr>
      <th class='w-100px'><?php echo $lang->customer->contact;?></th>
      <td>
        <div class='input-group'>
          <?php echo html::input('realname', '', "class='form-control'");?>
          <?php echo html::select('contact', $contacts, '', "class='form-control chosen' style='display:none'");?>
          <span class='input-group-addon'>
            <label class='checkbox'>
              <input type='checkbox' name='selectContact' id='selectContact' value='1'/><?php echo $lang->customer->selectContact;?>
            </label>
          </span>
        </div>
      </td>
    </tr>
    <tbody id='contactInfo' class='hidden'>
      <tr>
        <th><?php echo $lang->contact->gender;?></th>
        <td><?php unset($lang->genderList->u); echo html::radio('gender', $lang->genderList, '');?></td>
      </tr>
      <tr>
        <th><?php echo $lang->contact->email;?></th>
        <td><?php echo html::input('email', '', "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->contact->mobile;?></th>
        <td><?php echo html::input('mobile', '', "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->contact->phone;?></th>
        <td><?php echo html::input('phone', '', "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->contact->qq;?></th>
        <td><?php echo html::input('qq', '', "class='form-control'");?></td>
      </tr>
    </tbody>
  </table>
  <p class='text-center'>
    <?php echo html::submitButton() . html::commonButton($lang->goback, 'reloadModal btn')?>
    <div class='popover'></div>
  </p>
<form>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
