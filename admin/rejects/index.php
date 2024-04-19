<!DOCTYPE html>
<html lang="en">

<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Reject</h3>
		<div class="card-tools">
			<?php if($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): ?>
				<a href="?page=rejects/manage_reject" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
			<?php endif; ?>
		</div>
	</div>
	<div class="card-body">
		<div class="row">
        <div class="container-fluid">
			<table id="table" class="table table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="14%">
					<col width="16%">
					<col width="10%">
					<col width="7%">
					<col width="10%">
					<col width="8%">
					<col width="9%">
					<col width="8%">
					<col width="16%">
				</colgroup>
				<thead>
					<tr class="bg-navy disabled text-center align-midle">
						<th>No</th>
						<th>Date Created</th>
						<th>Reject No</th>
						<th>Departemen</th>
						<th>Items</th>
						<th>Pimp. Prod.</th>
						<th>Pic QA</th>
						<th>Pimp. QA</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						if($_settings->userdata('type') == 1 || $_settings->userdata('type') == 4 || $_settings->userdata('type') == 5):
							$qry = $conn->query("SELECT reject.*, s.name as sname FROM `reject_list` reject inner join `departemen_list` s on reject.departemen_id = s.id order by unix_timestamp(reject.date_updated)");
						
						elseif($_settings->userdata('type') == 2 && $_settings->userdata('username') == 'user-sales'):
							$qry = $conn->query("SELECT reject.*, s.name as sname FROM `reject_list` reject inner join `departemen_list` s on reject.departemen_id = s.id WHERE name = 'Sales' order by unix_timestamp(reject.date_updated)");
						
						elseif($_settings->userdata('type') == 3 && $_settings->userdata('username') == 'pimp-sales'):
							$qry = $conn->query("SELECT reject.*, s.name as sname FROM `reject_list` reject inner join `departemen_list` s on reject.departemen_id = s.id WHERE name = 'Sales' order by unix_timestamp(reject.date_updated)");
						
						elseif($_settings->userdata('type') == 2 && $_settings->userdata('username') == 'user-prod'):
							$qry = $conn->query("SELECT reject.*, s.name as sname FROM `reject_list` reject inner join `departemen_list` s on reject.departemen_id = s.id WHERE name = 'Produksi' order by unix_timestamp(reject.date_updated)");
						
						elseif($_settings->userdata('type') == 3 && $_settings->userdata('username') == 'pimp-prod'):
							$qry = $conn->query("SELECT reject.*, s.name as sname FROM `reject_list` reject inner join `departemen_list` s on reject.departemen_id = s.id WHERE name = 'Produksi' order by unix_timestamp(reject.date_updated)");
						
						elseif($_settings->userdata('type') == 2 && $_settings->userdata('username') == 'user-pc'):
							$qry = $conn->query("SELECT reject.*, s.name as sname FROM `reject_list` reject inner join `departemen_list` s on reject.departemen_id = s.id WHERE name = 'PC RMWH' OR name = 'PC FGWH' order by unix_timestamp(reject.date_updated)");
						
						elseif($_settings->userdata('type') == 3 && $_settings->userdata('username') == 'pimp-pc'):
							$qry = $conn->query("SELECT reject.*, s.name as sname FROM `reject_list` reject inner join `departemen_list` s on reject.departemen_id = s.id WHERE name = 'PC RMWH' OR name = 'PC FGWH' order by unix_timestamp(reject.date_updated)");
						
						endif;
						while($row = $qry->fetch_assoc()):
							$row['item_count'] = $conn->query("SELECT * FROM order_items where reject_id = '{$row['id']}'")->num_rows;
					?>
						<tr class="align-midle">
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo date("d-m-Y H:i",strtotime($row['date_created3'])) ; ?></td>
							<td class="text-center" style="text-transform:uppercase"><?php echo $row['reject_no'] ?></td>
							<td class="text-center" style="text-transform:uppercase"><?php echo $row['sname'] ?></td>
							<td class="text-center"><?php echo number_format($row['item_count']) ?></td>
							<td class="text-center">
								<?php 
									switch ($row['status1']) {
										case '1':
											echo '<span class="badge badge-primary">Approved</span>';
											break;
										case '2':
											echo '<span class="badge badge-danger">Denied</span>';
											break;
										default:
											echo '<span class="badge badge-warning">Pending</span>';
											break;
									}
								?>
							</td>
							<td class="text-center">
								<?php 
									switch ($row['status2']) {
										case '1':
											echo '<span class="badge badge-primary">Approved</span>';
											break;
										case '2':
											echo '<span class="badge badge-danger">Denied</span>';
											break;
										default:
											echo '<span class="badge badge-warning">Pending</span>';
											break;
									}
								?>
							</td>
							<td class="text-center">
								<?php 
									switch ($row['status3']) {
										case '1':
											echo '<span class="badge badge-primary">Approved</span>';
											break;
										case '2':
											echo '<span class="badge badge-danger">Denied</span>';
											break;
										default:
											echo '<span class="badge badge-warning">Pending</span>';
											break;
									}
								?>
							</td>
							<td class="text-center">
								<?php if($row['status1'] == 1 && $row['status2'] == 1 && $row['status3'] == 1): ?>
									<h5><span class="badge badge-success">CLOSE</span></h5>
								<?php else: ?>
									<h5><span class="badge badge-danger">OPEN</span></h5>
								<?php endif; ?>
							</td>
							<td align="center">


										<a class="btn btn-sm btn-flat btn-info" href="?page=rejects/view_reject&id=<?php echo $row['id'] ?>"><i class="fa fa-eye"></i></a>
										
										
										<?php if($_settings->userdata('type') == 1): ?>
											<a class ="btn btn-sm btn-flat btn-secondary" href="?page=rejects/manage_reject&id=<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></a>
										<?php elseif($_settings->userdata('type') == 2 && $row['status1'] == 1): ?>
											<a class ="btn btn-sm btn-flat btn-secondary disabled" href="?page=rejects/manage_reject&id=<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></a>
										<?php elseif($_settings->userdata('type') == 4 && $row['status1'] == 0): ?>
											<a class ="btn btn-sm btn-flat btn-secondary disabled" href="?page=rejects/manage_reject&id=<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></a>
										<?php elseif($_settings->userdata('type') == 5 && $row['status2'] == 0): ?>
											<a class ="btn btn-sm btn-flat btn-secondary disabled" href="?page=rejects/manage_reject&id=<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></a>
										<?php elseif($row['status1'] == 1 && $row['status2'] == 1 && $_settings->userdata('type') == 3): ?>
											<a class ="btn btn-sm btn-flat btn-secondary disabled" href="?page=rejects/manage_reject&id=<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></a>
										<?php elseif ($row['status1'] == 1 && $row['status2'] == 1 && $row['status3'] == 1): ?>
											<a class ="btn btn-sm btn-flat btn-secondary disabled" href="?page=rejects/manage_reject&id=<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></a>
										<?php else: ?>
											<a class="btn btn-sm btn-flat btn-secondary" href="?page=rejects/manage_reject&id=<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></a>
										<?php endif; ?>
										
										
										<?php if($_settings->userdata('type') == 1): ?> 
											<a class="btn btn-sm btn-flat btn-danger delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i></a>
										<?php elseif($_settings->userdata('type') == 2 && $row['status1'] == 1): ?>
											<a class="btn btn-sm btn-flat btn-danger delete_data disabled" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i></a>
										<?php elseif($_settings->userdata('type') == 3 && $row['status1'] == 0 || $row['status1'] == 1): ?>
											<a class="btn btn-sm btn-flat btn-danger delete_data disabled" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i></a>
										<?php elseif($_settings->userdata('type') == 3 && $row['status1'] == 2): ?>
											<a class="btn btn-sm btn-flat btn-danger delete_data disabled" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i></a>
										<?php elseif($row['status1'] == 1 && $row['status2'] == 1 && $_settings->userdata('type') == 3 || $_settings->userdata('type') == 4 || $_settings->userdata('type') == 5): ?>
											<a class="btn btn-sm btn-flat btn-danger delete_data disabled" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i></a>
										<?php elseif ($row['status1'] == 1 && $row['status2'] == 1 && $row['status3'] == 1): ?>
											<a class="btn btn-sm btn-flat btn-danger delete_data disabled" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i></a>
										<?php else: ?>
											<a class="btn btn-sm btn-flat btn-danger delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i></a>
										<?php endif; ?>
									</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>

	<script src="/e_rejectqa/plugins/bootstrap/js/jquery.min.js"></script>
    <script src="/e_rejectqa/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Datatables -->
	<script src="/e_rejectqa/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/e_rejectqa/plugins/datatables/dataTables.bootstrap4.min.js"></script>

    <script src="/e_rejectqa/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/e_rejectqa/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/e_rejectqa/plugins/jszip/jszip.min.js"></script>
    <script src="/e_rejectqa/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="/e_rejectqa/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/e_rejectqa/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/e_rejectqa/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/e_rejectqa/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
	
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this rent permanently?","delete_reject",[$(this).attr('data-id')])
		})
		$('.view_details').click(function(){
			uni_modal("Reservaton Details","rejects/view_details.php?id="+$(this).attr('data-id'),'mid-large')
		})
	})
	function delete_reject($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_reject",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occuredDEL.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status1 == 'success'){
					location.reload();
				}
				if(typeof resp== 'object' && resp.status2 == 'success'){
					location.reload();
				}
				if(typeof resp== 'object' && resp.status3 == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
	
	var table = $("#table").DataTable({
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    })
	.buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
</script>
</html>