<?php
$config->order->require = new stdclass();
$config->order->require->create = 'product';
$config->order->require->edit   = 'product';

$config->order->editor = new stdclass();
$config->order->editor->close = array('id' => 'closedNote', 'tools' => 'simple');
