 <?php

 $app->group('/mensaje', function () use ($app)	{

		$app->get('/:mensaje', function ($mensaje) use ($app) {

			//LOS ESPACIOS SON IDENTIFICADOS POR |
			//LOS SALTOS DE LINEA POR _

			$mensaje = str_replace("|", "<br>", $mensaje);
			$mensaje = str_replace("_", " ", $mensaje);

			$mailer = new Mailer();

			// Configuracion SMPT
				$mailer->getPort = '25';

				$mailer->getHost = 'directiontohost';
				$mailer->getUserName = 'nameaccountmail';
				$mailer->getPassword = 'passwordofnameaccount';
				


			// Configurando Destinatarios, asunto , mensaje

				$total = array();
				$name = array('nombre' => 'Jorge S', 'direccion' =>  'mail@mail.com');
				array_push($total, $name);
				$name = array('nombre' => 'Jorge SM', 'direccion' =>  'keymanky@hotmail.com');
				array_push($total, $name);
				$name = array('nombre' => 'Independencia', 'direccion' =>  'otheraddress@mail.com');
				array_push($total, $name);
				$mailer->setto($total);

				$froms = array('nombre' => 'SOPORTE',
							   'direccion' => 'soporte@mail.com'
						);
				$mailer->setFrom($froms);

				$subject = array(
			        'subject' => 'Test'
			    );
			    $mailer->setSubject($subject);			

			//Renderiza la plantilla de mensaje FileMaker

			include 'render/Templates/plantillas.inc';
				$html = $produccion;	
				$found    = array('{{contenido}}');
		        $replace  = array($mensaje);
		        $template = str_replace($found, $replace, $html);
				
				$mailer->setBody($template);	

				if(isset($cc)){
					$total = array();
					$name = array('nombre' => $cc_nombre, 'direccion' =>  $cc);
					array_push($total, $name);
					$mailer->setcc($total);
				}

				if(isset($cco)){
					$total = array();
					$name = array('nombre' => $cco_nombre, 'direccion' =>  $cco);
					array_push($total, $name);
					$mailer->setcco($total);
				}
								
			//Respuesta del servicio

				if ($mailer->Send()) {
					if (count($mailer->getWarnings())) {
				    } 
				    $response = array(
				    	'succes' => true,
				    	'message' => 'mail sent'
				    	);
					$app->response->setStatus(200);
					$app->response->setBody(json_encode($response));
				}else{
					$response = array(
				    	'succes' => false,
				    	'port' => $mailer->getPort(),
				    	'smtp_secure' => $mailer->getSMTP_secure(),
				    	'auth' => $mailer->getAuth(),
				    	'host' => $mailer->getHost(),
				    	'usuario' => $mailer->getUserName(),
				    	'password' => $mailer->getPassword()
				    );
					$app->response->setStatus(400);
					$app->response->setBody(json_encode($response));
				}
 	
			/*Respuesta del servicio*/
			$app->response->setBody(json_encode($response));			
			$app->response->setStatus(200);
			$app->stop();

		});

		/*Respuesta del get id*/
		$app->options('/:mensaje', function () use ($app){
		 	$app->response->setStatus(200);
		 	$app->response->setBody(json_encode(array('message' => 'ok')));
		});	

});
?>
