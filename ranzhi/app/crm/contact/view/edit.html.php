<?php 
/**
 * The edit view of contact module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@cnezsoft.com>
 * @package     contact 
 * @version     $Id $
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<div class='panel'>
  <div class='panel-heading'><strong><?php echo $lang->contact->edit;?></strong></div>
  <div class='panel-body'>
    <div class="row"></div>
    <form method='post' id='ajaxForm' class='form-condensed'>
      <div class='row'>
        <div class='col-md-8'>
          <fieldset class='fieldset-primary'>
            <table class='table table-form'>
              <tr class='text-left'>
                <th><?php echo $lang->contact->realname;?></th>
                <th class='w-p45'><?php echo $lang->contact->nickname;?></th>
                <td class='w-80px text-right' rowspan='2' title='<?php echo $lang->contact->avatar;?>'>
                  <div class="avatar avatar-empty">
                    <?php if($contact->avatar) echo html::image($contact->avatar); ?>
                    <span><?php echo $lang->contact->uploadAvatar ?></span>
                    <?php echo html::file('files', "class='form-control'");?>
                  </div>
                </td>
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
                <td class='w-p40'><?php echo html::select('customer', $customers, $contact->customer, "class='form-control'");?></td><td></td><td></td>
              </tr>
              <tr>
                <th><?php echo $lang->contact->birthday;?></th>
                <td><?php echo html::input('birthday', $contact->birthday, "class='form-control form-date'");?></td>
                <th><?php echo $lang->contact->gender;?></th>
                <td><?php echo html::radio('gender', $lang->contact->genderList, $contact->gender);?></td>
              </tr>
              <tr>
                <th><?php echo $lang->contact->site;?></th>
                <td colspan='3'><?php echo html::input('site', $contact->site, "class='form-control'");?></td>
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
                <td><?php echo html::input('weibo', $contact->weibo, "class='form-control'");?></td>
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
        <div class='col-md-4'>
          <table class='table table-form'>
            <tr>
              <th class='text-left'><?php echo $lang->contact->desc;?></th>
            </tr>
            <tr>
              <td><?php echo html::textarea('desc', $contact->desc, "rows='2' class='form-control'");?></td>
            </tr>
          </table>
        </div>
      </div>
      <?php echo html::submitButton();?>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
