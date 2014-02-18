$(document).ready(function()
{
    $('#customer').change(function()
    {
        location.href = createLink('contract', 'create', 'orderID=0&customerID=' + $(this).val());
    })
    $('#order').change(function()
    {
        location.href = createLink('contract', 'create', 'orderID=' + $(this).val());
    })
})
