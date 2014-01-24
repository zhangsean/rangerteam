$(function()
{
    /* start ips */
    $.ipsStart(entries, $.extend({onBlocksOrdered: sortBlocks}, config));
    $('.entries-count').text(entries.length - 2)

    printBlock();
})

/**
 * Print block.
 * 
 * @access public
 * @return void
 */
function printBlock()
{
    $('.panels-container .row .panel').each(function()
    {
        var index = $(this).attr('id').replace('block', '');
        $('#block' + index).find('.panel-body').load(createLink('block', 'printBlock', 'index=' + index));
    })
}

/**
 * Delete block.
 * 
 * @param  int    $index 
 * @access public
 * @return void
 */
function deleteBlock(index)
{
    $.getJSON(createLink('block', 'delete', 'index=' + index), function(data)
    {
        if(data.result != 'success')
        {
            alert(data.message);
            return false;
        }

        /* remove div for this bloc.  */
        $('#block' + index).parent().remove();
    })
}

/**
 * Sort blocks.
 * 
 * @param  object $orders  format is {'block2' : 1, 'block1' : 2, oldOrder : newOrder} 
 * @access public
 * @return void
 */
function sortBlocks(orders)
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
            /* Update new index for block id edit and delete. */
            $(this).attr('id', 'block' + index);
            $(this).find('.custom-actions .edit-block').attr('href', createLink('block', 'admin', 'index=' + index));
            $(this).find('.custom-actions .remove-block').attr('onclick', 'deleteBlock(' + index + ')');
        })
    });
}
