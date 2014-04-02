/**
 * Get all blocks.
 * 
 * @param  string|int $entryID 
 * @access public
 * @return void
 */
function getBlocks(entryID)
{
    var entryBlock = $('#allEntries').parent().parent().next();
    $(entryBlock).hide();
    $('#blockParam').empty();
    if(entryID == '') return false;
    if(entryID == 'rss' || entryID == 'html')
    {
        getRssAndHtmlParams(entryID);
        return true;
    }

    $.get(createLink('entry', 'blocks', 'entryID=' + entryID + '&index=' + v.index), function(data)
    {
        $(entryBlock).html(data);
        $(entryBlock).show();
    })
}

/**
 * Get rss and html params.
 * 
 * @param  string $type 
 * @access public
 * @return void
 */
function getRssAndHtmlParams(type)
{
    $.get(createLink('block', 'set', 'index=' + v.index + '&type=' + type), function(data)
    {
        $('#blockParam').html(data);
        $.setAjaxForm('#ajaxForm', function(){parent.location.href=config.webRoot + config.appName;});
    });
}

/**
 * Get block params.
 * 
 * @param  string $blockID 
 * @param  int    $entryID 
 * @access public
 * @return void
 */
function getBlockParams(blockID, entryID)
{
    $('#blockParam').empty();
    if(blockID == '') return false;

    $.get(createLink('entry', 'setBlock', 'index=' + v.index + '&entryID=' + entryID + '&blockID=' + blockID), function(data)
    {
        $('#blockParam').html(data);
        $.setAjaxForm('#ajaxForm', function(){parent.location.href=config.webRoot + config.appName;});
    });
}

$(function()
{
    $('#allEntries').change(function(){getBlocks($(this).val())});
    getBlocks($('#allEntries').val());
})
