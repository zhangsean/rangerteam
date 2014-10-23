$(function()
{
    var resetBoards = function()
    {
        $('.boards').boards(
        {
            drop: function(e)
            {
                var fromBoard = e.element.closest('.board'),
                    toBoard = e.target.closest('.board');

                if(toBoard.data('group') == 'status')
                {
                    if(toBoard.data('key') == 'done')   button = e.element.find('a[href*=finish]');
                    if(toBoard.data('key') == 'closed') button = e.element.find('a[href*=close]');
                    if(toBoard.data('key') == 'doing')  button = e.element.find('a[href*=start]');
                    if(typeof(button) == 'undefined' || button.prop('disabled')) 
                    {
                        messager.danger(v.notAllowed);
                        reloadDataTable();
                    }

                    return button.click();
                }

                if(toBoard.data('group') != 'status' && fromBoard.data('id') != toBoard.data('id'))
                {
                    // messager.show('Sending...');
                    var change = 
                    {
                        field: toBoard.data('group'),
                        id: e.element.data('id'),
                        oldValue: fromBoard.data('key'),
                        value: toBoard.data('key')
                    }
                    
                    $.post(
                        createLink('task', 'kanban'),
                        change,
                        function(response)
                        {
                            if(response.result == 'success') messager.success(response.message);
                        },
                        'json'
                    )
                }
            }
        });

        $('[data-toggle="popover"]').popover();
    }

    window.reloadDataTable = function()
    {
        var $list = $('#taskKanban');
        $list.load(document.location.href + ' #taskKanban', function()
        {
            $list.find('[data-toggle="modal"]').modalTrigger();
            resetBoards();
        });
        return false;
    };

    resetBoards();
});
