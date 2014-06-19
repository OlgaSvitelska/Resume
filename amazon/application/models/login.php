<?php class Login{



	private $reg;



	function __construct($reg){

		$this->reg=$reg;

	}

	

	function linked_in($login){

		try {

			include(MAIN_PATH."application/models/linkedin_3.2.0.class.php");
		
			 $API_CONFIG = array(
			    	'appKey'       => '75aqqiumzpixph',
				  	'appSecret'    => 'Y3pe9bAUyRuFw4Vp',
				  	'callbackUrl'  => NULL 
			);


			define('DEMO_GROUP', '4010474');
			define('DEMO_GROUP_NAME', 'Knoomaad Demo');
			define('PORT_HTTP', '80');
			define('PORT_HTTP_SSL', '443');


			$_REQUEST[LINKEDIN::_GET_TYPE] = (isset($_GET[LINKEDIN::_GET_TYPE])) ? $_GET[LINKEDIN::_GET_TYPE] : '';


			$href_linkedin= '?' . LINKEDIN::_GET_TYPE . '=initiate&linkedin=Connect to LinkedIn';
			$this->reg->set('href_linkedin', $href_linkedin);
			$this->reg->set('login_b', $href_linkedin);

			switch($_REQUEST[LINKEDIN::_GET_TYPE]) {

				case 'initiate':

					$API_CONFIG['callbackUrl']=PATH_ROOT.$login. '?' . LINKEDIN::_GET_TYPE . '=initiate&' . LINKEDIN::_GET_RESPONSE . '=1';
				    $OBJ_linkedin = new LinkedIn($API_CONFIG);

			     	// check for response from LinkedIn
			     	$_GET[LINKEDIN::_GET_RESPONSE] = (isset($_GET[LINKEDIN::_GET_RESPONSE])) ? $_GET[LINKEDIN::_GET_RESPONSE] : '';

				    if(!$_GET[LINKEDIN::_GET_RESPONSE]) {

				        $response = $OBJ_linkedin->retrieveTokenRequest();
				        if($response['success'] === TRUE) {

				          	// store the request token
				          	$_SESSION['oauth']['linkedin']['request'] = $response['linkedin'];
				          	$url_linkedin=LINKEDIN::_URL_AUTH . $response['linkedin']['oauth_token'];
							return array('url_linkedin'=>$url_linkedin);

				        } else {

						  	$this->reg->error(ERR);
				        }

				    } else {

				        $response = $OBJ_linkedin->retrieveTokenAccess($_SESSION['oauth']['linkedin']['request']['oauth_token'], $_SESSION['oauth']['linkedin']['request']['oauth_token_secret'], $_GET['oauth_verifier']);

				        if($response['success'] === TRUE) {

				          	// the request went through without an error, gather user's 'access' tokens
				         	$response = $OBJ_linkedin->profile('~:(id,first-name,last-name,headline,member-url-resources,picture-url,location,public-profile-url,email-address)');

				          	if($response['success'] === TRUE) {

				          		$data = new SimpleXMLElement($response['linkedin']);
								return array('data'=>$data);

							}

				        } else {

				          	// bad token access
							$err='Access token retrieval failed:<br /><br />RESPONSE:<br /><br /><pre>'.$response.'</pre><br/><br/>LINKEDIN OBJ:<br /><br /><pre>';

							$this->reg->error($err);

				        } 

		      		}

					break;

				default:

					$err='';
				    if(version_compare(PHP_VERSION, '5.0.0', '<')) {
						$err.='You must be running version 5.x or greater of PHP to use this library.<br><br>';
					}  

				    // check for cURL
				    if(!extension_loaded('curl')) {
						$err.='You must load the cURL extension to use this library.';
					}

					if($err==''){
						return true;
					}else{
						$this->reg->error($err);
					}

				break;

			} 

		} catch(LinkedInException $e) {
		  	echo $e->getMessage();
		} 

	}

	



	

	function get_data_user($unique_id){

		$pr = $this->reg['db']->prepare("SELECT * FROM users WHERE id_unique='".trim($unique_id)."'");
		$pr -> execute ();

		$result =$pr->fetchAll(PDO::FETCH_ASSOC);
		if(empty($result)) return false; else return $result[0];

	} 

	


	 

	function login_linkedin($data){

		$data =(array)$data;
		$unique_id=$data['id'];

	//	print_r($data);

		$user_id=$this->check_user($unique_id);
		if(empty($user_id)){ 
			$save_user=$this->save_linked_in($data,$unique_id);
			if($save_user){
				$this->set_user($unique_id);
				if($this->login($unique_id)==true){
					return 'new';
				}else{
					return false;}
			}else{
				return false;
			}
		}else{
			if($this->login($unique_id)==true){
				return 'exist';
			}else{
				return false;
			}
		}	

	}


	

	function check_user($unique_id) {

		$pr = $this->reg['db']->prepare("SELECT id FROM users WHERE id_unique=:unique_id");
		$pr -> execute (array(':unique_id'=>$unique_id));
		$user_id =$pr->fetchAll(PDO::FETCH_ASSOC); 

		return $user_id;

	}



	function check_user_registration($email){


		$pr = $this->reg['db']->prepare("SELECT id FROM users WHERE email=:email");
		$pr -> execute (array(':email'=>$email));

		$result =$pr->fetchAll(PDO::FETCH_ASSOC); 
		if(empty($result)) return false; else return $result;

	} 

	
 

	 function save_linked_in($data,$unique_id){


		if(!isset($data['first-name'])) $data['first-name']='';
		if(!isset($data['last-name'])) $data['last-name']='';
		if(!isset($data['headline'])) $data['headline']='';
		if(!isset($data['picture-url'])) $data['picture-url']='';
		

		$data =(array)$data;

		$new_user = $this->reg['db']->prepare(

		"INSERT INTO users(

			id_unique,
			name,
			lname,
			headline,
			picture_url,
			city_from,
			country_from,
			public_profile_url) 

		VALUES (

			:id_unique,
			:first_name,
			:last_name,
			:headline,
			:picture_url,
			:city_from,
			:country_from,
			:public_profile_url

		) "); 

		$new_user -> execute (array(

			':id_unique'=>$unique_id,
			':first_name'=>$data['first-name'],
			':last_name'=>$data['last-name'],
			':headline'=>$data['headline'],
			':picture_url'=>$data['picture-url'],
			':city_from'=>$data['location']->name,
			':country_from'=>$data['location']->country->code,
			':public_profile_url'=>$data['public-profile-url']

			));

			$new_user->fetchAll(PDO::FETCH_ASSOC);

			if($this->reg['db']->lastInsertId()){
				return $this->reg['db']->lastInsertId();
			}else{

				return false;

			}
	} 

	


	function set_user($unique_id){

		$check_user = $this->check_user($unique_id);

	}



	function registration($email,$password, $confirm_password, $name, $lname){

		if ($password!=$confirm_password){
			$this->reg->error('Confirm password should match the one you have entered above.');
		}else{

			$password=md5($password.SOLT);
			$check_user =$this->check_user_registration($email);
			$unique_id = uniqid();

			if (!$check_user){

				$new_user = $this->reg['db']->prepare("INSERT INTO users (email, password, id_unique, name, lname) VALUES (:email, :password, :unique_id, :name, :lname)");
				$new_user -> execute (array(':email' => $email, ':password' => $password, ':unique_id' => $unique_id, ':name' => $name, ':lname' => $lname));

				if($this->reg['db']->lastInsertId()){
					return $unique_id;
				}else{
					$this->reg->error('Something does not works!.');
				}

			} else {
				$this->reg->error('The email address you have entered already exists. Please use a different email address and try again.');
			}
		} 
	}

	

		

	function login($unique_id){

		$unique_id_encrypt = $this->reg['bf']->encryptString($unique_id);
		$autorized=md5('unique_id'.SOLT);

		SetCookie($autorized, $unique_id_encrypt, time()+350*86400, '/');

		$_SESSION['unique_id']=$unique_id;

		return true;

	}


	function check_login(){

		$autorized=md5('unique_id'.SOLT);



		if(isset($_COOKIE[$autorized])||isset($_SESSION['unique_id'])){

			if(isset($_COOKIE[$autorized])){
				$unique_id=$_COOKIE[$autorized];
				$unique_id = $this->reg['bf']->decryptString($unique_id);
			}else{
				$unique_id=$_SESSION['unique_id'];
			}
			
			
			$check_sessions = $this->check_sessions($unique_id);

			if( isset ($check_sessions)){

				$data_user=$this->get_data_user($unique_id);
				$this->reg->set('data_user', $data_user, true);
				$this->reg->set('check_login', true, true);
				return true;
			}else{
				$this->reg->set('check_login', false, true);
				return false;
			}

		}else{
			$this->reg->set('check_login', false, true);
			return false;

		}

	} 


	function check_sessions($unique_id){
	

		if(isset($_SESSION['unique_id'])){
			if(trim($_SESSION['unique_id'])==trim($unique_id)){
				$_SESSION=$_SESSION;
				return true;
			}else{
				return false;
			}

		}else{
			$check_user=$this->check_user($unique_id);
			 if(!empty($check_user)){
				return true;
			 }else{
				return false;
			}

		}

	}	




	function check_reglogin($email,$password){

		$password=md5($password.SOLT);
		$pr = $this->reg['db']->prepare("SELECT id_unique FROM users WHERE email=:email AND password=:password");
		$pr-> execute (array(':email'=>$email,':password' => $password));

		$result =$pr->fetchAll(PDO::FETCH_ASSOC); 
		if(empty($result)) return false; else return $result[0]['id_unique'];

	}

		


	function sign_out() {
		unset($this->reg['data_user']);
		$this->reg->set('check_login', false, true);
		$autorized=md5('unique_id'.SOLT);
		SetCookie($autorized,'',-1, '/');
		session_unset();
		return true;
	}


}


?>