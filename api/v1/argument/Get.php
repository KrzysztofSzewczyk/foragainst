
<?php

require 'vendor/autoload.php';

header('Content-Type: application/json');

$database = new \Filebase\Database([
    'dir' => 'db/argument/'
]);

if(!isset($_GET['id'])) {
	echo "{\"error\": \"ID missing.\"}";
	die;
}

if(!$database->has($_POST['id'])) {
	echo "{\"error\": \"No such argument.\"}";
	die;
}

$result = $database->get($_POST['id']);

$item->isfor = $_POST['type'] == 'for' ? true : false;
$item->content = $_POST['content'];
$item->id = $id;
$item->parent = $_POST['parent'];
$item->score = 0;

echo "{\"ispositive\": " . $result->isfor .
	 ", \"content\": " . $result->content . 
	 ", \"score\": " . $result->score . "}";
die;

?>
