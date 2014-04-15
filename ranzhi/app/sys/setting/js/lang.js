$(function()
{
    /* Highlight current nav. */
    $('.nav li').removeClass('active');
    $(".nav li a[href*='" + v.module + "']").parent().addClass('active');

    /* Add an item. */
    $(document).on('click', '.add', function()
    {
        $(this).parent().parent().after(v.itemRow);
    })

    /* Remove an item. */
    $(document).on('click', '.remove', function()
    {
        $(this).parent().parent().remove();
    })
})
