<?php
header('Content-Type: application/json');

require_once '../config.php';
$sqlQuery = "SELECT *,SUM(qty) as tot FROM order_items INNER JOIN item_list ON order_items.item_id = item_list.id GROUP BY code_item ORDER BY tot DESC LIMIT 7";
$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

//mysqli_close($conn);

echo json_encode($data);
?>