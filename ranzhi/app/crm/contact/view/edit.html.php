<?php 
/**
 * The edit view of contact module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@cnezsoft.com>
 * @package     contact 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<form method='post' id='ajaxForm' class='form-condensed'>
  <div class='col-md-8'>
    <div class='panel'>
      <div class='panel-heading'><strong><?php echo $lang->contact->edit;?></strong></div>
      <div class='panel-body'>
        <table class='table table-form'>
          <tr>
            <th class='w-80px'><?php echo $lang->contact->realname;?></th>
            <td><?php echo html::input('realname', $contact->realname, "class='form-control'");?></td>
          </tr>
          <tr>
            <th class='w-80px'><?php echo $lang->contact->customer;?></th>
            <td class='w-p40'><?php echo html::select('customer', $customers, $contact->customer, "class='form-control chosen'");?></td>
            <td>
              <?php $checked = $contact->maker ? "checked='checked'" : '';?>
              <input type='checkbox' name='maker' id='maker' value='1' <?php echo $checked?>/>
              <label for='maker'><?php echo $lang->resume->maker?></label>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->resume->dept;?></th>
            <td><?php echo html::input('dept', $contact->dept, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->resume->title;?></th>
            <td><?php echo html::input('title', $contact->title, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->resume->join;?></th>
            <td><?php echo html::input('join', $contact->join, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->contact->birthday;?></th>
            <td><?php echo html::input('birthday', $contact->birthday, "class='form-control form-date'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->contact->gender;?></th>
            <td><?php echo html::radio('gender', $lang->contact->genderList, $contact->gender);?></td>
          </tr>
          <tr>
            <th><?php echo $lang->contact->createdDate;?></th>
            <td><?php echo html::input('createdDate', $contact->createdDate == '0000-00-00 00:00:00' ? '' : $contact->createdDate, "class='form-control form-datetime'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->contact->desc;?></th>
            <td colspan='2'><?php echo html::textarea('desc', $contact->desc, "rows='3' class='form-control'");?></td>
          </tr>
        </table>
      </div>
      <div class='panel-footer'><?php echo html::submitButton() . html::backButton();?></div>
    </div>
    <?php echo $this->fetch('action', 'history', "objectType=contact&objectID={$contact->id}&customer=0")?>
  </div>
  <div class='col-md-4'>
    <div class='panel'>
      <div class='panel-heading'><strong><?php echo $lang->contact->contactInfo;?></strong></div>
      <div class='panel-body'>
        <table class='table table-form'>
          <?php foreach($config->contact->contactWayList as $item):?>
          <tr>
            <th class='w-70px'><?php echo $lang->contact->{$item};?></th>
            <td><?php echo html::input($item, $contact->$item, "class='form-control'");?></td>
          </tr>
          <?php endforeach;?>
        </table>
      </div>
    </div>
  </div>
</form>
<?php include '../../common/view/footer.html.php';?>
