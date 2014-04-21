$(document).ready(function()
{
    $(document).on('click', '.plus', function()
    {
        $(this).parents('tr').after("<tr><th></th><td>" + $('#orderTD').html() + "</td></tr>");
    });
  
    $(document).on('click', '.minus', function()
    {
        $(this).parents('tr').remove();

        var amount = 0;
        $('.order-real').each(function()
        {
            amount += parseFloat($(this).val());
        });

        $('#amount').val(amount);
    });
})
