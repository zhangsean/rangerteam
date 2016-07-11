<?php
if(!isset($comfig->refund)) $config->refund = new stdclass();
$config->refund->require = new stdclass();
$config->refund->require->create = 'name,money';
$config->refund->require->edit   = 'name,money';

$config->refund->list = new stdclass();
$config->refund->list->exportFields = 'id, name, category, date, money, currency, desc, 
related, status, createdBy, createdDate, editedBy, editedDate, firstReviewer, 
firstReviewDate, secondReviewer, secondReviewDate, refundBy, refundDate, reason';
