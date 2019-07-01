<?php
global $db;
$db = new PDO(
	'mysql:dbhost=localhost;dbname=laporjalan', 'root', ''
);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
