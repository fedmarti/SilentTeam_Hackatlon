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
$songs = [];
$player = array("name" => $_POST["name"], "birth" => $_POST["birth"], "n_planted" => "0", "last_time_planted" => "", "songs" => $songs);
if (is_null($player["name"]) || $player["name"] == "")
{
	echo "unset player name";
	http_response_code(400);
	return ;
}
$redis->incr("n_players");
$n_players = $redis->get("n_players");
$redis->set("player". $n_players, json_encode($player));
?>