$(document).ready(function()
{
    $("#menu li a").parent().removeClass('active');
    $("#menu li a[href*='" + v.type + "']").parent().addClass('active');
    $.setAjaxJSONER('.review', function(response)
    {
        if(response.message)
        {
            bootbox.alert(response.message);
        }

        /* If the response has locate param, locate the browse. */
        if(response.locate == 'reload') return location.href = location.href;
        if(response.locate) return location.href = response.locate;
    });
});
