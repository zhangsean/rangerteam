$(document).ready(function()
{
    $(document).on('change', '#type', function()
    {
        if($(this).find('option:selected').val() == 'bank')
        {
            $('#depositor').show();
            $('.bankcode').show();
            $('.provider').html($('.branch').html());
        }

        if($(this).find('option:selected').val() == 'online')
        {
            $('#depositor').show();
            $('.bankcode').hide();
            $('.provider').html($('.service').html());
        }

        if($(this).find('option:selected').val() == 'cash')   $('#depositor').hide();
    })
})
