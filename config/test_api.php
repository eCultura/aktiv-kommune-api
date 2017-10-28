<?php
	
	$api = new portico_api();

	$login = '<brukernavn>';
	$passwd = '<et passord, men ikke mitt...>';

	$session_id = $api->login($login, $passwd);

	class portico_api
	{

		function __construct()
		{

		}

		function login($login, $passwd)
		{
			$webservicehost =  "http://localhost/~hc483/savannah_trunk/login.php?phpgw_return_as=json";

			if(!$login || !$passwd)
			{
				throw new Exception('Missing parametres for webservice');
			}

			$post_data = array
			(
				'login'			=> $login,
				'passwd'		=> $passwd,
				'submitit'		=> true,
				'logindomain'	=> 'default',
				'skip_remote'	=> true
			);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $webservicehost);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);

			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);

			print_r($result);

			$ret = json_decode($result, true);

			return $ret;			
		}
	}
