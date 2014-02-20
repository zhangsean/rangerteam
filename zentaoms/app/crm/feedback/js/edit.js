$(function()
{
    if($('#status').val() != 'closed') $('#closedReason').parent().parent().hide();
    /* Toggle the line of closedReason. */
    $('#status').change(function(){$('#closedReason').parent().parent().toggle($(this).val() == 'closed');})
})
