$(function()
{
    /* show team menu. */
    $('[name^=multiple]').change(function()
    {
        if($(this).prop('checked'))
        {
            $('#assignedTo, #assignedTo_chosen').addClass('hidden');
            $('#team').removeClass('hidden');
            $('#estimate').attr('readonly', true);
        }
        else
        {
            $('#assignedTo, #assignedTo_chosen').removeClass('hidden');
            $('#team').addClass('hidden');
            $('#estimate').attr('readonly', false);
        }
    });
})
