$(document).ready(function()
{
    var key = v.key;
    $(document).on('click', '.plus', function()
    {
        $(this).parents('tr').after("<tr>" + $('#originTR').html().replace(/key/g,  key ) + "</tr>");
        key++;
        $("#ajaxForm .rules").chosen({no_results_text: '<?php echo $lang->noResultsMatch;?>', placeholder_text:' ', disable_search_threshold: 10, width: '100%'});
    });
    $(document).on('click', '.condition-deleter', function(){ $(this).parents('tr').remove(); });
})
