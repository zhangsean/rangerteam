<?php
/**
 * The html template file of step5 method of install module of ZenTaoMS.
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
<div class='container'>
  <table class='table table-bordered shadow'>
    <caption><?php echo $lang->install->success;?></caption>
    <tr>
      <th class='a-center'>
        <?php echo html::a('index.php', $lang->install->visitFront, "class='btn btn-primary' target='_blank'");?>
        <?php echo html::a('admin.php', $lang->install->visitAdmin, "class='btn btn-primary' target='_blank'");?>
      </th>
    </tr>
  </table>
</div>
<?php include './footer.html.php';?>
