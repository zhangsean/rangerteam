<?php
/**
 * The category form view file of block module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
*/
?>
<tr>
  <th><?php echo $lang->block->category->showChildren;?></th>
  <td><?php echo html::radio('params[showChildren]', $lang->block->category->showChildrenList, isset($block->content->showChildren) ? $block->content->showChildren : 'no');?></td>
</tr>
