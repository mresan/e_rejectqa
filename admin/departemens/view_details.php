<?php
require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `departemen_list` where id = '{$_GET['id']}' ");
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
            <dt class="col-md-4">Departemen</dt>
            <dd class="col-md-8">: <?php echo $name ?></dd>
            <dt class="col-md-4">PIC</dt>
            <dd class="col-md-8">: <span><?php echo $name1 ?></span></dd>
            <dt class="col-md-4">Pimpinan</dt>
            <dd class="col-md-8">: <?php echo $name2 ?></dd>
            <dt class="col-md-4">PIC QA</dt>
            <dd class="col-md-8">: <?php echo $name3 ?></dd>
			<dt class="col-md-4">Pimp. QA</dt>
            <dd class="col-md-8">: <?php echo $name4 ?></dd>
            <dt class="col-md-4">Email</dt>
            <dd class="col-md-8">: <?php echo $email ?></dd>
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