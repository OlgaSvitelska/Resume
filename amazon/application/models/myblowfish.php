<?php



class MyBlowfish {

	private $key;
        
	function __construct($key) {

        $this->key = $key;

    }

	function decryptString($data){

		$iv=pack("H*" , substr($data,0,16));
		$x =pack("H*" , substr($data,16));

		$res = mcrypt_decrypt(MCRYPT_BLOWFISH, $this->key, $x , MCRYPT_MODE_CBC, $iv);
		return $res;
	}

	function encryptString($data){

		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_CBC);
    
		if(isset($_SESSION['iv'])) {
		
			$iv=$_SESSION['iv'];
			$_SESSION['iv']=$iv;

		}else{

			$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
			$_SESSION['iv']=$iv;
		}	   

		$crypttext = mcrypt_encrypt(MCRYPT_BLOWFISH, $this->key, $data, MCRYPT_MODE_CBC, $iv);
    
		return bin2hex($iv . $crypttext);

	}



}


?>
