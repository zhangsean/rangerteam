<?php
$config->user->register->requiredFields .= ',role';

$config->user->create = new stdclass();
$config->user->create->requiredFields = $config->user->register->requiredFields;

$config->user->edit->requiredFields .= ',role';

$config->user->default = new stdclass();
$config->user->default->module = RUN_MODE == 'front' ? 'index' : 'admin';
$config->user->default->method = RUN_MODE == 'front' ? 'index' : 'index';
