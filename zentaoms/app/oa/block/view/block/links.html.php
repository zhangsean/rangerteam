<?php
/**
 * The link front view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
?>
<?php if(!empty($this->config->links->index)):?>
<ul class='nav nav-pills' id='links'>
  <li class='nav-heading'><i class='icon-link'></i> <?php echo $this->lang->link; ?></li>
  <li><?php echo $this->config->links->index;?></li>
  <li><?php echo html::a(helper::createLink('links', 'index'), $this->lang->more . "<i class='icon-double-angle-right'></i>"); ?></li>
</ul>
<?php endif;?>
