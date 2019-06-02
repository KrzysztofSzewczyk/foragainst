
<?php

require 'vendor/autoload.php';

$database = new \Filebase\Database([
    'dir' => 'db/argument/'
]);

session_start();
if (isset($_SESSION['LAST_CALL'])) {
	$last = strtotime($_SESSION['LAST_CALL']);
	$curr = strtotime(date("Y-m-d h:i:s"));
	$sec = abs($last - $curr);
	if ($sec <= 600) { // You can post argument every 10 minutes.
		echo json_encode(array("error" => "Ratelimit exceeded."));
		die;
	}
}
$_SESSION['LAST_CALL'] = date("Y-m-d h:i:s");

if(!isset($_POST['type']) && 
   !isset($_POST['content']) &&
   !isset($_POST['parent'])) {
	echo json_encode(array("error" => "Type, parent and content missing."));
	die;
}

$id = md5($_POST['type'] . $_POST['content'] . string(random_int()));

$item = $database->get($id);
$item->isfor = $_POST['type'] == 'for' ? true : false;
$item->content = $_POST['content'];
$item->id = $id;
$item->parent = $_POST['parent'];
$item->score = 0;

$topicDatabase = new \Filebase\Database([
    'dir' => 'db/topic/'
]);

if(!$database->has($_POST['parent'])) {
	echo json_encode(array("error" => "Invalid parent."));
	die;
}

$topic = $topicDatabase->get($_POST['parent']);
$topic->arguments[] = $id;

$item->save();
$topic->save();

echo json_encode(array("ok" => "Argument posted."));
die;

?>
