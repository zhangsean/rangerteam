<?php
/**
 * The thread module english file of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     thread
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->thread->common    = 'Thread';

$lang->thread->id         = 'Id';
$lang->thread->title      = 'Title';
$lang->thread->author     = 'Autuor';
$lang->thread->content    = 'Content ';
$lang->thread->file       = 'File ';
$lang->thread->postedDate = 'Posted date';
$lang->thread->replies    = 'Replies';
$lang->thread->views      = 'Views';
$lang->thread->lastReply  = 'Last reply';

$lang->thread->post       = 'Post';
$lang->thread->browse     = 'Threads';
$lang->thread->stick      = 'Sticky';
$lang->thread->edit       = 'Edit';
$lang->thread->status     = 'Status';
$lang->thread->hide       = 'Hide';
$lang->thread->show       = 'Show';

$lang->thread->sticks[0] = 'Don\'t stick';
$lang->thread->sticks[1] = 'Stick on board';
$lang->thread->sticks[2] = 'Global stick';

$lang->thread->statusList['hidden'] = 'hidden';
$lang->thread->statusList['normal'] = 'normal';

$lang->thread->confirmDeleteThread = "Are you sure to delete this thread?";
$lang->thread->confirmHideReply    = "Are you sure to hide this reply?";
$lang->thread->confirmHideThread   = "Are you sure to hide this thread?";
$lang->thread->confirmDeleteReply  = "Are you sure to delete this reply?";
$lang->thread->confirmDeleteFile   = "Are you sure to delete this file?";

$lang->thread->lblSpeaker     = '<strong>%s</strong><br />Views: %s<br />Register: %s<br />Last visits: %s<br />Score: %s';
$lang->thread->lblEdited      = '<i>%s Last edited, %s</i> ';
$lang->thread->message        = '%s reply at #%s in forum, the thread is: %s, the content is: %s';
$lang->thread->readonly       = 'Read only';
$lang->thread->successStick   = 'Successfully sticky.';
$lang->thread->successUnstick = 'Successfully unsticky.';
$lang->thread->readonlyMessage = 'The thread has been setted <strong>READONLY</strong>，you can not post new reply。';

/* Adjust the pager. */
if(!isset($lang->pager->settedInForum))
{
    $lang->pager->noRecord = '';
    $lang->pager->digest   = str_replace('records', 'replies', $lang->pager->digest);
}
