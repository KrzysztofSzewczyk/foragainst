
<?php

require 'vendor/autoload.php';

header('Content-Type: application/json');

$database = new \Filebase\Database([
    'dir' => 'db/'
]);

$json = "{}";

if(!isset($_GET['query'])) {
	echo "{\"error\": \"Query string missing\"}";
	die;
}

?>
