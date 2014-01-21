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

  $.get(createLink('block', 'order', 'oldOrder=' + oldOrder.join(',') + '&newOrder=' + newOrder.join(',')));
}
