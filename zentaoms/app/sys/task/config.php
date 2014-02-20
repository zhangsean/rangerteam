<?php
$config->task->require = new stdclass();
$config->task->require->create = 'name, customer, order';
$config->task->require->edit   = 'name, customer, order';

$config->task->editor = new stdclass();
$config->task->editor->create = array('id' => 'desc', 'tools' => 'simple');
$config->task->editor->edit   = array('id' => 'desc', 'tools' => 'simple');
