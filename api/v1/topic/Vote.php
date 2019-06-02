
<?php

require 'vendor/autoload.php';

header('Content-Type: application/json');

$database = new \Filebase\Database([
    'dir' => 'db/topic/'
]);

session_start();
if (isset($_SESSION['LAST_CALL'])) {
	$last = strtotime($_SESSION['LAST_CALL']);
	$curr = strtotime(date("Y-m-d h:i:s"));
	$sec = abs($last - $curr);
	if ($sec <= 300) { // You can post argument every 5 minutes.
		echo "{\"error\": \"Ratelimit exceeded.\"}";
		die;   
	}
}
$_SESSION['LAST_CALL'] = date("Y-m-d h:i:s");

if(!isset($_GET['id'])) {
	echo "{\"error\": \"ID missing.\"}";
	die;
}

if(!$database->has($_POST['id'])) {
	echo "{\"error\": \"No such topic.\"}";
	die;
}

$result = $database->get($_POST['id']);

$result['score']++;
$result->save();

echo "{\"ok\": \"Vote cast.\"}";
die;

?>
