$(document).ready(function()
{
    /* Add one condition. */
    var key = v.key;
    $(document).on('click', '.plus', function()
    {
        $(this).parents('tr').after("<tr>" + $('#originTR').html().replace(/key/g, key) + "</tr>");
        key++;
    });

    /* Delete one condition. */
    $(document).on('click', '.condition-deleter', function(){ $(this).parents('tr').remove(); });
})
