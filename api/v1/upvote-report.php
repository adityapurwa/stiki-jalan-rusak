<?php
require_once("../core/bootstrap.php");

guard();

use Rakit\Validation\Validator;

global $db;
global $_JSON;

$reportId = $_JSON['report_id'];
$userId = $_SESSION[APP_SESSION_USER_ID];

$validator = new Validator();
$validation = $validator->make(
	compact('reportId'),
	[
		'reportId' => 'required'
	]
);

$validation->validate();
if ($validation->fails()) {
	http_response_code(400);
	echo json_encode($validation->errors()->toArray());
	exit;
}

try {

	$stmt = $db->prepare("SELECT * FROM report_votes WHERE user_id = ? and report_id = ?");
	$stmt->bindParam(1, $userId);
	$stmt->bindParam(2, $reportId);
	$stmt->execute();
	if ($stmt->fetch()) {
		http_response_code(409);
		echo json_encode(
			[
				'error' => 'Anda sudah pernah mendukung laporan ini'
			]
		);
		exit;
	}

	$stmt = $db->prepare("INSERT INTO report_votes (id, user_id, report_id, type) VALUES(UUID(), ?, ?, 'positive')");
	$stmt->bindParam(1, $userId);
	$stmt->bindParam(2, $reportId);
	$stmt->execute();

	http_response_code(201);
	echo json_encode(
		[
			'status' => 'created'
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
