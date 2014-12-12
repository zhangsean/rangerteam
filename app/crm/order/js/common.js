$(function()
{
    $('#menu .nav > li').removeClass('active').find('[href*=' + v.mode + ']').parent().addClass('active');
});

$(function()
{
    /* move search button to left menu. */
    $('#bysearchTab').appendTo($('#menu').find('ul'));
    
    if(v.mode == 'bysearch')
    {
        $('#bysearchTab').addClass('active');
        ajaxGetSearchForm();
    }
    toggleSearch();
});
