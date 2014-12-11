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
});
