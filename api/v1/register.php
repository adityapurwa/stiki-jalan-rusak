<?php
require_once("../core/bootstrap.php");

use Rakit\Validation\Validator;

global $db;
global $_JSON;

$email = $_JSON['email'];
$name = $_JSON['name'];
$password = $_JSON['password'];
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$validator = new Validator();
$validation = $validator->make(
	compact('email', 'password', 'name'),
	[
		'email' => 'required|email',
		'name' => 'required',
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
	$stmt = $db->prepare("INSERT INTO users VALUES(UUID(), ?, ?, ?)");
	$stmt->bindParam(1, $email);
	$stmt->bindParam(2, $name);
	$stmt->bindParam(3, $hashedPassword);
	$stmt->execute();

	$stmt = $db->prepare("SELECT id, email, name FROM users WHERE email = ?");
	$stmt->bindParam(1, $email);
	$stmt->execute();
	$newUser = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($newUser) {
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
		http_response_code(500);
		var_dump($newUser);
		echo json_encode(
			[
				'error' => "Unknown Error"
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
