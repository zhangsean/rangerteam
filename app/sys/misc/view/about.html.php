<style>
#aboutNav {margin: 20px -15px -15px; background-color: #fafafa; padding: 10px; border-top: 1px solid #e5e5e5}
#aboutNav > .nav > li > a.text-important {color: #81511c}
#aboutNav > .nav > li > a.text-important:hover {background-color: #81511c; color: #fff}
#about {height: 200px; width:450px; margin:auto;}
</style>
<div id='about' class='text-center'>
  <div class='col-md-4'>
    <?php echo html::image($this->config->webRoot . 'theme/default/images/main/logo.login.png'); ?>
    <h4><?php printf($lang->misc->version, $config->version);?></h4>
  </div>
  <div class='col-md-4'>
    <ul class='nav nav-pills'>
      <li><?php echo html::a('http://www.ranzhico.com/ranzhisaas-plans.html', "<i class='icon-cloud'></i> " . $lang->misc->yunranzhi, "target='_blank' class='text-important'")?></li>
      <li><?php echo html::a('http://www.ranzhico.com', "<i class='icon-globe'></i> " . $lang->misc->offcialSite, "target='_blank'")?></li>
      <li><?php echo html::a('https://www.ranzhico.com/page/support.html', "<i class='icon-question-sign'></i> " . $lang->misc->support, "target='_blank'")?></li>
    </ul>
  </div>
  <div class='col-md-4'>
    <ul class='nav nav-pills'>
      <li><?php echo html::a('https://www.ranzhico.com/book/', "<i class='icon-book'></i> " . $lang->misc->userbook, "target='_blank'")?></li>
      <li><?php echo html::a('https://www.ranzhico.com/forum/', "<i class='icon-comments-alt'></i> " . $lang->misc->forum, "target='_blank'")?></li>
    </ul>
  </div>
</div>
