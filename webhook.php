<?php
header('Content-Type: application/json');

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token=='abc123'){
echo $challenge;
}

$input = json_decode(file_get_contents('php://input'), true);
// setting the value of details in post_data
$post_data=null;
foreach ( $input['details'] as $key => $value) {
       $post_data->$key = $key."=".$value;
    }
// encode post_data into json
$sendInput=json_encode($post_data, true);
$postInput = json_decode($sendInput, true);
$postInputValue=implode("&",$postInput);
error_log('info_log:$postInputValue'.$postInputValue);
//create cURL connection
$curl_connection = curl_init('http://kohler.leadperfection.com/batch/leadformgeneric.asp');
//set data to be posted
curl_setopt($curl_connection, CURLOPT_POST, 1);
curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $postInputValue);
curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curl_connection, CURLOPT_HEADER, 0);
curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, 1);
//perform our request
$response = curl_exec($curl_connection);
error_log('info_log:$response'.$response);
//close the connection
curl_close($curl_connection);

?>