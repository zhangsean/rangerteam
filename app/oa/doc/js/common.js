/* Load the products of the roject. */
function loadProducts(project)
{
    link = createLink('project', 'ajaxGetProducts', 'projectID=' + project);
    $('#productBox').load(link);
}

/* Set doc type. */
function setType(type)
{
    if(type == 'url')
    {
        $('#urlBox').removeClass('hidden');
        $('#fileBox').addClass('hidden');
        $('#contentBox').addClass('hidden');
    }
    else if(type == 'text')
    {
        $('#urlBox').addClass('hidden');
        $('#fileBox').addClass('hidden');
        $('#contentBox').removeClass('hidden');
    }
    else
    {
        $('#urlBox').addClass('hidden');
        $('#fileBox').removeClass('hidden');
        $('#contentBox').addClass('hidden');
    }
}

$(function()
{
    /* move search button to left menu. */
    $('#bysearchTab').appendTo($('#menu').children('ul'));
    
    if(v.mode == 'bysearch')
    {
        $('#bysearchTab').addClass('active');
        ajaxGetSearchForm();
    }
    toggleSearch();
});

$(document).ready(function()
{
    if(typeof(v.libID) != undefined && v.libID != 'createLib')
    {
        $('#menu .nav li').removeClass('active');
        if(typeof(v.libID) != undefined) $(".nav li a[href*='" + v.libID + "']").parent().addClass('active');
        $(".nav li a[href*='createlib']").attr('data-toggle', 'modal');
    }
});
