<?php
/**
 * The common modal header view file of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     Ranzhi
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<div class="modal-dialog" style="width:700px;">
  <div class="modal-content">
    <div class="modal-header">
      <?php echo html::closeButton();?>
      <h4 class="modal-title"><?php echo $title; ?></h4>
    </div>
    <div class="modal-body">
