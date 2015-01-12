<?php
/**
 * The all avaliabe actions in RanZhi.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     group
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */

/* App module group. */
$lang->appModule = new stdclass();

$lang->appModule->crm = array();
$lang->appModule->crm[] = 'order';
$lang->appModule->crm[] = 'contract';
$lang->appModule->crm[] = 'customer';
$lang->appModule->crm[] = 'contact';
$lang->appModule->crm[] = 'product';
$lang->appModule->crm[] = 'address';
$lang->appModule->crm[] = 'resume';

$lang->appModule->cash = array();
$lang->appModule->cash[] = 'trade';
$lang->appModule->cash[] = 'depositor';
$lang->appModule->cash[] = 'balance';
$lang->appModule->cash[] = 'provider';

$lang->appModule->oa = array();
$lang->appModule->oa[] = 'project';
$lang->appModule->oa[] = 'announce';
$lang->appModule->oa[] = 'doc';

$lang->appModule->team = array();
$lang->appModule->team[] = 'blog';
$lang->appModule->team[] = 'forum';
$lang->appModule->team[] = 'thread';
$lang->appModule->team[] = 'user';

$lang->appModule->sys = array();
$lang->appModule->sys[] = 'task';
$lang->appModule->sys[] = 'tree';
$lang->appModule->sys[] = 'schema';
$lang->appModule->sys[] = 'setting';

/* Module order. */
$lang->moduleOrder[0]   = 'order';
$lang->moduleOrder[5]   = 'contract';
$lang->moduleOrder[10]  = 'customer';
$lang->moduleOrder[15]  = 'contact';
$lang->moduleOrder[20]  = 'product';
$lang->moduleOrder[25]  = 'address';
$lang->moduleOrder[26]  = 'resume';

$lang->moduleOrder[30]  = 'trade';
$lang->moduleOrder[35]  = 'depositor';
$lang->moduleOrder[40]  = 'balance';
$lang->moduleOrder[41]  = 'provider';

$lang->moduleOrder[45]  = 'project';
$lang->moduleOrder[50]  = 'announce';
$lang->moduleOrder[55]  = 'doc';

$lang->moduleOrder[60]  = 'blog';
$lang->moduleOrder[65]  = 'forum';
$lang->moduleOrder[70]  = 'thread';
$lang->moduleOrder[72]  = 'user';

$lang->moduleOrder[75]  = 'task';
$lang->moduleOrder[80]  = 'tree';
$lang->moduleOrder[100] = 'schema';
$lang->moduleOrder[105] = 'setting';

$lang->resource = new stdclass();

/* Order module. */
$lang->resource->order = new stdclass();
$lang->resource->order->browse   = 'browse';
$lang->resource->order->create   = 'create';
$lang->resource->order->edit     = 'edit';
$lang->resource->order->view     = 'view';
$lang->resource->order->close    = 'close';
$lang->resource->order->activate = 'activate';
$lang->resource->order->contact  = 'contact';
$lang->resource->order->assign   = 'assign';
$lang->resource->order->delete   = 'delete';

$lang->order->methodOrder[5]  = 'browse';
$lang->order->methodOrder[10] = 'create';
$lang->order->methodOrder[15] = 'edit';
$lang->order->methodOrder[20] = 'view';
$lang->order->methodOrder[25] = 'close';
$lang->order->methodOrder[30] = 'activate';
$lang->order->methodOrder[40] = 'contact';
$lang->order->methodOrder[45] = 'assign';
$lang->order->methodOrder[50] = 'delete';

/* Contract. */
$lang->resource->contract = new stdclass();
$lang->resource->contract->browse   = 'browse';
$lang->resource->contract->create   = 'create';
$lang->resource->contract->edit     = 'edit';
$lang->resource->contract->view     = 'view';
$lang->resource->contract->delivery = 'delivery';
$lang->resource->contract->receive  = 'receive';
$lang->resource->contract->cancel   = 'cancel';
$lang->resource->contract->finish   = 'finish';
$lang->resource->contract->delete   = 'delete';

$lang->contract->methodOrder[5]  = 'browse';
$lang->contract->methodOrder[10] = 'create';
$lang->contract->methodOrder[15] = 'edit';
$lang->contract->methodOrder[20] = 'view';
$lang->contract->methodOrder[25] = 'delivery';
$lang->contract->methodOrder[30] = 'receive';
$lang->contract->methodOrder[40] = 'cancel';
$lang->contract->methodOrder[45] = 'finish';
$lang->contract->methodOrder[50] = 'delete';

