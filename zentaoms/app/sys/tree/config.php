<?php
$config->tree->edit = new stdclass();
$config->tree->edit->requiredFields = 'name';

$config->tree->editor = new stdclass();
$config->tree->editor->edit = array('id' => 'desc', 'tools' => 'simpleTools');

$config->tree->systemModules  = ',admin,block,book,captcha,company,file,index,links,message,';
$config->tree->systemModules .= 'nav,product,rss,site,slide,thread,ui,user,article,blog,cache,';
$config->tree->systemModules .= 'common,error,forum,install,mail,misc,page,reply,setting,sitemap,tag,tree,upgrade,';
