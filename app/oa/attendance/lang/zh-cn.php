<?php
if(!isset($lang->attendance)) $lang->attendance = new stdclass();
$lang->attendance->common     = '考勤';
$lang->attendance->personal   = '我的考勤';
$lang->attendance->department = '部门考勤';
$lang->attendance->company    = '公司考勤';
$lang->attendance->settings   = '设置';

$lang->attendance->id       = '编号';
$lang->attendance->signIn   = '签到';
$lang->attendance->signOut  = '签退';
$lang->attendance->date     = '日期';
$lang->attendance->status   = '状态';
$lang->attendance->account  = '用户';
$lang->attendance->extra    = '其他信息';
$lang->attendance->dayName  = '星期';
$lang->attendance->report   = '考勤表';

$lang->attendance->statusList['normal'] = '';
$lang->attendance->statusList['late'] = '';
$lang->attendance->statusList['early'] = '';
$lang->attendance->statusList['lateEarly'] = '';
$lang->attendance->statusList[''] = '';
$lang->attendance->statusList[] = '';
$lang->attendance->statusList[] = '';
$lang->attendance->statusList[] = '';
$lang->attendance->statusList[] = '';

$lang->attendance->signInSuccess  = '签到成功';
$lang->attendance->signInFail     = '签到失败';
$lang->attendance->signOutSuccess = '签退成功';
$lang->attendance->signOutFail    = '签退失败';

$lang->attendance->latestSignInTime    = '最晚签到时间';
$lang->attendance->earliestSignOutTime = '最早签退时间';
$lang->attendance->workingDaysPerWeek  = '每周工作天数';
$lang->attendance->forcedSignOut       = '必须签退';

$lang->attendance->workingDaysPerWeekList['5'] = "周一～周五";
$lang->attendance->workingDaysPerWeekList['6'] = "周一～周六";

$lang->attendance->forcedSignOutList['yes'] = '需要';
$lang->attendance->forcedSignOutList['no']  = '不需要';

$lang->attendance->weeks = array('第一周', '第二周', '第三周', '第四周', '第五周');
