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

$lang->attend->statusList['normal'] = '正常';
$lang->attend->statusList['late']   = '迟到';
$lang->attend->statusList['early']  = '早退';
$lang->attend->statusList['both']   = '迟到+早退';
$lang->attend->statusList['absent'] = '矿工';
$lang->attend->statusList['leave']  = '请假';
$lang->attend->statusList['trip']   = '出差';
$lang->attend->statusList['rest']   = '假期';

$lang->attend->reasonlist['normal'] = '正常';
$lang->attend->reasonlist['trip']   = '出差';
$lang->attend->reasonlist['leave']  = '请假';

$lang->attend->reviewList['wait']   = '等待审核';
$lang->attend->reviewList['pass']   = '批准';
$lang->attend->reviewList['reject'] = '拒绝';

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
