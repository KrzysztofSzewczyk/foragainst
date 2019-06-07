
<?php

require '../../../vendor/autoload.php';

header('Content-Type: application/json');

$database = new \Filebase\Database([
    'dir' => 'db/argument/'
]);

if(!isset($_GET['id'])) {
	http_response_code(400); // 400: Bad Request.
	echo "{\"error\": \"ID missing.\"}";
	die;
}

if(!$database->has($_POST['id'])) {
	http_response_code(404); // 404: Not Found
	echo "{\"error\": \"No such argument.\"}";
	die;
}

$result = $database->get($_POST['id']);

http_response_code(200); // 200: OK
echo json_encode(array("ispositive" => $result->isfor, "content" => $result->content, "score" => $result->score));

die;

?>
