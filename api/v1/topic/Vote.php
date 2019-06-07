
<?php

require '../../../vendor/autoload.php';

header('Content-Type: application/json');

$database = new \Filebase\Database([
    'dir' => '../../../db/topic/'
]);

session_start();
if (isset($_SESSION['LAST_CALL_TV'])) {
	$last = strtotime($_SESSION['LAST_CALL_TV']);
	$curr = strtotime(date("Y-m-d h:i:s"));
	$sec = abs($last - $curr);
	if ($sec <= 300) { // You can post argument every 5 minutes.
		http_response_code(403); // 403: Forbidden
		echo json_encode(array("error" => "Ratelimit exceeded."));
		die;   
	}
}
$_SESSION['LAST_CALL_TV'] = date("Y-m-d h:i:s");

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

$result['score']++;
$result->save();

http_response_code(200); // 200: OK
echo json_encode(array("error" => "Vote cast."));
die;

?>
