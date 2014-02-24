$(document).ready(function()
{
    /* Add one condition. */
    $(document).on('click', '.icon-plus-sign', function()
    {
        $(this).parents('.input-group').after($('#conditionGroup').html());
    });

    /* Remove one condition. */
    $(document).on('click', '.icon-minus-sign', function()
    {
        $(this).parents('.input-group').remove();
    });

    /* Toggle result value input. */
    $('#result').change(function()
    {
        $(this).nextAll('span, :input').toggle($(this).val() == 'input');
        if($(this).val() == 'input') $('#resultValue').focus();
    });
    $('#result').change();
})
