$(document).ready(function() 
{
    setRequiredFields();

    /* Enable default ajax options. */
    $.setAjaxModal();
    $.setAjaxForm('#ajaxForm');
    $.setAjaxDeleter('.deleter');
    $.setReload('.reload');
    $.setReloadDeleter('.reloadDeleter');
    $.setAjaxLoader('.loadInModal', '#ajaxModal');

    /* Set ping keep online. */
    setInterval('ping()', 1000 * 360);

    /* Enable tooltip */
    $('body').tooltip({html: true,selector: "[data-toggle='tooltip']",container: "body"});

    fixTableHeader();
    condensedForm();    

    /* Reload modal. */
    $(document).on('click', '.reloadModal', function(){$.reloadAjaxModal()});

    /* Enable create customer option of customer selecter. */
    $(document).on('change', '.select-customer', function()
    {
        if($(this).val() == 'create')
        {
           window.open(createLink('customer', 'create'));
        }
        return false;
    });
    
    /* Enable create contact option of contact selecter. */
    $(document).on('change', '.select-contact', function()
    {
        if($(this).val() == 'create')
        {
           window.open(createLink('contact', 'create', 'customer=' + v.customer));
        }
    });
});
