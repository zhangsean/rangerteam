<?php
/**
 * The English file of mail module of RanZhi.
 *
 * @copyright   Copyright 2009-2016 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     mail 
 * @version     $Id: en.php 4029 2016-08-26 06:50:41Z liugang $
 * @link        http://www.ranzhico.com
 */
$lang->mail->common = 'Email setting';
$lang->mail->index  = 'Index';
$lang->mail->detect = 'Detect';
$lang->mail->edit   = 'Configure';
$lang->mail->save   = 'Successfully saved';
$lang->mail->test   = 'Testing';
$lang->mail->reset  = 'Reset';

$lang->mail->turnon      = 'Turnon';
$lang->mail->fromAddress = 'From email';
$lang->mail->fromName    = 'From title';
$lang->mail->mta         = 'MTA';
$lang->mail->host        = 'SMTP host';
$lang->mail->port        = 'SMTP port';
$lang->mail->auth        = 'Authentication';
$lang->mail->username    = 'SMTP account';
$lang->mail->password    = 'SMTP password';
$lang->mail->secure      = 'Secure';
$lang->mail->debug       = 'Debug';

$lang->mail->turnonList[1] = 'on';
$lang->mail->turnonList[0] = 'off';

$lang->mail->debugList[0] = 'off';
$lang->mail->debugList[1] = 'normal';
$lang->mail->debugList[2] = 'high';

$lang->mail->authList[1]  = 'necessary';
$lang->mail->authList[0]  = 'unnecessary';

$lang->mail->secureList['']    = 'plain';
$lang->mail->secureList['ssl'] = 'ssl';
$lang->mail->secureList['tls'] = 'tls';

$lang->mail->inputFromEmail = 'Please input the from email:';
$lang->mail->nextStep       = 'Next';
$lang->mail->successSaved   = 'The configuration has been successfully saved.';
$lang->mail->subject        = "It's a testing email from ranzhico.";
$lang->mail->content        = 'If you can see this, the email notification feature can work now!';
$lang->mail->successSended  = 'Successfully sended!';
$lang->mail->needConfigure  = "I can not find the configuration, please configure it first.";

$lang->mail->mailContentTip = <<<EOT
<strong>%s</strong>(%s) Powered by <a href='https://www.ranzhico.com' target='blank'>RanZhi OA</a>.<br />
<a href='http://www.cnezsoft.com' target='blank'>Nature Easy Soft</a>
EOT;
$lang->mail->openTip = 'Send e-mail when assign order, customer and task, review leave and refund.';
