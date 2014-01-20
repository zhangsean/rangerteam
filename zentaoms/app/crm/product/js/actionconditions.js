$(document).ready(function()
{
    $(document).on('click', '.plus', function(){ $(this).parents('tr').after("<tr>" + $('#originTR').html() + "</tr>");});
    $(document).on('click', '.condition-deleter', function(){ $(this).parents('tr').remove(); });
})
