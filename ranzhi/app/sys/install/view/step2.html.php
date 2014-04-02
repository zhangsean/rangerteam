<?php
/**
 * The html template file of step2 method of install module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     install 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<div class="container">
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'><strong><?php echo $lang->install->setConfig;?></strong></div>
      <div class='modal-body'>
      <form method='post' action='<?php echo $this->createLink('install', 'step3');?>' class='form-inline' id='form1'>
        <table class='table table-bordered table-form'>
          <tr>
            <th class='w-p20'><?php echo $lang->install->key;?></th>
            <th class='text-center'><?php echo $lang->install->value?></th>
          </tr>
          <tr>
            <th><?php echo $lang->install->dbHost;?></th>
            <td><?php echo html::input('dbHost', '127.0.0.1', "class='text-3 form-control'");?><?php echo $lang->install->dbHostNote;?></td>
          </tr>
          <tr>
            <th><?php echo $lang->install->dbPort;?></th>
            <td><?php echo html::input('dbPort', '3306', "class='text-3 form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->install->dbUser;?></th>
            <td><?php echo html::input('dbUser', 'root', "class='text-3 form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->install->dbPassword;?></th>
            <td><?php echo html::input('dbPassword', '', "class='text-3 form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->install->dbName;?></th>
            <td><?php echo html::input('dbName', 'zentaoms', "class='text-3 form-control'") . html::checkBox('clearDB', $lang->install->clearDB);?></td>
          </tr>
          <tr><td colspan='2' class='text-center'><?php echo html::hidden('requestType','GET') . html::submitButton();?></td></tr>
        </table>
      </form>
      </div>
    </div>
  </div>
</div>
<?php include './footer.html.php';?>
