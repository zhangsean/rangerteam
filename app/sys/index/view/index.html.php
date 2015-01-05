<?php
/**
 * The index view file of index module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     index 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
include "../../common/view/header.lite.html.php";
css::import($themeRoot . 'default/ips.css');
js::import($jsRoot . 'jquery/ips.js');
?>
<!-- Desktop -->
<div id='desktop' class='fullscreen-mode' unselectable='on' style='-moz-user-select:none;-webkit-user-select:none;' onselectstart='return false;'>
  <div id='leftBar' class='dock-left'>
    <button id='start' class='dock-bottom'>
      <div class='avatar avatar-md'><?php if(!empty($app->user->avatar)) echo html::image($app->user->avatar);?></div>
    </button>
    <ul id='startMenu' class='dropdown-menu fade'>
      <li class='with-avatar'><?php echo html::a($this->createLink('user', 'profile'), "<div class='avatar avatar-md'>" . (empty($app->user->avatar) ? '' : html::image($app->user->avatar)) . "</div><strong>{$app->user->realname}</strong>", "data-toggle='modal' data-id='profile'");?></li>
      <li class="divider"></li>
      <li class='dropdown-submenu'><?php include '../../common/view/selectlang.html.php';?></li>
      <li class="divider"></li>
      <li><?php echo html::a($this->createLink('entry', 'create'), "<i class='icon icon-plus'></i> {$lang->index->addEntry}", "data-id='superadmin' class='app-btn'"  )?></li>
      <li><a href='javascript:;' class='fullscreen-btn' data-id='allapps'><i class='icon icon-th-large'></i> <?php echo $lang->index->allEntries?></a></li>
      <li class="divider"></li>
      <li><?php echo html::a($this->createLink('user', 'logout'), "<i class='icon icon-signout'></i> {$lang->logout}")?></li>
    </ul>
    <div id='apps-menu'>
      <ul class='bar-menu'></ul>
    </div>
  </div>
  <div id='bottomBar' class='dock-bottom'>
    <div id='taskbar'><ul class='bar-menu'></ul></div>
    <div id='bottomRightBar' class='dock-right'>
      <ul class='bar-menu'>
        <li><button id='version'><?php echo html::a('http://www.ranzhico.com', $lang->ranzhi . $this->config->version, "target='_blank'")?></button></li>
        <li><button id='showDesk' class='fullscreen-btn icon-desktop' data-id='home' data-toggle='tooltip' title='<?php echo $lang->index->showDesk; ?>'></button></li>
      </ul>
    </div>
  </div>
  <div id='home' class='fullscreen fullscreen-active'>
    <div class='panels-container dashboard' id='dashboard' data-confirm-remove-block='<?php  echo $lang->block->confirmRemoveBlock;?>'>
      <div class='btn-toolbar actions'>
        <button title='<?php echo $lang->index->refresh;?>' class='btn btn-pure refresh-all-panel'><i class='icon-repeat'></i></button>
        <?php end($blocks);?>
        <a data-toggle='modal' href='<?php echo $this->createLink("block", "admin"); ?>' title='<?php echo $lang->index->addBlock; ?>' class='btn btn-pure'><i class='icon-plus'></i></a>
      </div>
      <div class='row'>
        <?php
        $index = 0;
        reset($blocks);
        ?>
        <?php foreach($blocks as $key => $block):?>
        <?php
        $index = $key;
        $block->params = json_decode($block->params);
        ?>
        <div class='col-sm-6 col-md-<?php echo $block->grid;?>'>
          <div class='panel <?php if(isset($block->params->color)) echo 'panel-' . $block->params->color;?>' id='block<?php echo $index?>' data-id='<?php echo $index?>' data-name='<?php echo $block->title?>' data-url='<?php echo $this->createLink('entry', 'printBlock', 'index=' . $index) ?>'>
            <div class='panel-heading'>
              <div class='panel-actions'>
                <button class="btn btn-mini refresh-panel"><i class="icon-repeat"></i></button>
                <div class='dropdown'>
                  <button role="button" class="btn btn-mini" data-toggle="dropdown"><span class="caret"></span></button>
                  <ul class="dropdown-menu pull-right" role="menu">
                    <li><a href="<?php echo $this->createLink("block", "admin", "index=$index"); ?>" data-toggle='modal' class='edit-block' data-title='<?php echo $block->title; ?>' data-icon='icon-pencil'><i class="icon-pencil"></i> <?php echo $lang->edit; ?></a></li>
                    <li><a href="javascript:;" class="remove-panel"><i class="icon-remove"></i> <?php echo $lang->delete; ?></a></li>
                    <?php if(!$block->source and $block->block == 'html'):?>
                      <li><a href="javascript:hiddenBlock(<?php echo $index;?>)" class="hidden-panel"><i class='icon-eye-close'></i> <?php echo $lang->index->hidden; ?></a></li>
                    <?php endif;?>
                  </ul>
                </div>
              </div>
              <?php echo $block->title?>
            </div>
            <div class='panel-body no-padding'></div>
          </div>
        </div>
        <?php endforeach;?>
      </div>
    </div>
  </div>
  <div id='allapps' class='fullscreen'>
    <header>
      <div class='row'>
        <div class='col-xs-4'>
          <ul class='nav nav-tabs' id='appSearchNav'>
            <li class='active'><a href="javascript:;" class='app-search' data-key=''><i class='icon-th-large'></i> <span><?php echo $lang->index->allEntries?></span> &nbsp;<small class='muted entries-count'></small></a></li>
            <li><a href="javascript:;" class='app-search' data-key=':open'><i class='icon-bolt'></i> <span><?php echo $lang->index->opened;?></span> &nbsp;<small class='muted search-count'></small></a></li>
          </ul>
        </div>
        <div class='col-xs-4'>
          <div class='search-input'>
            <i class='icon-search icon'></i>
            <input id='search' type='text' class='form-control-pure form-control'>
            <button id='cancelSearch' class='btn btn-pure btn-mini'><i class='icon-remove'></i></button>
          </div>
        </div>
        <div class='col-xs-4 text-right'>
          <?php echo html::a($this->createLink('entry', 'create'), "<i class='icon-plus'></i> {$lang->index->addEntry}", "data-id='superadmin' class='app-btn btn btn-pure'")?>
        </div>
      </div>
    </header>
    <div class='all-apps-list' id='allAppsList'>
      <ul class='bar-menu'>
      </ul>
    </div>
  </div>
  <div id='deskContainer'></div>
  <div id='modalContainer'></div>
</div>
<script>
var entries = [
{
    id       : 'allapps',
    code     : 'allapps',
    name     : '<?php echo $lang->index->allEntries?>',
    display  : 'fullscreen',
    desc     : '<?php echo $lang->index->allEntries?>',
    menu     : 'menu',
    icon     : 'icon-th-large',
    sys      : true,
    forceMenu: true,
    order    : 9999999
}];

<?php if($this->app->user->admin == 'super'):?>
entries.push(
{
    id       : 'superadmin',
    code     : 'superadmin',
    name     : '<?php echo $lang->index->superAdmin;?>',
    open     : 'iframe',
    desc     : '<?php echo $lang->index->superAdmin?>',
    menu     : 'all',
    sys      : true,
    icon     : 'icon-cog',
    url      : "<?php echo $this->createLink('admin')?>",
    order    : 9999998
});
<?php endif;?>

var ipsLang = {};
<?php
foreach ($lang->index->ips as $key => $value)
{
    echo 'ipsLang["' . $key . '"] = "' . $value . '";';
}
?>

<?php echo $allEntries;?>
</script>
<?php include "../../common/view/footer.html.php"; ?>
