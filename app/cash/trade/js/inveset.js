$(document).ready(function()
{
    $(document).on('change', '#type', function()
    {
        var type = $(this).val();
        if(type == 'redeem')
        {
            $('tr.category').show();
        }
        else
        {
            $('tr.category').hide();
        }

    })

    $('#type').change();
});
