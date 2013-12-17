<?php
$lang->dept = new stdclass();
$lang->dept->common     = '部门结构';
$lang->dept->edit       = '维护部门结构';
$lang->dept->children   = '子部门';
$lang->dept->moderators = '部门经理';

$lang->dept->menu[] = "会员列表|user|admin";
$lang->dept->menu[] = "部门结构|tree|browse|type=dept";

$lang->user->create = '创建用户';

$lang->user->dept = '所属部门';
$lang->user->role = '角色';

$lang->user->roleList['']       = ''; 
$lang->user->roleList['dev']    = '研发';
$lang->user->roleList['qa']     = '测试';
$lang->user->roleList['pm']     = '项目经理';
$lang->user->roleList['po']     = '产品经理';
$lang->user->roleList['td']     = '研发主管';
$lang->user->roleList['pd']     = '产品主管';
$lang->user->roleList['qd']     = '测试主管';
$lang->user->roleList['top']    = '高层管理';
$lang->user->roleList['others'] = '其他';
