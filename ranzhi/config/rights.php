<?php
/**
 * The config items for rights.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     config
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
/* Init the rights. */
$config->rights = new stdclass();

$config->rights->member['index']['index'] = 'index';

$config->rights->member['order']['index']  = 'index';
$config->rights->member['order']['browse'] = 'browse';
$config->rights->member['order']['create'] = 'create';
$config->rights->member['order']['edit']   = 'edit';
$config->rights->member['order']['view']   = 'view';

$config->rights->member['article']['index']  = 'index';
$config->rights->member['article']['browse'] = 'browse';
$config->rights->member['article']['view']   = 'view';

$config->rights->member['blog']['index']  = 'index';
$config->rights->member['blog']['view']   = 'view';

$config->rights->member['product']['index']  = 'index';
$config->rights->member['product']['browse'] = 'browse';
$config->rights->member['product']['view']   = 'view';

$config->rights->member['company']['index']   = 'index';
$config->rights->member['company']['contact'] = 'contact';

$config->rights->member['links']['index'] = 'index';

$config->rights->member['forum']['index'] = 'index';
$config->rights->member['forum']['board'] = 'board';

$config->rights->member['thread']['view']   = 'view';
$config->rights->member['thread']['post']   = 'post';
$config->rights->member['thread']['locate'] = 'locate';

$config->rights->member['message']['index']   = 'index';
$config->rights->member['message']['comment'] = 'show';
$config->rights->member['message']['notify']  = 'notify';
$config->rights->member['message']['post']    = 'post';

$config->rights->member['book']['index']  = 'index';
$config->rights->member['book']['browse'] = 'browse';
$config->rights->member['book']['read']   = 'read';

$config->rights->member['user']['login']         = 'login';
$config->rights->member['user']['register']      = 'register';
$config->rights->member['user']['oauthlogin']    = 'oauthlogin';
$config->rights->member['user']['oauthcallback'] = 'oauthcallback';
$config->rights->member['user']['oauthregister'] = 'oauthregister';
$config->rights->member['user']['oauthbind']     = 'oauthbind';
$config->rights->member['user']['message']       = 'message';

$config->rights->member['rss']['index']       = 'index';
$config->rights->member['sitemap']['index']   = 'index';

$config->rights->member['file']['download']    = 'download';
$config->rights->member['file']['printfiles']  = 'printfiles';
$config->rights->member['file']['filemanager'] = 'filemanager';

$config->rights->member['error']['index'] = 'index';

$config->rights->member['page']['index'] = 'index';
$config->rights->member['page']['view']  = 'view';

$config->rights->member['misc']['qrcode'] = 'qrcode';

$config->rights->member['thread']['post']       = 'post';
$config->rights->member['thread']['reply']      = 'reply';
$config->rights->member['thread']['edit']       = 'edit';
$config->rights->member['thread']['hide']       = 'hide';
$config->rights->member['thread']['stick']      = 'stick';
$config->rights->member['thread']['delete']     = 'delete';
$config->rights->member['thread']['deletefile'] = 'deletefile';

$config->rights->member['reply']['post']       = 'post';
$config->rights->member['reply']['eidt']       = 'edit';
$config->rights->member['reply']['hide']       = 'hide';
$config->rights->member['reply']['delete']     = 'delete';
$config->rights->member['reply']['deletefile'] = 'deletefile';

$config->rights->member['user']['control'] = 'control';
$config->rights->member['user']['profile'] = 'profile';
$config->rights->member['user']['edit']    = 'edit';
$config->rights->member['user']['logout']  = 'logout';
$config->rights->member['user']['thread']  = 'thread';
$config->rights->member['user']['reply']   = 'reply';
$config->rights->member['user']['message'] = 'message';

$config->rights->member['file']['ajaxupload'] = 'ajaxupload';

$config->rights->member['message']['view']        = 'view';
$config->rights->member['message']['batchdelete'] = 'batchdelete';
