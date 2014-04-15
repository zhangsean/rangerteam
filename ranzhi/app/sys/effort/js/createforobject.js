$(function()
{
    /* Set effort ajax form. */
    $.setAjaxForm('#effortForm', function(data)
    {
        if(data.result == 'success') $.reloadAjaxModal(1500);
    });

    $.setAjaxLoader('.edit', '#ajaxModal');
})
