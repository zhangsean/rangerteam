<?php
if(!isset($lang->attend)) $lang->attend = new stdclass();
$lang->attend->common       = 'Attend';
$lang->attend->personal     = 'My Attend';
$lang->attend->department   = 'Department attend';
$lang->attend->company      = 'Company attend';
$lang->attend->detail       = 'Detail attend';
$lang->attend->edit         = 'Manual sign';
$lang->attend->edited       = 'Signed in';
$lang->attend->leave        = 'Leave';
$lang->attend->leaved       = 'Already leave';
$lang->attend->lieu         = 'Lieu';
$lang->attend->lieud        = 'Already lieu';
$lang->attend->trip         = 'Trip';
$lang->attend->egress       = 'Egress';
$lang->attend->overtime     = 'Overtime';
$lang->attend->overtimed    = 'Already overtime';
$lang->attend->review       = 'Review attendance';
$lang->attend->settings     = 'Setting';
$lang->attend->export       = 'Export';
$lang->attend->stat         = 'Stat';
$lang->attend->saveStat     = 'Save Stat';
$lang->attend->exportStat   = 'Export Stat';
$lang->attend->detail       = 'Detail Attends';
$lang->attend->exportDetail = 'Export Detail Attends';
$lang->attend->browseReview = 'Review List';

$lang->attend->id            = 'ID';
$lang->attend->date          = 'Date';
$lang->attend->account       = 'User';
$lang->attend->signIn        = 'Sign in';
$lang->attend->signOut       = 'Sign out';
$lang->attend->status        = 'Status';
$lang->attend->ip            = 'IP';
$lang->attend->device        = 'Device';
$lang->attend->desc          = 'description';
$lang->attend->dayName       = 'Day name';
$lang->attend->report        = 'Report';
$lang->attend->AM            = 'AM';
$lang->attend->PM            = 'PM';
$lang->attend->ipList        = 'IP List';
$lang->attend->noAttendUsers = 'Users Without Attendance';

$lang->attend->user          = 'User';
$lang->attend->begin         = 'Begin';
$lang->attend->end           = 'End';
$lang->attend->search        = 'Search';

$lang->attend->manualIn     = 'Manual sign in';
$lang->attend->manualOut    = 'Manual sign out';
$lang->attend->reason       = 'Reason';
$lang->attend->reviewStatus = 'Review status';
$lang->attend->reviewedBy   = 'Reviewed By';
$lang->attend->reviewedDate = 'Reviewed Date';
$lang->attend->deserveDays  = 'Deserved Days';
$lang->attend->actualDays   = 'Actual Days';

$lang->attend->statusList['normal']   = 'Normal';
$lang->attend->statusList['late']     = 'Late';
$lang->attend->statusList['early']    = 'Leave early';
$lang->attend->statusList['both']     = 'Late and Leave early';
$lang->attend->statusList['absent']   = 'Absent';
$lang->attend->statusList['leave']    = 'Ask for leave';
$lang->attend->statusList['trip']     = 'Biz trip';
$lang->attend->statusList['egress']   = 'Biz egress';
$lang->attend->statusList['rest']     = 'Rest day';
$lang->attend->statusList['overtime'] = 'Overtime';
$lang->attend->statusList['lieu']     = 'Lieu';

$lang->attend->abbrStatusList['normal']   = '√';
$lang->attend->abbrStatusList['late']     = 'Late';
$lang->attend->abbrStatusList['early']    = 'Early';
$lang->attend->abbrStatusList['both']     = 'L+E';
$lang->attend->abbrStatusList['absent']   = 'Absent';
$lang->attend->abbrStatusList['leave']    = 'Leave';
$lang->attend->abbrStatusList['trip']     = 'Biz';
$lang->attend->abbrStatusList['egress']   = 'Out';
$lang->attend->abbrStatusList['rest']     = 'Rest';
$lang->attend->abbrStatusList['overtime'] = 'Over';
$lang->attend->abbrStatusList['lieu']     = 'Lieu';

$lang->attend->markStatusList['normal']   = '√';
$lang->attend->markStatusList['late']     = '=';
$lang->attend->markStatusList['early']    = '>';
$lang->attend->markStatusList['both']     = '=>';
$lang->attend->markStatusList['absent']   = 'x';
$lang->attend->markStatusList['leave']    = '!';
$lang->attend->markStatusList['trip']     = '$';
$lang->attend->markStatusList['egress']   = '#';
$lang->attend->markStatusList['rest']     = '~';
$lang->attend->markStatusList['overtime'] = '+';
$lang->attend->markStatusList['lieu']     = '↓';

$lang->attend->reasonList['normal'] = 'Normal';
$lang->attend->reasonList['trip']   = 'Biz trip';
$lang->attend->reasonList['egress'] = 'Biz egress';
$lang->attend->reasonList['leave']  = 'Ask for leave';
$lang->attend->reasonList['lieu']   = 'Lieu';

$lang->attend->reviewStatusList['wait']   = 'Wait';
$lang->attend->reviewStatusList['pass']   = 'Pass';
$lang->attend->reviewStatusList['reject'] = 'Reject';

$lang->attend->inSuccess  = 'Signed in.';
$lang->attend->inFail     = 'Signin failed.';
$lang->attend->outSuccess = 'Signed out.';
$lang->attend->outFail    = 'Signout failed.';

$lang->attend->signInLimit  = 'Latest time of sign in';
$lang->attend->signOutLimit = 'Earlies time of sign out';
$lang->attend->workingDays  = 'Working days per week';
$lang->attend->workingHours = 'Working hours per day';
$lang->attend->mustSignOut  = 'Required Signout';

$lang->attend->workingDaysList['5']  = "Monday ~ Friday";
$lang->attend->workingDaysList['6']  = "Monday ~ Saturday";
$lang->attend->workingDaysList['7']  = "Monday ~ Sunday";
$lang->attend->workingDaysList['12'] = "Sunday ~ Thursday";
$lang->attend->workingDaysList['13'] = "Sunday ~ Friday";

$lang->attend->mustSignOutList['yes'] = 'Yes';
$lang->attend->mustSignOutList['no']  = 'No';

$lang->attend->weeks = array('First week', 'Second week', 'Third week', 'Fourth week', 'Fifth week', 'Sixth week');

$lang->attend->notice['today']    = "<p>Your attendance yesterday was %s, <a href='%s' %s> Click here to edit.</a></p>";
$lang->attend->notice['yestoday'] = "<p>Your attendance today is %s, <a href='%s' %s> Click here to edit.</a></p>";
$lang->attend->notice['absent']   = "No record";

$lang->attend->confirmReview['pass']   = 'Do you want to pass it?';
$lang->attend->confirmReview['reject'] = 'Do you want to reject it?';

$lang->attend->settings   = 'Normal Settings';
$lang->attend->setManager = 'Department Manager Settings';
$lang->attend->setDept    = 'Set Department';

$lang->attend->note = new stdClass();
$lang->attend->note->ip       = "Use commas to separate IPs, and IP segment is OK, e.g. 192.168.1.*";
$lang->attend->note->allip    = 'All IP';
$lang->attend->note->IPDenied = 'IP denied.';

$lang->attend->h = 'hours';
$lang->attend->m = 'minutes';
$lang->attend->s = 'seconds';
