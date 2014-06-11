<?php
/**
 * The manage privilege by group view of group module of RanZhi.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     group
 * @version     $Id: managepriv.html.php 1517 2011-03-07 10:02:57Z wwccss $
 * @link        http://www.ranzhi.org
 */
?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class='icon-lock'> </i><?php echo $lang->group->managePriv;?></strong>
  </div>
  <div class='panel-body'>
    <form class='form-condensed' id='ajaxForm' method='post'>
      <?php foreach($lang->appModule as $app => $modules):?>
      <table class='table table-hover table-striped table-bordered table-form'> 
        <caption><?php echo $lang->apps->$app;?></caption>
        <thead>
          <tr>
            <th><?php echo $lang->group->module;?></th>
            <th><?php echo $lang->group->method;?></th>
          </tr>
        </thead>
        <?php foreach($lang->resource as $moduleName => $moduleActions):?>
        <?php if(!in_array($moduleName, $modules)) continue;?>
        <?php if(!$this->group->checkMenuModule($menu, $moduleName)) continue;?>
        <?php
        $this->app->loadLang($moduleName, $app);
        /* Check method in select version. */
        if($version)
        {
            $hasMethod = false;
            foreach($moduleActions as $action => $actionLabel)
            {
                if(strpos($changelogs, ",$moduleName-$actionLabel,") !== false)
                {
                    $hasMethod = true;
                    break;
                }
            }
            if(!$hasMethod) continue;
        }
        ?>
        <tr class='<?php echo cycle('even, bg-gray');?>'>
          <th class='text-right w-100px'><?php echo html::checkbox($moduleName, isset($this->lang->$moduleName->common) ? $this->lang->$moduleName->common : '')?></th>
          <td id='<?php echo $moduleName;?>'>
            <?php $i = 1;?>
            <?php foreach($moduleActions as $action => $actionLabel):?>
            <?php if(!empty($version) and strpos($changelogs, ",$moduleName-$actionLabel,") === false) continue;?>
            <div class='group-item'>
              <input type='checkbox' name='actions[<?php echo $moduleName;?>][]' value='<?php echo $action;?>' <?php if(isset($groupPrivs[$moduleName][$action])) echo "checked";?> />
              <span class='priv' id="<?php echo $moduleName . '-' . $actionLabel;?>"><?php echo $lang->$moduleName->$actionLabel;?></span>
            </div>
            <?php endforeach;?>
          </td>
        </tr>
        <?php endforeach;?>
        <tr>
          <th class='text-right'><?php echo html::checkbox('', 'checkbox')?></th>
          <td>
            <?php 
            echo html::submitButton($lang->save, "onclick='setNoChecked()'");
            echo html::linkButton($lang->goback, $this->createLink('group', 'browse'));
            echo html::hidden('foo'); // Just a hidden var, to make sure $_POST is not empty.
            echo html::hidden('noChecked'); // Save the value of no checked.
            ?>
          </td>
        </tr>
      </table>
      <?php endforeach;?>
    </form>
  </div>
</div>
<script type='text/javascript'>
var groupID = <?php echo $groupID?>;
var menu    = "<?php echo $menu?>";
</script>
