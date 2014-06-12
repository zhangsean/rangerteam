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

$config->rights->guest = array();

$config->rights->member['entry']['visit'] = 'visit';

$config->rights->member['index']['index'] = 'index';

$config->rights->member['dashboard']['index'] = 'index';

$config->rights->member['order']['index']    = 'index';
$config->rights->member['order']['browse']   = 'browse';
$config->rights->member['order']['create']   = 'create';
$config->rights->member['order']['edit']     = 'edit';
$config->rights->member['order']['view']     = 'view';
$config->rights->member['order']['close']    = 'close';
$config->rights->member['order']['activate'] = 'activate';
$config->rights->member['order']['contact']  = 'contact';
$config->rights->member['order']['assign']   = 'assign';

$config->rights->member['contract']['index']    = 'index';
$config->rights->member['contract']['browse']   = 'browse';
$config->rights->member['contract']['create']   = 'create';
$config->rights->member['contract']['edit']     = 'edit';
$config->rights->member['contract']['view']     = 'view';
$config->rights->member['contract']['delivery'] = 'delivery';
$config->rights->member['contract']['receive']  = 'receive';
$config->rights->member['contract']['cancel']   = 'cancel';
$config->rights->member['contract']['finish']   = 'finish';
$config->rights->member['contract']['delete']   = 'delete';

$config->rights->member['customer']['index']       = 'index';
$config->rights->member['customer']['browse']      = 'browse';
$config->rights->member['customer']['create']      = 'create';
$config->rights->member['customer']['edit']        = 'edit';
$config->rights->member['customer']['view']        = 'view';
$config->rights->member['customer']['order']       = 'order';
$config->rights->member['customer']['contact']     = 'contact';
$config->rights->member['customer']['linkContact'] = 'linkContact';
$config->rights->member['customer']['contract']    = 'contract';
$config->rights->member['customer']['record']      = 'record';
$config->rights->member['customer']['delete']      = 'delete';

$config->rights->member['contact']['index']  = 'index';
$config->rights->member['contact']['browse'] = 'browse';
$config->rights->member['contact']['create'] = 'create';
$config->rights->member['contact']['edit']   = 'edit';
$config->rights->member['contact']['view']   = 'view';
$config->rights->member['contact']['block']  = 'block';
$config->rights->member['contact']['delete'] = 'delete';

$config->rights->member['article']['index']  = 'index';
$config->rights->member['article']['browse'] = 'browse';
$config->rights->member['article']['view']   = 'view';

$config->rights->member['blog']['index']  = 'index';
$config->rights->member['blog']['view']   = 'view';

$config->rights->member['product']['index']  = 'index';
$config->rights->member['product']['browse'] = 'browse';
$config->rights->member['product']['create'] = 'create';
$config->rights->member['product']['edit']   = 'edit';
$config->rights->member['product']['delete'] = 'delete';

$config->rights->member['address']['index']  = 'index';
$config->rights->member['address']['browse'] = 'browse';
$config->rights->member['address']['create'] = 'create';
$config->rights->member['address']['edit']   = 'edit';
$config->rights->member['address']['delete'] = 'delete';

$config->rights->member['resume']['index']  = 'index';
$config->rights->member['resume']['browse'] = 'browse';
$config->rights->member['resume']['create'] = 'create';
$config->rights->member['resume']['edit']   = 'edit';
$config->rights->member['resume']['delete'] = 'delete';

$config->rights->member['trade']['index']       = 'index';
$config->rights->member['trade']['browse']      = 'browse';
$config->rights->member['trade']['create']      = 'create';
$config->rights->member['trade']['batchCreate'] = 'batchCreate';
$config->rights->member['trade']['edit']        = 'edit';
$config->rights->member['trade']['transfer']    = 'transfer';
$config->rights->member['trade']['detail']      = 'detail';
$config->rights->member['trade']['delete']      = 'delete';

$config->rights->member['depositor']['index']  = 'index';
$config->rights->member['depositor']['browse'] = 'browse';
$config->rights->member['depositor']['create'] = 'create';
$config->rights->member['depositor']['edit']   = 'edit';
$config->rights->member['depositor']['delete'] = 'delete';
$config->rights->member['depositor']['view']   = 'view';

$config->rights->member['balance']['index']  = 'index';
$config->rights->member['balance']['browse'] = 'browse';
$config->rights->member['balance']['create'] = 'create';
$config->rights->member['balance']['edit']   = 'edit';
$config->rights->member['balance']['delete'] = 'delete';

$config->rights->member['project']['index']  = 'index';
$config->rights->member['project']['create'] = 'create';
$config->rights->member['project']['edit']   = 'edit';
$config->rights->member['project']['delete'] = 'delete';

