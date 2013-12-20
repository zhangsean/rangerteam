<?php include '../../common/view/header.html.php';?>
<section id="reset">
  <div class="box-radius">
    <div class="panel panel-default">
      <div class="panel-heading"><h4><strong><?php echo $lang->user->recoverPassword;?></strong></h4></div>
      <div class="panel-body">
        <form method='post' id='ajaxForm'>
          <table> 
            <tr>
              <td><?php echo html::input('account', '', "class='text-box' placeholder='{$lang->user->inputAccountOrEmail}'");?></td>
            </tr>
            <tr>
              <td><?php echo html::submitButton($lang->user->submit,'btn btn-primary btn-block');?></td>
            </tr>
          </table>
        </form>
      </div>
    </div>  
  </div>
</section>
<?php include '../../common/view/footer.html.php';?>
