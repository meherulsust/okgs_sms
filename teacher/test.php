<?php

	$sms_id=rand(100000,999999);
	$gsm='8801553488246';
	$message='Test message';
	$username='arerajcpsc';
	$password='arerajcpsc!@#';
	$security_code='arenaapi!@#';
	$url = 'http://arenaapps.net/smsenquiry/index.php/home';
					
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "username=$username&password=$password&gsm=$gsm&message=$message&sms_id=$sms_id&security_code=$security_code");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$output = curl_exec ($ch);
	curl_close ($ch);	

	if($output==1)
	{
		echo 'Send';
	}else{
		echo 'Not Send';
	}
	
	
?>