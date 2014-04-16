<?php
/**
 * The html template file of select version method of upgrade module of ZenTaoPMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $Id$
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<form method='post' action='<?php echo inlink('confirm');?>'>
  <table align='center' class='table table-bordered'>
    <caption><?php echo $lang->upgrade->selectVersion;?></caption>
    <tr>
      <td>
        <p>
        <?php 
        echo html::select('fromVersion', $lang->upgrade->fromVersions, $version);
        echo "<span class='red'>{$lang->upgrade->versionNote}</span>";
        ?>
        </p>
        <?php echo html::submitButton($lang->upgrade->common);?>
      </td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.lite.html.php';?>
