<?php
/**
 * The upgrade module English file of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
$lang->upgrade = new stdclass();
$lang->upgrade->common  = 'Upgrade';

$lang->upgrade->result  = 'Result';
$lang->upgrade->fail    = 'Failed';
$lang->upgrade->success = 'Success';
$lang->upgrade->tohome  = 'Go to index';

$lang->upgrade->index         = 'Upgrad chanzhiEPS.';
$lang->upgrade->backup        = 'Backup';
$lang->upgrade->selectVersion = 'Select version to upgrade from';
$lang->upgrade->confirm       = 'Confirm the SQL to be excuted.';
$lang->upgrade->execute       = 'Execute';
$lang->upgrade->next          = 'Next';

$lang->upgrade->setOkFile = <<<EOT
<div class='alert'>
<h5>For security reason, please do these steps. </h5>
<p>Create "<code>%s</code>" file. If this file exists already, reopen it and save again.</p>
</div>
EOT;

$lang->upgrade->backupData = <<<EOT
<pre>
<strong>Using phpMyAdmin or mysqldump to backup database.</strong>
<code class='red'>$ mysqldump -u %s</span> -p%s %s > chanzhi.sql</code>
</pre>
EOT;

$lang->upgrade->versionNote = "Please choose the version to upgrade.";

$lang->upgrade->fromVersions['1_0'] = '1.0.beta';
