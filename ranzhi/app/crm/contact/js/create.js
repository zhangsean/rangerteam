$(document).ready(function()
{
    /* Show notice when auto create customer. */
    $('#newCustomer').change(function()
    {
        if($(this).attr('checked') == undefined)
        {
            $('#customer').attr('disabled', true);
            $(this).attr('checked', true);

            var label = $(this).next('label');
            label.popover({trigger:'manual', content:v.autoCustomer, placement:'right'}).popover('show');
            label.next('.popover').addClass('popover-default');
            function distroy(){label.popover('destroy')}
            setTimeout(distroy,2000);

            $('.customerInfo').removeClass('hidden');
        }
        else
        {
            $(this).removeAttr('checked');
            $('#customer').removeAttr('disabled');
            $('.customerInfo').addClass('hidden');
        }
    })
})
