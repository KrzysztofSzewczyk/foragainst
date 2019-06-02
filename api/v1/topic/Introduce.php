
<?php

require 'vendor/autoload.php';

$database = new \Filebase\Database([
    'dir' => 'db/topic/'
]);

session_start();
if (isset($_SESSION['LAST_CALL'])) {
	$last = strtotime($_SESSION['LAST_CALL']);
	$curr = strtotime(date("Y-m-d h:i:s"));
	$sec = abs($last - $curr);
	if ($sec <= 60 * 20) { // You can post argument every 20 minutes.
		echo "{\"error\": \"Ratelimit exceeded.\"}";
		die;   
	}
}
$_SESSION['LAST_CALL'] = date("Y-m-d h:i:s");

if(!isset($_POST['title']) && 
   !isset($_POST['description'])) {
	echo "{\"error\": \"Title and description missing\"}";
	die;
}

$id = md5($_POST['title'] . $_POST['description'] . string(random_int()));

$item = $database->get($id);
$item->title = $_POST['title'];
$item->description = $_POST['description'];
$item->id = $id;
$item->score = 0;
$item->arguments = array();
$item->introduced = false;

$item->save();

?>
