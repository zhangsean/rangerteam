$(document).ready(function()
{
     /* if in modal hide edit button. */
     if($('a[data-toggle=modal]').parents('#ajaxModal').size()) 
     {
        $('#ajaxModal a[data-toggle=modal]').hide();
     }

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
