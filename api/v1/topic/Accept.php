
<?php

require '../../../vendor/autoload.php';

header('Content-Type: application/json');

$database = new \Filebase\Database([
    'dir' => '../../../db/topic/'
]);

if(!isset($_GET['id'])) {
	http_response_code(400); // 400: Bad Request
	echo json_encode(array("error" => "ID missing."));
	die;
}

if(!$database->has($_POST['id'])) {
	http_response_code(404); // 404: Not Found
	echo json_encode(array("error" => "No such topic."));
	die;
}

$result = $database->get($_POST['id']);

if($result['score'] > 10) {
	$result->introduced = true;
	$result->save();
	
	http_response_code(202); // 201: Accepted
	echo json_encode(array("ok" => "Topic has been introduced."));
	die;
} else {
	http_response_code(304); // 304: Not modified
	echo json_encode(array("error" => "Topic needs 10 votes to be introduced."));
	die;
}

?>
