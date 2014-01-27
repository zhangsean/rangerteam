<?php
$config->order->require = new stdclass();
$config->order->require->create = 'product';
$config->order->require->edit   = 'product';

$config->order->editor = new stdclass();
$config->order->editor->close = array('id' => 'closedNote', 'tools' => 'simple');

$config->order->commonFields = array();
$config->order->commonFields['plan'] = new stdclass();
$config->order->commonFields['plan']->field   = 'plan';
$config->order->commonFields['plan']->control = 'input';

$config->order->commonFields['real'] = new stdclass();
$config->order->commonFields['real']->field   = 'real';
$config->order->commonFields['real']->control = 'input';

$config->order->commonFields['status'] = new stdclass();
$config->order->commonFields['status']->field   = 'status';
$config->order->commonFields['status']->control = 'select';
global $lang;
$config->order->commonFields['status']->options = join(',', array_values($lang->order->statusList));

$config->order->commonFields['assignedTo'] = new stdclass();
$config->order->commonFields['assignedTo']->field   = 'assignedTo';
$config->order->commonFields['assignedTo']->control = 'input';

$config->order->commonFields['assignedBy'] = new stdclass();
$config->order->commonFields['assignedBy']->field   = 'assignedBy';
$config->order->commonFields['assignedBy']->control = 'input';

$config->order->commonFields['signedBy'] = new stdclass();
$config->order->commonFields['signedBy']->field   = 'signedBy';
$config->order->commonFields['signedBy']->control = 'input';

$config->order->commonFields['signedDate'] = new stdclass();
$config->order->commonFields['signedDate']->field   = 'signedDate';
$config->order->commonFields['signedDate']->control = 'input';

$config->order->commonFields['payedDate'] = new stdclass();
$config->order->commonFields['payedDate']->field   = 'payedDate';
$config->order->commonFields['payedDate']->control = 'input';

$config->order->commonFields['closedBy'] = new stdclass();
$config->order->commonFields['closedBy']->field   = 'closedBy';
$config->order->commonFields['closedBy']->control = 'input';

$config->order->commonFields['closedDate'] = new stdclass();
$config->order->commonFields['closedDate']->field   = 'closedDate';
$config->order->commonFields['closedDate']->control = 'input';

$config->order->commonFields['closedReason'] = new stdclass();
$config->order->commonFields['closedReason']->field   = 'closedReason';
$config->order->commonFields['closedReason']->control = 'input';

$config->order->commonFields['closedNote'] = new stdclass();
$config->order->commonFields['closedNote']->field   = 'closedNote';
$config->order->commonFields['closedNote']->control = 'input';

$config->order->commonFields['activatedBy'] = new stdclass();
$config->order->commonFields['activatedBy']->field   = 'activatedBy';
$config->order->commonFields['activatedBy']->control = 'input';

$config->order->commonFields['activatedDate'] = new stdclass();
$config->order->commonFields['activatedDate']->field   = 'activatedDate';
$config->order->commonFields['activatedDate']->control = 'input';

$config->order->commonFields['contactedBy'] = new stdclass();
$config->order->commonFields['contactedBy']->field   = 'contactedBy';
$config->order->commonFields['contactedBy']->control = 'input';

$config->order->commonFields['contactedDate'] = new stdclass();
$config->order->commonFields['contactedDate']->field   = 'contactedDate';
$config->order->commonFields['contactedDate']->control = 'input';

$config->order->conditionFields = array('plan', 'real', 'status', 'assignedDate', 'signedDate', 'payedDate', 'closedDate', 'closedReason', 'activatedDate', 'contactedDate');
