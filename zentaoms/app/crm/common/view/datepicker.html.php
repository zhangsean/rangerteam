<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php
include $this->app->getBasePath() . 'app/sys/common/view/datepicker.html.php';
