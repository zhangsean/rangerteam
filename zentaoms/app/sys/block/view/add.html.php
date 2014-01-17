<?php
/**
 * The index view file of index module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     index 
 * @version     $Id: index.html.php 7655 2014-01-16 09:45:08Z sunhao $
 * @link        http://www.zentao.net
 */
include "../../common/view/header.lite.html.php";
?>
<form method='post' id='addBlockForm' class='form'>
  <table class='table table-form w-p80'>
    <tr>
      <th><?php echo $lang->block->lblEntry; ?></th>
      <td><select class='form-control' name="entry" id="entry"></select></td>
    </tr>
      <th><?php echo $lang->block->lblBlock; ?></th>
      <td><select class='form-control' name="entry" id="entry"></select></td>
    <tr>
    </tr>
    <tr><td></td><td><?php echo html::submitButton();?> <button class='btn' data-dismiss="modal"><?php echo $lang->goback; ?></button></td></tr>
  </table>
</form>
</body>
</html>
