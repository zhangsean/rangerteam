$(document).ready(function()
{
    if($('body.body-modal').length) // if(v.from == 'modal')
    {
        $.setAjaxForm('#editRecord',function() { $.reloadIframeModal(); });
    }
    else
    {
        $.setAjaxForm('#editRecord');
    }
});
