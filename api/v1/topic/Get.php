
<?php

require 'vendor/autoload.php';

header('Content-Type: application/json');

$database = new \Filebase\Database([
    'dir' => 'db/topic/'
]);

if(!isset($_GET['id'])) {
	echo "{\"error\": \"ID missing.\"}";
	die;
}

if(!$database->has($_POST['id'])) {
	echo "{\"error\": \"No such topic.\"}";
	die;
}

$result = $database->get($_POST['id']);

echo "{\"ispositive\": " . $result->isfor .
	 ", \"content\": " . $result->content . 
	 ", \"score\": " . $result->score . "}";
die;

?>
