<?php
/**
 * The side common view file of blog module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php
$treeMenu = $this->tree->getTreeMenu('blog', 0, array('treeModel', 'createBlogBrowseLink'));
?>
<div class='col-md-3'>
  <div class='panel'> 
    <?php echo html::a($this->createLink('article', 'create', "type=blog"), $lang->blog->create, "class='btn btn-primary btn-lg btn-block'");?>
  </div>
  <div class='panel'> 
    <div class='panel-heading'> <h4 class='title'><?php echo $lang->categoryMenu;?></h4></div>
    <div class='panel-body'> <?php echo $treeMenu;?> </div>
  </div>
</div>
