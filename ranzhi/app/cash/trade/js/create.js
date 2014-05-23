$(document).ready(function()
{
    $(document).on('change', '#type', function()
    {
        if($(this).find('option:selected').val() == 'in')
        {
            $('.income').hide().find('select').attr('disabled', true);
            $('.expense').show().find('select').attr('disabled', false);
        }

        if($(this).find('option:selected').val() == 'out')
        {
            $('.expense').hide().find('select').attr('disabled', true);
            $('.income').show().find('select').attr('disabled', false);
        }
    })

    $('#type').change();
})
