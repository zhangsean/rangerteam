<?php
$config->book->imgMaxWidth = 950;

$config->book->require = new stdclass();
$config->book->require->book = 'title, alias';
$config->book->require->node = 'title';

$config->book->editor = new stdclass();
$config->book->editor->edit = array('id' => 'content', 'tools' => 'simpleTools');
