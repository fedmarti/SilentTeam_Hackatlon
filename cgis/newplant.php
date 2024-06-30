<?php

$redis = new Redis();
$redis_port = 6379;
// $redis_password = 'icareaboutsecurity123';
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


$x = $_POST["pos_x"];
$y = $_POST["pos_y"];

if (is_null($x) || $x == "" || is_null($y) || $y == "" || !is_numeric($x) || !is_numeric($y)){
	http_response_code(400);
	return ;
}
$location = ["x" => $x, "y" => $y];

$plant = ["location" => $location, "player_id" => $_POST["player_id"], "birth" => $_POST["birth"], "times_watered" => "0", "song" => ""];

//could check if the player has hacked but i don't have enough time
$player_str = $redis->get($plant["player_id"]);
if (is_null($player_str) || $player_str == "")
{
	http_response_code(400);
	return ;
}
$player = json_decode($player_str, true);

$player["last_time_planted"] = $plant["birth"];
$redis->set($plant["player_id"], json_encode($player));

$plant["song"] = rand(0, 4);
$redis->incr("n_plants");
$plant_id = "plant". $redis->get("n_plants");
$redis->set($plant_id, json_encode($plant));

?>