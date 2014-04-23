$(function()
{
    $.setAjaxForm('#linkContactForm', function(data)
    {
        if(data.result == 'success') $.reloadAjaxModal(1500);
    })

    $('#newContact').change(function()
    {
        if($(this).attr('checked') == undefined)
        {
            $('#contact').attr('disabled', true);
            $(this).attr('checked', true);
            $('#contactInfo').removeClass('hidden');
        }
        else
        {
            $(this).removeAttr('checked', true);
            $('#contact').removeAttr('disabled');
            $('#contactInfo').addClass('hidden');
        }
    })
})
