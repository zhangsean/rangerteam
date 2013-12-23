<?php
/**
 * The side view file of user module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user 
 * @version     $Id: side.html.php 2605 2013-12-23 09:12:58Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<div class='col-md-2'>
  <ul class='nav nav-primary nav-stacked user-control-nav'>
    <li class='nav-heading'><?php echo $lang->user->control->common;?></li>
    <?php
    ksort($lang->user->control->menus);
    foreach($lang->user->control->menus as $menu)
    {
        $class = '';
        list($label, $module, $method) = explode('|', $menu);

        if(in_array($method, array('thread', 'reply')) && !commonModel::isAvailable('forum')) continue;

        if($module == $this->app->getModuleName() && $method == $this->app->getMethodName()) $class .= 'active';

        echo '<li class="' . $class . '">' . html::a($this->createLink($module, $method), $label) . '</li>';
    }
    ?>
  </ul>
</div>
