$(document).ready(function()
{
     if(v.from == 'admin')
     {
          $.setAjaxForm('#editForm', function(){ location.reload()});
     }
     else
     {
          $.setAjaxForm('#editForm',function() { $.reloadAjaxModal(0); });
     }
});
