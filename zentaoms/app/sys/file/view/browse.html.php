<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title" id="ajaxModalTitle"><i class="icon-paper-clip"></i> <?php echo $lang->file->browse;?></h4>
    </div>
    <div class="modal-body">
      <table class='table table-bordered'>
        <thead>
          <tr>
            <th><?php echo $lang->file->id;?></th>
            <th><?php echo $lang->file->common;?></th>
            <th><?php echo $lang->file->extension;?></th>
            <th><?php echo $lang->file->size;?></th>
            <th><?php echo $lang->file->addedBy;?></th>
            <th><?php echo $lang->file->addedDate;?></th>
            <th style='width: 150px'><?php echo $lang->file->public;?></th>
            <th><?php echo $lang->file->downloads;?></th>
            <th><?php echo $lang->actions;?></th>
          </tr>          
        </thead>
        <tbody>
          <?php foreach($files as $file):?>
          <tr class='text-middle'>
            <td><?php echo $file->id;?></td>
            <td>
              <?php
              if($file->isImage)
              {
                  echo html::a(inlink('download', "id=$file->id"), html::image($file->smallURL, "class='image-small' title='{$file->title}'"), "target='_blank'");
                  if($file->primary == 1) echo '<small class="label label-success">'. $lang->file->primary .'</small>';
              }
              else
              {
                  echo html::a(inlink('download', "id=$file->id"), "{$file->title}.{$file->extension}", "target='_blank'");
              }
              ?>
            </td>
            <td><?php echo $file->extension;?></td>
            <td><?php echo $file->size;?></td>
            <td><?php echo $file->addedBy;?></td>
            <td><?php echo $file->addedDate;?></td>
            <td>
            <?php
            echo '<span>' . $lang->file->publics[$file->public] . '</span> ';
            echo html::a(inlink($file->public ? 'deny' : 'allow',  "id=$file->id"), $lang->file->toggle, 'class="option"');
            ?>
            </td>
            <td><?php echo $file->downloads;?></td>
            <td>
            <?php
            echo html::a(inlink('edit',   "id=$file->id"), $lang->edit, "class='edit'");
            echo html::a(inlink('delete', "id=$file->id"), $lang->delete, "class='deleter'");
            if($file->isImage) echo html::a(inlink('setPrimary', "id=$file->id"), $lang->file->setPrimary, "class='option'");
            ?>
            </td>
          </tr>
          <?php endforeach;?>          
        </tbody>

      </table>
      <form id="fileForm" method='post' enctype='multipart/form-data' action='<?php echo inlink('upload', "objectType=$objectType&objectID=$objectID");?>'>
        <table class='table table-form'>
          <?php if($writeable):?>
          <tr>
            <td class='text-middle'><?php echo $lang->file->upload . $lang->file->limit;?></td>
            <td><?php echo $this->fetch('file', 'buildForm');?></td>
          </tr>
          <tr><td colspan='2' class='text-center'><?php echo html::submitButton();?></td></tr>
          <?php else:?>
          <tr><td colspan='2'><h5 class='text-danger'><?php echo $lang->file->errorUnwritable;?></h5></td></tr>
          <?php endif;?>
        </table>
      </form>
    </div>
  </div>
</div>
<script>
$(document).ready(function()
{   
    $.setAjaxForm('#fileForm', function(data)
    {
        if(data.result == 'success') $.reloadAjaxModal(1500);
    }); 
    $.setAjaxLoader('.edit', '#ajaxModal');
    $('a.option').click(function(data)
    {
        $.getJSON($(this).attr('href'), function(data) 
        {
            if(data.result == 'success')
            {
                $.reloadAjaxModal();
            }
            else
            {
                alert(data.message);
            }
        });
        return false;
    });

    $(".modal-backdrop").click(function()
    {
        $('.modal').modal('hide');
    });
});
</script>
