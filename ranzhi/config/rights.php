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

$config->rights->member['index']['index']            = 'index';
$config->rights->member['entry']['visit']            = 'visit';
$config->rights->member['dashboard']['index']        = 'index';
$config->rights->member['order']['index']            = 'index';
$config->rights->member['contract']['index']         = 'index';
$config->rights->member['customer']['index']         = 'index';
$config->rights->member['contact']['index']          = 'index';
$config->rights->member['product']['index']          = 'index';
$config->rights->member['address']['index']          = 'index';
$config->rights->member['resume']['index']           = 'index';
$config->rights->member['trade']['index']            = 'index';
$config->rights->member['depositor']['index']        = 'index';
$config->rights->member['project']['index']          = 'index';
$config->rights->member['task']['index']             = 'index';
$config->rights->member['announce']['index']         = 'index';
$config->rights->member['doc']['index']              = 'index';
$config->rights->member['message']['index']          = 'index';
$config->rights->member['book']['index']             = 'index';
$config->rights->member['rss']['index']              = 'index';
$config->rights->member['sitemap']['index']          = 'index';
$config->rights->member['links']['index']            = 'index';
$config->rights->member['error']['index']            = 'index';
$config->rights->member['misc']['qrcode']            = 'qrcode';
$config->rights->member['user']['setreferer']        = 'setreferer';
$config->rights->member['contract']['getOrder']      = 'getOrder';
$config->rights->member['customer']['getOptionMenu'] = 'getOptionMenu';
$config->rights->member['contact']['getOptionMenu']  = 'getOptionMenu';
$config->rights->member['thread']['locate']          = 'locate';
$config->rights->member['reply']['post']             = 'post';
$config->rights->member['reply']['edit']             = 'edit';
$config->rights->member['reply']['delete']           = 'delete';
$config->rights->member['reply']['deleteFile']       = 'deleteFile';
