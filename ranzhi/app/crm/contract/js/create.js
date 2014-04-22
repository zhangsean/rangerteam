/**
 * Get orders of a customer. 
 * 
 * @param  int $customerID 
 * @access public
 * @return void
 */
function getOrder(customerID)
{
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
    /* Show real of an order and compute amount of the contract. */
    $(document).on('change', 'select.select-order', function()
    {
        $(this).parent().next('span').find(':input').val($(this).find('option:selected').attr('data-real'));
        $(this).parent().next('span').find(':input').change();
    });

    /* Recompute amount when change real of an order.  */
    $(document).on('change', '.order-real', function()
    {
        var amount = 0;
        $('.order-real').each(function(){ amount += parseFloat($(this).val()); });
        $('#amount').val(amount);
    });
})
