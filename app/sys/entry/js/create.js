$(document).ready(function()
{
    $('#chanzhi').change(function()
    {
        if($(this).prop('checked')) 
        {
            $('#integration').prop('checked', true);
            $('#integration').change();
            $('#login').attr('placeholder', v.chanzhiPlaceholder);
            $('#login').parents('tr').find('th').text(v.chanzhiURL);
            $('#logout').parents('tr').hide();
            $('#block').parents('tr').hide();
        }
        else
        {
            $('#logout').parents('tr').show();
            $('#block').parents('tr').show();
        }
    });

    $('#zentao').change(function()
    {
        if($(this).prop('checked')) 
        {
            $('#integration').prop('checked', true);
            $('#integration').change();
            $('#login').attr('placeholder', v.zentaoPlaceholder);
            $('#login').parents('tr').find('th').text(v.zentaoURL);
            $('#adminAccount').parents('tr').show();
            $('#key').parents('tr').hide();
            $('#logout').parents('tr').hide();
            $('#block').parents('tr').hide();
        }
        else
        {
            $('#login').attr('placeholder', v.loginPlaceholder);
            $('#login').parents('tr').find('th').text(v.loginUrl);
            $('#adminAccount').parents('tr').hide();
            $('#key').parents('tr').show();
            $('#logout').parents('tr').show();
            $('#block').parents('tr').show();
        }
    });
});