$config->rights->member['task']['index']       = 'index';
$config->rights->member['task']['browse']      = 'browse';
$config->rights->member['task']['create']      = 'create';
$config->rights->member['task']['batchCreate'] = 'batchCreate';
$config->rights->member['task']['edit']        = 'edit';
$config->rights->member['task']['view']        = 'view';
$config->rights->member['task']['finish']      = 'finish';
$config->rights->member['task']['assignTo']    = 'assignTo';
$config->rights->member['task']['activate']    = 'activate';
$config->rights->member['task']['cancel']      = 'cancel';
$config->rights->member['task']['close']       = 'close';
$config->rights->member['task']['delete']      = 'delete';

$config->rights->member['announce']['index']  = 'index';
$config->rights->member['announce']['browse'] = 'browse';
$config->rights->member['announce']['create'] = 'create';
$config->rights->member['announce']['edit']   = 'edit';
$config->rights->member['announce']['view']   = 'view';
$config->rights->member['announce']['delete'] = 'delete';

$config->rights->member['doc']['index']     = 'index';
$config->rights->member['doc']['browse']    = 'browse';
$config->rights->member['doc']['create']    = 'create';
$config->rights->member['doc']['edit']      = 'edit';
$config->rights->member['doc']['view']      = 'view';
$config->rights->member['doc']['delete']    = 'delete';
$config->rights->member['doc']['createLib'] = 'createLib';
$config->rights->member['doc']['editLib']   = 'editLib';
$config->rights->member['doc']['deleteLib'] = 'deleteLib';

$config->rights->member['blog']['index']  = 'index';
$config->rights->member['blog']['create'] = 'create';
$config->rights->member['blog']['edit']   = 'edit';
$config->rights->member['blog']['view']   = 'view';
$config->rights->member['blog']['delete'] = 'delete';

$config->rights->member['forum']['index']  = 'index';
$config->rights->member['forum']['board']  = 'board';
$config->rights->member['forum']['admin']  = 'admin';
$config->rights->member['forum']['update'] = 'update';

$config->rights->member['thread']['post']         = 'post';
$config->rights->member['thread']['edit']         = 'edit';
$config->rights->member['thread']['view']         = 'view';
$config->rights->member['thread']['transfer']     = 'transfer';
$config->rights->member['thread']['delete']       = 'delete';
$config->rights->member['thread']['switchStatus'] = 'switchStatus';
$config->rights->member['thread']['stick']        = 'stick';
$config->rights->member['thread']['deleteFile']   = 'deleteFile';
$config->rights->member['thread']['locate']       = 'locate';

$config->rights->member['reply']['post']       = 'post';
$config->rights->member['reply']['eidt']       = 'edit';
$config->rights->member['reply']['hide']       = 'hide';
$config->rights->member['reply']['delete']     = 'delete';
$config->rights->member['reply']['deletefile'] = 'deletefile';

$config->rights->member['tree']['browse']   = 'browse';
$config->rights->member['tree']['edit']     = 'edit';
$config->rights->member['tree']['children'] = 'children';
$config->rights->member['tree']['delete']   = 'delete';

$config->rights->member['user']['control']        = 'control';
$config->rights->member['user']['profile']        = 'profile';
$config->rights->member['user']['thread']         = 'thread';
$config->rights->member['user']['reply']          = 'reply';
$config->rights->member['user']['create']         = 'create';
$config->rights->member['user']['edit']           = 'edit';
$config->rights->member['user']['delete']         = 'delete';
$config->rights->member['user']['admin']          = 'admin';
$config->rights->member['user']['colleague']      = 'colleague';
$config->rights->member['user']['forbid']         = 'forbid';
$config->rights->member['user']['active']         = 'active';
$config->rights->member['user']['setReferer']     = 'setReferer';
$config->rights->member['user']['changePassword'] = 'changePassword';
$config->rights->member['user']['vcard']          = 'vcard';
$config->rights->member['user']['message']        = 'message';

$config->rights->member['message']['index']       = 'index';
$config->rights->member['message']['comment']     = 'show';
$config->rights->member['message']['notify']      = 'notify';
$config->rights->member['message']['post']        = 'post';
$config->rights->member['message']['view']        = 'view';
$config->rights->member['message']['batchdelete'] = 'batchdelete';

$config->rights->member['book']['index']  = 'index';
$config->rights->member['book']['browse'] = 'browse';
$config->rights->member['book']['read']   = 'read';

$config->rights->member['file']['download']    = 'download';
$config->rights->member['file']['printfiles']  = 'printfiles';
$config->rights->member['file']['filemanager'] = 'filemanager';
$config->rights->member['file']['ajaxupload']  = 'ajaxupload';

$config->rights->member['rss']['index']     = 'index';
$config->rights->member['sitemap']['index'] = 'index';
$config->rights->member['links']['index']   = 'index';
$config->rights->member['error']['index']   = 'index';
$config->rights->member['misc']['qrcode']   = 'qrcode';
