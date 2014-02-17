$(document).ready(function()
{
    /* Set role when select an account. */
    $(document).on('change', '.account', function()
    {
       account = $(this).val();
       v.userRoles[account] && $(this).parent('td').next().find('.role').val(v.userRoles[account]);
    });

    /* Add a role. */
    $(document).on('click', '.icon-plus-sign', function()
    {
        $(this).parents('tr').after($('#roleGroup').html());
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
