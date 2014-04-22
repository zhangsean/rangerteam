$(document).ready(function()
{
    if(window.opener)
    {
        $.setAjaxForm('#contactForm', function(response)
        {
           if(response.result == 'success')
           {
                $('.select-contact', window.opener.document).load(createLink('contact', 'getoptionmenu', "customer=" + v.customer + '&current=' + response.contactID), function(){ window.close(); });
           }
        });
    }
    else
    {
        $.setAjaxForm('#contactForm');
    }

    /* Show notice when auto create customer. */
    var value = ''
    $('#newCustomer').change(function()
    {
        if($(this).attr('checked') == undefined)
        {
            value = $('#customer').val();
            $('#customer').val('');
            $('#customer').find('option').eq(0).html(v.autoCustomer);
            $(this).attr('checked', true);
        }
        else
        {
            $('#customer').val(value);
            $('#customer').find('option').eq(0).html('');
            $(this).removeAttr('checked');
        }
    })
})
