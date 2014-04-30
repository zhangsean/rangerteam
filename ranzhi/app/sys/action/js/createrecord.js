$(document).ready(function()
{
   $.setAjaxForm('#createRecordForm', function()
   {
      $.reloadAjaxModal();
   });
   $('#ajaxModal .sorter').click();
});
