
<?php

require 'vendor/autoload.php';

header('Content-Type: application/json');

$database = new \Filebase\Database([
    'dir' => 'db/topic/'
]);

if(!isset($_GET['id'])) {
	echo json_encode(array("error" => "ID missing."));
	die;
}

if(!$database->has($_POST['id'])) {
	echo json_encode(array("error" => "No such topic."));
	die;
}

$result = $database->get($_POST['id']);

echo json_encode(array("title" => $result->title, "description" => $result->description, "score" => $result->score, "arguments" => json_encode($result->arguments)));
die;

?>
