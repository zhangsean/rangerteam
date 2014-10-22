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
        else(response.result == 'success')
        {
            if(response.closeModal)
            {
                setTimeout($.closeModal, 1200);
            }

            if(response.callback)
            {
                var rcall = window[response.callback];
                if($.isFunction(rcall))
                {
                    if(rcall() === false)
                    {
                        return;
                    }
                }
            }
            if(response.locate == 'reload') return location.href = location.href;
            $.reloadAjaxModal(1500);
        }
    })
})
