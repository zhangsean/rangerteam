<?php
/**
 * The project list block view file of block module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<div class='article-content'>
    <?php foreach($depositors as $id => $depositor):?>
    <dl>
      <?php if($depositor->type == 'bank'):?>
      <dt><?php echo $depositor->title;?></dt>
      <dd><?php echo $depositor->provider . ' ' . $depositor->account;?></dd>
      <?php else:?>
      <dt><?php echo $depositor->title;?></dt>
      <dd><?php echo $lang->depositor->providerList[$depositor->provider] . ' ' . $depositor->account;?></dd>
      <?php endif;?>
    </dl>
    <?php endforeach;?>
</div>
