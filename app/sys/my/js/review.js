$(document).ready(function()
{
    $('[data-toggle=ajax]').click(function()
    {
        if($(this).hasClass('disabled')) return false;
        $.get($(this).prop('href'), function(response)
        {
            if(response.message) $.zui.messager.success(response.message);
            if(response.result == 'success') location.reload();
            return false;
        }, 'json');
        return false;
    });
});
