<?php
/**
 * The project module zh-cn file of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     project
 * @version     $Id: zh-cn.php 824 2010-05-02 15:32:06Z wwccss $
 * @link        http://www.ranzhico.com
 */
if(!isset($lang->project)) $lang->project = new stdclass();
$lang->project->common     = '项目视图';
$lang->project->browse     = '项目列表';
$lang->project->index      = '项目首页';
$lang->project->create     = "创建项目";
$lang->project->edit       = '修改项目';
$lang->project->finish     = '完成项目';
$lang->project->delete     = '删除项目';
$lang->project->enter      = '进入';
$lang->project->suspend    = '挂起';
$lang->project->activate   = '激活';
$lang->project->mine       = '我负责:';
$lang->project->other      = '其他：';
$lang->project->deleted    = '已删除';
$lang->project->finished   = '已结束';
$lang->project->suspended  = '已挂起';
$lang->project->noMatched  = '找不到包含"%s"的项目';
$lang->project->search     = '搜索';
$lang->project->import     = '导入';
$lang->project->importTask = '导入任务';

$lang->project->id          = '编号';
$lang->project->name        = '项目名称';
$lang->project->desc        = '项目描述';
$lang->project->begin       = '开始日期';
$lang->project->manager     = '负责人';
$lang->project->member      = '团队';
$lang->project->end         = '结束日期';
$lang->project->createdBy   = '由谁创建';
$lang->project->createdDate = '创建时间';
$lang->project->fromproject = '所属项目';
$lang->project->acl         = '访问权限';
$lang->project->whitelist   = '白名单';
$lang->project->privilege   = '权限';
$lang->project->viewTask    = '查看全部';
$lang->project->editTask    = '编辑全部';
$lang->project->task        = '任务权限';

$lang->project->confirm = new stdclass();
$lang->project->confirm->activate = '确认激活此项目？';
$lang->project->confirm->suspend  = '确认挂起此项目？';

$lang->project->activateSuccess = '激活操作成功';
$lang->project->suspendSuccess  = '挂起操作成功';
$lang->project->selectProject   = '请选择项目';

$lang->project->note = new stdclass();
$lang->project->note->rate = '按工时计算';
$lang->project->note->task = '任务数';

$lang->project->aclList['open']    = '默认设置(有项目视图权限，即可访问)';
$lang->project->aclList['private'] = '私有项目(只有项目团队成员才能访问)';
$lang->project->aclList['custom']  = '自定义白名单(团队成员和白名单的成员可以访问)';
