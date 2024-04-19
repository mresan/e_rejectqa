<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
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
        <div class="card-tools">
            <button class="btn btn-sm btn-flat btn-success" id="print" type="button"><i class="fa fa-print"></i> Print</button>
			<?php if($_settings->userdata('type') == 1): ?>
				<a class="btn btn-sm btn-flat btn-primary" href="?page=rejects/manage_reject&id=<?php echo $id ?>">Edit</a>
			<?php elseif($_settings->userdata('type') == 2 && $status1 == 1): ?>
				<a class="btn btn-sm btn-flat btn-primary disabled" href="?page=rejects/manage_reject&id=<?php echo $id ?>">Edit</a>
			<?php elseif($_settings->userdata('type') == 4 && $status1 == 0): ?>
				<a class="btn btn-sm btn-flat btn-primary disabled" href="?page=rejects/manage_reject&id=<?php echo $id ?>">Edit</a>
			<?php elseif($_settings->userdata('type') == 5 && $status2 == 0): ?>
				<a class="btn btn-sm btn-flat btn-primary disabled" href="?page=rejects/manage_reject&id=<?php echo $id ?>">Edit</a>
			<?php elseif($_settings->userdata('type') == 3 && $status1 == 1 && $status2 == 1): ?>
				<a class="btn btn-sm btn-flat btn-primary disabled" href="?page=rejects/manage_reject&id=<?php echo $id ?>">Edit</a>
			<?php elseif ($status1 == 1 && $status2 == 1 && $status3 == 1): ?>
				<a class="btn btn-sm btn-flat btn-primary disabled" href="?page=rejects/manage_reject&id=<?php echo $id ?>">Edit</a>
			<?php else: ?>
				<a class="btn btn-sm btn-flat btn-primary" href="?page=rejects/manage_reject&id=<?php echo $id ?>">Edit</a>
			<?php endif; ?>
		    <a class="btn btn-sm btn-flat btn-default" href="?page=rejects">Back</a>
        </div>
	</div>
	
	<div class="card-body" id="out_print">
	<div class="row mb-2">
        <div class="col-6">
			<h5 class="text-left"><b>PT. Shindengen Indonesia</b></h5>
			<img src="<?php echo validate_image($_settings->info('logmas')) ?>" alt="" height="50px">
        </div>
            <div class="col-6 row">
                <div class="col-6">
					<p class="m-0"></p>
                </div>
                <div align="right" class="col-6">
					<tr style="text-align:right">Tanggal Efektif : 05 Juni 2024</tr>
					<table border="1" cellpadding="4">
						<tr>
							<td> No. Dokumen </td>
							<td> Q-FR-QA-003 </td>
						</tr>
					</table>
				<p> Masa Simpan : 20 Tahun</p>
                </div>
            </div>
        </div>
		<h4 style="text-align:center"><b>REJECT CARD</b></h4>
	    <div class="row mb-3">
        </div>
        <div class="row mb-0">
            <div class="col-6 row">
				<div class="col-8">
					<?php 
					$sup_qry = $conn->query("SELECT * FROM departemen_list where id = '{$departemen_id}'");
					$departemen = $sup_qry->fetch_array();
					?>
					<p>Dibuat : <?php echo $departemen['name1'] ?> - <b><?php echo $departemen['name'] ?> </b></p>
				</div>
            </div>
            <div class="col-6 row">
                <div class="col-6">
					<p class="m-0" style="text-align:right">Tanggal : <?php echo date("d-m-Y",strtotime($date_created3)) ?></p>
                </div>
                <div class="col-6">
                    <p class="m-0" style="text-align:right">Reject No : <?php echo $reject_no ?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table border="1" cellpadding="4" id="item-list">
                    <colgroup>
						<col width="3%">
						<col width="8%">
						<col width="25%">
						<col width="8%">
						<col width="8%">
						<col width="7%">
						<col width="7%">
						<col width="10%">
						<col width="26%">
                    </colgroup>
                    <thead>
                        <tr style="text-align:center">
							<th>No</th>
                            <th>No Part</th>
                            <th>Nama Part</th>
							<th>Kode Part</th>
							<th>Type</th>
							<th>No Lot</th>
							<th>Qty</th>
                            <th>Faktor Mesin/Tester</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
						$a = 1;						
                        if(isset($id)):
                        $order_items_qry = $conn->query("SELECT o.*,i.no_item, i.name_item, i.code_item FROM `order_items` o inner join item_list i on o.item_id = i.id where o.`reject_id` = '$id' ");
                        $sub_total = 0;
                        while($row = $order_items_qry->fetch_assoc()):
                        ?>
                        <tr class="reject-item" data-id="">
							<td style="text-align:center"><?php echo $a++; ?></td>
							<td style="text-align:center"><?php echo $row['no_item'] ?></td>
							<td style="text-transform:uppercase"><?php echo $row['name_item'] ?></td>
							<td style="text-align:center" style="text-transform:uppercase"><?php echo $row['code_item'] ?></td>
							<td style="text-align:center" style="text-transform:uppercase"><?php echo $row['type_item'] ?></td>
							<td style="text-align:center" style="text-transform:uppercase"><?php echo $row['no_lot'] ?></td>
                            <td style="text-align:center"><?php echo $row['qty'] ?></td>                        
                            <td style="text-align:center" style="text-transform:uppercase"><?php echo $row['factor_mt'] ?></td>
                            <td style="text-align:center" style="text-transform:uppercase"><?php echo $row['ket'] ?></td>
                        </tr>
                        <?php endwhile;endif; ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-6">
					<br>
                        <label for="notes" class="control-label">Notes</label>
                        <p><?php echo isset($notes) ? $notes : '' ?></p>
                    </div>
				</div>
				<table border="1" cellpadding="7" align="right" style="text-align:center">
					<tr style= "height:20px">
						<td>Diketahui <?php echo $departemen['name'] ?></td>
						<td>Diperiksa QA</td>
						<td>Diketahui QA</td>
					</tr>
                    <tr style= "height:50px">
						<td>
                        <?php 
                        switch($status1){
                            case 1:
                                echo "<span class='py-2 px-4 btn-flat btn-success text-dark'><b>Approved</b></span>";
                                break;
                            case 2:
                                echo "<span class='py-2 px-4 btn-flat btn-danger text-dark'><b>Denied</b></span>";
                                break;
                            default:
                                echo "<span class='py-2 px-4 btn-flat btn-warning text-dark'><b>Pending</b></span>";
                                break;
                        }
                        ?>
						</td>
						<td>
                        <?php 
                        switch($status2){
                            case 1:
                                echo "<span class='py-2 px-4 btn-flat btn-success text-dark'><b>Approved</b></span>";
                                break;
                            case 2:
                                echo "<span class='py-2 px-4 btn-flat btn-danger text-dark'><b>Denied</b></span>";
                                break;
                            default:
                                echo "<span class='py-2 px-4 btn-flat btn-warning text-dark'><b>Pending</b></span>";
                                break;
                        }
                        ?>
						</td>
						<td>
                        <?php 
                        switch($status3){
                            case 1:
                                echo "<span class='py-2 px-4 btn-flat btn-success text-dark'><b><b>Approved</b></b></span>";
                                break;
                            case 2:
                                echo "<span class='py-2 px-4 btn-flat btn-danger text-dark'><b>Denied</b></span>";
                                break;
                            default:
                                echo "<span class='py-2 px-4 btn-flat btn-warning text-dark'><b>Pending</b></span>";
                                break;
                        }
                        ?>
						</td>
					</tr>
					<tr style= "height:20px">
						<td><?php echo $departemen['name2'] ?></td>
						<td><?php echo $departemen['name3'] ?></td>
						<td><?php echo $departemen['name4'] ?></td>
					</tr>
				</table>
            </div>
        </div>
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
		<td style="text-transform:uppercase" class="align-middle p-1 item-code_item"></td>
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
			<input style="text-transform:uppercase" type="text" class="text-center w-100 border-0" name="factor_mt[]"/>
		</td>
		<td class="align-middle p-1">
			<input style="text-transform:uppercase" type="text" class="text-center w-100 border-0" name="ket[]"/>
		</td>

	</tr>
</table>
<script>
	$(function(){
        $('#print').click(function(e){
            e.preventDefault();
            start_loader();
            var _h = $('head').clone()
            var _p = $('#out_print').clone()
            var _el = $('<div>')
                _p.find('thead th').attr('style','color:black !imrejectrtant')
                _el.append(_h)
                _el.append(_p)
                
            var nw = window.open("","","width=1200,height=950")
                nw.document.write(_el.html())
                nw.document.close()
                setTimeout(() => {
                    nw.print()
                    setTimeout(() => {
                        end_loader();
                        nw.close()
                    }, 300);
                }, 200);
        })
    })
</script>