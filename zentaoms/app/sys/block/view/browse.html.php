<?php
/**
 * The browse view file of block module of ZenTaoPMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<table class='table table-form w-p80'>
  <tr>
    <th class='w-80px'><?php echo $lang->block->lblEntry; ?></th>
    <?php
    $entryID = '';
    if($block)
    {
        $entryID = $block->type == 'system' ? $block->entryID : $block->type;
    }
    ?>
    <td><?php echo html::select('allEntries', $allEntries, $entryID, "class='form-control'")?></td>
  </tr>
  <tr></tr>
</table>
<div id='blockParam'></div>
<?php include '../../common/view/footer.lite.html.php';?>
<?php js::set('index', $index)?>
</body>
</html>
