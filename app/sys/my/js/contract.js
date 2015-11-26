$(document).ready(function()
{
    /* Highlight submenu. */
    if(config.requestType == 'GET')
    {
        $('#menu li').removeClass('active').find("[href*='=" + v.type + "']").parent().addClass('active');
    }
    else
    {
        $('#menu li').removeClass('active').find("[href*='-" + v.type + "']").parent().addClass('active');
    }

    /* process actions. */
    $('.actions a').click(function()
    {
        var skip = false;
        if($(this).data('toggle') == 'modal') skip = true;
        if($(this).hasClass('deleter')) skip = true;
        if($(this).hasClass('reloadDeleter')) skip = true;

        var href = $(this).prop('href');
        var app  = '';
        if(href.indexOf('/crm/') != -1)  app = 'crm';
        if(href.indexOf('/oa/') != -1)   app = 'oa';
        if(href.indexOf('/cash/') != -1) app = 'cash';
        if(href.indexOf('/team/') != -1) app = 'team';

        if(!skip && app != '')
        {
            $.openEntry(app, href);
            return false;
        }
    });
});
