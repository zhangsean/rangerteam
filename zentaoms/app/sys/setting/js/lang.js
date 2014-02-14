$(function()
{
    $('.nav li').removeClass('active');
    $(".nav li a[href*='" + v.module + "']").parent().addClass('active');

    $(document).on('click', '.add', function()
    {
        $(this).parent().parent().after(v.itemRow);
    })
    $(document).on('click', '.remove', function()
    {
        $(this).parent().parent().remove();
    })
})
