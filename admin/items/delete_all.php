<?php
	require_once '../../config.php';
	mysqli_query($conn, "DELETE FROM `item_list`") or die(mysqli_error());
	header("location:/e_rejectqa/admin/?page=items");
?>