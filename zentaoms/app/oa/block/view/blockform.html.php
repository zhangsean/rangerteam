<?php
/**
 * The block form view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2014 ൺϢϢ޹˾ (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
?>
<?php
$webRoot   = $config->webRoot;
$jsRoot    = $webRoot . "js/";
$themeRoot = $webRoot . "theme/";
?>
<?php
$formFile = dirname(__FILE__) . '/block/' . strtolower($type) . '.form.php';
if(file_exists($formFile)) include $formFile;
?>
