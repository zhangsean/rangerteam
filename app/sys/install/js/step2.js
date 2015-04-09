$(document).ready(function()
{
    /* Compute request type. */
    $.get('pathinfo.php', function(result)
    {
        if(result == 'pathinfo') $('#requestType').val('PATH_INFO');
    });
});     
