$(document).ready(function()
{
    $('#customer').change(function()
    {
        location.href = createLink('task', 'create', 'orderID=0&customerID=' + $(this).val());
    })

    $('#order').change(function()
    {
        location.href = createLink('task', 'create', 'orderID=' + $(this).val());
    })
})
