$(function()
{
    $('.reloadDeleter').data('afterDelete', function(data)
    {
        if(data.result == 'success')
        {
            var task = $(this).closest('.task');
            var info = task.closest('.task-list').closest('.item').children('.info');
            var total = info.find('.group-total');
            total.text(parseInt(total.text()) - 1);
            var statusTotal = info.find('.group-' + task.data('status'));
            statusTotal.text(parseInt(statusTotal.text()) - 1);

            task.remove();
        }
    });
});
