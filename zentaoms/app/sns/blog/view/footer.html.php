<?php
/**
 * The footer view file of blog category of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
  <footer class="footer">
    <div class='a-center mb-20px'>
      <?php 
      echo "&copy; {$config->company->name} {$config->site->copyright}-" . date('Y') . '&nbsp;&nbsp;';
      echo $config->site->icp;
      printf($lang->poweredBy, $config->version, $config->version);
      echo html::a(helper::createLink('rss', 'index', '', '', 'xml') . '?type=blog', '<i class="icon icon-rss-sign icon-large"></i>', "target='_blank'");
      ?>
    </div>
  </footer>
   
<?php
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
if(isset($pageJS)) js::execute($pageJS);
?>
</div>
</body>
</html>
