<?php
unset($lang->menu->product);
unset($lang->menu->comment);
unset($lang->menu->site);
unset($lang->menu->blog);
unset($lang->menu->forum);
unset($lang->menu->ui);

$lang->menu->entry = '应用|entry|admin|';

$lang->entry       = new stdclass();
$lang->entry->menu = new stdclass();
$lang->entry->menu->admin  = array('link' => '应用列表|entry|admin|', 'alias' => 'edit');
$lang->entry->menu->create = array('link' => '添加应用|entry|create|');

$lang->chanzhiEPS = '蝉知企业内部门户 ';
