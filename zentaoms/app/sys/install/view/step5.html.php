<?php
/**
 * The html template file of step4 method of install module of chanzhiEPS.
 *
 * @copyright Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license   LGPL
 * @author	  Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package	  chanzhiEPS
 * @version	  $Id: step4.html.php 867 2010-06-17 09:32:58Z wwccss $
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
