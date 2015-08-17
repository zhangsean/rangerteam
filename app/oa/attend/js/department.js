$(document).ready(function()
{
    if(v.company)
    {
        $('#menu .nav > li').removeClass('active').find("[href*='true']").parent().addClass('active');
    }
});
