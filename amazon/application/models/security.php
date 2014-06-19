<?php class Security{

	private $reg;

	function __construct($reg){

		$this->reg=$reg;

	}
	
	function validation($val,$type){
		
		switch($type){
			case 'email':
					
					if ($val==0) {return $val;}
					else{
					$val=filter_var($val,FILTER_VALIDATE_EMAIL);
					//print_r($val);
					if(!$val||empty($val))$this->reg->error(ERR6);
					return $val;
					 }
				  
				
			case 'string':
				
					if ($val==0) {return $val;}
					else{
					$val=filter_var($val,FILTER_SANITIZE_STRING);
					//print_r($val);
					if(!$val||empty($val))$this->reg->error(ERR7);
					return $val;
					 }  
				
			case 'int':
				
				if ($val==0) {return $val;}
					else{
					$val=filter_var($val,FILTER_VALIDATE_INT);
					//print_r($val);
					if(!$val||empty($val))$this->reg->error(ERR8);
					return $val;
					 }
		
			
			case 'array':
			   
				return $val;
					  

		}
	
	}
	
}

?>