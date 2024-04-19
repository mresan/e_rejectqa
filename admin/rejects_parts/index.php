<!DOCTYPE html>
<html lang="en">

<div class="row">	
	<div class="info-box">
		<div class="container-fluid">
			<h6>Part Rejected</h6>
			<table id="table" class="table table-sm table-striped">
				<colgroup>
					<col width="2%">
					<col width="6%">
					<col width="7%">
					<col width="5%">
					<col width="15%">
					<col width="5%">
					<col width="5%">
					<col width="3%">
					<col width="3%">
					<col width="5%">
					<col width="16%">
				</colgroup>
				<thead>
					<tr class="bg-navy disabled text-center">
						<th>No</th>
						<th>No Reject</th>
						<th>Date</th>
						<th>No Part</th>
						<th>Name Part</th>
						<th>Code Part</th>
						<th>Type</th>
						<th>No Lot</th>
						<th>Qty</th>
						<th>Fact M/T</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						if($_settings->userdata('type') == 1 || $_settings->userdata('type') == 4 || $_settings->userdata('type') == 5):
							$qry = $conn->query("SELECT * FROM order_items INNER JOIN item_list ON order_items.item_id = item_list.id INNER JOIN reject_list ON order_items.reject_id = reject_list.id INNER JOIN departemen_list ON reject_list.departemen_id = departemen_list.id");
						elseif($_settings->userdata('type') == 2 && $_settings->userdata('username') == 'user-sales'):
							$qry = $conn->query("SELECT * FROM order_items INNER JOIN item_list ON order_items.item_id = item_list.id INNER JOIN reject_list ON order_items.reject_id = reject_list.id INNER JOIN departemen_list ON reject_list.departemen_id = departemen_list.id WHERE name = 'Sales'");
						elseif($_settings->userdata('type') == 3 && $_settings->userdata('username') == 'pimp-sales'):
							$qry = $conn->query("SELECT * FROM order_items INNER JOIN item_list ON order_items.item_id = item_list.id INNER JOIN reject_list ON order_items.reject_id = reject_list.id INNER JOIN departemen_list ON reject_list.departemen_id = departemen_list.id WHERE name = 'Sales'");
						elseif($_settings->userdata('type') == 2 && $_settings->userdata('username') == 'user-prod'):
							$qry = $conn->query("SELECT * FROM order_items INNER JOIN item_list ON order_items.item_id = item_list.id INNER JOIN reject_list ON order_items.reject_id = reject_list.id INNER JOIN departemen_list ON reject_list.departemen_id = departemen_list.id WHERE name = 'Produksi'");
						elseif($_settings->userdata('type') == 3 && $_settings->userdata('username') == 'pimp-prod'):
							$qry = $conn->query("SELECT * FROM order_items INNER JOIN item_list ON order_items.item_id = item_list.id INNER JOIN reject_list ON order_items.reject_id = reject_list.id INNER JOIN departemen_list ON reject_list.departemen_id = departemen_list.id WHERE name = 'Produksi'");
						elseif($_settings->userdata('type') == 2 && $_settings->userdata('username') == 'user-pc'):
							$qry = $conn->query("SELECT * FROM order_items INNER JOIN item_list ON order_items.item_id = item_list.id INNER JOIN reject_list ON order_items.reject_id = reject_list.id INNER JOIN departemen_list ON reject_list.departemen_id = departemen_list.id WHERE name = 'PC RMWH' OR name = 'PC FGWH'");
						elseif($_settings->userdata('type') == 3 && $_settings->userdata('username') == 'pimp-pc'):
							$qry = $conn->query("SELECT * FROM order_items INNER JOIN item_list ON order_items.item_id = item_list.id INNER JOIN reject_list ON order_items.reject_id = reject_list.id INNER JOIN departemen_list ON reject_list.departemen_id = departemen_list.id WHERE name = 'PC RMWH' OR name = 'PC FGWH'");
						endif;
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td style="text-transform:uppercase"><?php echo $row['reject_no'] ?></td>
							<td class=""><?php echo date("d-m-Y",strtotime($row['date_created3'])) ; ?></td>
							<td class="text-center"><?php echo $row['no_item'] ?></td>							
							<td style="text-transform:uppercase"><?php echo $row['name_item'] ?></td>	
							<td class="text-center" style="text-transform:uppercase"><?php echo $row['code_item'] ?></td>	
							<td class="text-center" style="text-transform:uppercase"><?php echo $row['type_item'] ?></td>
							<td class="text-center" style="text-transform:uppercase"><?php echo $row['no_lot'] ?></td>
							<td class="text-center" style="text-transform:uppercase"><?php echo $row['qty'] ?></td>
							<td class="text-center" style="text-transform:uppercase"><?php echo $row['factor_mt'] ?></td>
							<td style="text-transform:uppercase"><?php echo $row['ket'] ?></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

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
	var table = $("#table").DataTable({
		"buttons": ["copy", "csv", "excel", "pdf", "print"]
    })
	.buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
</script>
</html>