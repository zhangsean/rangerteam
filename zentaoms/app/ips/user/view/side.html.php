<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<div class='col-md-2' id='leftmenu'>
  <div class="list-group">
      <strong class="list-group-item list-group-title"><?php echo $lang->user->control->common;?></strong>
      <?php
      ksort($lang->user->control->menus);
      foreach($lang->user->control->menus as $menu)
      {
          $class = 'list-group-item';
          list($label, $module, $method) = explode('|', $menu);

          if(in_array($method, array('thread', 'reply')) && !commonModel::isAvailable('forum')) continue;

          if($module == $this->app->getModuleName() && $method == $this->app->getMethodName()) $class .= ' active';
          echo html::a($this->createLink($module, $method), $label, "class='$class'");
      }
      ?>      
  </div>
</div>
