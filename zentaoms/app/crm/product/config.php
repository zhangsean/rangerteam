<?php
$config->product->require = new stdclass();
$config->product->require->create = 'name, code';
$config->product->require->edit   = 'name, code';

$config->field = new stdclass();
$config->field->require = new stdclass();
$config->field->require->create = 'name, field, product, control';
$config->field->require->edit   = 'name, field, product, control';

$config->field->controlTypeList = array();
$config->field->controlTypeList['input']    = 'varchar(200)';
$config->field->controlTypeList['textarea'] = 'text';
$config->field->controlTypeList['date']     = 'date';
$config->field->controlTypeList['datetime'] = 'datetime';
$config->field->controlTypeList['select']   = 'varchar(200)';
$config->field->controlTypeList['radio']    = 'varchar(200)';
$config->field->controlTypeList['checkbox'] = 'varchar(200)';
