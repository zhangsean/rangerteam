/**
 * Set role when select an account.
 * 
 * @param  string $account 
 * @param  int    $roleID 
 * @access public
 * @return void
 */
$(document).ready(function()
{
    $('.account').change(function()
    {
        account = $(this).val();
        r = eval('v.userRoles.' + account);
        $(this).parent().next().find('.role').val(v.roles[r]);
    });
});
