<?php
header('Content-Type: application/json');
$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];
if ($verify_token=='GJey7558YvtWhFNP'){
echo $challenge;
}
$input = json_decode(file_get_contents('php://input'), true);
$post_data=null;
$leadgenname=$input['entry'][0]['changes'][0]['field'];
$leadgenid=$input['entry'][0]['changes'][0]['value']['leadgen_id'];
$leadgenurl="https://graph.facebook.com/v3.0/";
if($leadgenname == 'leadgen'){
		//create cURL connection
	$leadcurl = curl_init();
	curl_setopt($leadcurl, CURLOPT_URL, $leadgenurl.$leadgenid."?access_token=EAAC3mbaNYZBMBAFbGPxQuTrHTldSlD3Apbh8zLCaKJ2O1oZB0IvYjAHvSukIJSabvbT0tWZCcVzxPfI93OqpRkf2pC9CJJRDmocZB3ljc7fgilIwtZAPLI0yapLwhVZA9hhfaVAFxXsE8LkB0xzwBy9nmZBunHU8LuPNS6MurjaZAtfdkfs6S8YZAyS7eLmDomy0ZD");
	curl_setopt($leadcurl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($leadcurl, CURLOPT_POSTFIELDS, "");
	curl_setopt($leadcurl, CURLOPT_CUSTOMREQUEST, "GET");
	$headers = array();
	$headers[] = "Content-Type: application/x-www-form-urlencoded";
	curl_setopt($leadcurl, CURLOPT_HTTPHEADER, $headers);
	$result = curl_exec($leadcurl);
	error_log("infolog:$result".$result);
	$inputlead = json_decode($result, true);
	curl_close ($leadcurl);
	
	$post_data=null;
	$fieldDataVar = $inputlead['field_data'] ;
	foreach($fieldDataVar as $item) { //foreach element in $arr
     $key = $item['name']; //etc
     $values1 =$item['values'];
 	 if($key =='first_name'){
        $post_data->FirstName="FirstName=".$item['values'][0];
 	  }

 	 if($key =='last_name'){
        $post_data->LastName="LastName=".$item['values'][0];
 	  }
 	  if($key =='phone_number'){
        $post_data->Phone="Phone=".$item['values'][0];
 	  }
 	  if($key =='zip_code'){
        $post_data->Zip="Zip=".$item['values'][0];
 	  }
 	  if($key =='email'){
        $post_data->Email="Email=".$item['values'][0];
 	  }

     }
	error_log("infolog:inputlead".print_r($inputlead, true));
	error_log('firstname'.$post_data->FirstName.'lastname'.$post_data->LastName.'phone'.$post_data->Phone.'zip'.$post_data->Zip.'email'.$post_data->Email);
	if(is_null($post_data->FirstName)){
		$post_data->FirstName="FirstName=Not Provided";
		error_log('error_log:$post_data->FirstName:'.$post_data->FirstName.'given is empty');
	}

	if(is_null($post_data->LastName)){
		$post_data->LastName="LastName=Not Provided";
		error_log('error_log:$post_data->LastName:'.$post_data->LastName.'given is empty');
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
		$post_data->Zip='Zip='.substr($post_data->Zip,-5); 
	} else{
		error_log('error_log:$post_data->Zip'.$post_data->Zip.'given is empty');
	}

	if(!is_null($post_data->Phone)){
		$post_data->Phone='Phone='.substr($post_data->Phone,-10); 
	}else{
		error_log('error_log:$post_data->Phone:'.$post_data->Phone.'given is empty');
	}

	if(strpos($post_data->Email, '@')){
	   error_log('error_log:$post_data->Email:'.$post_data->Email.'given is not valid');
	} else if(is_null($post_data->Email)){
		error_log('error_log:$post_data->Email:'.$post_data->Email.'given is empty');
	}else{
	}

	$post_data->Dialed_Tollfree="Dialed_Tollfree=8002072647";
	$post_data->UserID="UserID=kohler";
	$post_data->Password="Password=webleads1";

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
}
?>
