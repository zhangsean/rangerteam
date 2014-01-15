<?php
/**
 * The profile view file of user module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<div class='page-user-control'>
  <div class='panel panel-pure'>
    <div class='panel-body'>
      <table class='table table-form'>
        <tr>
          <th style='width:100px;'><?php echo $lang->user->realname;?></th>
          <td><?php echo $user->realname;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->email;?></th>
          <td><?php echo $user->email;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->address;?></th>
          <td><?php echo $user->address;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->zipcode;?></th>
          <td><?php echo $user->zipcode;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->mobile;?></th>
          <td><?php echo $user->mobile;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->phone;?></th>
          <td><?php echo $user->phone;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->qq;?></th>
          <td><?php echo $user->qq;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->gtalk;?></th>
          <td><?php echo $user->gtalk;?></td>
        </tr>
        <tr>
          <th></th>
          <td><?php echo html::a(inlink('edit'), "<i class='icon-pencil'></i> " . $lang->user->editProfile, "class='btn btn-primary'");?></td>
        </tr>
      </table>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
</body>
</html>
