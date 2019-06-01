
<?php

require 'vendor/autoload.php';

header('Content-Type: application/json');

$database = new \Filebase\Database([
    'dir' => 'db/'
]);

$json = "{}";

$req_amount = 10;
$req_offset = 0;

if(!isset($_GET['query'])) {
	echo "{\"error\": \"Query string missing\"}";
	die;
}

if(isset($_GET['amount']))
	$req_amount = intval($_GET['amount']);

if(isset($_GET['page']))
	$req_offset = intval($_GET['page']) * $req_amount;


?>
