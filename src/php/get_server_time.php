<?php
$api_url = 'http://worldtimeapi.org/api/timezone/Asia/Manila';
$response = file_get_contents($api_url);
$data = json_decode($response, true);

if ($data && isset($data['datetime'])) {
    echo json_encode(array('server_time' => $data['datetime']));
} else {
    echo json_encode(array('server_time' => 'Error fetching server time'));
}
?>
