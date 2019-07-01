<?php
require_once("../core/bootstrap.php");

use Rakit\Validation\Validator;

global $db;
global $_JSON;

$email = $_JSON['email'];
$password = $_JSON['password'];

$validator = new Validator();
$validation = $validator->make(
	compact('email', 'password'),
	[
		'email' => 'required|email',
		'password' => 'required',
	]
);

$validation->validate();
if ($validation->fails()) {
	http_response_code(400);
	echo json_encode($validation->errors()->toArray());
	exit;
}

try {

	$stmt = $db->prepare("SELECT id, email, name, password FROM users WHERE email = ?");
	$stmt->bindParam(1, $email);
	$stmt->execute();
	$newUser = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($newUser && password_verify($password, $newUser['password'])) {
		http_response_code(201);
		// Auto login for registered user
		$_SESSION[APP_SESSION_USER_ID] = $newUser['id'];
		$_SESSION[APP_SESSION_USER_EMAIL] = $newUser['email'];
		$_SESSION[APP_SESSION_USER_NAME] = $newUser['name'];
		echo json_encode(
			[
				'user' => $newUser,
				'session'=> session_id()
			]
		);
	} else {
		http_response_code(403);
		echo json_encode(
			[
				'error' => "Invalid username or password"
			]
		);
	}

} catch (Exception $ex) {
	http_response_code(500);
	echo json_encode(
		[
			'error' => $ex->getMessage()
		]
	);
}
