<?php
require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `item_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=stripslashes($v);
        }
    }
}
?>
<style>
    #uni_modal .modal-footer{
        display:none
    }
</style>
<div class="container fluid">
    <callout class="callout-primary">
        <dl class="row">
            <dt class="col-md-4">No Part</dt>
            <dd class="col-md-8">: <?php echo $no_item ?></dd>
            <dt class="col-md-4">Nama Part</dt>
            <dd class="col-md-8">: <?php echo $name_item ?></dd>
			<dt class="col-md-4">Kode Part</dt>
            <dd class="col-md-8">: <?php echo $code_item ?></dd>
            <dt class="col-md-4">Status</dt>
            <dd class="col-md-8">:&nbsp;
                <?php if($status == 1): ?>
                    <span class="badge badge-success">Active</span>
                <?php else: ?>
                    <span class="badge badge-secondary">Inactive</span>
                <?php endif; ?>
            </dd>
        </dl>
    </callout>
    <div class="row px-2 justify-content-end">
        <div class="col-1">
            <button class="btn btn-dark btn-flat btn-sm" type="button" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>