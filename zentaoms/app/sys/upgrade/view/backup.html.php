<?php
/**
 * The html template file of index method of upgrade module of ZenTaoPMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $Id$
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<table align='center' class='table table-bordered table-5'>
  <caption><?php echo $lang->upgrade->backup;?></caption>
  <tr>
    <td>
      <?php printf($lang->upgrade->backupData, $db->user, $db->password, $db->name, inlink('selectVersion'));?>
    </td>
  </tr>
</table>
<?php include '../../common/view/footer.lite.html.php';?>
