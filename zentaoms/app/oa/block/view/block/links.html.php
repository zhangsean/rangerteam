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
<div id="links" class="nav nav-pills">
  <?php echo $this->lang->link . $this->lang->colon;?>
  <?php echo $this->config->links->index; if(!empty($this->config->links->all))echo "&nbsp;&nbsp&nbsp" . html::a(helper::createLink('links', 'index'), $this->lang->more . $this->lang->raquo);?>
</div>
<?php endif;?>
