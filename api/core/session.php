<?php
if (isset($_SERVER['HTTP_X_PHP_SESSID'])) {
	$sessionId = $_SERVER['HTTP_X_PHP_SESSID'];
	session_id($sessionId);
}
session_start();

function check_session()
{
	global $db;

	if (isset($_SESSION[APP_SESSION_USER_ID])) {
		$userId = $_SESSION[APP_SESSION_USER_ID];
		$stmt = $db->prepare("SELECT id FROM users WHERE id = ?");
		$stmt->bindParam(1, $userId);
		$stmt->execute();

		if (!$stmt->fetch()) {
			unset($_SESSION[APP_SESSION_USER_ID]);
			unset($_SESSION[APP_SESSION_USER_EMAIL]);
			unset($_SESSION[APP_SESSION_USER_NAME]);
		}

	}
}

function guard()
{
	global $db;

	if (isset($_SESSION[APP_SESSION_USER_ID])) {
		$userId = $_SESSION[APP_SESSION_USER_ID];
		$stmt = $db->prepare("SELECT id FROM users WHERE id = ?");
		$stmt->bindParam(1, $userId);
		$stmt->execute();

		if (!$stmt->fetch()) {
			http_response_code(401);
			echo json_encode(
				[
					'error' => 'Unauthorized'
				]
			);
			exit;
		}

	}
}

check_session();
