<?php
global $_JSON;
$entityBody = file_get_contents('php://input');
$_JSON = json_decode($entityBody, true);

