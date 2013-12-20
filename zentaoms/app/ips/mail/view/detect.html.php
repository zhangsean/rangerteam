<?php include '../../common/view/header.admin.html.php';?>
<form method='post' id='dataform'>
<table class='table' align='center'>
  <caption><?php echo $lang->mail->inputFromEmail;?></caption>
  <tr>
    <td class='a-center'>
      <?php echo html::input('fromAddress', $fromAddress, 'class=text-3') . html::submitButton($lang->mail->nextStep);?>
    </td>
  </tr>
</table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
