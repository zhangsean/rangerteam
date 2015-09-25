function updateChecked(clickObj)
{
    var clickObj = $(clickObj);
    var acl = $('input[name=acl]:checked').val();    
    /* hide all tr. */
    $('#whitelistBox').addClass('hidden');
    $('#viewListBox').addClass('hidden');
    $('#editListBox').addClass('hidden');
    /* show all checkbox. */
    $('label.checkbox').removeClass('hidden');
    if(acl == 'open')
    {
        $('label.checkbox').each(function()
        {
            $(this).find('input').prop('checked', '');
        });
    }
    if(acl == 'private')
    {
        $('#viewListBox').removeClass('hidden');
        $('#editListBox').removeClass('hidden');
        $('label.checkbox').each(function()
        {
            var checkbox = $(this);
            if(!checkbox.hasClass('in-team'))
            {
                checkbox.find('input').prop('checked', '');
                checkbox.addClass('hidden');
            }
        });
        /* check viewList if editList checked. */
        $('#editListBox input[type=checkbox]:checked').each(function()
        {
            var checkbox = $(this);
            $('#viewuser' + checkbox.val()).find('input').prop('checked', 'checked');
        });
    }
    if(acl == 'custom')
    {
        /* show tr. */
        $('#whitelistBox').removeClass('hidden');
        $('#viewListBox').removeClass('hidden');
        $('#editListBox').removeClass('hidden');
        /* hide all checkbox */
        $('#viewListBox label.checkbox, #editListBox label.checkbox').addClass('hidden');
        /* show checked group's user. */
        $('#whitelistBox input[type=checkbox]:checked').each(function()
        {
            var groupID = $(this).val();
            $('label.checkbox.group-' + groupID).removeClass('hidden');
        });
        /* show team users. */
        $('label.checkbox.in-team').removeClass('hidden');
        /* unchecked hidden checkbox. */
        $('label.checkbox.hidden').each(function()
        {
            $(this).find('input').prop('checked', '');
        });
        /* check viewList if editList checked. */
        $('#editListBox input[type=checkbox]:checked').each(function()
        {
            var checkbox = $(this);
            $('#viewuser' + checkbox.val()).find('input').prop('checked', 'checked');
        });
    }
    /* check all checkbox. */
    if(clickObj.prop('name') == 'acl')
    {
        $('#editListBox label.checkbox, #viewListBox label.checkbox').each(function()
        {
            var checkbox = $(this);
            if(!checkbox.hasClass('hidden')) checkbox.find('input').prop('checked', 'checked');
        });
    }
}
$(document).ready(function(){updateChecked()});
