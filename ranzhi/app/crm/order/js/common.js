$(document).ready(function()
{
    $('.activate').click(function()
    {
        var url = $(this).attr('href');
        var button = $(this);
        $.getJSON(url, function(response)
        {
            if(response.result == 'success')
            {
                button.popover({trigger:'manual', content:response.message, placement:'right'}).popover('show');
                button.next('.popover').addClass('popover-success');
                function distroy()
                {
                    button.popover('destroy');
                    location.reload();
                }
                setTimeout(distroy,2000);
            }
            else
            {
                alert(response.message);
            }
        });
        return false;
    });
});
