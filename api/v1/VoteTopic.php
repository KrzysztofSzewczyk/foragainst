
<?php

require 'vendor/autoload.php';

header('Content-Type: application/json');

$database = new \Filebase\Database([
    'dir' => 'db/topic/'
]);

$json = "";

$req_amount = 10;
$req_offset = 0;

if(!isset($_GET['id'])) {
	echo "{\"error\": \"ID missing.\"}";
	die;
}

$results = $database->where('id','=',$_POST['id'])->andWhere('introduced','=',false)->results();

$times_executed = 0;

foreach($results as &$res) {
	$res['score']++;
	$times_executed++;
}

if($times_executed == 0) {
	echo "{\"error\": \"No such topic.\"}";
	die;
}

?>
