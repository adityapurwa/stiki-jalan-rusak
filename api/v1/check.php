<?php
/**
 * Check whether the current user is authenticated or not
 */
require_once("../core/bootstrap.php");

use Rakit\Validation\Validator;

global $db;
global $_JSON;

if (!isset($_SESSION[APP_SESSION_USER_ID])) {
	http_response_code(403);
	echo json_encode(
		[
			'error' => 'Unauthorized'
		]
	);
} else {
	http_response_code(200);
	echo json_encode(
		[
			'user' => [
				'id' => $_SESSION[APP_SESSION_USER_ID],
				'name' => $_SESSION[APP_SESSION_USER_NAME],
				'email' => $_SESSION[APP_SESSION_USER_EMAIL]
			]
		]
	);
}
