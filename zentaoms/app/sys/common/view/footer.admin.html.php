<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php if($moduleMenu) echo '</div>';?>
</div>

<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
  <div class="collapse navbar-collapse navbar-ex6-collapse">
    <div class='navbar-text pull-right'><?php printf($lang->poweredBy, $config->version, $config->version);?></div>
  </div>
</nav>

<?php include 'footer.lite.html.php' ?>
</body>
</html>
