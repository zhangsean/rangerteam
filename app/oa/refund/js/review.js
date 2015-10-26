$(document).ready(function()
{
    $.setAjaxForm('#rejectForm', function(data)
    {
        if(data.isDetail)
        {
            $.reloadAjaxModal();
        }
        else
        {
            setTimeout(function(){location.href = data.locate;}, 1200);
        }
    }); 
})
