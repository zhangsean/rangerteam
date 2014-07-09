<?php 
/**
 * The browse view file of schema module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     schema 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-group"></i> <?php echo $lang->schema->common;?></strong>
    <div class="panel-actions pull-right">
      <?php echo html::a(inlink('create'),  "{$lang->schema->create}</i>", "class='btn btn-primary'")?>
    </div>
  </div>
  <table class='table table-hover table-striped tablesorter table-data' id='schemaList'>
    <thead>
      <tr class='text-center'>
        <th class='w-70px'><?php  echo $lang->trade->id;?></th>
        <th class='text-left'><?php echo $lang->schema->name;?></th>
        <th class='w-100px'><?php echo $lang->trade->category;?></th>
        <th class='w-100px'><?php echo $lang->trade->customer;?></th>
        <th class='w-100px'><?php echo $lang->trade->money;?></th>
        <th class='w-120px'><?php echo $lang->trade->desc;?></th>
        <th class='w-100px'><?php echo $lang->trade->date;?></th>
        <th class='w-100px'><?php echo $lang->trade->fee;?></th>
        <th class='w-120px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody class='text-center'>
      <?php foreach($schemas as $schema):?>
      <tr>
        <td><?php echo $schema->id;?></td>
        <td class='text-left'><?php echo $schema->name;?></td>
        <td><?php echo $schema->category;?></td>
        <td><?php echo $schema->customer;?></td>
        <td><?php echo $schema->money;?></td>
        <td><?php echo $schema->desc;?></td>
        <td><?php echo $schema->date;?></td>
        <td><?php echo $schema->fee;?></td>
        <td>
          <?php echo html::a(inlink('edit', "schemaID={$schema->id}"), $lang->edit);?>
          <?php echo html::a(inlink('delete', "schemaID={$schema->id}"), $lang->delete, "class='deleter'");?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
</body>
</html>
