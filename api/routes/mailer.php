<?php 

	$app->group('/', function () use ($app)	{

		$app->post('/', function () use($app){
      	date_default_timezone_set('America/Mexico_City');  

			//Check params format json
				$pars = $app->request->getBody();
				$params = json_decode($pars);			
				if ($params === null) {
					$app->response->setStatus(400);
					$app->response->setBody(json_encode("NO_JSON_PARAMS"));
					$app->stop();
				}

			//Recovery values
				foreach ($params as $key => $value) {
				
					if ($key == 'to') {
						$to = $value;
					}
					if ($key == 'to_name') {
						$to_name = $value;
					}					
					if ($key == 'cc') {
						$cc = $value;
					}
					if ($key == 'cc_name') {
						$cc_name = $value;
					}
					if ($key == 'cco') {
						$cco = $value;
					}
					if ($key == 'cco_name') {
						$cco_name = $value;
					}
					if ($key == "subject") {
						$subject = $value;
					}	
					if ($key == "content") {
						$content = $value;
					}
					if ($key == "template") {
						$template = $value;
					}									
				}

			//Initialize Server

				$mail = new phpmailer();
				$mail->CharSet = 'UTF-8';
				$mail->Mailer = "smtp";
				$mail->IsSMTP();
		 		ini_set('max_execution_time', 600);	
				$mail->SMTPAuth = true;

				//Example
					$mail->Port = 587;
					$mail->Host = "smtp.office365.com";
					$mail->Username = "account@outlook.com";
					$mail->Password = "password";
					$mail->SetFrom('notificacion@detexis.com', 'Notificaciones');

				$mail->Subject = $subject;
				$mail->AddAddress($to,  $to_name);


			//Set Values of message
				$mail->Subject = $subject;
				$mail->AddAddress($to,  $to_name);

				if ( empty($cc) ){
					$cc = "mailcopy@mail.com";
					$cc_name = "Georgi";
				}
				if ( empty($cco)) {
					$cco = "mailhide@mail.com";
					$cco_name = "Georgi";
				}

				$mail->AddCC($cc, $cc_name);  			
				$mail->AddBCC($cco, $cco_name);	

			//To render
				//Get html text
					include 'render/Templates/plantillas.inc';
					if($template == "ticket_new"){
						$html = $ticket_new;
					}elseif($template == "ticket_to_assing"){
						$html = $ticket_to_assing;
					}elseif($template == "ticket_to_close"){
						$html = $ticket_to_close;
					}elseif($template == "ticket_comment_user"){
						$html = $ticket_comment_user;
					}elseif($template == "ticket_comment_specialist"){
						$html = $ticket_comment_specialist;
					}else{
						$html = $nothing;
					}
					
					$found    = array('{{content}}');
		        	$replace  = array($content);
		        	$template = str_replace($found, $replace, $html);
					$mail->MsgHTML($template);	
					$mail->IsHTML(true);

			//Send

				if (!$mail->send()) {
				    $msn =  "Mailer Error: " . $mail->ErrorInfo;
				} else {
				    $msn =  "Message sent!";
				}

			$response = array(
				'message' => $msn
				);
			$app->response->setStatus(200);
			$app->response->setBody(json_encode($response));
		});

		$app->options('/', function () use ($app){
	    	$app->response->setStatus(204);
		    $app->response->setBody(json_encode(array('message' => 'ok')));
	    });

	});

?>