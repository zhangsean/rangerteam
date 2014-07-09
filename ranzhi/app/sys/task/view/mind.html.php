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
<?php include '../../common/view/datepicker.html.php';?>
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
    <div id='mindmap' class='mindmap'></div>
    <div class='popover scale top fade' id='taskPopover'>
      <div class='arrow'></div>
      <div class='popover-title'>
        <div class='pri-list'><span class='pri pri-0'>0</span><span class='pri pri-1'>1</span><span class='pri pri-2'>2</span><span class='pri pri-3'>3</span><span class='pri pri-4'>4</span></div>
        <table>
          <tr class='task-headings'>
            <td colspan='2' class='nobr'><span class='active task-pri pri pri-3' title='<?php echo $lang->task->lblPri?>'></span> <strong class='task-name' title='<?php echo $lang->task->name?>'>-</strong></td>
            <td class='text-right'><small class='text-muted task-type label' title='<?php echo $lang->task->type;?>'>-</small> <span class='label label-circle label-badge task-status-wait task-status' title='<?php echo $lang->task->status;?>'>-</span><button class='btn btn-success btn-sm btn-finish'><i class='icon-ok'></i> <?php echo $lang->finish;?></button></td>
          </tr>
          <tr class='task-infos'>
            <td><span class='task-assignedTo' title='<?php echo $lang->task->assignedTo?>'><i class='icon-user text-muted'></i> <small>-</small></span></td>
            <td class='text-center'><span class='task-createdDate' title='<?php echo $lang->task->createdDate?>'><i class='icon-time text-muted'></i> <small>-</small></span></td>
            <td class='text-right'><span class='task-deadline text-warning' title='<?php echo $lang->task->deadline;?>'><input type="text" name="taskDeadline" class='form-date form-control input-sm' id='taskDeadline' placeholder='<?php echo $lang->task->deadline;?>' /></span></td>
          </tr>
        </table>
      </div>
      <div class="popover-content task-desc" title='<?php echo $lang->task->desc;?>' placeholder='<?php echo $lang->task->desc;?>'></div>
    </div>
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
        data: {groupBy: '<?php echo $groupBy;?>'},
        children:
        [
            <?php $index = 0; ?>
            <?php foreach($tasks as $groupKey => $groupTasks):?>
            {
                text: '<?php echo empty($groupKey) ? $lang->task->unkown : ($groupBy == "status" ? $lang->task->statusList[$groupKey] : $groupKey);?>',
                type: 'sub',
                id: 'sub-<?php echo $index++;?>',
                readonly: true,
                data:
                {
                    key: '<?php echo $groupKey?>'
                    <?php if($groupBy == 'status') echo ",statusName: '" . $lang->task->statusList[$groupKey] . "'"; ?>
                },
                
                children:
                [
                    <?php foreach($groupTasks as $task):?>
                    {
                        text: '<?php echo $task->name?>',
                        type: 'node',
                        id: '<?php echo $task->id?>',
                        data: 
                        {
                            deadline: '<?php echo $task->deadline == "0000-00-00" ? '' : $task->deadline;?>',
                            createdDate: '<?php echo $task->createdDate?>',
                            assignedTo: '<?php echo $task->assignedTo?>',
                            pri: '<?php echo $task->pri?>',
                            status: '<?php echo $task->status?>',
                            desc: '<?php echo $task->desc?>',
                            type: '<?php echo $task->type?>',
                            statusName: '<?php echo $lang->task->statusList[$task->status];?>',
                        }
                    },
                    <?php endforeach;?>
                ]
            },
            <?php endforeach;?>
        ]
    };

    var groupBy = data.data.groupBy;
        $saveBtn = $('#saveBtn'), 
        $taskPopover = $('#taskPopover');

    var $mindmap = $('#mindmap').mindmap(
    {
        data: data,
        beforeHotkey: function()
        {
            return $taskPopover.find('.task-desc').attr('contenteditable') != 'true';
        },
        onChange: onChange,
        startDrag: function()
        {
            hidePopover();
        },
        beforeMove: function(e)
        {
            if(!(e.event.element.data('type') == 'node' && e.event.target.data('type') == 'sub'))
            {
                window.messager.warning('<?php echo $lang->task->mindMoveTip;?>');
                return false;
            }
        },
        onTextChanged: function(e)
        {
            if(e.node.data('id') == $taskPopover.data('id'))
            {
                $taskPopover.find('.task-name').text(e.text);
            }
        },
        afterMove: function(e)
        {
            var parent = this.getNodeData(e.node.parent);
            if(groupBy === 'status')
            {
                e.node.data.status = parent.data.key;
                e.node.data.statusName = parent.data.statusName;
            }
            else if(groupBy === 'assignedto')
            {
                e.node.data.assignedTo = parent.data.key;
            }
        },
        beforeDelete: function(e)
        {
            hidePopover();
            return e.node.type == 'node';
        },
        beforeAdd: function(e)
        {
            hidePopover();
            return e.node.type == 'sub' && e.newNode.type == 'node';
        },
        afterAdd: function(e)
        {
            e.newNode.data =
            {
                deadline: '',
                createdDate: (new Date()).format('yyyy-MM-dd hh:mm'),
                assignedTo: '',
                pri: '0',
                status: 'wait',
                desc: '',
                type: '',
                statusName: '<?php echo $lang->task->statusList["wait"];?>',
            };

            if(groupBy === 'status')
            {
                e.newNode.data.status = e.node.data.key;
                e.newNode.data.statusName = e.node.data.statusName;
            }
            else if(groupBy === 'assignedto')
            {
                e.newNode.data.assignedTo = e.node.data.key;
            }
        },
        onBindEvents: function(e)
        {
            var $node = e.node;
            var node = this.getNodeData($node.data('id'));

            $node.attr('data-key', node.data.key);

            $node.hover(function()
            {
                $node.addClass('hover');
            },function()
            {
                $node.removeClass('hover');
            });
        },
        onNodeActive: function(e)
        {
            var mm = this,
                $node = e.node;
            var node = mm.getNodeData($node.data('id'));
            if(node.type === 'node' && $node.hasClass('hover') &&(!$node.hasClass('dragging')))
            {
                showPopover(node);
            }
            else
            {
                hidePopover();
            }
        },
        beforeMoveCanvas: function(e)
        {
            hidePopover();
        }
    }).click(function(){hidePopover();});

    var mindmap = $mindmap.data('zui.mindmap'),
        $container = $mindmap.find('.mindmap-container');

    function showPopover(node)
    {
        if(!$.isPlainObject(node)) return;

        var pp = $taskPopover, task = node.data;
        pp.hide().removeClass('in');

        /* update data */
        pp.find('.task-pri').attr('class', 'active task-pri pri pri-' + task.pri).text(task.pri);
        pp.find('.pri-list .pri.active').removeClass('active');
        pp.find('.pri-list .pri.pri-' + task.pri).addClass('active');
        pp.find('.task-name').text(node.text);
        pp.find('.task-type').text(task.type).toggle(task.type != '');
        pp.find('.task-status').attr('class', 'label label-circle label-badge task-status task-status-' + task.status).text(task.statusName);
        pp.find('.task-assignedTo small').html(task.assignedTo == '' ? '<span class="text-muted">[<?php echo $lang->task->unAssigned;?>]</span>' : task.assignedTo);
        pp.find('.task-createdDate small').text(task.createdDate.substr(0, 10));
        pp.find('.task-deadline').toggleClass('empty', task.deadline == '').find('#taskDeadline').val(task.deadline);
        pp.find('.task-desc').html(task.desc);
        pp.data('id', node.id);

        /* ajust position */
        var ctnPos  = $container.position(),
            nodePos = node.ui.element.position(),
            width      = pp.outerWidth(),
            height     = pp.outerHeight();
        var left       = ctnPos.left + nodePos.left + Math.floor(node.ui.width / 2),
            top      = ctnPos.top + nodePos.top;
        pp.css({left: left - Math.floor(width / 2), top: top - height});


        pp.show();
        setTimeout(function(){pp.addClass('in');}, 50);
    }

    function hidePopover()
    {
        $taskPopover.removeClass('in');
        setTimeout(function(){$taskPopover.hide();}, 150);
    }

    function onChange()
    {
        $saveBtn.removeClass('disabled').removeAttr('disabled').find('span').text('<?php echo $lang->save;?>');
    }

    $taskPopover.hover(function()
    {
        var pp = $taskPopover;
        pp.addClass('hover');

        var node = mindmap.getNodeData($taskPopover.data('id'));
        pp.toggleClass('show-finish', node.data.status != 'done' && node.data.status != 'closed' && node.data.status != 'cancel');
    }, function()
    {
        var pp = $taskPopover;
        pp.removeClass('hover show-finish');

    }).find('.task-desc')
      .hover(function(){$(this).attr('contenteditable', true)}, function(){$(this).attr('contenteditable', false)})
      .on('keyup paste blur', function()
      {
          mindmap.getNodeData($taskPopover.data('id')).data.desc = $(this).html();
          onChange();
      });
    $taskPopover.find('#taskDeadline').on('change', function()
    {
        var node = mindmap.getNodeData($taskPopover.data('id'));
        var val = $(this).val();
        if(val != '') $(this).closest('.task-deadline').removeClass('empty');
        if(val != node.data.deadline)
        {
            node.data.deadline = val;
            onChange();
        }
    });
    $taskPopover.find('.btn-finish').click(function()
    {
        var node = mindmap.getNodeData($taskPopover.data('id'));
        node.data.status = 'done';
        node.data.statusName = '<?php echo $lang->task->statusList['done'];?>';
        node.data.finishedDate = (new Date()).format('yyyy-MM-dd hh:mm');
        if(groupBy == 'status')
        {
            mindmap.update({action: 'move', data: node, newParent: $mindmap.find('[data-key="done"]').data('id')});
        }
        hidePopover();
        onChange();
    });
    var $priList = $taskPopover.find('.pri-list');
    $taskPopover.find('.task-pri').hover(function(){$priList.fadeIn(150)});
    $priList.hover(null, function(){$priList.fadeOut(150)}).find('.pri').hover(function(){$priList.find('.pri.hover').removeClass('hover'); $(this).addClass('hover')}).click(function()
    {
        var pri = $(this).text();
        var node = mindmap.getNodeData($taskPopover.data('id'));
        if(node.data.pri != pri)
        {
            node.data.pri = pri;
            $taskPopover.find('.task-pri').attr('class', 'active task-pri pri pri-' + pri).text(pri);
            $taskPopover.find('.pri-list .pri.active').removeClass('active');
            $(this).addClass('active');
            onChange();
            $priList.fadeOut(150);
        }
    });

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
