$(document).ready(function()
{
    /* Show notice when auto create customer. */
    var value = ''
    $('#newCustomer').change(function()
    {
        if($(this).attr('checked') == undefined)
        {
            value = $('#customer').val();
            $('#customer').val('');
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
            $('#customer').val(value);
            $(this).removeAttr('checked');
            $('.customerInfo').addClass('hidden');
        }
    })

    /* Reset newCustomer when customer is not empty. */
    $('#customer').change(function()
    {
        if($(this).val() != '' && $('#newCustomer').attr('checked')) $('#newCustomer').removeAttr('checked');
    })
})
