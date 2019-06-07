
<?php

require '../../../vendor/autoload.php';

header('Content-Type: application/json');

$database = new \Filebase\Database([
    'dir' => 'db/topic/'
]);

if(!isset($_GET['id'])) {
	http_response_code(400); // 400: Bad Request
	echo json_encode(array("error" => "ID missing."));
	die;
}

if(!$database->has($_GET['id'])) {
	http_response_code(404); // 404: Not Found
	echo json_encode(array("error" => "No such topic."));
	die;
}

$result = $database->get($_GET['id']);

http_response_code(200); // 200: OK
echo json_encode(array("title" => $result->title, "description" => $result->description, "score" => $result->score, "arguments" => json_encode($result->arguments)));
die;

?>
