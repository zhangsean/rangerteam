$(document).ready(function()
{
    $.setAjaxForm('#avatarForm', function(response)
    {
        if(response.result == 'success')
        {
            $('#ajaxModal').load(response.locate);
        }
    });
});
