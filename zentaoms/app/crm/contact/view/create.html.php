<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->contact->create;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form'>
        <tr>
          <th><?php echo $lang->contact->customer;?></th>
          <td><?php echo html::select('customer', $customers, '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->realname;?></th>
          <td><?php echo html::input('realname', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->nickname;?></th>
          <td><?php echo html::input('nickname', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->avatar;?></th>
          <td><?php echo html::file('files', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->birthday;?></th>
          <td><?php echo html::input('birthday', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->gender;?></th>
          <td><?php echo html::radio('gender', $lang->contact->genderList, '');?></td>
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
          <th><?php echo $lang->contact->skype;?></th>
          <td><?php echo html::input('skype', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->qq;?></th>
          <td><?php echo html::input('qq', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->weixin;?></th>
          <td><?php echo html::input('weixin', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->weibo;?></th>
          <td><?php echo html::input('weibo', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->wangwang;?></th>
          <td><?php echo html::input('wangwang', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->yahoo;?></th>
          <td><?php echo html::input('yahoo', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->gtalk;?></th>
          <td><?php echo html::input('gtalk', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->site;?></th>
          <td><?php echo html::input('site', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->contact->desc;?></th>
          <td><?php echo html::textarea('desc', '', "rows='2' class='form-control'");?></td>
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
