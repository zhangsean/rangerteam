<?php include '../../common/view/header.admin.html.php';?>
<form method='post' id='ajaxForm'>
<table class='table' align='center'>
  <caption>
    <div class='f-left'> <?php echo $lang->mail->test;?></div>
  </caption>
  <tr>
    <td class='a-center'>
      <?php 
      echo html::input('to', $app->user->email, "class='text-3'");
      echo html::submitButton($lang->mail->test);
      echo html::linkButton($lang->mail->edit, inLink('edit'));
      ?>
    </td>
  </tr>
</table>
</form>
<table class='table-4 bd-none' align='center'><tr><td><iframe id='resultWin'></iframe></td></tr></table>
<?php include '../../common/view/footer.admin.html.php';?>
