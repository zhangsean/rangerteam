<?php
/**
 * The index view file of admin module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiyingl@xirangit.com>
 * @package     admin
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class='container' id='shortcutBox'>
  <div class='row'>
    <div class='col-md-4 col-sm-6'>
      <div class="shortcut user">
        <?php echo html::a($this->createLink('user', 'create'), '<h3>' . $lang->admin->shortcuts->createUser . '</h3>')?>  
      </div>
    </div>
    <div class='col-md-4 col-sm-6'> 
      <div class="shortcut company">
        <?php echo html::a($this->createLink('company', 'setbasic'), '<h3>' . $lang->admin->shortcuts->company . '</h3>')?>
      </div>
    </div>
    <div class='col-md-4 col-sm-6'>
      <div class="shortcut entry">
        <?php echo html::a($this->createLink('entry', 'create'), '<h3>' . $lang->admin->shortcuts->createEntry . '</h3>')?>
      </div>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
