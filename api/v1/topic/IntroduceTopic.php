
<?php

require 'vendor/autoload.php';

$database = new \Filebase\Database([
    'dir' => 'db/topic/'
]);

if(!isset($_POST['title']) && 
   !isset($_POST['description'])) {
	echo "{\"error\": \"Title and description missing\"}";
	die;
}

$id = md5($_POST['title'] . $_POST['description']);

$item = $database->get($id);
$item->title = $_POST['title'];
$item->description = $_POST['description'];
$item->id = $id;
$item->score = 0;
$item->arguments = array();
$item->introduced = false;

$item->save();

?>
