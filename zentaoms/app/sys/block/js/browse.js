function getAPIBlocks(entryID)
{
    var entryBlock = $('#allEntries').parent().parent().next();
    $(entryBlock).hide();
    $('#blockParam').empty();
    if(entryID == '') return false;
    if(entryID == 'rss' || entryID == 'html')
    {
        getBlockParams(entryID);
        return false;
    }
    $.get(createLink('entry', 'blocks', 'entryID=' + entryID + '&index=' + v.index), function(data)
    {
        $(entryBlock).html(data);
        $(entryBlock).show();
    })
}

function getBlockParams(value, entryID)
{
  $('#blockParam').empty();
    if(value == '') return false;
    if(value == 'rss' || value == 'html')
    {
        $.get(createLink('block', 'set', 'index=' + v.index + '&type=' + value), function(data)
        {
            $('#blockParam').html(data);
            $.setAjaxForm('#ajaxForm', afterAddBlock);
        });
    }
    else
    {
        $.get(createLink('entry', 'setBlock', 'index=' + v.index + '&entryID=' + entryID + '&blockID=' + value), function(data)
        {
            $('#blockParam').html(data);
            $.setAjaxForm('#ajaxForm', afterAddBlock);
        });
    }
}

function afterAddBlock()
{
  parent.location.href=config.webRoot + config.appName;
}

$(function()
{
    $('#allEntries').change(function(){getAPIBlocks($(this).val())});
    getAPIBlocks($('#allEntries').val());
})
