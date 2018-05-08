<?php
header('Content-Type: application/json');

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token=='Kohler123'){
echo $challenge;
}

$input = json_decode(file_get_contents('php://input'), true);
error_log(print_r($input, true));
// setting the value of details in post_data
//$post_data=null;
//$fname=$input['entry'][0]['changes'][0]['field'];
//$lname=$input['entry'][0]['changes'][0]['value']['leadgen_id'];
//error_log('info_log:$fname '.$fname.'info_log:$lname '.$lname);
foreach ( $input['entry'][0]['changes'][0]['details'] as $key => $value) {
       $post_data->$key = $key."=".$value;
    }
// checking for validation
if(is_null($post_data->FirstName)){
	$post_data->FirstName="Kohler";
}

if(is_null($post_data->LastName)){
	$post_data->LastName="Kohler";
}

if(is_null($post_data->Address)){
	error_log('error_log:$post_data->Address:'.$post_data->Address.'given is empty');
}

if(is_null($post_data->City)){
	error_log('error_log:$post_data->City:'.$post_data->City.'given is empty');
}

if(is_null($post_data->State)){
	error_log('error_log:$post_data->State:'.$post_data->State.'given is empty');
}

if(!is_null($post_data->Zip)){
	$post_data->Zip=substr($post_data->Zip,0,5); 
} else{
	error_log('error_log:$post_data->Zip'.$post_data->Zip.'given is empty');
}

if(!is_null($post_data->Phone)){
	$post_data->Phone=substr($post_data->Phone,-10); 
}else{
	error_log('error_log:$post_data->Phone:'.$post_data->Phone.'given is empty');
}

if(strpos($post_data->Email, '@') !== false){
   error_log('error_log:$post_data->Email:'.$post_data->Email.'given is not valid');
} else if(is_null($post_data->Email)){
	error_log('error_log:$post_data->Email:'.$post_data->Email.'given is empty');
}else{
}
$post_data->Dialed_Tollfree=8002072647;
$post_data->UserID="kohler";
$post_data->Password="webleads1";


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