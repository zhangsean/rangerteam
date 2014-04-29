$(document).ready(function()
{
     if($('a[data-toggle=modal]').parents('#ajaxModal').size()) 
     {
        $('a[data-toggle=modal]').hide();
     }
     $('.toggle').click(function()
     {
          $(this).toggleClass('change-show').toggleClass('change-hide');
          $(this).parent().next().toggle();
     });

     $('.toggle-all').click(function()
     {
          $(this).toggleClass('change-show').toggleClass('change-hide');
          $('.toggle').click();
     });
});

function toggleOrder(obj)
{
    var orderClass = $(obj).find('span').attr('class');
    if(orderClass == 'log-asc')
    {
        $(obj).find('span').attr('class', 'log-desc');
    }
    else
    {
        $(obj).find('span').attr('class', 'log-asc');
    }
    $("#historyItem li").reverseOrder();
}
