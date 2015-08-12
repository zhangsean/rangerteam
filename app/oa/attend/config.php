<?php
if(!isset($comfig->attend)) $config->attend = new stdclass();
$config->attend->latestSignInTime    = '10:00:00';
$config->attend->earliestSignOutTime = '17:00:00';
$config->attend->workingDaysPerWeek  = '5';
$config->attend->forcedSignOut       = 'yes';
