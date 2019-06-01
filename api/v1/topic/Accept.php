
<?php

require 'vendor/autoload.php';

header('Content-Type: application/json');

$database = new \Filebase\Database([
    'dir' => 'db/topic/'
]);

if(!isset($_GET['id'])) {
	echo "{\"error\": \"ID missing.\"}";
	die;
}

if(!$database->has($_POST['id'])) {
	echo "{\"error\": \"No such topic.\"}";
	die;
}

$result = $database->get($_POST['id']);

if($result['score'] > 10) {
	$result->introduced = true;
	$result->save();
	
	echo "{\"ok\": \"Topic has been introduced.\"}";
	die;
} else {
	echo "{\"error\": \"Topic needs at least 10 votes to be introduced.\"}";
	die;
}

?>
