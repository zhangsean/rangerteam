<?php
/**
 * The view file of thread module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     thread
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
include '../../common/view/header.html.php';
include '../../../sys/common/view/kindeditor.html.php';

if($pager->pageID == 1) include './thread.html.php';
if(!$thread->readonly)  include './reply.html.php';
else echo "<div class='alert alert-info'>{$lang->thread->readonlyMessage}</div>";

include '../../common/view/footer.html.php';
