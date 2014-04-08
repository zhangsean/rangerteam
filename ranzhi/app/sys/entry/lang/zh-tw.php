<?php
/**
 * The zh-tw file of entry module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商業軟件，非開源軟件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entry 
 * @version     $Id: zh-tw.php 7424 2013-12-23 08:42:32Z zhujinyong $
 * @link        http://www.ranzhi.co
 */
$lang->entry->common    = '應用';
$lang->entry->admin     = '應用列表';
$lang->entry->create    = '添加應用';
$lang->entry->edit      = '編輯應用';
$lang->entry->delete    = '刪除應用';
$lang->entry->code      = '代號';
$lang->entry->name      = '名稱';
$lang->entry->key       = '密鑰';
$lang->entry->ip        = 'IP列表';
$lang->entry->logo      = 'Logo';
$lang->entry->createKey = '重新生成密鑰';
$lang->entry->login     = '登錄地址';
$lang->entry->logout    = '退出地址';
$lang->entry->nothing   = '暫時沒有應用';
$lang->entry->open      = '打開方式';

$lang->entry->confirmDelete = '您確定刪除該應用嗎？';

$lang->entry->note = new stdClass();
$lang->entry->note->name    = '授權應用名稱';
$lang->entry->note->code    = '授權應用代號';
$lang->entry->note->login   = '登錄應用的表單提交地址';
$lang->entry->note->logout  = '退出應用的地址';
$lang->entry->note->visible = '顯示在首頁左側欄';
$lang->entry->note->ip      = "允許該應用使用這些ip訪問，多個ip使用逗號隔開。支持IP段，如192.168.1.*";

$lang->entry->error = new stdClass();
$lang->entry->error->name  = '名稱不能為空';
$lang->entry->error->code  = '代號不能為空';
$lang->entry->error->key   = '密鑰不能為空';
$lang->entry->error->ip    = 'IP列表不能為空';

$lang->entry->openList['']       = '';
$lang->entry->openList['blank']  = '新開標籤';
$lang->entry->openList['iframe'] = '內嵌窗口';

$lang->entry->instruction = <<<EOT
EOT;
