
<?php

require 'vendor/autoload.php';

header('Content-Type: application/json');

$database = new \Filebase\Database([
    'dir' => 'db/argument/'
]);


if(!isset($_GET['id'])) {
	echo "{\"error\": \"ID missing.\"}";
	die;
}

if(!$database->has($_POST['id'])) {
	echo "{\"error\": \"No such argument.\"}";
	die;
}

$result = $database->get($_POST['id']);

$result['score']++;
$result->save();

echo "{\"ok\": \"Vote cast.\"}";
die;

?>
