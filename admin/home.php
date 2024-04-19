<h3 class="text-dark">Welcome to <?php echo $_settings->info('name') ?></h3>
<hr class="border-dark">

<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
			<span class="info-box-icon bg-navy elevation-1"><i class="fas fa-file-alt"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Total Reject Card</span>
				<span class="info-box-number">
					<?php 
						$totreject = $conn->query("SELECT * FROM reject_list")->num_rows;
						echo number_format($totreject);
					?>
				</span>
			</div>
		</div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
			<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">OPEN Reject Card</span>
				<span class="info-box-number">
					<?php 
						$rejectop = $conn->query("SELECT * FROM reject_list where `status3` = 0 ")->num_rows;
						echo number_format($rejectop);
					?>
				</span>
			</div>
        </div>
    </div>
		
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
			<span class="info-box-icon bg-success elevation-1"><i class="fas fa-check"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">CLOSE Reject Card</span>
				<span class="info-box-number">
					<?php 
					$rejectcl = $conn->query("SELECT * FROM reject_list where `status3` = 1 ")->num_rows;
						echo number_format($rejectcl);
						?>
				</span>
			</div>
        </div>
    </div>
	
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
			<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-microchip"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Total Part Rejected</span>
				<span class="info-box-number">
					<?php 
					$rejectpart = $conn->query("SELECT SUM(qty) as total FROM order_items")->fetch_array()['total'];
						echo number_format($rejectpart);
						?>
				</span>
			</div>
        </div>
    </div>
	
	<div class="col-6 col-sm-6 col-md-6">
        <div class="info-box mb-6">
			<div class="info-box-content">
				<h5 class="info-box-text">Total Part Rejected (Top 7)</h5>

				<script type="text/javascript" src="/e_rejectqa/plugins/chart/jquery.min.js"></script>
				<script type="text/javascript" src="/e_rejectqa/plugins//chart/Chart.min.js"></script>
				<body>
					<div id="chart-container">
						<canvas id="graphCanvas"></canvas>
					</div>
					<script>
						$(document).ready(function () {
							showGraph();
						});
						function showGraph()
						{
							{
								$.post("chart.php",
								function (data)
								{
									console.log(data);
									 var name = [];
									var tot = [];

									for (var i in data) {
										name.push(data[i].code_item);
										tot.push(data[i].tot);
									}

									var chartdata = {
										labels: name,
										datasets: [
											{
												label: 'Part Type',
												backgroundColor: '#F333F3',
												borderColor: '#F333F3',
												hoverBackgroundColor: '#142440',
												hoverBorderColor: '#666666',
												data: tot
											}
										]
									};
									var graphTarget = $("#graphCanvas");
									var barGraph = new Chart(graphTarget, {
										type: 'bar',
										data: chartdata
									});
								});
							}
						}
					</script>
				</body>
			</div>
        </div>
    </div>
	
	<div class="col-6 col-sm-6 col-md-6">
        <div class="info-box">
				<table class="table table-sm table-striped">
					<colgroup>
						<col width="3%">
						<col width="13%">
						<col width="28%">
						<col width="14%">
						<col width="7%">
					</colgroup>
					<thead>
						<tr class="bg-navy disabled text-center">
							<th>No</th>
							<th>No Part</th>
							<th>Name Part</th>
							<th>Code Part</th>
							<th>Qty</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$i = 1;
								$qry = $conn->query("SELECT *,SUM(qty) as tot FROM order_items INNER JOIN item_list ON order_items.item_id = item_list.id GROUP BY code_item ORDER BY tot DESC LIMIT 7");
								while($row = $qry->fetch_assoc()):
								//$row['qty1'] = $conn->query("SELECT SUM(qty) as tot FROM order_items")->fetch_array()['tot'];
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td class="text-center"><?php echo $row['no_item'] ?></td>							
								<td style="text-transform:uppercase"><?php echo $row['name_item'] ?></td>	
								<td style="text-transform:uppercase" class="text-center"><?php echo $row['code_item'] ?></td>	
								<td style="text-transform:uppercase" class="text-center"><?php echo $row['tot'] ?></td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
        </div>
    </div>
	
</div>

	