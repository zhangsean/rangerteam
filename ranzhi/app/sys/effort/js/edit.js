$(function()
{
    /* Set edit effort ajax form. */
    $.setAjaxForm('#editEffortForm', function(data)
    {
        if(data.result == 'success') $.reloadAjaxModal(1500);
    });
})
