<?php
/**
 * The project block view file of block module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<table class='table table-data table-hover block-project'>
  <tr class='text-center'>
    <th class='w-50px'><?php echo $lang->project->id?></th>
    <th class='text-left'><?php echo $lang->project->name?></th>
    <th class='w-80px'><?php echo $lang->project->createdBy?></th>
    <th class='w-80px'><?php echo $lang->project->createdDate?></th>
  </tr>
  <?php foreach($projects as $id => $project):?>
  <?php $appid = ($this->get->app == 'sys' and isset($_GET['entry'])) ? "class='app-btn text-center' data-id={$this->get->entry}" : "class='text-center'"?>
  <tr data-url='<?php echo $this->createLink('oa.task', 'browse', "projectID=$id"); ?>' <?php echo $appid?>>
    <td><?php echo $id;?></td>
    <td class='text-left'><?php echo $project->name;?></td>
    <td><?php echo zget($users, $project->createdBy, $project->createdBy);?></td>
    <td><?php echo substr($project->createdDate, 0, 10);?></td>
  </tr>
  <?php endforeach;?>
</table>
<script>$('.block-project').dataTable();</script>
