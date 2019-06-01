
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

$results = $database->where('id','=',$_POST['id'])->andWhere('introduced','=',false)->results();

$times_executed = 0;

foreach($results as &$res) {
	if($res['score'] > 10) {
		$res->introduced = true;
		$res->save();
		echo "{\"ok\": \"Topic has been introduced.\"}";
		die;
	} else {
		echo "{\"error\": \"Topic needs at least 10 votes to be introduced.\"}";
		die;
	}
	$times_executed++;
}

if($times_executed == 0) {
	echo "{\"error\": \"No such topic.\"}";
	die;
}

?>
