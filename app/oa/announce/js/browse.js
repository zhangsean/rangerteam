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
