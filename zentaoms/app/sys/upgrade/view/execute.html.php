<?php
/**
 * The html template file of execute method of upgrade module of ZenTaoPMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $Id$
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<table align='center' class='table table-bordered table-5'>
  <caption><?php echo $lang->upgrade->$result;?></caption>
  <tr>
    <td>
      <?php
      if($result == 'fail') echo nl2br(join('\n', $errors));
      if($result == 'success') echo html::a('index.php', $lang->home, "class='btn btn-primary'");
      ?>
    </td>
  </tr>
</table>
<?php include '../../common/view/footer.lite.html.php';?>
