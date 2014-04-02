$(document).ready(function()
{
    /* Add a role. */
    $(document).on('click', '.icon-plus-sign', function()
    {
        $(this).parents('tr').after( $('#roleGroup').html());
    });

    /* Delete a role. */
    $(document).on('click', '.icon-minus-sign', function()
    {
        if($(this).parents('table').find('div.input-group').size() == 1)
        {
            $(this).parents('tr').find(':input,span').remove();
        }
        else
        {
            $(this).parents('tr').remove();
        }
    });

});
