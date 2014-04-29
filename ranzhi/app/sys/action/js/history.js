$(document).ready(function()
{
     /* Toggle one comment. */
     $('.toggle').click(function()
     {
          $(this).toggleClass('change-show').toggleClass('change-hide');
          $(this).parent().next().toggle();
     });

     /* Toggle all comment. */
     $('.toggle-all').click(function()
     {
          $(this).toggleClass('change-show').toggleClass('change-hide');
          $('.toggle').click();
     });
    
     /* Sort records. */
     $('.sorter').click(function()
     {
          var orderClass = $(this).find('span').attr('class');

          if(orderClass == 'log-asc')
          {
              $(this).find('span').attr('class', 'log-desc');
          }
          else
          {
              $(this).find('span').attr('class', 'log-asc');
          }

          $(this).parents('.panel').find('.panel-body li').reverseOrder();
     });
});
