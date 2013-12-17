$(document).ready(function()
{
    /* Set current active topNav. */
    if(v.path && v.path.length)
    {
        $.each(eval(v.path), function(index, category) 
        { 
            $('.nav-blog-' + category).addClass('active');
        })
    }

   if(typeof(v.categoryID) != 'undefined') $('.tree #category' + v.categoryID).addClass('active');
});
