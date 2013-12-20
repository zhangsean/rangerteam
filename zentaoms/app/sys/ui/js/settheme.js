$(document).ready(function()
{
    $('.ajax').click(function()
    {
        current = $(this);
        $.getJSON($(this).attr('href'), function(data)
        {
            bootbox.alert(data.message + '', function(){$('.current').removeClass('current'); current.parents('td').addClass('current');});
        });
        return false;
    });
})
