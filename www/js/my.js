$(document).ready(function() 
{
    setRequiredFields();

    /* Enable default ajax options. */
    $.setAjaxForm('#ajaxForm');
    $.setAjaxDeleter('.deleter');
    $.setReload('.reload');
    $.setReloadDeleter('.reloadDeleter');
    $.setAjaxLoader('.loadInModal', '#ajaxModal');

    /* Set ping keep online. */
    setInterval('ping()', 1000 * 360);

    /* Enable tooltip */
    $('body').tooltip({html: true,selector: "[data-toggle='tooltip']",container: "body"});

    fixTableHeader();
    condensedForm();
    setPageActions();

    /* Reload modal. */
    $(document).on('click', '.reloadModal', function(){$.reloadAjaxModal()});

    /* Init search tab on menu */
    initSearch();
});

/* left, go to pre object. */
$(document).bind('keydown', 'left', function(evt)
{
    preLink = ($('#pre').attr("href"));
    if(typeof(preLink) != 'undefined') location.href = preLink;
});

/* right, go to next object. */
$(document).bind('keydown', 'right', function(evt)
{
    nextLink = ($('#next').attr("href"));
    if(typeof(nextLink) != 'undefined') location.href = nextLink;
});

/**
 * Show or hide more items. 
 * 
 * @access public
 * @return void
 */
function switchMore()
{
    $('#search').width($('#search').width()).focus();
    $('#moreMenu').width($('#defaultMenu').outerWidth());
    $('#searchResult').toggleClass('show-more');
}
 
/**
 * Toogle the search form.
 * 
 * @access public
 * @return void
 */
function toggleSearch()
{
    $("#bysearchTab").click (function(){
        if($('#bysearchTab').hasClass('active'))
        {
            $('#bysearchTab').removeClass('active');
            $('#querybox').removeClass('show').addClass('hidden');
        }
        else
        {
            $('#bysearchTab').addClass('active');
            ajaxGetSearchForm();
            $('#querybox').removeClass('hidden').addClass('show');
        }
    });
}


function initSearch()
{
    $searchTab = $('#bysearchTab');
    if($searchTab.data('initSearch')) return;

    if(!$searchTab.closest('#menu').length)
    {
        $('#menu > ul:first').append($searchTab);
    }

    var $queryBox = $('#querybox');
    if(!$queryBox.length)
    {
        $queryBox = $("<div id='querybox' class='hidden'/>").insertAfter($('#menu'));
    }

    if(v && v.mode == 'bysearch')
    {
        $('#menu > ul > li.active').removeClass('active');
        ajaxGetSearchForm($queryBox);
        $searchTab.addClass('active');
        $queryBox.removeClass('hidden');
    }

    $searchTab.on('click', function()
    {
        if($searchTab.hasClass('active'))
        {
            $searchTab.removeClass('active').data('oldTab').addClass('active');
            $queryBox.addClass('hidden');
        }
        else
        {
            $searchTab.data('oldTab', $('#menu > ul > li.active').removeClass('active')).addClass('active');
            ajaxGetSearchForm($queryBox);
            $queryBox.removeClass('hidden');
        }
    });

    $searchTab.data('initSearch', true);
}

/**
 * Ajax get search form 
 * 
 * @access public
 * @return void
 */
function ajaxGetSearchForm($queryBox)
{
    if(!$queryBox) $queryBox = $('#querybox');
    if($queryBox.html() == '')
    {
        $.get(createLink('search', 'buildForm'), function(data)
        {
            $queryBox.html(data);
        });
    }
}
