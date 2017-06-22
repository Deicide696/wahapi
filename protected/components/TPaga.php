<?php

class TPaga extends CApplicationComponent
{
	public function create_tpaga_customer($firstName, $lastName, $email, $phone) {
		$customer_data = [ 
				'firstName' => ($firstName),
				'lastName' => ($lastName),
				'email' => ($email),
				'phone' => ($phone) 
		];
		
		$json_response = $this->tpaga_api_post ( '/api/customer', $customer_data, [ 
				201 
		] );
		
		return $json_response; // Retornamos datos de creación
			                       
		// $_SESSION["tpaga_customer_token"] = $json_response["id"];
	}
	public function assoc_cc_customer($customerId, $ccToken) {
		$json_response = tpaga_api_post ( "/api/customer/" . $customerId . "/credit_card_token", [ 
				'token' => ($ccToken) 
		], [ 
				201 
		] );
		
		$_SESSION ["user_cc"] = $json_response;
	}
	public function create_charge($taxAmount, $amount = 0, $creditCard, $currency = 'COP') {
		$json_response = $this->tpaga_api_post ( "/api/charge/credit_card", [ 
				'taxAmount' => $taxAmount,
				'amount' => intval ( $amount ),
				'currency' => $currency,
				'creditCard' => $creditCard 
		], [ 
				201,
				402 
		] );
		
		return $json_response;
	}
	public function create_cc($primaryAccountNumber, $cardHolderName, $expirationMonth, $expirationYear, $cvc) {
		$json_response = $this->tpaga_api_post_tokenize ( '/api/tokenize/credit_card' . [ 
				'primaryAccountNumber' => $primaryAccountNumber,
				'cardHolderName' => $cardHolderName,
				'expirationMonth' => $expirationMonth,
				'expirationYear' => $expirationYear,
				'cvc' => $cvc 
		], [ 
				201 
		] );

		
		
		return $json_response;
	}
	private function tpaga_api_post($url, $data, $expected_http_codes) {

        Yii::import('ext.guzzle.*');

	    $client = new Client ( [
				'base_uri' => "https://sandbox.tpaga.co",
				'timeout' => 30,
				'headers' => [ 
						'Content-Type' => 'application/json' 
				],
				'http_errors' => false,
				'verify' => false 
		] );
		
		$response = null;
		
		try {
			$response = $client->post ( $url, [ 
					'auth' => [ 
							"c507thtjd5prg91rvjtet9g3ns2egura",
							'' 
					],
					'json' => $data 
			] );
			// var_dump($response);
			// exit;
		} catch ( Exception $e ) {
			
			error_log ( "Caught exception: " . $e->getMessage () );
			echo ('Error: ' . $e->getMessage ());
			exit ();
			
			// header ( "Location: http://" . $_SERVER [HTTP_HOST] . "/" );
			// die ();
		}
		
		if (! in_array ( $response->getStatusCode (), $expected_http_codes )) {
			error_log ( $this->message_for_failed_request ( $response ) );
			// TODO set proper path for redirect
			// header ( "Location: http://" . $_SERVER [HTTP_HOST] . "/" );
			echo ('Error: ' . $this->message_for_failed_request ( $response ));
			exit ();
		}
		
		return json_decode ( $response->getBody (), true );
	}
	private function unsafe_tpaga_api_post($url, $data, $expected_http_codes) {
		$client = new Client ( [ 
				'base_uri' => "https://sandbox.tpaga.co",
				'timeout' => 30,
				'headers' => [ 
						'Content-Type' => 'application/json' 
				],
				'http_errors' => false,
				'verify' => false 
		] );
		
		$response = $client->post ( $url, [ 
				'auth' => [ 
						"c507thtjd5prg91rvjtet9g3ns2egura",
						'' 
				],
				'json' => $data 
		] );
		
		// any 5XX HTTP status code will also be handled by the caller
		if (! in_array ( $response->getStatusCode (), $expected_http_codes ) && $response->getStatusCode () < 500) {
			$this->message_for_failed_request ( $response );
			// TODO set proper path for redirect
			header ( "Location: http://" . $_SERVER [HTTP_HOST] . "/" );
			die ();
		}
		
		return $response;
	}
	private function tpaga_api_post_tokenize($url, $data, $expected_http_codes) {
		/*
		 * $data_string = json_encode($data);
		 * $process = curl_init(self::TPAGA_URL_TOKENIZE);
		 * curl_setopt($process, CURLOPT_CUSTOMREQUEST, "POST");
		 * curl_setopt($process, CURLOPT_USERPWD, self::API_PUBLIC_TOKEN . ":" );
		 * curl_setopt($process, CURLOPT_TIMEOUT, 30);
		 * curl_setopt($process, CURLOPT_POSTFIELDS, $data_string);
		 * curl_setopt($process, CURLOPT_POST, 1);
		 * curl_setopt($process, CURLOPT_HTTPHEADER, array(
		 * 'Content-Type: application/json',
		 * 'Content-Length: ' . strlen($data_string))
		 * );
		 *
		 * curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
		 * $response = curl_exec($process);
		 *
		 * curl_close($process);
		 * return $response;
		 */
		$client = new Client ( [
				'base_uri' => Yii::$app->params ['tpaga_url'],
				'timeout' => 30,
				'headers' => [ 
						'Content-Type' => 'application/json' 
				],
				'http_errors' => false,
				'verify' => false 
		] );
		
		$response = null;
		
		try {
			$response = $client->post ( $url, [ 
					'auth' => [ 
							Yii::$app->params ['public_api_key_tpaga'],
							'' 
					],
					'json' => $data,
					'verify' => false 
			] );
		} catch ( Exception $e ) {
			error_log ( "Caught exception: " . $e->getMessage () );
			// header ( "Location: http://" . $_SERVER [HTTP_HOST] . "/" );
			die ();
		}
		
		if (! in_array ( $response->getStatusCode (), $expected_http_codes )) {
			error_log ( $this->message_for_failed_request ( $response ) );
			// TODO set proper path for redirect
			// header ( "Location: http://" . $_SERVER [HTTP_HOST] . "/" );
			die ();
		}
		
		return json_decode ( $response->getBody (), true );
	}
	private function message_for_failed_request($response) {
		$http_status_code = $response->getStatusCode ();
		
		error_log ( "TPaga API answered: " . $http_status_code );
		if ($http_status_code == 401) {
			return "Ooops, credentials for Tpaga API are wrong";
		}
		
		if ($http_status_code == 422) {
			$response_data = json_decode ( $response->getBody (), true );
			
			error_log ( print_r ( $response_data, true ) );
			return "Ooops, we sent wrong data to the Tpaga API: invalid data in field: " . $response_data ['errors'] [0] ['field'];
		}
		
		// handle unknown payment status reported by CC network/Tpaga
		$json_response = json_decode ( $response->getBody (), true );
		if (in_array ( $json_response ["errorCode"], [ 
				"9999",
				"" 
		] )) {
			// header("Location: http://" . $_SERVER[HTTP_HOST] . "/form_unknown_conclusion.php");
			return "Unknown payment status reported by CC network/Tpaga";
		}
		
		// naughty, naughty person
		if (in_array ( $json_response ["errorCode"], [ 
				"41",
				"43" 
		] )) {
			return "Naughty, naughty person";
		}
		
		// no funds, charge too large, expired card
		if (in_array ( $json_response ["errorCode"], [ 
				"51",
				"54",
				"61" 
		] )) {
			return $json_response ["errorMessage"];
		}
		
		// end handle
		
		if ($http_status_code >= 400 && $http_status_code < 500) {
			return "Ooops, we did something wrong with the Tpaga API";
		}
		
		if ($http_status_code >= 500) {
			return "Ooops, the Tpaga API failed";
		}
		
		return "What?! unknown error";
	}
}
