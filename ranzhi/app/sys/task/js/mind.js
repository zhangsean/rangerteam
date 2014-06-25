$(function()
{
    $('#fsBtn').click(function()
    {
        var mm = $('#mindmap');
        mm.toggleClass('fullscreen');
        ajustMinderSize();
    });

    function ajustMinderSize()
    {
        var $km = $('#kityminder');
        $('#kity_svg_0').attr('height', $(window).height() - $km.offset().top - ($('#mindmap').hasClass('fullscreen') ? 1 : 21)).attr('width', $km.width());
    }

    $(window).resize(ajustMinderSize);
    ajustMinderSize();
});
