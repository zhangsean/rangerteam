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
<div class='panel'>
  <div class='panel-heading'><strong><?php echo $lang->contact->edit;?></strong></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm' class='form-condensed'>
      <div class='row'>
        <div class='col-md-9'>
          <fieldset class='fieldset-primary'>
            <table class='table table-form'>
              <tr class='text-left'>
                <th><?php echo $lang->contact->realname;?></th>
                <th class='w-p45'><?php echo $lang->contact->nickname;?></th>
              </tr>
              <tr>
                <td><?php echo html::input('realname', $contact->realname, "class='form-control'");?></td>
                <td><?php echo html::input('nickname', $contact->nickname, "class='form-control'");?></td>
              </tr>
            </table>
          </fieldset>
          <fieldset>
            <legend><?php echo $lang->contact->basicInfo; ?></legend>
            <table class='table table-form'>
              <tr>
                <th class='w-80px'><?php echo $lang->contact->customer;?></th>
                <td class='w-p40'><?php echo html::select('customer', $customers, $contact->customer, "class='form-control select-customer'");?></td>
                <td>
                  <?php $checked = $contact->maker ? "checked='checked'" : '';?>
                  <input type='checkbox' name='maker' id='maker' value='1' <?php echo $checked?>/>
                  <label for='maker'><?php echo $lang->contact->maker?></label>
                </td>
                <td></td>
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
                <td colspan='3'><?php echo html::textarea('desc', $contact->desc, "rows='3' class='form-control'");?></td>
              </tr>
              <tr>
                <th><?php echo $lang->contact->site;?></th>
                <td colspan='3'><?php echo html::input('site', $contact->site ? $contact->site : 'http://', "class='form-control'");?></td>
              </tr>
            </table>
          </fieldset>
          <fieldset>
            <legend><?php echo $lang->contact->contactInfo; ?></legend>
            <table class='table table-form'>
              <tr>
                <th class='w-80px'><?php echo $lang->contact->email;?></th>
                <td><?php echo html::input('email', $contact->email, "class='form-control'");?></td>
                <th class='w-80px'><?php echo $lang->contact->mobile;?></th>
                <td><?php echo html::input('mobile', $contact->mobile, "class='form-control'");?></td>
              </tr>
              <tr>
                <th><?php echo $lang->contact->phone;?></th>
                <td><?php echo html::input('phone', $contact->phone, "class='form-control'");?></td>
                <th><?php echo $lang->contact->skype;?></th>
                <td><?php echo html::input('skype', $contact->skype, "class='form-control'");?></td>
              </tr>
              <tr>
                <th><?php echo $lang->contact->qq;?></th>
                <td><?php echo html::input('qq', $contact->qq, "class='form-control'");?></td>
                <th><?php echo $lang->contact->weixin;?></th>
                <td><?php echo html::input('weixin', $contact->weixin, "class='form-control'");?></td>
              </tr>
              <tr>
                <th><?php echo $lang->contact->weibo;?></th>
                <td><?php echo html::input('weibo', $contact->weibo ? $contact->weibo : 'http://weibo.com/', "class='form-control'");?></td>
                <th><?php echo $lang->contact->wangwang;?></th>
                <td><?php echo html::input('wangwang', $contact->wangwang, "class='form-control'");?></td>
              </tr>
              <tr>
                <th><?php echo $lang->contact->yahoo;?></th>
                <td><?php echo html::input('yahoo', $contact->yahoo, "class='form-control'");?></td>
                <th><?php echo $lang->contact->gtalk;?></th>
                <td><?php echo html::input('gtalk', $contact->gtalk, "class='form-control'");?></td>
              </tr>
            </table>
          </fieldset>
        </div>
      </div>
      <?php echo html::submitButton();?>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
