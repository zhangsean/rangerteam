<?php
$config->effort         = new stdclass();
$config->effort->create = new stdclass();
$config->effort->edit   = new stdclass();
$config->effort->times  = new stdclass();
$config->effort->list   = new stdclass();

$config->effort->create->requiredFields = 'work';
$config->effort->edit->requiredFields   = 'work';
$config->effort->times->delta           = 10;

$config->effort->list->exportFields = 'id, account, date, consumed, objectType, work'; 

$config->effort->objectTables['task']     = TABLE_TASK;
$config->effort->objectTables['order']    = TABLE_ORDER;
$config->effort->objectTables['contract'] = TABLE_CONTRACT;
