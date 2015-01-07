<style>
#aboutNav {margin: 20px -15px -15px; background-color: #fafafa; padding: 10px; border-top: 1px solid #e5e5e5}
#aboutNav > .nav > li > a.text-important {color: #81511c}
#aboutNav > .nav > li > a.text-important:hover {background-color: #81511c; color: #fff}
</style>
<div class='text-center'>
  <?php echo html::image($this->config->webRoot . 'theme/default/images/main/logo.png'); ?>
  <h4><?php printf($lang->misc->version, $config->version);?></h4>
  <div id='aboutNav' class='clearfix'>
    <ul class='nav nav-pills pull-left'>
      <li><?php echo html::a('http://www.ranzhico.com', $lang->misc->offcialSite, "target='_blank'")?></li>
      <li><?php echo html::a('https://www.ranzhico.com/page/support.html', $lang->misc->support, "target='_blank'")?></li>
      <li><?php echo html::a('https://www.ranzhico.com/book/', $lang->misc->userbook, "target='_blank'")?></li>
      <li><?php echo html::a('https://www.ranzhico.com/forum/', $lang->misc->forum, "target='_blank'")?></li>
    </ul>
    <ul class='nav nav-pills pull-right'>
      <li><?php echo html::a('http://www.ranzhico.com/ranzhisaas-plans.html', $lang->misc->yunranzhi, "target='_blank' class='text-important'")?></li>
    </ul>
  </div>
</div>
