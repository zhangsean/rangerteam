<?php
/**
 * The index view file of index module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     index 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
include "../../common/view/header.lite.html.php";
css::import($themeRoot . 'default/ips.css');
js::import($jsRoot . 'jquery/ips.js');
?>
  <!-- Desktop -->
  <div id='desktop' class='fullscreen-mode' unselectable="on" style="-moz-user-select:none;-webkit-user-select:none;" onselectstart="return false;">
    <div id='leftBar' class='dock-left'>
      <div id='apps-menu'>
        <ul class='bar-menu'></ul>
      </div>
    </div>
    <div id='bottomBar' class='dock-bottom'>
      <button id='start' class='dock-left radiance'><img class='avatar-img' src='<?php echo $themeRoot . 'default/images/ips/avatar.jpg'?>' alt=''></button>
      <ul id='startMenu' class='dropdown-menu'>
        <li><a href='###' class='app-btn' data-id='profile'><img class='avatar-img' src='<?php echo $themeRoot . 'default/images/ips/avatar.jpg'?>' alt=''> <strong><?php echo $app->user->realname?></strong></a></li>
        <li class="divider"></li>
        <li><a href='<?php echo $this->createLink('entry', 'create') ?>' target='_blank' class=><i class='icon icon-plus'></i> <?php echo $lang->index->addEntry?></a></li>
        <li><a href='###' class='fullscreen-btn' data-id='allapps'><i class='icon icon-th-large'></i> <?php echo $lang->index->allEntries?><div class='pull-right'><span class='label label-badge entries-count'></span></div></a></li>
      </ul>
      <div id='taskbar'>
        <ul class='bar-menu'>
        </ul>
      </div>
      <div id='bottomRightBar' class='dock-right'>
        <ul class='bar-menu'>
          <li><button id='showDesk' class='fullscreen-btn icon-home' data-id='home' data-toggle='tooltip' title='<?php echo $lang->index->showDesk; ?>'></button></li>
        </ul>
      </div>
    </div>
    <div id='home' class='fullscreen fullscreen-active'>
      <div class='btn-toolbar actions'>
        <button data-toggle='tooltip' data-placement='bottom' data-id='addblcok' title='<?php echo $lang->index->addBlock; ?>' class='btn btn-pure app-btn'><i class='icon-plus'></i></button>
        <button data-target='#home' data-toggle-class='custom-mode' data-toggle='tooltip' data-placement='bottom' title='<?php echo $lang->index->customBlocks; ?>' class='btn btn-pure'><i class='icon-wrench'></i></button>
      </div>
      <div class='panels-container'>
        <div class='row'>
        <?php $index = 0;?>
        <?php foreach($blocks as $key => $block):?>
        <?php
        $index = str_replace('b', '', $key);
        $block = json_decode($block);
        ?>
          <div class='col-sm-6 col-md-4 col-lg-3'>
            <div class='panel' id='block<?php echo $index?>'>
              <div class='panel-heading'>
                <?php echo $block->name?>
                <div class='custom-actions'>
                  <a class='btn btn-mini edit-block' data-toggle='modal' href='<?php echo $this->createLink("block", "admin", "index=$index"); ?>'><i class='icon-pencil'></i></a>
                  <button class='btn btn-mini remove-block btn-danger' onclick='deleteBlock(<?php echo $index?>)'><i class='icon-remove'></i></button>
                </div>
              </div>
              <div class='panel-body no-padding'>
                <img src='<?php echo $themeRoot?>default/images/ips/loading.gif' style='display:block;margin:40px auto;'/>
              </div>
            </div>
          </div>
          <?php endforeach;?>
        </div>
      </div>
    </div>
    <div id='allapps' class='fullscreen'>
      <header>
        <div class='row'>
          <div class='col-md-4'>
            <h4><i class='icon-th-large'></i> <?php echo $lang->index->allEntries?> &nbsp;<small class='muted'><?php echo $lang->index->countEntries?></small></h4>
          </div>
          <div class='col-md-4'>
            <div class='search-input'>
              <i class='icon-search icon'></i>
              <input id='search' type='text' class='form-control-pure form-control'>
              <button id='cancelSearch' class='btn btn-pure btn-mini'><i class='icon-remove'></i></button>
            </div>
          </div>
          <div class='col-md-4 text-right'>
            <a class='btn btn-pure' href='<?php echo $this->createLink('entry', 'create') ?>' target='_blank'><i class='icon-plus'></i> <?php echo $lang->index->addEntry?></a>
          </div>
        </div>
      </header>
      <div class='all-apps-list' id='allAppsList'>
        <ul class='bar-menu'>
        </ul>
      </div>
    </div>
    <div id='deskContainer'>
    </div>
    <div id='modalContainer'>
    </div>
  </div>
<script>
var entries = new Array(
{
    id       : 'profile',
    url      : '<?php echo $this->createLink('user', 'profile')?>',
    name     : '<?php echo $lang->user->profile?>',
    open     : 'iframe',
    desc     : '<?php echo $lang->index->profile?>',
    display  : 'modal',
    size     : 'default',
    menu     : false,
    position : 'center',
    control  : 'full'
},
{
    id       : 'allapps',
    name     : '<?php echo $lang->index->allEntries?>',
    display  : 'fullscreen',
    desc     : '<?php echo $lang->index->allEntries?>',
    menu     : true,
    icon     : 'icon-th-large'
},
{
    id       : 'addblcok',
    url      : '<?php echo $this->createLink("block", "admin", "index=" . ($index + 1)); ?>',
    name     : '<?php echo $lang->index->addBlock; ?>',
    open     : 'iframe',
    display  : 'modal',
    size     : 'default',
    menu     : false,
    control  : 'full',
    icon     : 'icon-plus'
});

<?php echo $allEntries;?>
</script>
<?php
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
include "../../common/view/footer.lite.html.php";
?>
</body>
</html>
