<?php
if(isset($_SERVER['HTTP_X_PHP_SESSID'])) {
	$sessionId = $_SERVER['HTTP_X_PHP_SESSID'];
	session_id($sessionId);
}
session_start();

