<?php
/**
 * The project view file of my of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     my
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include './header.html.php';?>
<div class='panel'>
  <table class='table table-hover table-striped tablesorter table-fixed table-data'>
    <thead>
    <tr class='text-center'>
      <th class='w-60px'><?php echo $lang->project->id;?></th>
      <th class='text-left'><?php echo $lang->project->name;?></th>
      <th class='w-100px'><?php echo $lang->project->manager;?></th>
      <th class='w-100px'><?php echo $lang->project->begin;?></th>
      <th class='w-100px'><?php echo $lang->project->end;?></th>
      <th class='w-100px'><?php echo $lang->project->createdBy;?></th>
      <th class='w-80px'><?php echo $lang->project->status;?></th>
      <th><?php echo $lang->project->desc;?></th>
    </tr>
    </thead>
    <?php foreach($projects as $project):?>
    <?php $browseLink = helper::createLink('oa.task', $this->cookie->taskListType == false ? 'browse' : $this->cookie->taskListType, "projectID=$project->id");?>
    <tr class='text-center'>
      <td><?php echo $project->id;?></td>
      <td class='text-left'><?php echo html::a("javascript:$.openEntry(\"oa\", \"" . $browseLink . "\")", $project->name);?></td>
      <td><?php foreach($project->members as $member) if($member->role == 'manager') echo zget($users, $member->account);?></td>
      <td><?php echo $project->begin;?></td>
      <td><?php echo $project->end;?></td>
      <td><?php echo zget($users, $project->createdBy);?></td>
      <td><?php echo $lang->project->statusList[$project->status];?></td>
      <td title='<?php echo $project->desc;?>'><?php echo $project->desc;?></td>
    </tr>
    <?php endforeach;?>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
