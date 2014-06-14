<?php
/**
 * The view view file of task module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     task
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php include '../../common/view/minder.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <i class='icon-usecase'></i> <strong><?php echo $lang->task->mind;?></strong>
    <div class='panel-actions pull-right'><?php echo html::a($this->inlink('create', "projectID=$projectID"), '<i class="icon-plus"></i> ' . $lang->task->create, 'class="btn btn-primary"');?></div>
  </div>
  <div class='panel-body minds-container'>
    <div id="kityminder" onselectstart="return false"></div>
  </div>
</div>
<script>
$(function()
{
    var data =
    {
        data:
        {
            currentstyle : 'default',
            text : '<?php echo $project->name;?>',
            type : 'root',
            expandState : 'expand'
        },
        children:
        [
            <?php foreach ($lang->task->statusList as $key => $value):?>
            <?php if(empty($key)) continue;?>
            {
                data: {text: '<?php echo $value;?>', type: 'main', expandState: 'expand'},
                children:
                [
                    <?php foreach($tasks as $task):?>
                    <?php if($task->status != $key) continue;?>
                    {
                        data: {text: '<?php echo $task->name?>', type: 'sub', expandState: 'expand'}
                    },
                    <?php endforeach;?>
                ]
            },
            <?php endforeach;?>
        ]
    };

   minder.importData(JSON.stringify(data), 'json');
});
</script>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
