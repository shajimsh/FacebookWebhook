<?php
syslog(LOG_DEBUG, "DEBUG_log:facebook start");
 error_log('Error_log:facebook start');
$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token=='abc123'){
echo $challenge;
}

$input = json_decode(file_get_contents('php://input'), true);
error_log(print_r($input, true));



 error_log('Error_log:facebook end'.$input['details']);
 
 
  
  foreach ( $input['details'] as $key => $value) {

    $arrayStrings[] = $key . '=' . $value;
	error_log('Error_log:$arrayStrings[]'.$arrayStrings[]);

}
  



?>