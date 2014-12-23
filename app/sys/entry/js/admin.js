/* refresh entries. */
$(document).ready(function()
{
    if(v.entries) 
    {
        $.refreshDesktop(v.entries, true);
    }
})
