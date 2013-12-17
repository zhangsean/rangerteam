<?php include '../../common/view/header.admin.html.php';?>
<table class='table' align='center'>
  <caption><?php echo $lang->mail->save ?></caption>
  <tr>
    <th class="w-150px"></th>
    <td class="v-middle">
      <?php 
      echo $lang->mail->successSaved;
      if($this->post->turnon and $mailExist) echo html::linkButton($lang->mail->test, inlink('test'));
      ?>
    </td>
  </tr>
</table>
<?php include '../../common/view/footer.admin.html.php';?>
