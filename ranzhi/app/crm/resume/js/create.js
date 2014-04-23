$(function()
{
    $('#newCustomer').change(function()
    {
        if($(this).attr('checked') == undefined)
        {
            $(this).attr('checked', true);
            $('.customerInfo').removeClass('hidden');
        }
        else
        {
            $(this).removeAttr('checked');
            $('.customerInfo').addClass('hidden');
        }
    })
})