/* Customer. */
$lang->resource->customer = new stdclass();
$lang->resource->customer->browse        = 'browse';
$lang->resource->customer->create        = 'create';
$lang->resource->customer->edit          = 'edit';
$lang->resource->customer->view          = 'view';
$lang->resource->customer->assign        = 'assign';
$lang->resource->customer->order         = 'order';
$lang->resource->customer->contact       = 'contact';
$lang->resource->customer->linkContact   = 'linkContact';
$lang->resource->customer->contract      = 'contract';
$lang->resource->customer->delete        = 'delete';

$lang->customer->methodOrder[5]  = 'browse';
$lang->customer->methodOrder[15] = 'create';
$lang->customer->methodOrder[20] = 'edit';
$lang->customer->methodOrder[25] = 'view';
$lang->customer->methodOrder[30] = 'order';
$lang->customer->methodOrder[35] = 'contact';
$lang->customer->methodOrder[40] = 'linkContact';
$lang->customer->methodOrder[45] = 'contract';
$lang->customer->methodOrder[55] = 'delete';

/* Contact. */
$lang->resource->contact = new stdclass();
$lang->resource->contact->browse        = 'browse';
$lang->resource->contact->create        = 'create';
$lang->resource->contact->edit          = 'edit';
$lang->resource->contact->view          = 'view';
$lang->resource->contact->block         = 'block';
$lang->resource->contact->delete        = 'delete';
$lang->resource->contact->vcard         = 'vcard';

$lang->contact->methodOrder[10] = 'browse';
$lang->contact->methodOrder[15] = 'create';
$lang->contact->methodOrder[20] = 'edit';
$lang->contact->methodOrder[25] = 'view';
$lang->contact->methodOrder[30] = 'block';
$lang->contact->methodOrder[35] = 'delete';
$lang->contact->methodOrder[40] = 'vcard';

/* Product. */
$lang->resource->product = new stdclass();
$lang->resource->product->browse = 'browse';
$lang->resource->product->create = 'create';
$lang->resource->product->edit   = 'edit';
$lang->resource->product->delete = 'delete';
$lang->resource->product->view   = 'view';

$lang->product->methodOrder[5]  = 'browse';
$lang->product->methodOrder[10] = 'create';
$lang->product->methodOrder[20] = 'edit';
$lang->product->methodOrder[35] = 'delete';
$lang->product->methodOrder[40] = 'view';

/* Address. */
$lang->resource->address = new stdclass();
$lang->resource->address->browse = 'browse';
$lang->resource->address->create = 'create';
$lang->resource->address->edit   = 'edit';
$lang->resource->address->delete = 'delete';

$lang->address->methodOrder[5]  = 'browse';
$lang->address->methodOrder[10] = 'create';
$lang->address->methodOrder[15] = 'edit';
$lang->address->methodOrder[20] = 'delete';

/* Resume. */
$lang->resource->resume = new stdclass();
$lang->resource->resume->browse = 'browse';
$lang->resource->resume->create = 'create';
$lang->resource->resume->edit   = 'edit';
$lang->resource->resume->delete = 'delete';

$lang->resume->methodOrder[5]  = 'browse';
$lang->resume->methodOrder[10] = 'create';
$lang->resume->methodOrder[15] = 'edit';
$lang->resume->methodOrder[20] = 'delete';

/* Product plan. */
$lang->resource->trade = new stdclass();
$lang->resource->trade->browse      = 'browse';
$lang->resource->trade->create      = 'create';
$lang->resource->trade->batchCreate = 'batchCreate';
$lang->resource->trade->batchEdit   = 'batchEdit';
$lang->resource->trade->edit        = 'edit';
$lang->resource->trade->transfer    = 'transfer';
$lang->resource->trade->detail      = 'detail';
$lang->resource->trade->delete      = 'delete';
$lang->resource->trade->import      = 'import';
$lang->resource->trade->showimport  = 'showImport';

$lang->trade->methodOrder[10] = 'browse';
$lang->trade->methodOrder[15] = 'create';
$lang->trade->methodOrder[20] = 'batchCreate';
$lang->trade->methodOrder[21] = 'batchEdit';
$lang->trade->methodOrder[25] = 'edit';
$lang->trade->methodOrder[30] = 'transfer';
$lang->trade->methodOrder[35] = 'detail';
$lang->trade->methodOrder[40] = 'delete';
$lang->trade->methodOrder[45] = 'import';
$lang->trade->methodOrder[50] = 'showImport';

