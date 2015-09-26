/* dropable setting. */
$(document).ready(function()
{
    $('[data-toggle="droppable"]').droppable(
    {
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
        }
    });

    $('.events .event').droppable(
    {
        start: function(event)
        {
            var from   = event.element;
            var target = event.element.data('targeta');
            if(typeof target == 'undefined') target = '.droppable-target';
            console.log(event);
        },
        drop: function(event)
        {
            if(event.target)
            {
                var from   = event.element;
                var to     = event.target;
                var target = from.data('targeta');
                if(typeof target == 'undefined') target = '.droppable-target';
                if(to.data('action') == 'delete')
                {
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
            }
        }
    });

    $('.side-handle').click(function()
    {
        if($(this).parents('.with-side').hasClass('hide-side'))
        {
            $('.with-side').removeClass('hide-side');
            $('.side-handle i').removeClass('icon-caret-left');
            $('.side-handle i').addClass('icon-caret-right');
            $.cookie('todoCalendarSide', 'show', {path: config.webRoot});
        }
        else
        {
            $('.side-handle i').removeClass('icon-caret-right');
            $('.side-handle i').addClass('icon-caret-left');
            $('.with-side').addClass('hide-side');
            $.cookie('todoCalendarSide', 'hide', {path: config.webRoot});
        }
    });

    /* Adjust calendar */
    $('.calendar').data('zui.calendar').display('month', v.settings.startDate);
});
