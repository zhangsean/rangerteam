<?php
$config->todo = new stdclass();
$config->todo->batchCreate = 8;

$config->todo->require = new stdclass();
$config->todo->require->create = 'name';
$config->todo->require->edit   = 'name';

$config->todo->dates = new stdclass();
$config->todo->dates->end = 15;

$config->todo->times = new stdclass();
$config->todo->times->begin = 6;
$config->todo->times->end   = 23;
$config->todo->times->delta = 10;

$config->todo->editor = new stdclass();
$config->todo->editor->create = array('id' => 'desc', 'tools' => 'simple');
$config->todo->editor->edit   = array('id' => 'desc', 'tools' => 'simple');

$config->todo->list = new stdclass();
$config->todo->list->exportFields = 'id, account, date, begin, end, type, idvalue, pri, name, desc, status, private'; 

$config->todo->calendarColor['custom']   = '#EA644A';
$config->todo->calendarColor['task']     = '#f1a325';
$config->todo->calendarColor['order']    = '#03b8cf';
$config->todo->calendarColor['customer'] = '#bd7b46';
$config->todo->calendarColor['attend']   = '#8666b8';
$config->todo->calendarColor['leave']    = '#8666b8';
