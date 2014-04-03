<?php
/**
 * The upgrade module English file of ZenTaoPMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$lang->upgrade->common  = 'Upgrade';

$lang->upgrade->result  = 'Result';
$lang->upgrade->fail    = 'Fail';
$lang->upgrade->success = 'Success';
$lang->upgrade->tohome  = 'Go to index';

$lang->upgrade->index         = 'Upgrad Ranzhi.';
$lang->upgrade->backup        = 'Backup';
$lang->upgrade->selectVersion = 'Select version to upgrade from';
$lang->upgrade->confirm       = 'Confirm the SQL to excute.';
$lang->upgrade->execute       = 'Execute the SQL.';

$lang->upgrade->setOkFile = <<<EOT
<h5>For security reason, please do these steps. </h5>
<p><code class='f-14px'>Create "<strong>%s</strong>" file. If this file exists already, reopen it and save again.</code></p>
<a href="upgrade.php" class='btn btn-primary'>Ready, go!</a>
EOT;

$lang->upgrade->backupData = <<<EOT
<pre>
<strong>Using phpMyAdmin or mysqldump to backup database.</strong>
<code class='red'>$ mysqldump -u %s</span> -p%s %s > chanzhi.sql</code>
</pre>
<a href="%s" class='btn btn-primary'>Next</a>
EOT;

$lang->upgrade->versionNote = "Please the version to upgrade.";

$lang->upgrade->fromVersions['1_1'] = '1.1.stable';
