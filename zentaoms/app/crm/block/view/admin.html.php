<div class="modal-dialog" style="width:700px;">
  <div class="modal-content">
    <div class="modal-header">
      <?php echo html::closeButton();?>
      <h4 class="modal-title"><i class="icon-cog"></i> <?php echo $lang->block->admin; ?></h4>
    </div>
    <div class="modal-body">
      <form method='post' action='' class='form'>
        <table class='table table-form' style="border:none;">
          <tr><td></td><td><?php echo html::submitButton();?></td></tr>
        </table>
      </form>
    </div>
  </div>
</div>
