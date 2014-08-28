$(document).ready(function()
{
    $.setAjaxForm('#startForm', function(response)
    {
        if(response.confirm)
        {
            if(confirm(response.confirm))
            {
                $('#doStart').val('yes');
                $('#startForm').submit();
            }
        }
        else
        {
            if(response.result == 'success')
            {
                if(response.locate == 'reload') return location.href = location.href;
                $.reloadAjaxModal(1500);
            }
        }
    })
})
