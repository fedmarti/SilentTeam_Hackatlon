<?php
$redis = new Redis();
$redis_port = 6379;
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

$keys = $redis->keys("plant[0-9]*");
var_dump($keys);
$plants = [];
foreach ($keys as $k)
{
	$str = $redis->get($k);
	var_dump($str);
	if (!is_null($str) && $str != "") 
	{
		$var = json_decode($str, true);
		$temp = [$k => $var];
		array_merge($plants, $temp);
	}
}
	var_dump($plants);
	echo json_encode($plants);
?>