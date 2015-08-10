<?php
if(!isset($comfig->attendance)) $config->attendance = new stdclass();
$config->attendance->latestSignInTime    = '10:00:00';
$config->attendance->earliestSignOutTime = '17:00:00';
$config->attendance->workingDaysPerWeek  = '5';
$config->attendance->forcedSignOut       = 'yes';
