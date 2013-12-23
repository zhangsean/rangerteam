<?php
/**
 * The html block form view file of block module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
?>
<?php $config->block->editor->blockform =  array('id' => 'content', 'tools' => 'fullTools', 'filterMode' => false); ?>
<?php include '../../common/view/kindeditor.html.php';?>
<tr>
  <th><?php echo $lang->block->content;?></th>
  <td><?php echo html::textarea('content', isset($block) ? $block->content : '', 'rows=20 class=form-control');?></td>
</tr>
