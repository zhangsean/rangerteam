$(document).ready(function()
{
    /* show team menu. */
    $('[name^=multiple]').change(function()
    {
        var checkboxObj = $(this);
        var checked = checkboxObj.prop('checked');
        if(checked)
        {
            checkboxObj.parents('td').next('td').find('select').addClass('hidden');
            checkboxObj.parents('td').next('td').find('a').removeClass('hidden');
        }
        else
        {
            checkboxObj.parents('td').next('td').find('select').removeClass('hidden');
            checkboxObj.parents('td').next('td').find('a').addClass('hidden');
        }
    });
});
