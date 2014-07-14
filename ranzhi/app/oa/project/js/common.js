$(document).ready(function()
{
    if(typeof(v.projectID) != undefined && v.projectID != 0)
    {
        $('.menu .nav li').removeClass('active');
        if(typeof(v.projectID) != undefined) $(".nav li a[href*='" + v.projectID + "']").parent().addClass('active');
        $('.leftmenu li').removeClass('active').find('[href*=' + v.status + ']').parent().addClass('active');
        $('.leftmenu li').find('[href*=' + v.status + ']').parent().addClass('active');

    }
    $.setAjaxJSONER('.activater', function(){location.reload()});
});
