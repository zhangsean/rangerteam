<?php
/**
 * The calendar view file of todo module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL
 * @author      chujilu <chujilu@cnezsoft.com>
 * @package     todo
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/datepicker.html.php';?>
<?php include '../../../sys/common/view/calendar.html.php';?>
<?php js::set('settings', new stdclass());?>
<?php js::set('settings.startDate', date('Y-m-d', strtotime($date)));?>
<?php js::set('settings.data', $data);?>
<div class='with-side'>
  <div class='side'>
    <ul id="myTab" class="nav nav-tabs">
      <li class="active"><a href="#tab_custom" data-toggle="tab"><?php echo $lang->todo->periods['future'] . $lang->todo->common?></a></li>
      <li class='dropdown'>
        <a href='#' class='dropdown-toggle' data-toggle='dropdown'>OA</a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="tableDropCRM">
          <li><a href="#tab_task" data-toggle="tab"><?php echo $lang->task->common;?></a></li>
          <li><a href="#tab_attend" data-toggle="tab"><?php echo $lang->attend->common;?></a></li>
          <li><a href="#tab_leave" data-toggle="tab"><?php echo $lang->leave->common;?></a></li>
        </ul>
      </li>
      <li class='dropdown'>
        <a href='#' class='dropdown-toggle' data-toggle='dropdown'>CRM</a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="tableDropCRM">
          <li><a href="#tab_order" data-toggle="tab"><?php echo $lang->order->common;?></a></li>
          <li><a href="#tab_customer" data-toggle="tab"><?php echo $lang->customer->common;?></a></li>
        </ul>
      </li>
    </ul>
    <div class='tab-content'>
      <?php foreach($todoList as $type => $todos):?>
      <div class='tab-pane fade in <?php echo $type == 'custom' ? 'active' : ''?>' id='tab_<?php echo $type;?>'>
        <?php foreach($todos as $id => $todo):?>
        <?php if($type == 'custom'):?>
        <div class='board-item' data-id='<?php echo $todo->id?>' data-name='<?php echo $todo->name?>' data-type='<?php echo $todo->type?>' data-begin='<?php echo $todo->begin?>' data-end='<?php echo $todo->end?>' data-toggle="droppable" data-target=".day">
          <span class='label'><?php echo $todo->begin?></span>
          <?php echo $todo->name?>
          <div class='action'><?php echo html::a($this->createLink('oa.todo', 'view', "id=$todo->id"), $lang->view, "data-toggle='modal'")?></div>
        </div>
        <?php endif;?>
        <?php if($type != 'custom'):?>
        <div class='board-item' data-id='<?php echo $id?>' data-type='<?php echo $type?>' data-toggle="droppable" data-target=".day">
          <?php echo $todo;?>
        </div>
        <?php endif;?>
        <?php endforeach;?>
      </div>
      <?php endforeach;?>
    </div>
  </div>
  <div class='calendar main'></div>
</div>
<script>
function updateCalendar()
{
    var calendar = $('.calendar').data('zui.calendar');
    var date = calendar.date.format('yyyy-MM-dd');
    $.get(createLink('oa.todo', 'calendar', 'date=' + date, 'json'), function(response)
    {
        if(response.status == 'success')
        {
            var data = JSON.parse(response.data);
            for(e in data.data.events) 
            {
                data.data.events[e]['start'] = new Date(data.data.events[e]['start']);
                data.data.events[e]['end']   = new Date(data.data.events[e]['end']);
            }
            calendar.events = data.data.events;
            v.settings.data.events = data.data.events;
            calendar.display();
        }
    }, 'json');
}

/* Finish a todo. */
function finishTodo(id)
{
    $.get(createLink('oa.todo', 'finish', 'todoId=' + id, 'json'),function(response)
    {
        if(response.result == 'success')
        {
            if(response.confirm)
            {
                if(confirm(response.confirm.note))
                {   
                    $.openEntry(response.confirm.entry, response.confirm.confirm);
                }   
            }
            if(response.message) $.zui.messager.success(response.message);
        }
        updateCalendar();
        return false;
    }, 'json');
}

/* Adjust calendar width. */
function adjustWidth()
{
    var weekendEvents = 0;
    var width = 80;
    $('.calendar tbody.month-days tr.week-days').each(function()
    {
        weekendEvents += $(this).find('td').eq(5).find('.event').size();
        weekendEvents += $(this).find('td').eq(6).find('.event').size();
    });
    if(weekendEvents == 0)
    {
        $('.calendar tr.week-head th').width('auto');
        $('.calendar tr.week-head th').eq(5).width(width);
        $('.calendar tr.week-head th').eq(6).width(width - 10);
        $('.calendar tbody.month-days tr.week-days').each(function()
        {
            $(this).find('td').width('auto');
            $(this).find('td').eq(5).width(width);
            $(this).find('td').eq(6).width(width - 10);
        });
    }
    else
    {
        $('.calendar tr.week-head th').removeAttr('style');
        $('.calendar tbody.month-days tr.week-days').each(function()
        {
            $(this).find('td').removeAttr('style');
        });
    }
}

