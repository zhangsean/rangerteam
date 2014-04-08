<?php
/**
 * The footer view file of blog category of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
  <footer class="footer">
    <div class='a-center mb-20px'>
      <?php 
      echo "&copy; {$config->company->name} -" . date('Y') . '&nbsp;&nbsp;';
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