/* Depositor. */
$lang->resource->depositor = new stdclass();
$lang->resource->depositor->browse      = 'browse';
$lang->resource->depositor->create      = 'create';
$lang->resource->depositor->edit        = 'edit';
$lang->resource->depositor->forbid      = 'forbid';
$lang->resource->depositor->activate    = 'activate';
$lang->resource->depositor->check       = 'check';
$lang->resource->depositor->savebalance = 'saveBalance';
$lang->resource->depositor->delete      = 'delete';

$lang->depositor->methodOrder[5]  = 'browse';
$lang->depositor->methodOrder[10] = 'create';
$lang->depositor->methodOrder[15] = 'edit';
$lang->depositor->methodOrder[20] = 'forbid';
$lang->depositor->methodOrder[25] = 'activate';
$lang->depositor->methodOrder[30] = 'check';
$lang->depositor->methodOrder[35] = 'saveBalance';
$lang->depositor->methodOrder[40] = 'delete';

/* Balance. */
$lang->resource->balance = new stdclass();
$lang->resource->balance->browse = 'browse';
$lang->resource->balance->create = 'create';
$lang->resource->balance->edit   = 'edit';
$lang->resource->balance->delete = 'delete';

$lang->balance->methodOrder[5]  = 'browse';
$lang->balance->methodOrder[10] = 'create';
$lang->balance->methodOrder[15] = 'edit';
$lang->balance->methodOrder[20] = 'delete';

/* Provider. */
$lang->resource->provider = new stdclass();
$lang->resource->provider->browse      = 'browse';
$lang->resource->provider->create      = 'create';
$lang->resource->provider->edit        = 'edit';
$lang->resource->provider->view        = 'view';
$lang->resource->provider->delete      = 'delete';
$lang->resource->provider->contact     = 'contact';
$lang->resource->provider->linkContact = 'linkContact';

$lang->provider->methodOrder[5]  = 'browse';
$lang->provider->methodOrder[10] = 'create';
$lang->provider->methodOrder[15] = 'edit';
$lang->provider->methodOrder[20] = 'view';
$lang->provider->methodOrder[25] = 'delete';
$lang->provider->methodOrder[30] = 'contact';
$lang->provider->methodOrder[35] = 'linkContact';

/* Schema. */
$lang->resource->schema = new stdclass();
$lang->resource->schema->browse = 'browse';
$lang->resource->schema->view   = 'view';
$lang->resource->schema->create = 'create';
$lang->resource->schema->edit   = 'edit';
$lang->resource->schema->delete = 'delete';

$lang->schema->methodOrder[5]  = 'browse';
$lang->schema->methodOrder[10] = 'create';
$lang->schema->methodOrder[15] = 'edit';
$lang->schema->methodOrder[20] = 'view';
$lang->schema->methodOrder[25] = 'delete';


/* Project. */
$lang->resource->project = new stdclass();
$lang->resource->project->index    = 'index';
$lang->resource->project->create   = 'create';
$lang->resource->project->edit     = 'edit';
$lang->resource->project->finish   = 'finish';
$lang->resource->project->activate = 'activate';
$lang->resource->project->suspend  = 'suspend';
$lang->resource->project->delete   = 'delete';

$lang->project->methodOrder[0]  = 'index';
$lang->project->methodOrder[5]  = 'create';
$lang->project->methodOrder[10] = 'edit';
$lang->project->methodOrder[15] = 'finish';
$lang->project->methodOrder[20] = 'activate';
$lang->project->methodOrder[25] = 'suspend';
$lang->project->methodOrder[35] = 'delete';

/* Task. */
$lang->resource->task = new stdclass();
$lang->resource->task->browse      = 'browse';
$lang->resource->task->kanban      = 'kanban';
$lang->resource->task->outline     = 'outline';
$lang->resource->task->create      = 'create';
$lang->resource->task->batchCreate = 'batchCreate';
$lang->resource->task->edit        = 'edit';
$lang->resource->task->view        = 'view';
$lang->resource->task->finish      = 'finish';
$lang->resource->task->start       = 'start';
$lang->resource->task->assignTo    = 'assignTo';
$lang->resource->task->activate    = 'activate';
$lang->resource->task->cancel      = 'cancel';
$lang->resource->task->close       = 'close';
$lang->resource->task->delete      = 'delete';

$lang->task->methodOrder[10] = 'browse';
$lang->task->methodOrder[15] = 'create';
$lang->task->methodOrder[20] = 'batchCreate';
$lang->task->methodOrder[25] = 'edit';
$lang->task->methodOrder[30] = 'view';
$lang->task->methodOrder[35] = 'finish';
$lang->task->methodOrder[40] = 'start';
$lang->task->methodOrder[45] = 'assignTo';
$lang->task->methodOrder[50] = 'activate';
$lang->task->methodOrder[55] = 'cancel';
$lang->task->methodOrder[60] = 'close';
$lang->task->methodOrder[65] = 'delete';

