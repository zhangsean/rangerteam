<?php
$config->block->allowedTags = $config->allowedTags->admin . '<script><style><object><param><embed><form><button>';

$config->block->editor = new stdclass();
$config->block->editor->create = array('id' => 'content', 'tools' => 'fullTools');
$config->block->editor->edit   = array('id' => 'content', 'tools' => 'fullTools');
