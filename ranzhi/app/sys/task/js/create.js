/**
 * Get orders of a customer. 
 * 
 * @param  int $customerID 
 * @access public
 * @return void
 */
function getOrder(customerID)
{
    var order = $('#order').parents('td');

    $('#order').parents('td').empty();

    if(customerID == '') return false;

    $.get(createLink('task', 'getOrder', 'customerID=' + customerID), function(data)
    {
        $(order).html(data);
        $(order).show();
    })
}