/* Announce. */
$lang->resource->announce = new stdclass();
$lang->resource->announce->browse = 'browse';
$lang->resource->announce->view   = 'view';
$lang->resource->announce->create = 'create';
$lang->resource->announce->edit   = 'edit';
$lang->resource->announce->delete = 'delete';

$lang->announce->methodOrder[5]  = 'browse';
$lang->announce->methodOrder[10] = 'view';
$lang->announce->methodOrder[15] = 'create';
$lang->announce->methodOrder[20] = 'edit';
$lang->announce->methodOrder[25] = 'delete';

/* Doc. */
$lang->resource->doc = new stdclass();
$lang->resource->doc->createLib = 'createLib';
$lang->resource->doc->editLib   = 'editLib';
$lang->resource->doc->deleteLib = 'deleteLib';
$lang->resource->doc->browse    = 'browse';
$lang->resource->doc->create    = 'create';
$lang->resource->doc->edit      = 'edit';
$lang->resource->doc->view      = 'view';
$lang->resource->doc->delete    = 'delete';

$lang->doc->methodOrder[0]  = 'createLib';
$lang->doc->methodOrder[5]  = 'editLib';
$lang->doc->methodOrder[10] = 'deleteLib';
$lang->doc->methodOrder[15] = 'browse';
$lang->doc->methodOrder[20] = 'create';
$lang->doc->methodOrder[25] = 'edit';
$lang->doc->methodOrder[30] = 'view';
$lang->doc->methodOrder[35] = 'delete';

/* Blog. */
$lang->resource->blog = new stdclass();
$lang->resource->blog->index  = 'index';
$lang->resource->blog->create = 'create';
$lang->resource->blog->edit   = 'edit';
$lang->resource->blog->view   = 'view';
$lang->resource->blog->delete = 'delete';

$lang->blog->methodOrder[0]   = 'index';
$lang->blog->methodOrder[5]   = 'create';
$lang->blog->methodOrder[10]  = 'edit';
$lang->blog->methodOrder[15]  = 'view';
$lang->blog->methodOrder[20]  = 'delete';

/* Forum. */
$lang->resource->forum = new stdclass();
$lang->resource->forum->index  = 'index';
$lang->resource->forum->board  = 'board';
$lang->resource->forum->admin  = 'admin';
$lang->resource->forum->update = 'update';

$lang->forum->methodOrder[0]  = 'index';
$lang->forum->methodOrder[5]  = 'board';
$lang->forum->methodOrder[10] = 'admin';
$lang->forum->methodOrder[15] = 'update';

/* Thread. */
$lang->resource->thread = new stdclass();
$lang->resource->thread->post         = 'post';
$lang->resource->thread->edit         = 'edit';
$lang->resource->thread->view         = 'view';
$lang->resource->thread->transfer     = 'transfer';
$lang->resource->thread->delete       = 'delete';
$lang->resource->thread->switchStatus = 'switchStatus';
$lang->resource->thread->stick        = 'stick';
$lang->resource->thread->deleteFile   = 'deleteFile';

$lang->thread->methodOrder[0]  = 'post';
$lang->thread->methodOrder[5]  = 'edit';
$lang->thread->methodOrder[10] = 'view';
$lang->thread->methodOrder[15] = 'transfer';
$lang->thread->methodOrder[20] = 'delete';
$lang->thread->methodOrder[25] = 'switchStatus';
$lang->thread->methodOrder[30] = 'stick';
$lang->thread->methodOrder[35] = 'deleteFile';

$lang->resource->user = new stdclass();
$lang->resource->user->colleague      = 'colleague';

$lang->user->methodOrder[10] = 'colleague';

/* Tree. */
$lang->resource->tree = new stdclass();
$lang->resource->tree->browse   = 'browse';
$lang->resource->tree->edit     = 'edit';
$lang->resource->tree->children = 'children';
$lang->resource->tree->delete   = 'delete';

$lang->tree->methodOrder[0]  = 'browse';
$lang->tree->methodOrder[5]  = 'edit';
$lang->tree->methodOrder[10] = 'children';
$lang->tree->methodOrder[15] = 'delete';


/* Setting. */
$lang->resource->setting = new stdclass();
$lang->resource->setting->lang  = 'lang';
$lang->resource->setting->reset = 'reset';

$lang->setting->methodOrder[5]  = 'lang';
$lang->setting->methodOrder[10] = 'reset';

/* Every version of new privilege. */
$lang->changelog = array();
//$lang->changelog['1.1'][]   = 'search-saveQuery';
