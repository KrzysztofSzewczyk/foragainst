
<?php

require 'vendor/autoload.php';

header('Content-Type: application/json');

$database = new \Filebase\Database([
    'dir' => 'db/topic/'
]);

$json = "";

$req_amount = 10;
$req_offset = 0;

if(!isset($_GET['query'])) {
	echo "{\"error\": \"Query string missing\"}";
	die;
}

if(isset($_GET['amount']))
	$req_amount = intval($_GET['amount']);

if(isset($_GET['page']))
	$req_offset = intval($_GET['page']) * $req_amount;

$results = $database->where('title','REGEX',$_GET['query'])->andWhere('introduced','=',true)->limit($req_amount, $req_offset)->results();

$json .= "{\"result\": [";

foreach($results as &$res)
	$json .= "{\"title\": \"" . $res['title'] . "\", \"id\": \"" . $res['id'] . "\", \"description\": \"" . $res['description'] . "},";

rtrim($json, ',');
$json .= "]}";

?>
