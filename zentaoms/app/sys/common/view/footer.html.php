<?php
/**
 * The footer view of common module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     common 
 * @version     $Id: footer.html.php 2605 2013-12-23 09:12:58Z wwccss $
 * @link        http://www.zentao.net
 */
if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}
?>
  <footer id="footer" class="clearfix">
    <div id="footNav">
      <?php
      echo html::a($this->createLink('sitemap', 'index'), '<i class="icon-sitemap"></i> ' . $lang->sitemap->common);

      if(empty($this->config->links->index) && !empty($this->config->links->all)) echo "&nbsp;" . html::a($this->createLink('links', 'index'), '<i class="icon-heart"></i>' . $this->lang->link);
      ?>
    </div>
    <span id="copyrightInfo">
    <?php echo "&copy; {$config->company->name} {$config->site->copyright}-" . date('Y') . '&nbsp;&nbsp;';?>
    </span>
    <span id="icpInfo"><?php echo $config->site->icp; ?></span>
    <div id="powerby">
      <?php printf($lang->poweredBy, $config->version, $config->version);?>
    </div>
  </footer>
   
<?php
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
if(isset($pageJS)) js::execute($pageJS);

/* Load hook files for current page. */
$extPath      = dirname(dirname(dirname(__FILE__))) . '/common/ext/view/';
$extHookRule  = $extPath . 'footer.front.*.hook.php';
$extHookFiles = glob($extHookRule);
if($extHookFiles) foreach($extHookFiles as $extHookFile) include $extHookFile;

/* Load hook file for site.*/
$siteExtPath  = dirname(dirname(dirname(__FILE__))) . "/common/ext/_{$config->site->code}/view/";
$extHookRule  = $siteExtPath . 'footer.front.*.hook.php';
$extHookFiles = glob($extHookRule);
if($extHookFiles) foreach($extHookFiles as $extHookFile) include $extHookFile;
?>
</div>
</body>
</html>
