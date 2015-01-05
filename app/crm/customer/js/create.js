$(document).ready(function()
{
   if(window.opener)
   {
       $.setAjaxForm('#customerForm', function(response)
       {
          if(response.result == 'success')
          {
               url = createLink('customer', 'getoptionmenu', 'current=' + response.customerID);
               $('.select-customer', window.opener.document).load(url, function(){ window.close(); });
          }
       });
   }
   else
   {
       $.setAjaxForm('#customerForm', function(response)
       {
           if(response.result == 'fail')
           {
               $('.popover').html(response.message);
               $('#submit').popover({trigger:'manual', placement:'right'}).popover('show');
               $('#submit').next('.popover').addClass('popover-content');
               return false;
           }
           else
           {
               setTimeout(function(){location.href = response.locate;}, 1200);
           }
       });
   }
})
