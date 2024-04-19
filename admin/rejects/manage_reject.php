<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `reject_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
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
	/* Chrome, Safari, Edge, Opera */
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
		}

		/* Firefox */
		input[type=number] {
		-moz-appearance: textfield;
		}
		[name="tax_percentage"],[name="discount_percentage"]{
			width:5vw;
		}
</style>
<div class="card card-outline card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update Reject Details": "New Reject Card" ?> </h3>
	</div>
	<div class="card-body">
		<form action="" id="reject-form">
			<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
			<div class="row">
				<div class="col-md-6 form-group">
				<label for="departemen_id">Departemen</label>
				<?php if($_settings->userdata('type') == 3 || $_settings->userdata('type') == 4 || $_settings->userdata('type') == 5): ?>
					<select name="departemen_id" id="departemen_id" class="custom-select custom-select-sm rounded-0 select2" disabled/>
				<?php else: ?>
					<select name="departemen_id" id="departemen_id" class="custom-select custom-select-sm rounded-0 select2">
				<?php endif; ?>
						<option value="" disabled <?php echo !isset($departemen_id) ? "selected" :'' ?>></option>
						<?php 
							$departemen_qry = $conn->query("SELECT * FROM `departemen_list` order by `name` asc");
							while($row = $departemen_qry->fetch_assoc()):
						?>
						<option value="<?php echo $row['id'] ?>" <?php echo isset($departemen_id) && $departemen_id == $row['id'] ? 'selected' : '' ?> <?php echo $row['status'] == 0? 'disabled' : '' ?>><?php echo $row['name'] ?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="col-md-6 form-group">
					<label for="reject_no">No Reject <span class="po_err_msg text-danger"></span></label>
					<?php if($_settings->userdata('type') == 3 || $_settings->userdata('type') == 4 || $_settings->userdata('type') == 5): ?>
						<input type="text" class="form-control form-control-sm rounded-0" id="reject_no" name="reject_no" style="text-transform:uppercase" value="<?php echo isset($reject_no) ? $reject_no : '' ?>" readonly/>
					<?php else: ?>
						<input type="text" class="form-control form-control-sm rounded-0" id="reject_no" name="reject_no" style="text-transform:uppercase" value="<?php echo isset($reject_no) ? $reject_no : '' ?>">
					<?php endif; ?>
					<small><i>No reject wajib diisi</i></small>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<table class="table table-striped table-bordered" id="item-list">
						<colgroup>
							<col width="5%">
							<col width="8%">
							<col width="23%">
							<col width="8%">
							<col width="7%">
							<col width="7%">
							<col width="7%">
							<col width="10%">
							<col width="26%">
						</colgroup>
						<thead>
							<tr class="bg-navy disabled">
								<th class="px-1 py-1 text-center"></th>
								<th class="px-1 py-1 text-center">No Part</th>
								<th class="px-1 py-1 text-center">Nama Part</th>
								<th class="px-1 py-1 text-center">Kode Part</th>
								<th class="px-1 py-1 text-center">Tipe</th>								
								<th class="px-1 py-1 text-center">NoLot</th>
								<th class="px-1 py-1 text-center">Qty</th>
								<th class="px-1 py-1 text-center">Faktor Mesin/Tester</th>
								<th class="px-1 py-1 text-center">Keterangan</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if(isset($id)):
							$order_items_qry = $conn->query("SELECT o.*,i.no_item, i.name_item, i.code_item FROM `order_items` o inner join item_list i on o.item_id = i.id where o.`reject_id` = '$id' ");
							echo $conn->error;
							while($row = $order_items_qry->fetch_assoc()):
							?>
							<tr class="reject-item" data-id="">
							<?php if($_settings->userdata('type') == 3 || $_settings->userdata('type') == 4 || $_settings->userdata('type') == 5): ?>
								<td class="align-middle p-1 text-center">
									<button class="btn btn-sm btn-danger py-0" type="button" disabled onclick="rem_item($(this))"><i class="fa fa-times"></i></button>
								</td>
							<?php else: ?>
								<td class="align-middle p-1 text-center">
									<button class="btn btn-sm btn-danger py-0" type="button" onclick="rem_item($(this))"><i class="fa fa-times"></i></button>
								</td>
							<?php endif; ?>
							
							<?php if($_settings->userdata('type') == 3 || $_settings->userdata('type') == 4 || $_settings->userdata('type') == 5): ?>
								<td class="align-middle p-1">
									<input type="hidden" name="item_id[]" value="<?php echo $row['item_id'] ?>">
									<input type="text" class="text-center w-100 border-0 item_id" value="<?php echo $row['no_item'] ?>" required/ readonly/>
								</td>
							<?php else: ?>
									<td class="align-middle p-1">
									<input type="hidden" name="item_id[]" value="<?php echo $row['item_id'] ?>">
									<input type="text" class="text-center w-100 border-0 item_id" value="<?php echo $row['no_item'] ?>" required/>
								</td>
							<?php endif; ?>
							
								<td class="align-middle p-1 item-name_item"><?php echo $row['name_item'] ?></td>
								<td class="text-center align-middle p-1 item-code_item"><?php echo $row['code_item'] ?></td>
								
							<?php if($_settings->userdata('type') == 3 || $_settings->userdata('type') == 4 || $_settings->userdata('type') == 5): ?>
								<td class="align-middle p-1">
									<input type="text" class="text-center w-100 border-0" name="type_item[]" value="<?php echo $row['type_item'] ?>" readonly/>
								</td>
							<?php else: ?>
								<td class="align-middle p-1">
									<input type="text" class="text-center w-100 border-0" name="type_item[]" value="<?php echo $row['type_item'] ?>">
								</td>
							<?php endif; ?>
							
							<?php if($_settings->userdata('type') == 3 || $_settings->userdata('type') == 4 || $_settings->userdata('type') == 5): ?>
								<td class="align-middle p-1">
									<input type="text" class="text-center w-100 border-0" name="no_lot[]" value="<?php echo $row['no_lot'] ?>" readonly/>
								</td>
							<?php else: ?>
								<td class="align-middle p-1">
									<input type="text" class="text-center w-100 border-0" name="no_lot[]" value="<?php echo $row['no_lot'] ?>"/>
								</td>
							<?php endif; ?>
							
							<?php if($_settings->userdata('type') == 3 || $_settings->userdata('type') == 4 || $_settings->userdata('type') == 5): ?>
								<td class="align-middle p-0 text-center">
									<input type="number" class="text-center w-100 border-0" step="any" name="qty[]" value="<?php echo $row['qty'] ?>" readonly/>
								</td>
							<?php else: ?>
								<td class="align-middle p-0 text-center">
									<input type="number" class="text-center w-100 border-0" step="any" name="qty[]" value="<?php echo $row['qty'] ?>"/>
								</td>
							<?php endif; ?>
							
							<?php if($_settings->userdata('type') == 3 || $_settings->userdata('type') == 4 || $_settings->userdata('type') == 5): ?>
								<td class="align-middle p-1">
									<input type="text" class="text-center w-100 border-0" name="factor_mt[]" value="<?php echo $row['factor_mt'] ?>" readonly/>
								</td>
							<?php else: ?>
								<td class="align-middle p-1">
									<input type="text" class="text-center w-100 border-0" name="factor_mt[]" value="<?php echo $row['factor_mt'] ?>"/>
								</td>
							<?php endif; ?>
							
							<?php if($_settings->userdata('type') == 3 || $_settings->userdata('type') == 4 || $_settings->userdata('type') == 5): ?>
								<td class="align-middle p-1">
									<input type="text" class="text-center w-100 border-0" name="ket[]" value="<?php echo $row['ket'] ?>" readonly/>
								</td>
							<?php else: ?>
								<td class="align-middle p-1">
									<input type="text" class="text-center w-100 border-0" name="ket[]" value="<?php echo $row['ket'] ?>"/>
								</td>
							<?php endif; ?>	
							</tr>
							<?php endwhile;endif; ?>
						</tbody>
						<tfoot>
							<tr class="bg-lightblue">
								<tr>
									<?php if($_settings->userdata('type') == 3 || $_settings->userdata('type') == 4 || $_settings->userdata('type') == 5): ?>
										<th class="p-1 text-right" colspan="0"><span><button class="btn btn btn-sm btn-flat btn-primary py-0 mx-1" type="button" id="add_row" disabled/>Add</button>
									<?php else: ?>
										<th class="p-1 text-right" colspan="0"><span><button class="btn btn btn-sm btn-flat btn-primary py-0 mx-1" type="button" id="add_row">Add</button>
									<?php endif; ?>	
								</tr>
							</tr>
						</tfoot>
					</table>
					<div class="row">
						<div class="col-md-6">
							<label for="notes" class="control-label">Notes</label>
							<textarea name="notes" id="notes" cols="10" rows="4" class="form-control rounded-0"><?php echo isset($notes) ? $notes : '' ?></textarea>
						</div>
					<?php if($_settings->userdata('type') == 3 || $_settings->userdata('type') == 4 || $_settings->userdata('type') == 5 || $_settings->userdata('type') == 1): ?>
						<div class="col-md-6">
							<?php if($_settings->userdata('type') == 3 || $_settings->userdata('type') == 1): ?>
								<label for="status1" class="control-label">Pimp. Prod.</label>
								<select name="status1" id="status1" class="form-control form-control-sm rounded-0">
									<option value="0" <?php echo isset($status1) && $status1 == 0 ? 'selected': '' ?>>Pending</option>
									<option value="1" <?php echo isset($status1) && $status1 == 1 ? 'selected': '' ?>>Approved</option>
									<option value="2" <?php echo isset($status1) && $status1 == 2 ? 'selected': '' ?>>Denied</option>
								</select>
							<?php endif; ?>
							<?php if($_settings->userdata('type') == 4 && $status1 == 1 || $_settings->userdata('type') == 1): ?>
								<label for="status2" class="control-label">Pic QA</label>
								<select name="status2" id="status2" class="form-control form-control-sm rounded-0">
									<option value="0" <?php echo isset($status2) && $status2 == 0 ? 'selected': '' ?>>Pending</option>
									<option value="1" <?php echo isset($status2) && $status2 == 1 ? 'selected': '' ?>>Approved</option>
									<option value="2" <?php echo isset($status2) && $status2 == 2 ? 'selected': '' ?>>Denied</option>
								</select>
							<?php endif; ?>
							<?php if($_settings->userdata('type') == 5 && $status1 == 1 && $status2 == 1 || $_settings->userdata('type') == 1): ?>
								<label for="status3" class="control-label">Pimp. QA</label>
								<select name="status3" id="status3" class="form-control form-control-sm rounded-0">
									<option value="0" <?php echo isset($status3) && $status3 == 0 ? 'selected': '' ?>>Pending</option>
									<option value="1" <?php echo isset($status3) && $status3 == 1 ? 'selected': '' ?>>Approved</option>
									<option value="2" <?php echo isset($status3) && $status3 == 2 ? 'selected': '' ?>>Denied</option>
								</select>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="reject-form">Save</button>
		<a class="btn btn-flat btn-default" href="?page=rejects">Cancel</a>
	</div>
</div>
<table class="d-none" id="item-clone">
	<tr class="reject-item" data-id="">
		<td class="align-middle p-1 text-center">
			<button class="btn btn-sm btn-danger py-0" type="button" onclick="rem_item($(this))"><i class="fa fa-times"></i></button>
		</td>
		<td class="align-middle p-1">
			<input type="hidden" name="item_id[]">
			<input type="text" class="text-center w-100 border-0 item_id" required/>
		</td>
		<td style="text-transform:uppercase" class="align-middle p-1 item-name_item"></td>
		<td style="text-transform:uppercase" class="align-middle p-1 item-code_item text-center"></td>
		<td class="align-middle p-1">
			<input style="text-transform:uppercase" type="text" class="text-center w-100 border-0" name="type_item[]"/>
		</td>
		<td class="align-middle p-1">
			<input style="text-transform:uppercase" type="text" class="text-center w-100 border-0" name="no_lot[]"/>
		</td>
		<td class="align-middle p-0 text-center">
			<input type="number" class="text-center w-100 border-0" step="any" name="qty[]"/>
		</td>
		<td class="align-middle p-1">
			<select style="text-transform:uppercase" id="factor_mt" class="form-control form-control-sm rounded-2" name="factor_mt[]">
				<option value="YA">YA</option>
				<option value="TIDAK">TIDAK</option>
			</select>
		</td>
		<td class="align-middle p-1">
			<input type="text" class="text-center w-100 border-0" name="ket[]" style="text-transform:uppercase"/>
		</td>	

	</tr>
</table>
<script>
	function rem_item(_this){
		_this.closest('tr').remove()
	}

	function _autocomplete(_item){
		_item.find('.item_id').autocomplete({
			source:function(request, response){
				$.ajax({
					url:_base_url_+"classes/Master.php?f=search_items",
					method:'POST',
					data:{q:request.term},
					dataType:'json',
					error:err=>{
						console.log(err)
					},
					success:function(resp){
						response(resp)
					}
				})
			},
			select:function(event,ui){
				console.log(ui)
				_item.find('input[name="item_id[]"]').val(ui.item.id)
				_item.find('.item-name_item').text(ui.item.name_item)
				_item.find('.item-code_item').text(ui.item.code_item)
			}
		})
	}
	$(document).ready(function(){
		$('#add_row').click(function(){
			var tr = $('#item-clone tr').clone()
			$('#item-list tbody').append(tr)
			_autocomplete(tr)

		})
		if($('#item-list .reject-item').length > 0){
			$('#item-list .reject-item').each(function(){
				var tr = $(this)
				_autocomplete(tr)
			})
		}else{
		$('#add_row').trigger('click')
		}
        $('.select2').select2({placeholder:"Please Select here",width:"relative"})
		$('#reject-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			$('.err-msg').remove();
			$('[name="reject_no"]').removeClass('border-danger')
			if($('#item-list .reject-item').length <= 0){
				alert_toast(" Please add atleast 1 item on the list.",'warning')
				return false;
			}
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_reject",
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
					if(typeof resp =='object' && resp.status1 == 'success'){
						location.href = "./?page=rejects/view_reject&id="+resp.id;
					}
					else if((resp.status1 == 'failed' || resp.status1 == 'reject_failed') && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: 0 }, "fast");
                            end_loader()
							if(resp.status1 == 'reject_failed'){
								$('[name="reject_no"]').addClass('border-danger').focus()
							}
                    }
					else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})

        
	})
</script>