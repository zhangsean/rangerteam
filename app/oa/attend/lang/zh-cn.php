<?php
if(!isset($lang->attend)) $lang->attend = new stdclass();
$lang->attend->common     = '考勤';
$lang->attend->personal   = '我的考勤';
$lang->attend->department = '部门考勤';
$lang->attend->company    = '公司考勤';
$lang->attend->settings   = '设置';

$lang->attend->id       = '编号';
$lang->attend->signIn   = '签到';
$lang->attend->signOut  = '签退';
$lang->attend->date     = '日期';
$lang->attend->status   = '状态';
$lang->attend->account  = '用户';
$lang->attend->extra    = '其他信息';
$lang->attend->dayName  = '星期';
$lang->attend->report   = '考勤表';

$lang->attend->statusList['normal'] = '';
$lang->attend->statusList['late'] = '';
$lang->attend->statusList['early'] = '';
$lang->attend->statusList['lateEarly'] = '';
$lang->attend->statusList[''] = '';
$lang->attend->statusList[] = '';
$lang->attend->statusList[] = '';
$lang->attend->statusList[] = '';
$lang->attend->statusList[] = '';

$lang->attend->inSuccess  = '签到成功';
$lang->attend->inFail     = '签到失败';
$lang->attend->outSuccess = '签退成功';
$lang->attend->outFail    = '签退失败';

$lang->attend->signInLimit  = '最晚签到时间';
$lang->attend->signOutLimit = '最早签退时间';
$lang->attend->workingDays  = '每周工作天数';
$lang->attend->mustSignOut  = '必须签退';

$lang->attend->workingDaysList['5'] = "周一～周五";
$lang->attend->workingDaysList['6'] = "周一～周六";

$lang->attend->mustSignOutList['yes'] = '需要';
$lang->attend->mustSignOutList['no']  = '不需要';

$lang->attend->weeks = array('第一周', '第二周', '第三周', '第四周', '第五周');
