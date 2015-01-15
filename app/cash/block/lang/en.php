<?php
/**
 * The en file of block module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
$lang->block->depositor = 'Payment Depositor';
$lang->block->lblBlock  = 'Block';
$lang->block->admin     = 'Manage Block';
$lang->block->num       = 'Number';
$lang->block->orderBy   = 'Order';

$lang->block->availableBlocks = new stdclass();
$lang->block->availableBlocks->depositor = 'Payment Depositor';
$lang->block->availableBlocks->trade     = 'Trade';
$lang->block->availableBlocks->provider  = 'Provider';

$this->lang->block->orderByList->trade['id_asc']  = 'ID ASC';
$this->lang->block->orderByList->trade['id_desc'] = 'ID DESC';

$this->lang->block->orderByList->provider['id_asc']  = 'ID ASC';
$this->lang->block->orderByList->provider['id_desc'] = 'ID DESC';
