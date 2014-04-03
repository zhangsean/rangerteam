/* Browse by module. */
function browseByModule()
{
    $('.divider').removeClass('hidden');
    $('#bymoduleTab').addClass('active');
    $('#allTab').removeClass('active');
    $('#bysearchTab').removeClass('active');
    $('#querybox').addClass('hidden');
}

function browseBySearch()
{
    $('.divider').addClass('hidden');
    $('#bymoduleTab').removeClass('active');
    $('#allTab').addClass('active');
    $('#bysearchTab').addClass('active');
    $('#querybox').removeClass('hidden');
}

$(function(){
    $('#' + v.browseType + 'Tab').addClass('active');
    if(v.browseType == "bysearch")
    {
        ajaxGetSearchForm();
        browseBySearch();
    }
});
