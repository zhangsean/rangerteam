<?php
if(!isset($lang->attend)) $lang->attend = new stdclass();
$lang->attend->common     = 'Attend';
$lang->attend->personal   = 'My Attend';
$lang->attend->department = 'Department attend';
$lang->attend->company    = 'Company attend';
$lang->attend->settings   = 'Setting';

$lang->attend->id       = 'ID';
$lang->attend->signIn   = 'Sign in';
$lang->attend->signOut  = 'Sign out';
$lang->attend->date     = 'Date';
$lang->attend->status   = 'Status';
$lang->attend->account  = 'User';
$lang->attend->extra    = 'Other info';
$lang->attend->dayName  = 'Day name';
$lang->attend->report   = 'Report';

$lang->attend->statusList['normal'] = 'Normal';
$lang->attend->statusList['late']   = 'Late';
$lang->attend->statusList['early']  = 'Leave early';
$lang->attend->statusList['both']   = 'Late and Leave early';
$lang->attend->statusList['absent'] = 'Absent';
$lang->attend->statusList['leave']  = 'Ask for leave';
$lang->attend->statusList['trip']   = 'Biz trip';
$lang->attend->statusList['rest']   = 'Rest day';

$lang->attend->reasonlist['normal'] = 'Normal';
$lang->attend->reasonlist['trip']   = 'Biz trip';
$lang->attend->reasonlist['leave']  = 'Ask for leave';

$lang->attend->reviewList['wait']   = 'Wait';
$lang->attend->reviewList['pass']   = 'Pass';
$lang->attend->reviewList['reject'] = 'Reject';

$lang->attend->inSuccess  = 'Sign in success';
$lang->attend->outSuccess = 'Sign out success';
$lang->attend->inFail     = 'Sign in fail';
$lang->attend->outFail    = 'Sign out fail';

$lang->attend->signInLimit  = 'Latest time of sign in';
$lang->attend->signOutLimit = 'Earlies time of sign out';
$lang->attend->workingDays  = 'Working days per week';
$lang->attend->mustSignOut  = 'Must sign out';

$lang->attend->workingDaysList['5'] = "Monday ~ Friday";
$lang->attend->workingDaysList['6'] = "Monday ~ Saturday";

$lang->attend->mustSignOutList['yes'] = 'need';
$lang->attend->mustSignOutList['no']  = 'not need';

$lang->attend->weeks = array('First week', 'Second week', 'Third week', 'Fourth week', 'Fifth week');
