$(document).ready(function()
{
   if(window.opener)
   {
       $.setAjaxForm('#contactForm', function(response)
       {
          if(response.result == 'success')
          {
               $('.select-contact', window.opener.document).load(createLink('contact', 'getoptionmenu', "customer=" + v.customer + '&current=' + response.contactID), function(){ window.close(); });
          }
       });
   }
   else
   {
       $.setAjaxForm('#contactForm');
   }

})
