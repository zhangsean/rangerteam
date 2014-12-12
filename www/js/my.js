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

/**
 * Ajax get search form 
 * 
 * @access public
 * @return void
 */
function ajaxGetSearchForm()
{
    if($('#querybox').html() == '')
    {
        $.get(createLink('search', 'buildForm'), function(data)
        {
            $('#querybox').html(data);
        });
    }
}
