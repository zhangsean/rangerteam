<?php
include '../../common/view/header.html.php';
js::import($jsRoot . 'md5.js');
js::set('random', $this->session->random);
?>
<section id="login">
  <div class="box-radius">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading"><h4><strong><?php echo $lang->user->login->welcome;?></strong></h4></div>
          <div class="panel-body">
            <form method='post' id='ajaxForm' role='form'>
              <div class="form-group"><?php echo html::input('account','',"placeholder='{$lang->user->inputAccountOrEmail}' class='input-lg'");?></div>
              <div class="form-group"><?php echo html::password('password','',"placeholder='{$lang->user->inputPassword}' class='input-lg'");?></div>
              <?php echo html::submitButton($lang->user->login->common, 'btn btn-primary btn-wider btn-lg');?>
              <?php if($config->mail->turnon) echo html::a(inlink('resetpassword'), $lang->user->recoverPassword);?>
              <?php echo html::hidden('referer', $referer);?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include '../../common/view/footer.html.php';?>
