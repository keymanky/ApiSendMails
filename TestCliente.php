<?php

    date_default_timezone_set ( "America/Mexico_City" );
    $ts_creacion = date("Y-m-d H:i:s");

	@$correo = $_POST["email"];

	if ( ! strlen($correo) > 0 ) {
		$correo = "mail@mail.com";	
	}


	$data = array(
		"to" =>  $correo, 
		"to_name" => "Usuario",
		"cc" => "mail@mail.com",
		"cc_name" => "Jorge Salgado", 
		"subject" => "Gracias por suscribirte a keymanky",		
		"content" => $correo,
		"template" => "test2"
	);
	$data_string = json_encode($data);


	//echo $data_string;

	$ch = curl_init('localhost/mail/api/');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($data_string))
	);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

	//execute post
	$result = curl_exec($ch);

	//close connection
	curl_close($ch);

?>
