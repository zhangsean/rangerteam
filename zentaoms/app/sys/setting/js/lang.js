
/**
 * Add lang item.
 * 
 * @param  string $clickedButton 
 * @access public
 * @return void
 */
function addItem(clickedButton)
{
    $(clickedButton).parent().parent().after(v.itemRow);
}

/**
 * Delete lang item.
 * 
 * @param  string $clickedButton 
 * @access public
 * @return void
 */
function delItem(clickedButton)
{
    $(clickedButton).parent().parent().remove();
}
$(function()
{
    $('#' + v.module + 'Tab').addClass('active');
})
