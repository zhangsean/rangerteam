<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/treeview.html.php';?>

<?php $this->block->printRegion($layouts, 'index_index', 'header');?>
<div class='row'><?php $this->block->printRegion($layouts, 'index_index', 'bottom', "<div class='col-md-4'>", '</div>');?></div>
<?php $this->block->printRegion($layouts, 'index_index', 'footer');?>
<?php include '../../common/view/footer.html.php';?>
