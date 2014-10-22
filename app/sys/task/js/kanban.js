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

                if(fromBoard.data('id') != toBoard.data('id'))
                {
                    messager.show('正在保存...');
                    
                    var groupBy = toBoard.data('groupBy');
                    // get taskID
                    var taskID = e.element.data('id');
                    // get status to change
                    var newGroup = toBoard.data('id');
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
