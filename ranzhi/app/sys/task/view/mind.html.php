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
<?php include '../../common/view/mindmap.html.php';?>
<div class='panel' id='mindmapPanel'>
  <div class='panel-heading'>
    <div class='panel-actions'>
      <div class='btn-group'>
        <?php echo html::a($this->inlink('browse', "projectID=$projectID"), "<i class='icon-list-ul icon'></i> " . $lang->task->list, "class='btn'"); ?>
        <?php echo html::a($this->inlink('kanban', "projectID=$projectID"), "<i class='icon-columns icon'></i> " . $lang->task->kanban, "class='btn'"); ?>
        <?php echo html::a($this->inlink('mind', "projectID=$projectID"), "<i class='icon-usecase icon'></i> " . $lang->task->mind, "class='btn active'"); ?>
        <?php echo html::a($this->inlink('outline', "projectID=$projectID"), "<i class='icon-list-alt icon'></i> " . $lang->task->outline, "class='btn'"); ?>
      </div>
      <div class="btn-group">
        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
        <i class='icon-cog'></i> <?php echo $lang->task->groups[$groupBy];?>
          <icon class="icon-caret-down"></icon>
        </button>
        <ul class="dropdown-menu">
        <?php foreach ($lang->task->groups as $key => $value):?>
        <?php if(empty($key)) continue;?>
          <?php $class = ($key == $groupBy) ? 'active' : '';?>
          <li class='<?php echo $class;?>'>
            <?php echo html::a($this->inlink('mind', "projectID=$projectID&groupBy=$key"), $value); ?>
          </li>
        <?php endforeach;?>
        </ul>
      </div>
      <div class="btn-group">
        <button class='btn' id='fsBtn'>全屏</button>
      </div>
    </div>
    <div class='panel-actions pull-right'><button id='saveBtn' type='button' class='btn btn-primary disabled' disabled='disabled'><i class="icon-save"></i> <span><?php echo $lang->save;?></span></button></div>
  </div>
  <div class='panel-body minds-container'>
    <div id="mindmap" class='mindmap'></div>
  </div>
</div>
<script>
$(function()
{
    var data =
    {
        text : '<?php echo $projectName;?>',
        type : 'root',
        id : 'project-<?php echo $projectID;?>',
        children:
        [
            <?php $index = 0; ?>
            <?php foreach($tasks as $groupKey => $groupTasks):?>
            {
                text: '<?php echo empty($groupKey) ? $lang->task->unkown : $groupKey;?>',
                type: 'sub',
                id: 'sub-<?php echo $index++;?>',
                readonly: true,
                children:
                [
                    <?php foreach($groupTasks as $task):?>
                    {
                        text: '<?php echo $task->name?>',
                        type: 'node',
                        id: '<?php echo $task->id?>'
                    },
                    <?php endforeach;?>
                ]
            },
            <?php endforeach;?>
        ]
    };

    $saveBtn = $('#saveBtn');
    var mindmap = $('#mindmap').mindmap(
    {
        data: data,
        onChange: function()
        {
            $saveBtn.removeClass('disabled').removeAttr('disabled').find('span').text('<?php echo $lang->save;?>');
        },
        beforeMove: function(e)
        {
            if(!(e.event.element.data('type') == 'node' && e.event.target.data('type') == 'sub'))
            {
                window.messager.warning('<?php echo $lang->task->mindMoveTip;?>');
                return false;
            }
        }
    }).data('zui.mindmap');

    $saveBtn.click(function()
    {
        $saveBtn.addClass('disabled').attr('disabled', 'disabled');

        /* Save data with flow methods */
        // console.log(mindmap.exportJSON());
        // console.log(mindmap.exportArray());
        
        $saveBtn.find('span').text('<?php echo $lang->saved?>');
    });
});
</script>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
