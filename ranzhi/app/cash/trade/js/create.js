$(document).ready(function()
{
    $(document).on('change', '#type', function()
    {
        if($(this).find('option:selected').val() == 'in')
        {
            $('.income').show().find('select').attr('disabled', false);
            $('.expense').hide().find('select').attr('disabled', true);
        }

        if($(this).find('option:selected').val() == 'out')
        {
            $('.expense').show().find('select').attr('disabled', false);
            $('.income').hide().find('select').attr('disabled', true);
        }
    })

    $('#type').change();
})
