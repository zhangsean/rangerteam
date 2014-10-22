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
                    var change = 
                    {
                        name: toBoard.data('groupBy'),  // 要更改的字段，例如status或者assignedTo
                        id: e.element.data('id'),       // 任务id
                        oldValue: fromBoard.data('id'), // 变更之前的值
                        value: toBoard.data('id')       // 变更之后的值
                    }
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
