$(document).ready(function()
{
    if(typeof(v.projectID) != undefined && v.projectID != 0)
    {
        $('.menu .nav li').removeClass('active');
        $('.leftmenu li').removeClass('active').find('[href*=' + v.status + ']').parent().addClass('active');
        $('.leftmenu li').find('[href*=' + v.status + ']').parent().addClass('active');

    }

    $(".leftmenu a[href*=create]").modalTrigger({width:800});
    $.setAjaxJSONER('.swticher', function(){location.reload()});
})
