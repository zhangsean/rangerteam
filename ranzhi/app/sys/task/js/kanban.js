$(function()
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
                
                // get taskID
                var taskID = e.element.data('id');
                // get status to change
                var newStatus = toBoard.data('id');
            }
        }
    });
});