/* Add +. */
function appendAddLink()
{
    $('.calendar tbody.month-days tr.week-days td.cell-day div.day div.heading .number').each(function()
    {
        var $this = $(this);
        $this.parent().find('.icon-plus').remove();

        thisDate = new Date($this.parents('div.day').attr('data-date'));
        year     = thisDate.getFullYear();
        month    = thisDate.getMonth();
        day      = thisDate.getDate();
        if(year > v.y || (year == v.y && month > v.m) || (year == v.y && month == v.m && day >= v.d))
        {
            $this.after(" <span class='text-muted icon-plus'>&nbsp;<\/span>")
        }
    });
}

/* Add calendar event handler. */
v.date = new Date();
v.d    = v.date.getDate();
v.m    = v.date.getMonth();
v.y    = v.date.getFullYear();

if(typeof(v.settings) == 'undefined') v.settings = {};
if(typeof(v.settings.data) == 'undefined') v.settings.data = {};
v.settings.clickCell = function(event)
{
    if(event.view == 'month')
    {
        var date = event.date;
        var year   = date.getFullYear();
        var month  = date.getMonth();
        var day    = date.getDate();
        if(year > v.y || (year == v.y && month > v.m) || (year == v.y && month == v.m && day >= v.d))
        {
            month = month + 1;
            if(day <= 9) day = '0' + day;
            if(month <= 9) month = '0' + month;
            var todourl = createLink('todo', 'batchCreate', "date=" + year + '' + month + '' + day, '', true);

            $.zui.modalTrigger.show({width: '85%', url: todourl});
        }
    }
};

v.settings.beforeChange = function(event)
{
    if(event.change == 'start')
    {
        var data = {
            'date': event.to.format('yyyy-MM-dd'),
            'name': event.event.title,
            'type': event.event.calendar
        }
        if(!event.event.allDay)
        {
            data.begin = event.event.start.format('hh:mm');
            data.end = event.event.end.format('hh:mm');
        }
        $.post(createLink('oa.todo', 'edit', 'id=' + event.event.id), data, function(response)
        {
            if(response.result == 'success')
            {
                $.zui.messager.success(response.message);
            }
            updateCalendar();
        }, 'json');
    }
};

v.settings.display = function(event)
{
    for(key in v.settings.data.events)
    {
        var e = v.settings.data.events[key];
        if(e.data.status != 'done')
        {
            $('.events .event[data-id=' + e.id + ']').append("<div class='action'><a href='javascript:;' class='finish'><?php echo $lang->todo->finish?><\/a>\n<\/span>").addClass('with-action');
            $('.events .event[data-id=' + e.id + '] .action .finish').click(function()
            {
                var id = $(this).closest('.event').data('id');
                finishTodo(id);
                return false;
            });
        }
        else if(e.data.status == 'done')
        {
            $('.events .event[data-id=' + e.id + ']').css('background-color', '#38B03F');
        }
    }
    adjustWidth();
    appendAddLink();
}

v.settings.clickNextBtn = updateCalendar;
v.settings.clickPrevBtn = updateCalendar;

/* dropable setting. */
$(document).ready(function()
{
    $('[data-toggle="droppable"]').droppable(
    {
        start: function(event)
        {
            var from   = event.element;
            var target = event.element.data('targeta');
            if(typeof target == 'undefined') target = '.droppable-target';
        },
        drop: function(event)
        {
            if(event.target)
            {
                var from   = event.element;
                var to     = event.target;
                var target = from.data('targeta');
                if(typeof target == 'undefined') target = '.droppable-target';
                to.date = new Date(to.data('date'));
                if(from.data('type') == 'custom')
                {
                    var data = {
                    'date': to.date.format('yyyy-MM-dd'),
                    'name': from.data('name'),
                    'type': from.data('type'),
                    'begin': from.data('begin'),
                    'end': from.data('end')
                    }
                    var url = createLink('oa.todo', 'edit', 'id=' + from.data('id'), 'json');
                }
                else
                {
                    var data = {
                    'date': to.date.format('yyyy-MM-dd'),
                    'type': from.data('type'),
                    'idvalue': from.data('id'),
                    'name': '',
                    'begin': '',
                    'end':'' 
                    }
                    var url = createLink('oa.todo', 'create', '', 'json');
                }
                $.post(url, data, function(response)
                {
                    if(response.result == 'success')
                    {
                        $.zui.messager.success(response.message);
                        updateCalendar();
                        from.hide();
                    }
                }, 'json');
            }
        },
        drag: function(event)
        {
            $('.day').removeClass('panel-success').removeClass('panel-warning');
            if(event.target) event.target.addClass('panel-warning');
        }
    });
});
</script>
<?php include '../../common/view/footer.html.php';?>
