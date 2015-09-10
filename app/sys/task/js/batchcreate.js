$(document).ready(function()
{
    $('.multiple').click(function()
    {
        var checked = $(this).prop('checked');
        var trObj = $(this).parents('tr');
        if(checked)
        {
            trObj.find('.assignedToForm').hide();
            trObj.find('.teamForm').show();
        }
        else
        {
            trObj.find('.assignedToForm').show();
            trObj.find('.teamForm').hide();
        }
    });
})
