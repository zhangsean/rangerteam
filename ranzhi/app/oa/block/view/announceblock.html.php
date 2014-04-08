<?php
/**
 * The announce block view file of block module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<table class='table table-data table-hover' id='oaBlockAnnounce'>
  <?php foreach($announces as $id => $announce):?>
  <?php $appid = ($this->get->app == 'sys' and isset($_GET['entry'])) ? "class='app-btn' data-id='{$this->get->entry}'" : ''?>
  <tr data-url='<?php echo $this->createLink('announce', 'view', "announceID=$id"); ?>' <?php echo $appid?>>
    <td><?php echo $announce->title?></td>
    <td class='w-100px'><?php echo date('y-m-d H:i', strtotime($announce->addedDate))?></td>
  </tr>
  <?php endforeach;?>
</table>
<script>$('#oaBlockAnnounce').dataTable();</script>
