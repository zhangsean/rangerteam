<?php
public static function createDeptLink($category)
{
    return html::a(helper::createLink('user', 'admin', "deptID={$category->id}"), $category->name, "id='category{$category->id}'");
}
