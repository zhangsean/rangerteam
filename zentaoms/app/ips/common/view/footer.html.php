<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
  <?php if(RUN_MODE == 'front') $this->loadModel('block')->printRegion($layouts, 'all', 'footer');?>
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
<?php if(RUN_MODE == 'front') $this->loadModel('block')->printRegion($layouts, 'all', 'end');?>
</body>
</html>
