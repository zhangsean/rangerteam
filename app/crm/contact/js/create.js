$(document).ready(function()
{
    /* Show notice when auto create customer. */
    $('#newCustomer').change(function()
    {
        if($(this).prop('checked')) 
        {
            $(this).parents('.input-group').find('select').hide();
            $('#customer_chosen').hide();
            $(this).parents('.input-group').find('input[type=text][id=name]').show().focus();
            $('.customerInfo').show();
        }
        else
        {
            $('#customer_chosen').show();
            $(this).parents('.input-group').find('input[type=text][id=name]').hide();
            $('.customerInfo').hide();
        }
    })

    $.setAjaxForm('#contactForm', function(response)
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
    });
})
