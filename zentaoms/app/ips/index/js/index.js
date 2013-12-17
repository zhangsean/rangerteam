$(document).ready(function()
{          
    /* Set rows label of bottom blocks. */
    $('.panel').each(function(index)
    {
        row = parseInt(parseInt(index) / 3);
        $(this).addClass('row-' + row);
    });
    rows = row;

    // auto ajust panel height.
    for(i=0; i<=rows; i++)
    {
        fitPanelHeight = 0;
        $(".row-" + i ).each(function(){fitPanelHeight=Math.max($(this).height(),fitPanelHeight);}).height(fitPanelHeight);
    }

    // add "index" class to the body element.
    $('body').addClass('index');

    // slide pictures start.     
    $('#slide').carousel();
    $('#slide .item').first().addClass('active');
    $('.nav-system-home').addClass('active');
})
