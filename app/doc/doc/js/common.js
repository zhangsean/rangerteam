/* Load the products of the roject. */
function loadProducts(project)
{
    link = createLink('project', 'ajaxGetProducts', 'projectID=' + project);
    $('#productBox').load(link);
}

/* Set doc type. */
function setType(type)
{
    if(type == 'url')
    {
        $('#urlBox').removeClass('hidden');
        $('#fileBox').addClass('hidden');
        $('#contentBox').addClass('hidden');
    }
    else if(type == 'text')
    {
        $('#urlBox').addClass('hidden');
        $('#fileBox').addClass('hidden');
        $('#contentBox').removeClass('hidden');
    }
    else
    {
        $('#urlBox').addClass('hidden');
        $('#fileBox').removeClass('hidden');
        $('#contentBox').addClass('hidden');
    }
}

$(document).ready(function()
{
    if(typeof(v.libID) != undefined && v.libID != 'createLib')
    {
        $('#menu .nav li').removeClass('active');
        if(typeof(v.libID) != undefined) $(".nav li a[href*='" + v.libID + "']").parent().addClass('active');
        $('#menu .nav li').first().removeClass('active');
        $(".nav li a[href*='createlib']").attr('data-toggle', 'modal');
    }

    if(v.libType != undefined)
    {
        $('#mainNavbar .nav li').removeClass('active');
        $("#mainNavbar .nav li a[href*='" + v.libType + "']").parent().addClass('active');
    }

    $('#private').click(function()
    {
        $('#userTR').toggle();
        $('#groupTR').toggle();

        if($(this).prop('checked'))
        {
            $('#users').val('');
            $('#users').trigger('chosen:updated');
            $('[name*=groups]').attr('checked', false);
        }
    });

    if(v.private) $('#private').click();

    $('#libList').sortable(
    {
        trigger: '.icon-move',
        selector: '#libList .lib',
        finish: function()
        {
            var orders = {};     
            var orderNext = 1;
            $('#libList .lib').not('.addbtn').not('.files').each(function()
            {
                orders[$(this).data('id')] = orderNext ++;
            });

             $.post(createLink('doc', 'sort'), orders, function(data)
             {
                 if(data.result == 'success')
                 {
                     return location.reload(); 
                 }
                 else
                 {
                     alert(data.message);
                     return location.reload(); 
                 }
             }, 'json');
        }
    })
});
