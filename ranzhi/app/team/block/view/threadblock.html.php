<?php
/**
 * The thread block view file of block module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<table class='table table-data table-hover table-fixed' id='oaBlockAnnounce'>
  <?php foreach($threads as $id => $thread):?>
  <tr>
    <td class='w-60px'><?php echo substr($thread->createdDate, 5, 5)?></td>
    <td><?php echo html::a($this->createLink('thread', 'view', "threadID=$id"), $thread->title)?></td>
  </tr>
  <?php endforeach;?>
</table>
<script>$(function(){$.setAjaxModal();})</script>
