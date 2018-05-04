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
error_log('info_log:$sendInput'.$sendInput);

$inputString=$sendInput['FirstName']."&".$sendInput['LastName']."&".$sendInput['Phone'];
error_log('info_log:$$inputString'.$inputString);
//create cURL connection
$curl_connection =
  curl_init('https://kohler.leadperfection.com/batch/leadformgenerictest.asp?');
//set data to be posted
curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $inputString);
//perform our request
$result = curl_exec($curl_connection);
error_log('info_log:$result'.$result);
//close the connection
curl_close($curl_connection);

?>