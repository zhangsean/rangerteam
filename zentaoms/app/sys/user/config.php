<?php
$config->user->register = new stdclass();
$config->user->register->requiredFields = 'account,realname,email,password1,role';

$config->user->edit = new stdclass();
$config->user->edit->requiredFields = 'realname,email,role';

$config->user->create = new stdclass();
$config->user->create->requiredFields = $config->user->register->requiredFields;

$config->user->default = new stdclass();
$config->user->default->module = RUN_MODE == 'front' ? 'index' : 'admin';
$config->user->default->method = RUN_MODE == 'front' ? 'index' : 'index';
