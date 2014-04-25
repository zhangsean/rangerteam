/**
 * Get orders of a customer. 
 * 
 * @param  int $customerID 
 * @access public
 * @return void
 */
function getOrder(customerID)
{
    if($('.select-order').length > 1) $('.select-order').parents('tr').not('#orderTR').remove();
    $('#orderTD').empty();

    if(customerID == '') return false;
    if(customerID == 'create') return true;

    $.get(createLink('contract', 'getOrder', 'customerID=' + customerID), function(data)
    {
        $('#orderTR').removeClass('hide');
        $('#orderTD').html(data).show();
    })
}

$(document).ready(function()
{
    $(document).on('click', '.plus', function()
    {
        $(this).parents('tr').after("<tr><th></th><td>" + $('#orderTD').html() + "</td></tr>");
    });
  
    $(document).on('click', '.minus', function()
    {
        if($(this).parents('table').find('.order-real').size() == 1)
        {
            $(this).parents('td').find('select').val('').change();
            return false;
        }
        $(this).parents('tr').remove();
        $('.order-real').change();
    });
})
