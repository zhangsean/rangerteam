<?php
/**
 * The product category zh-cn file of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$lang->field  = new stdclass();
$lang->field->name        = '名称';
$lang->field->type        = '类型';
$lang->field->field       = '字段名';
$lang->field->options     = '可选值';
$lang->field->control     = '控件';
$lang->field->default     = '默认值';
$lang->field->rules       = '验证规则';
$lang->field->desc        = '描述';
$lang->field->placeholder = '提示文字';

$lang->field->browse  = '属性列表';
$lang->field->create  = '添加属性';

$lang->field->controlTypeList = array();
$lang->field->controlTypeList['input']    = '文本框';
$lang->field->controlTypeList['textarea'] = '富文本';
$lang->field->controlTypeList['date']     = '日期';
$lang->field->controlTypeList['datetime'] = '时间';
$lang->field->controlTypeList['select']   = '下拉菜单';
$lang->field->controlTypeList['radio']    = '单选按钮';
$lang->field->controlTypeList['checkbox'] = '复选框';

$lang->field->rulesList = array();
$lang->field->rulesList['require'] = '必填';
$lang->field->rulesList['unique']  = '唯一';
$lang->field->rulesList['date']    = '日期';
$lang->field->rulesList['email']   = 'email';
$lang->field->rulesList['number']  = '数字';
$lang->field->rulesList['phone']   = '电话';
$lang->field->rulesList['ip']      = 'IP';

$lang->field->optionsPlaceholder = '多个值之间用空格或逗号隔开';
