<?php
require_once("../core/bootstrap.php");

use Rakit\Validation\Validator;

global $db;
global $_JSON;

$address = $_POST['address'];
$photo = $_FILES['photo'];
$userId = $_SESSION[APP_SESSION_USER_ID];

$validator = new Validator();
$validation = $validator->make(
	compact('address', 'photo'),
	[
		'address' => 'required',
		'photo' => 'required'
	]
);

$validation->validate();
if ($validation->fails()) {
	http_response_code(400);
	echo json_encode($validation->errors()->toArray());
	exit;
}

try {

	$photoShaName = sha1_file($photo['tmp_name']);

	move_uploaded_file($photo['tmp_name'], '../storage/' . $photoShaName . '.jpg');

	$stmt = $db->prepare("INSERT INTO reports (id, address, photo, user_id) VALUES(UUID(), ?, ?, ?)");
	$stmt->bindParam(1, $address);
	$stmt->bindParam(2, $photoShaName);
	$stmt->bindParam(3, $userId);
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
