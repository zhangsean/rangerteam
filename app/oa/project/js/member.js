/* update role tip. */
function updateRole()
{
    $('[name^=role]:checked').each(function()
    {
        $(this).parents('td').next('td').text(v.roleTips[$(this).val()]);
    });
}

/* Disabled user who selected. */
function updateMember()
{
    $('[name^=member]').find('option').prop('disabled', '');
    $('[name^=member]').find('[value=' + v.manager + ']').prop('disabled', 'disabled');
    $('[name^=member]').each(function()
    {
        var value = $(this).val();
        if(value != '')
        {
            $('[name^=member]').each(function()
            {
                if($(this).val() == '')
                {
                    $(this).find('[value=' + value + ']').prop('disabled', 'disabled');
                }
            });
        }
    });
    $('.chosen').trigger("chosen:updated");
}

$(document).ready(function()
{
    updateRole();
    updateMember();
    /* Add a trade detail item. */
    $(document).on('click', '.icon-plus', function()
    {
        $(this).parents('tr').after($('#hiddenMember').html().replace(/key/g, v.key));
        $(this).parents('tr').next().find("[name^='member']").chosen();
        v.key ++;
    });

    /* Remove a trade detail item. */
    $(document).on('click', '.icon-minus', function()
    {
        if($('#ajaxForm table tbody tr').size() > 1)
        {
            $(this).parents('tr').remove();
        }
        else
        {
            $(this).parents('tr').find('input,select').val('');
        }
    });
});
