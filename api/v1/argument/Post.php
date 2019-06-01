
<?php

require 'vendor/autoload.php';

$database = new \Filebase\Database([
    'dir' => 'db/argument/'
]);

if(!isset($_POST['type']) && 
   !isset($_POST['content']) &&
   !isset($_POST['parent'])) {
	echo "{\"error\": \"Type, parent and content missing\"}";
	die;
}

$id = md5($_POST['type'] . $_POST['content']);

$item = $database->get($id);
$item->isfor = $_POST['type'] == 'for' ? true : false;
$item->content = $_POST['content'];
$item->id = $id;
$item->score = 0;

$item->save();

$topicDatabase = new \Filebase\Database([
    'dir' => 'db/topic/'
]);

$topic = $topicDatabase->get($_POST['parent']);
$topic->arguments[] = $id;

?>