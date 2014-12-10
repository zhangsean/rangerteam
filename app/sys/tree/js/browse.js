$(document).ready(function()
{
    /* set active left menu. */
    var menu = $('#menu .nav li').size() == 0 ? '.nav li' : '#menu .nav li';
    if(v.type == 'dept' && $('#menu .nav li').size() == 0) menu = '';
    $(menu).removeClass('active');
    if(config.requestType == 'GET')
    {
        $(menu + " a[href*='tree'][href*='=" + v.type + "']").parent().addClass('active');
    }
    else
    {
        $(menu + " a[href*='tree'][href*='" + v.type + "']").parent().addClass('active');
    }

    if(v.type == 'customdoc')
    {
         $(menu + " a[href*='" + v.root +"']").parent().addClass('active');
    }

    /* Load the children of current category when page loaded. */
    var link = createLink('tree', 'children', 'type=' + v.type + '&moduleID=' + v.moduleID + '&root=' + v.root);
    $('#categoryBox').load(link);
    $('#treeMenuBox li:has(ul)').each(function()
    {
        $(this).children('.deleter').remove();
    });

    $.setAjaxLoader('#treeMenuBox .ajax', '#categoryBox');
})
