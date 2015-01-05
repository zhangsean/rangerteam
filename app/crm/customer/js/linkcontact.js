$(function()
{
    $.setAjaxForm('#linkContactForm', function(data)
    {
        if(data.result == 'success')
        {
            $.reloadAjaxModal(1500);
        }
        else
        {
            $('.popover').html(data.message);
            $('#submit').popover({trigger:'manual', placement:'right'}).popover('show');
            $('#submit').next('.popover').addClass('popover-content');
            return false;
        }
    })

    $('#selectContact').change(function()
    {
        if($(this).prop('checked'))
        {
            $('#contact_chosen').show();
            $(this).parents('.input-group').find('input[type=text][id=realname]').hide();

            $('#contact').trigger("chosen:updated");
            $('#contactInfo').addClass('hidden');
        }
        else
        {
            $(this).parents('.input-group').find('select').hide();
            $('#contact_chosen').hide();
            $(this).parents('.input-group').find('input[type=text][id=realname]').show();

            $('#contact').trigger("chosen:updated");
            $('#contactInfo').removeClass('hidden');
        }
    });
    $('#selectContact').change();
})
