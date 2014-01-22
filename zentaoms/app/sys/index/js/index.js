$(function()
{
   for(var i = 1; i <= v.blockCount; i++) $('#block' + i).find('.panel-body').load(createLink('block', 'printBlock', 'index=' + i));
})

function deleteBlock(index)
{
    $.getJSON(createLink('block', 'delete', 'index=' + index), function(data)
    {
        if(data.result != 'success')
        {
            alert(data.message);
            return false;
        }
        $('#block' + index).parent().remove();
    })
}

function orderBlocks(orders)
{
    var oldOrder = new Array();
    var newOrder = new Array();
    for(i in orders)
    {
       oldOrder.push(i.replace('block', ''));
       newOrder.push(orders[i]);
    }

    $.getJSON(createLink('block', 'order', 'oldOrder=' + oldOrder.join(',') + '&newOrder=' + newOrder.join(',')), function(data)
    {
        if(data.result != 'success') return false;

        $('div[data-order]').each(function()
        {
            var index = $(this).attr('data-order');
            $(this).attr('id', 'block' + index);
            $(this).find('.custom-actions .edit-block').attr('href', createLink('block', 'browse', 'index=' + index));
            $(this).find('.custom-actions .remove-block').attr('onclick', 'deleteBlock(' + index + ')');
        })
    });
}
