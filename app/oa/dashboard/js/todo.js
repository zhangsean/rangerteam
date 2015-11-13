$(document).ready(function()
{
    $('.ajaxFinish').click(function()
    {
        if($(this).hasClass('disabled')) return false;
        $.get($(this).prop('href'), function(response)
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
        return false;
    });
});
