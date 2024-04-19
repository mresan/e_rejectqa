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
    span.select2-selection.select2-selection--single {
        border-radius: 0;
        padding: 0.25rem 0.5rem;
        padding-top: 0.25rem;
        padding-right: 0.5rem;
        padding-bottom: 0.25rem;
        padding-left: 0.5rem;
        height: auto;
    }
</style>
<form action="" id="departemen-form">
     <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
    <div class="container-fluid">
        <div class="form-group">
            <label for="name" class="control-label">Departemen</label>
            <input type="text" name="name" id="name" class="form-control rounded-0" value="<?php echo isset($name) ? $name :"" ?>" required>
        </div>
        <div class="form-group">
            <label for="name1" class="control-label">PIC</label>
            <textarea rows="3" name="name1" id="name1" class="form-control rounded-0" required><?php echo isset($name1) ? $name1 :"" ?></textarea>
        </div>
        <div class="form-group">
            <label for="name2" class="control-label">Pimpinan</label>
            <input type="text" name="name2" id="name2" class="form-control rounded-0" value="<?php echo isset($name2) ? $name2 :"" ?>" required>
        </div>
        <div class="form-group">
            <label for="name3" class="control-label">PIC QA</label>
            <input type="text" name="name3" id="name3" class="form-control rounded-0" value="<?php echo isset($name3) ? $name3 :"" ?>" required>
        </div>
		<div class="form-group">
            <label for="name4" class="control-label">Pimp. QA</label>
            <input type="text" name="name4" id="name4" class="form-control rounded-0" value="<?php echo isset($name4) ? $name4 :"" ?>" required>
        </div>
        <div class="form-group">
            <label for="email" class="control-label">Email</label>
            <input type="email" name="email" id="email" class="form-control rounded-0" value="<?php echo isset($email) ? $email :"" ?>" required>
        </div>
        <div class="form-group">
            <label for="status" class="control-label">Status</label>
            <select name="status" id="status" class="form-control rounded-0" required>
                <option value="1" <?php echo isset($status) && $status =="" ? "selected": "1" ?> >Active</option>
                <option value="0" <?php echo isset($status) && $status =="" ? "selected": "0" ?>>Inactive</option>
            </select>
        </div>
    </div>
</form>
<script>
    $(function(){
        $('#departemen-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_departemen",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.reload();
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: 0 }, "fast");
                    }else{
						alert_toast("An error occured",'error');
                        console.log(resp)
					}
                    end_loader()
				}
			})
		})
	})
</script>