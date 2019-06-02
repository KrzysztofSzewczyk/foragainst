
<?php

require 'vendor/autoload.php';

header('Content-Type: application/json');

$database = new \Filebase\Database([
    'dir' => 'db/topic/'
]);

if(!isset($_GET['id'])) {
	echo json_encode(array("error" => "ID missing."));
	die;
}

if(!$database->has($_POST['id'])) {
	echo json_encode(array("error" => "No such topic."));
	die;
}

$result = $database->get($_POST['id']);

if($result['score'] > 10) {
	$result->introduced = true;
	$result->save();
	
	echo json_encode(array("ok" => "Topic has been introduced."));
	die;
} else {
	echo json_encode(array("error" => "Topic needs 10 votes to be introduced."));
	die;
}

?>
