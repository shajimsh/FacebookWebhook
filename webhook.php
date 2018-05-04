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
 
 syslog(LOG_DEBUG, "DEBUG_log:facebook end");
$obj=json_decode($input['details']);

//create array of data to be posted
$post_data['txtFirstName'] = $obj->FirstName;
$post_data['txtLastName'] = $obj->LastName;
$post_data['txtAddress'] = $obj->Address;
$post_data['txtCity'] = $obj->City;
$post_data['txtState'] = $obj->State;
$post_data['txtZip'] = $obj->Zip;
$post_data['txtPhone'] = $obj->Phone;
$post_data['txtEmail'] = $obj->Email;
$post_data['txtDialed_Tollfree'] = '800-207-2647';
$post_data['txtUserID'] = 'kohler';
$post_data['txtPassword'] = 'webleads1';
error_log('obj'.print_r($obj, true));
error_log('first name'.print_r($post_data['txtFirstName'], true));
error_log('post_data'.print_r($post_data, true));

foreach ( $post_data as $key => $value) {

    $post_items[] = $key . '=' . $value;

}

//create the final string to be posted using implode()

$post_string = implode ('&', $post_items);

//create cURL connection
$curl_connection =
  curl_init('https://kohler.leadperfection.com/batch/leadformgenerictest.asp');
//set options
curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($curl_connection, CURLOPT_USERAGENT,
  "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
//set data to be posted
curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);
//perform our request
$result = curl_exec($curl_connection);
//show information regarding the request
/*print_r(curl_getinfo($curl_connection));
echo curl_errno($curl_connection) . '-' .
                curl_error($curl_connection);*/
//close the connection
curl_close($curl_connection);


?>