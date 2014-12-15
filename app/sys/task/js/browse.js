$(function()
{
   if(v.mode)  $('#menu').find('[href*=' + v.mode + ']').parent().addClass('active');

    window.reloadDataTable = function()
    {
        var $list = $('#taskList');
        $list.load(document.location.href + ' #taskList', function()
        {
            $list.dataTable();
            $list.find('[data-toggle="modal"]').modalTrigger();
            resetBoards();
        });
        return false;
    };

})

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
