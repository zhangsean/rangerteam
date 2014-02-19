$(function()
{
    $('#dashboard').dashboard(
    {
        height   : 240,
        draggable: true,
        afterOrdered: function(orders)
        {
        },
        afterPanelRemoved: function(index)
        {
        }
    });
});
