$(document).ready(function()
{
    /* Toggle options. */
    $('.unit').change(function()
    {
        unit = $(this).val();
        $(this).nextAll('span, :input').toggle(unit == 'fix');
    });

    /* Add a unit. */
    $(document).on('click', '.icon-plus-sign', function()
    {
        $(this).parents('.input-group').after( $('#unitItem').html());
    });

    /* Delete a option. */
    $(document).on('click', '.icon-minus-sign', function()
    {
        if($(this).parents('td').find('.input-group').size() > 1)
        {
            $(this).parents('.input-group').remove();
        }
    });

});
