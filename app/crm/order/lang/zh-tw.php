<?php
/**
 * The order module zh-tw file of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     order
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
if(!isset($lang->order)) $lang->order = new stdclass();
$lang->order->common         = '訂單';
$lang->order->id             = '編號';
$lang->order->name           = '名稱';
$lang->order->product        = '產品';
$lang->order->customer       = '客戶';
$lang->order->contact        = '聯繫人';
$lang->order->team           = '團隊';
$lang->order->currency       = '貨幣類型';
$lang->order->plan           = '計劃金額';
$lang->order->real           = '成交金額';
$lang->order->amount         = '金額';
$lang->order->status         = '狀態';
$lang->order->createdBy      = '由誰創建';
$lang->order->createdDate    = '創建時間';
$lang->order->assignedTo     = '指派給';
$lang->order->assignedBy     = '由誰指派';
$lang->order->assignedDate   = '指派時間';
$lang->order->signedBy       = '由誰簽單';
$lang->order->signedDate     = '簽單時間';
$lang->order->payedDate      = '付款時間';
$lang->order->closedBy       = '由誰關閉';
$lang->order->closedDate     = '關閉時間';
$lang->order->closedReason   = '關閉原因';
$lang->order->closedNote     = '備註';
$lang->order->activatedBy    = '由誰激活';
$lang->order->activatedDate  = '激活時間';
$lang->order->contactedBy    = '由誰聯繫';
$lang->order->contactedDate  = '聯繫時間';
$lang->order->nextDate       = '下次聯繫';
$lang->order->editedBy       = '最後修改';
$lang->order->editedDate     = '最後修改日期';

$lang->order->list          = '訂單列表';
$lang->order->browse        = '瀏覽訂單';
$lang->order->create        = '創建訂單';
$lang->order->record        = '溝通';
$lang->order->edit          = '編輯訂單';
$lang->order->view          = '訂單詳情';
$lang->order->close         = '關閉訂單';
$lang->order->sign          = '簽約';
$lang->order->assign        = '訂單指派';
$lang->order->activate      = '激活';

$lang->order->statusList['normal'] = '正常';
$lang->order->statusList['signed'] = '已簽約';
$lang->order->statusList['closed'] = '已關閉';

$lang->order->closedReasonList['']          = '';
$lang->order->closedReasonList['payed']     = '已付款';
$lang->order->closedReasonList['failed']    = '失敗';
$lang->order->closedReasonList['postponed'] = '延期';

$lang->order->currencyList['rmb']  = '人民幣';
$lang->order->currencyList['usd']  = '美元';
$lang->order->currencyList['hkd']  = '港元';
$lang->order->currencyList['twd']  = '台元';
$lang->order->currencyList['euro'] = '歐元';
$lang->order->currencyList['dem']  = '馬克';
$lang->order->currencyList['chf']  = '瑞士法郎';
$lang->order->currencyList['frf']  = '法國法郎';
$lang->order->currencyList['gbp']  = '英鎊';
$lang->order->currencyList['nlg']  = '荷蘭盾';
$lang->order->currencyList['cad']  = '加拿大元';
$lang->order->currencyList['sur']  = '盧布';
$lang->order->currencyList['inr']  = '盧比';
$lang->order->currencyList['aud']  = '澳大利亞元';
$lang->order->currencyList['nzd']  = '新西蘭元';
$lang->order->currencyList['thb']  = '泰國銖';
$lang->order->currencyList['sgd']  = '新加坡元';

$lang->order->currencySign['rmb']  = '￥';
$lang->order->currencySign['usd']  = '$';
$lang->order->currencySign['hkd']  = 'HK$';
$lang->order->currencySign['twd']  = 'NT$';
$lang->order->currencySign['euro'] = 'ECU';
$lang->order->currencySign['dem']  = 'DM';
$lang->order->currencySign['chf']  = 'SF';
$lang->order->currencySign['frf']  = 'FF';
$lang->order->currencySign['gbp']  = '￡';
$lang->order->currencySign['nlg']  = 'F';
$lang->order->currencySign['cad']  = 'CAN$';
$lang->order->currencySign['sur']  = 'Rbs';
$lang->order->currencySign['inr']  = 'Rs';
$lang->order->currencySign['aud']  = 'A$';
$lang->order->currencySign['nzd']  = 'NZ$';
$lang->order->currencySign['thb']  = 'B';
$lang->order->currencySign['sgd']  = 'S$';

$lang->order->titleLBL  = "[%s] %s購買%s";
$lang->order->basicInfo = "基本信息";
$lang->order->lifetime  = "訂單的一生";
