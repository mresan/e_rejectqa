<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Part</h3>
		<div class="card-tools">
			<form action="/e_rejectqa/admin/items/import_csv.php" id="import-form" method="POST" enctype="multipart/form-data">
				<?php if($_settings->userdata('type') == 1): ?>
					<button type="button" class="btn btn-flat btn-danger" data-target="#modal_confirm" data-toggle="modal"><span class="fas fa-trash"></span> Delete All</button>
					<input type="file" accept=".csv" name="fileData" id="fileData" required>
					<button class="btn btn-flat btn-warning" form="import-form"><span class="fas fa-upload"></span>  Import</button>
				<?php endif; ?>
				<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
			</form>
			
		</div>		
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="17%">
					<col width="12%">
					<col width="27%">
					<col width="12%">
					<col width="8%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr class="bg-navy disabled text-center align-midle">
						<th>#</th>
						<th>Tanggal Buat</th>
						<th>No Part</th>
						<th>Nama Part</th>
						<th>Kode Part</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					$qry = $conn->query("SELECT * from `item_list` order by (`no_item`) asc ");
					while($row = $qry->fetch_assoc()):
						$row['name_item'] = html_entity_decode($row['name_item']);
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td class="text-center"><?php echo $row['no_item'] ?></td>
							<td style="text-transform:uppercase" title="<?php echo $row['name_item'] ?>"><?php echo $row['name_item'] ?></td>
							<td style="text-transform:uppercase" class="text-center"><?php echo $row['code_item'] ?></td>
							<td class="text-center">
								<?php if($row['status'] == 1): ?>
									<span class="badge badge-success">Active</span>
								<?php else: ?>
									<span class="badge badge-secondary">Inactive</span>
								<?php endif; ?>
							</td>
							<td align="center">

				                    <a class="btn btn-sm btn-flat btn-info view_data" href="javascript:void(0)" data-id = "<?php echo $row['id'] ?>"><i class="fa fa-eye"></i></a>
									<a class="btn btn-sm btn-flat btn-secondary edit_data" href="javascript:void(0)" data-id = "<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></a>
									<?php if($_settings->userdata('type') == 1): ?>	
										<a class="btn btn-sm btn-flat btn-danger delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i></a>
									<?php endif; ?>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
	
	<div class="modal fade" id="modal_confirm" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">System</h5>
				</div>
				<div class="modal-body">
					<center><h6>Are you sure you want to delete all data?</h6></center>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
					<a type="button" class="btn btn-success" href="/e_rejectqa/admin/items/delete_all.php">Yes</a>
				</div>
			</div>
		</div>
	</div>
	
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this item permanently?","delete_item",[$(this).attr('data-id')])
		})
		$('#create_new').click(function(){
			uni_modal("<i class='fa fa-plus'></i> Create New item","items/manage_item.php")
		})
		$('.view_data').click(function(){
			uni_modal("<i class='fa fa-info-circle'></i> item's Details","items/view_details.php?id="+$(this).attr('data-id'),"")
		})
		$('.edit_data').click(function(){
			uni_modal("<i class='fa fa-edit'></i> Edit item's Details","items/manage_item.php?id="+$(this).attr('data-id'))
		})
		$('.table th,.table td').addClass('px-1 py-0 align-middle')
		$('.table').dataTable();
	})
	function delete_item($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_item",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>