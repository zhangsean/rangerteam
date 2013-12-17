<?php include '../../common/view/header.admin.html.php'; ?>
<form method='post' id='ajaxForm' enctype='multipart/form-data'>
  <table class='table table-form'>
    <caption><?php echo $lang->forum->update;?></caption>
    <tbody>
      <th class="w-150px"></th>
      <td class="v-middle">
        <?php echo $lang->forum->updateDesc;?>
        <?php echo html::submitButton($lang->forum->update) . html::hidden('action', 'update');?>
      </td>
    </tbody>
  </table>
</form>
<?php include '../../common/view/footer.admin.html.php'; ?>
