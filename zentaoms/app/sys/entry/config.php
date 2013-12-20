<?php
$config->entry                         = new stdclass();
$config->entry->create                 = new stdclass();
$config->entry->create->requiredFields = 'name,code,openMode,key,ip,login';
$config->entry->edit                   = new stdclass();
$config->entry->edit->requiredFields   = 'name,openMode,key,ip,login';
