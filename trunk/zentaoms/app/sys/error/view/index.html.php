<?php
/**
 * The error view file of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     error
 * @version     $Id$
 * @link        http://www.zentao.net
 */
include '../../common/view/header.html.php';
?>
<div class='alert alert-danger'>
  <h3><?php echo $lang->error->pageNotFound;?></h3>
  <p><?php echo $this->config->company->desc;?></p>
</div>
<?php include '../../common/view/footer.html.php';?>
