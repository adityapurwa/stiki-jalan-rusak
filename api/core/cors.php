<?php
header("Access-Control-Allow-Origin: http://localhost:1234");
header("Access-Control-Allow-Headers: Content-Type, X-PHP-SESSID");
if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
	http_response_code(200);
	exit;
}

