$(function()
{
    /* Toggle the line of closedReason. */
    $('#status').change(function(){$('#closedReason').parents('tr').toggle($(this).val() == 'closed');})
    $('#status').change();
})
