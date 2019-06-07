
<?php

require 'vendor/autoload.php';

$database = new \Filebase\Database([
    'dir' => 'db/topic/'
]);

session_start();
if (isset($_SESSION['LAST_CALL_TINT'])) {
	$last = strtotime($_SESSION['LAST_CALL_TINT']);
	$curr = strtotime(date("Y-m-d h:i:s"));
	$sec = abs($last - $curr);
	if ($sec <= 60 * 20) { // You can post argument every 20 minutes.
		http_response_code(403); // 403: Forbidden
		echo json_encode(array("error" => "Ratelimit exceeded."));
		die;   
	}
}
$_SESSION['LAST_CALL_TINT'] = date("Y-m-d h:i:s");

if(!isset($_POST['title']) && 
   !isset($_POST['description'])) {
	http_response_code(400); // 400: Bad Request
	echo json_encode(array("error" => "Title and description missing."));
	die;
}

$id = md5($_POST['title'] . $_POST['description'] . microtime());

$item = $database->get($id);
$item->title = $_POST['title'];
$item->description = $_POST['description'];
$item->id = $id;
$item->score = 0;
$item->arguments = array();
$item->introduced = false;

$item->save();

http_response_code(201); // 201: Created
echo json_encode(array("ok" => "Topic introduced.", "id" => $id));

?>
