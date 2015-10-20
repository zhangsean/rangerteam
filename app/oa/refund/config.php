<?php
if(!isset($comfig->refund)) $config->refund = new stdclass();
$config->refund->require = new stdclass();
$config->refund->require->create = 'name,date,money';
