<?php

Class Registry Implements ArrayAccess{ 

    private $vars = array();

	function set($key, $var, $overwrite=false) {
	
        if (isset($this->vars[$key]) == true AND $overwrite==false) {
                throw new Exception('Unable to set var `' . $key . '`. Already set.');
        }
        $this->vars[$key] = $var;
        return true;
	}


	function get($key) {
       if (isset($this->vars[$key]) == false) { 
                return null;
        }
        return $this->vars[$key]; 
	}
	
	function get_param(){
		return $_GET;
	}

	function remove($var) {
        unset($this->vars[$var]);
	}
	
	function success($data=false){

		exit (json_encode(array('succ'=>true, 'data'=>$data)));
	}
	
	function success_submit($url=false){
	//print_r($url);
		//$header=$this->get_header();
		exit (json_encode(array('succ'=>true, 'url'=>$url)));
	}

	function error($error=false){
		if($error==false) $error=ERR;
		exit (json_encode(array('succ'=>false, 'error'=>$error)));
	}

	function get_header($header_view){

		if(is_bool($header_view)){
			
			if(isset($this['data_user'])){
				$header_view='signout';
			}else{
				$header_view='login';
			}	
	
		}




		ob_start();
		include 'application/views/header_'.$header_view.'.php';
		$header = ob_get_contents();
		ob_end_clean();

		return $header;

	}


	
	//************ start methods for ArrayAccess
	
	function offsetExists($offset) {
		return isset($this->vars[$offset]);
	}

	function offsetGet($offset) {
		return $this->get($offset);
	}

	function offsetSet($offset, $value) {
		$this->set($offset, $value);
	}

	function offsetUnset($offset) {
		unset($this->vars[$offset]);
	}
	//************ end methods for ArrayAccess
	
	
}
?>