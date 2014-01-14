<?php
$config->tree->require = new stdclass();
$config->tree->require->edit = 'name';

$config->tree->editor = new stdclass();
$config->tree->editor->edit = array('id' => 'desc', 'tools' => 'simple');

$config->tree->systemModules  = ',admin,block,book,company,file,index,message,';
$config->tree->systemModules .= 'product,rss,thread,user,article,blog,';
$config->tree->systemModules .= 'common,error,forum,install,mail,misc,reply,setting,upgrade,';
