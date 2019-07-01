<?php
require_once("../core/bootstrap.php");

global $db;
global $_JSON;

$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 0;

try {

	$stmt = $db->prepare(
		"SELECT reports.id, reports.address, reports.photo, reports.user_id, reports.created_at, users.name as user_name FROM reports JOIN users ON (users.id = reports.user_id) ORDER BY created_at DESC LIMIT ?, ?"
	);
	$stmt->bindParam(1, $page, PDO::PARAM_INT);
	$stmt->bindParam(2, $limit, PDO::PARAM_INT);
	$stmt->execute();

	$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

	http_response_code(201);
	echo json_encode(
		[
			'reports' => $reports
		]
	);

} catch (Exception $ex) {
	http_response_code(500);
	echo json_encode(
		[
			'error' => $ex->getMessage()
		]
	);
}
