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
       $.setAjaxForm('#customerForm');
   }
})
