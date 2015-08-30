<?php
if(!isset($lang->attend)) $lang->attend = new stdclass();
$lang->attend->common       = '考勤';
$lang->attend->personal     = '我的考勤';
$lang->attend->department   = '部门考勤';
$lang->attend->company      = '公司考勤';
$lang->attend->edit         = '补录';
$lang->attend->review       = '补录审核';
$lang->attend->settings     = '设置';
$lang->attend->export       = '导出';
$lang->attend->browseReview = '补录列表';

$lang->attend->id       = '编号';
$lang->attend->date     = '日期';
$lang->attend->account  = '用户';
$lang->attend->signIn   = '签到';
$lang->attend->signOut  = '签退';
$lang->attend->status   = '状态';
$lang->attend->ip       = 'IP';
$lang->attend->device   = '设备';
$lang->attend->desc     = '描述';
$lang->attend->dayName  = '星期';
$lang->attend->report   = '考勤表';

$lang->attend->manualIn     = '签到时间';
$lang->attend->manualOut    = '签退时间';
$lang->attend->reason       = '原因';
$lang->attend->reviewStatus = '补录状态';
$lang->attend->reviewedBy   = '审核人';
$lang->attend->reviewedDate = '审核时间';

$lang->attend->statusList['normal'] = '正常';
$lang->attend->statusList['late']   = '迟到';
$lang->attend->statusList['early']  = '早退';
$lang->attend->statusList['both']   = '迟到+早退';
$lang->attend->statusList['absent'] = '旷工';
$lang->attend->statusList['leave']  = '请假';
$lang->attend->statusList['trip']   = '出差';
$lang->attend->statusList['rest']   = '休息日';

$lang->attend->abbrStatusList['normal'] = '√';
$lang->attend->abbrStatusList['late']   = '迟';
$lang->attend->abbrStatusList['early']  = '早';
$lang->attend->abbrStatusList['both']   = '迟+早';
$lang->attend->abbrStatusList['absent'] = '旷';
$lang->attend->abbrStatusList['leave']  = '假';
$lang->attend->abbrStatusList['trip']   = '差';
$lang->attend->abbrStatusList['rest']   = '休';

$lang->attend->reasonList['normal'] = '正常';
$lang->attend->reasonList['trip']   = '出差';
$lang->attend->reasonList['leave']  = '请假';

$lang->attend->reviewStatusList['wait']   = '等待审核';
$lang->attend->reviewStatusList['pass']   = '通过';
$lang->attend->reviewStatusList['reject'] = '拒绝';

$lang->attend->inSuccess  = '签到成功';
$lang->attend->inFail     = '签到失败';
$lang->attend->outSuccess = '签退成功';
$lang->attend->outFail    = '签退失败';

$lang->attend->signInLimit  = '上班时间';
$lang->attend->signOutLimit = '下班时间';
$lang->attend->workingDays  = '每周工作天数';
$lang->attend->mustSignOut  = '必须签退';

$lang->attend->workingDaysList['5'] = "周一～周五";
$lang->attend->workingDaysList['6'] = "周一～周六";

$lang->attend->mustSignOutList['yes'] = '需要';
$lang->attend->mustSignOutList['no']  = '不需要';

$lang->attend->weeks = array('第一周', '第二周', '第三周', '第四周', '第五周');

$lang->attend->notice['today']    = "您今天的考勤状态为：%s。<a href='%s' %s>去补录</a>";
$lang->attend->notice['yestoday'] = "您昨天的考勤状态为：%s。<a href='%s' %s>去补录</a>";

$lang->attend->confirmReview['pass']   = '您确定要执行通过操作吗？';
$lang->attend->confirmReview['reject'] = '您确定要执行拒绝操作吗？';
