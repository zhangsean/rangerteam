<?php
/**
 * The code block form view file of block module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
*/
?>
<tr>
  <th><?php echo $lang->block->code;?></th>
  <td><?php echo html::textarea('content', isset($block) ? $block->content : '', 'rows=20 class="form-control"');?></td>
</tr>
