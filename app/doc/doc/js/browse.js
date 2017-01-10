$(document).ready(function()
{
      $(document).on('click', '.fix-menu', function()
      {   
          $.getJSON($(this).attr('href'), function(data) 
          {   
              if(data.result == 'success')
              {   
                  return location.reload();
              }   
              else
              {   
                  alert(data.message);
                  return location.reload();
              }   
          }); 
          return false;
      })
})
