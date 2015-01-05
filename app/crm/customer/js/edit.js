$(document).ready(function()
{
    $.setAjaxForm('#customerForm', function(response)
    {
        if(response.result == 'fail')
        {
            $('.popover').html(response.message);
            $('#submit').popover({trigger:'manual', placement:'right'}).popover('show');
            $('#submit').next('.popover').addClass('popover-content');
            return false;
        }
        else
        {
            setTimeout(function(){location.href = response.locate;}, 1200);
        }
    })
})
