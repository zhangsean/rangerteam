<?php
if(!isset($lang->attendance)) $lang->attendance = new stdclass();
$lang->attendance->common     = 'Attendance';
$lang->attendance->personal   = 'My Attendance';
$lang->attendance->department = 'Department attendance';
$lang->attendance->company    = 'Company attendance';
$lang->attendance->settings   = 'Setting';

$lang->attendance->id       = 'ID';
$lang->attendance->signIn   = 'Sign in';
$lang->attendance->signOut  = 'Sign out';
$lang->attendance->date     = 'Date';
$lang->attendance->status   = 'Status';
$lang->attendance->account  = 'User';
$lang->attendance->extra    = 'Other info';
$lang->attendance->dayName  = 'Day name';
$lang->attendance->report   = 'Report';

$lang->attendance->signInSuccess  = 'Sign in success';
$lang->attendance->signOutSuccess = 'Sign out success';
$lang->attendance->signInFail     = 'Sign in fail';
$lang->attendance->signOutFail    = 'Sign out fail';

$lang->attendance->latestSignInTime    = 'Latest time of sign in';
$lang->attendance->earliestSignOutTime = 'Earlies time of sign out';
$lang->attendance->workingDaysPerWeek  = 'Working days per week';
$lang->attendance->forcedSignOut       = 'Must sign out';

$lang->attendance->workingDaysPerWeekList['5'] = "Monday ~ Friday";
$lang->attendance->workingDaysPerWeekList['6'] = "Monday ~ Saturday";

$lang->attendance->forcedSignOutList['yes'] = 'need';
$lang->attendance->forcedSignOutList['no']  = 'not need';

$lang->attendance->weeks = array('First week', 'Second week', 'Third week', 'Fourth week', 'Fifth week');
