<?php
/**
 * The html template file of confirm method of upgrade module of ZenTaoPMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $Id$
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<form method='post' action='<?php echo inlink('execute');?>'>
  <table align='center' class='table table-bordered'>
    <caption><?php echo $lang->upgrade->confirm;?></caption>
    <tr>
      <td>
        <pre><?php echo $confirm;?></pre>
        <?php echo html::submitButton($lang->upgrade->execute) . html::hidden('fromVersion', $fromVersion);?>
      </td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.lite.html.php';?>
