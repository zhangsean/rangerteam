$(document).ready(function()
{
    $('#feeRow1').change(function()
    {
        $(this).prop('checked') ? $('#fee').attr('disabled', 'disabled') : $('#fee').removeAttr('disabled');
    });
})
