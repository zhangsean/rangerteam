$(document).ready(function()
{
    $('.singleEdit').click(function()
    {
        if($('tr.edit').is(':visible')) return false;

        $(this).parents('tr').next('tr.edit').show();
        $(this).parents('tr').next('tr.edit').children('td.singleSave').show();
        $(this).parents('tr').hide();
    })
})
