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
       $post_data->$key = $value;
    }
// encode post_data into json
$sendInput=json_encode($post_data, true);
$inputString=implode("&",$sendInput);
error_log('info_log:$sendInput'.$sendInput);

//create cURL connection
$curl_connection =
  curl_init('https://kohler.leadperfection.com/batch/leadformgenerictest.asp?'.$inputString);
//set data to be posted
curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $sendInput);
//perform our request
$result = curl_exec($curl_connection);
//show information regarding the request
print_r(curl_getinfo($curl_connection));
echo curl_errno($curl_connection) . '-' .
                curl_error($curl_connection);
//close the connection
curl_close($curl_connection);

?>