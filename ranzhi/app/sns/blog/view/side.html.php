<?php
/**
 * The side common view file of blog module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.ranzhi.co
 */
?>
<?php
$treeMenu = $this->tree->getTreeMenu('blog', 0, array('treeModel', 'createBlogBrowseLink'));
?>
<div class='col-md-3'>
  <div class='box widget radius'> 
    <h4 class='title'><?php echo $lang->categoryMenu;?></h4>
    <?php echo $treeMenu;?>
  </div>
</div>
