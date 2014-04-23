$(function()
{
    $('#newCustomer').change(function()
    {
        if($(this).attr('checked') == undefined)
        {
            $(this).attr('checked', true);
            $('#customer').attr('disabled', true);
            $('#customer').trigger("chosen:updated");
            $('.customerInfo').removeClass('hidden');
        }
        else
        {
            $(this).removeAttr('checked');
            $('#customer').removeAttr('disabled', true);
            $('#customer').trigger("chosen:updated");
            $('.customerInfo').addClass('hidden');
        }
    })
})
