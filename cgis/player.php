<?php
$redis = new Redis();
$redis_password = '';
try {
	$redis->connect('localhost', $redis_port);
	// $redis->auth($redis_password);
}
catch (exception $e)
{
	// echo "couldn't connect and authenticate\n";
	http_response_code(500);
	return;
}

$id = $_POST["player_id"];

if (is_null($id) || $id == "")
{
	echo "Invalid player id";
	http_response_code(400);
	return ;
}
$player = $redis->get($id);
if (is_null($player) || $player == "")
{
	http_response_code(404);
	return ;
}

echo $player;

?>