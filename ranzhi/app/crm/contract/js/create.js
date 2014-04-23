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
