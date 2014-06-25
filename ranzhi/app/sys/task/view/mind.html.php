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
<div class='panel' id='mindmap'>
  <div class='panel-heading'>
    <div class='panel-actions'>
      <div class='btn-group'>
        <?php echo html::a($this->inlink('browse', "projectID=$projectID"), "<i class='icon-list-ul icon'></i> " . $lang->task->list, "class='btn'"); ?>
        <?php echo html::a($this->inlink('kanban', "projectID=$projectID"), "<i class='icon-columns icon'></i> " . $lang->task->kanban, "class='btn'"); ?>
        <?php echo html::a($this->inlink('mind', "projectID=$projectID"), "<i class='icon-usecase icon'></i> " . $lang->task->mind, "class='btn active'"); ?>
        <?php echo html::a($this->inlink('outline', "projectID=$projectID"), "<i class='icon-list-alt icon'></i> " . $lang->task->outline, "class='btn'"); ?>
      </div>
      <div class="btn-group">
        <button class='btn' id='fsBtn'>全屏</button>
      </div>
    </div>
    <div class='panel-actions pull-right'><button id='saveBtn' type='button' class='btn btn-primary disabled' disabled='disabled'><i class="icon-save"></i> <span><?php echo $lang->save;?></span></button></div>
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
            expandState : 'expand',
            id : '<?php echo $project->id;?>'
        },
        children:
        [
            <?php foreach ($lang->task->statusList as $key => $value):?>
            <?php if(empty($key)) continue;?>
            {
                data: {text: '<?php echo $value;?>', type: 'main', expandState: 'expand', id: '<?php echo $key;?>'},
                children:
                [
                    <?php foreach($tasks as $task):?>
                    <?php if($task->status != $key) continue;?>
                    {
                        data: {text: '<?php echo $task->name?>', type: 'sub', expandState: 'expand', id: '<?php echo $task->id?>'}
                    },
                    <?php endforeach;?>
                ]
            },
            <?php endforeach;?>
        ]
    };

    minder.importData(JSON.stringify(data), 'json');

    $saveBtn = $('#saveBtn');

    minder.on('contentchange', function()
    {
        $saveBtn.removeClass('disabled').removeAttr('disabled').find('span').text('<?php echo $lang->save;?>');
    });

    $saveBtn.click(function()
    {
        $saveBtn.addClass('disabled').attr('disabled', 'disabled');
        var data = minder.exportData( 'json' );
        // save json data...
        $saveBtn.find('span').text('<?php echo $lang->saved?>');
    });
});
</script>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
