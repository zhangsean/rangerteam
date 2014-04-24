$(document).ready(function()
{
    /* Show notice when auto create customer. */
    $('#newCustomer').change(function()
    {
        $(this).next('label').popover('destroy');
        if($(this).prop('checked'))
        {
            $('#customer').attr('disabled', true);

            var label = $(this).next('label');
            label.popover({trigger:'manual', content:v.autoCustomer, placement:'right'}).popover('show');
            label.next('.popover').addClass('popover-default');
            function distroy(){label.popover('destroy')}
            setTimeout(distroy,2000);

            $('.customerInfo').removeClass('hidden');
        }
        else
        {
            $('#customer').attr('disabled', false);
            $('.customerInfo').addClass('hidden');
        }
    })
})
