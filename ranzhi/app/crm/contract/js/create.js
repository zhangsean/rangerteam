$(document).ready(function()
{
    /* Enable customer jump menu.*/
    $('#customer').change(function()
    {
        location.href = createLink('contract', 'create', 'orderID=0&customerID=' + $(this).val());
    })

    /* Enable order jump menu.*/
    $('#order').change(function()
    {
        location.href = createLink('contract', 'create', 'orderID=' + $(this).val());
    })
})
