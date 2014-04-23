$(function()
{
    $.setAjaxForm('#linkContactForm', function(data)
    {
        if(data.result == 'success') $.reloadAjaxModal(1500);
    })

    var value = '';
    $('#newContact').change(function()
    {
        if($(this).attr('checked') == undefined)
        {
            value = $('#contact').val();
            $('#contact').val('');
            $(this).attr('checked', true);
            $('#contactInfo').removeClass('hidden');
        }
        else
        {
            $('#contact').val(value);
            $(this).removeAttr('checked', true);
            $('#contactInfo').addClass('hidden');
        }
    })
})
