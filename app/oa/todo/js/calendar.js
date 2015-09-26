$(document).ready(function()
{
    /* Adjust calendar */
    $('.calendar').data('zui.calendar').display('month', v.settings.startDate);

    /* dropable setting. */
    var dropSetting = {drop: function(event)
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
    }};
    $('[data-toggle="droppable"]').droppable(dropSetting);

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

    /* hide side. */
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

    /* Add pager of board list. */
    function addPager(selecter)
    {
        var tab = $(selecter);
        var count = tab.find('div.board-item').length;
        var page  = Math.ceil(count/10);
        if(page > 1)
        {
            for(i = 1; i<= page; i++)
            {
                tab.append("<span class='page-num' data-id='" + i + "'>" + i + '</span>')
            }
            $(selecter + ' span.page-num').click(function()
            {
                var tab = $(this).parent();
                var page = $(this).data('id');
                page = parseInt(page) *  10;
                tab.find('.board-item').hide();
                for(i = page; i > page - 10; i--)
                {
                    tab.find('[data-index=' + i + ']').show();
                }
            });
            $(selecter + ' span.page-num[data-id=1]').click();
        }
    }
    /* load board list. */
    var param = 'account=&id=&type=board';
    var link = createLink('task', 'ajaxGetTodoList', param);
    $('#tab_task').load(link, function(){$('#tab_task [data-toggle="droppable"]').droppable(dropSetting); addPager('#tab_task');});
    var link = createLink('crm.order', 'ajaxGetTodoList', param);
    $('#tab_order').load(link, function(){$('#tab_order [data-toggle="droppable"]').droppable(dropSetting); addPager('#tab_order');});
    var link = createLink('crm.customer', 'ajaxGetTodoList', param);
    $('#tab_customer').load(link, function(){$('#tab_customer [data-toggle="droppable"]').droppable(dropSetting); addPager('#tab_customer');});
});
