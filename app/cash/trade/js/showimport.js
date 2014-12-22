$(document).ready(function()
{
    $(document).on('change', '.type', function()
    {
        var type = $(this).val();
        if(type == 'fee') type = $(this).next('input:hidden').val();
        $(this).parents('tr').find('.in, .out').hide().attr('disabled', true).find('*').attr('disabled', true);
        $(this).parents('tr').find('.' + type).show().attr('disabled', false).find('*').attr('disabled', false);
    })
    $('.type').change();

    $('[name*=createCustomer]').change(function()
    {
        if($(this).prop('checked')) 
        {
            $(this).parents('.input-group').find('select').hide();
            $(this).parents('.input-group').find('input[type=text]').show().focus();
        }
        else
        {
            $(this).parents('.input-group').find('select').show();
            $(this).parents('.input-group').find('input[type=text]').hide();
        }
    })
});
