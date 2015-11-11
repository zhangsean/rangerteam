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
                    $.openEntry(response.confirm.entry, response.confirm.url);
                }   
            }
            if(response.message) $.zui.messager.success(response.message);
            setTimeout(function(){location.reload()}, 1000);
        }
        else
        {
            if(response.message) $.zui.messager.show(response.message);
        }
        return false;
    }, 'json');
}

$(document).ready(function()
{
    $('.ajaxFinish').click(function()
    {
        finishTodo($(this).data('id'));
        return false;
    });
});
