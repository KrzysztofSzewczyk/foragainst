
<?php

require '../../../vendor/autoload.php';

header('Content-Type: application/json');

$database = new \Filebase\Database([
    'dir' => '../../../db/topic/'
]);

$json = "";

$req_amount = 10;
$req_offset = 0;

if(!isset($_GET['query'])) {
	http_response_code(400); // 400: Bad Request
	echo json_encode(array("error" => "Query string missing."));
	die;
}

if(isset($_GET['amount']))
	$req_amount = intval($_GET['amount']);

if(isset($_GET['page']))
	$req_offset = intval($_GET['page']) * $req_amount;

$results = $database->where('title','REGEX',$_GET['query'])->andWhere('introduced','=',true)->limit($req_amount, $req_offset)->results();

// Note: It seems like generating JSON by hand is the simplest and the most efficent way to do it, yet
//       there is slight chance I'm wrong. When better workaround comes in place, delete this clusterfuck of code.

http_response_code(200); // 200: OK

$json .= "{\"result\": [";

foreach($results as &$res)
	$json .= "{\"title\": \"" . $res['title'] . "\", \"id\": \"" . $res['id'] . "\", \"description\": \"" . $res['description'] . "},";

rtrim($json, ',');
$json .= "]}";

?>
