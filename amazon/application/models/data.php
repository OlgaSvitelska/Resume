<?php class Data{

		private $reg;

		function __construct($reg){
			$this->reg=$reg;
		} 
	
		function get_language( $language){
			$path=MAIN_PATH.'application'.DIRSEP.'languages'.DIRSEP;

			if ($language=='en'){
				include $path.'english.php';
			}elseif($language=='ru'){
				include $path.'russian.php';
			}else{
				echo'error language settings';
			}
		}	

		function error($val){
			$arr['1']="";
			return $arr[$val];
		}


		function save_message($vals){

			$name=$this->reg['secur']->validation($vals['name'],'string');
			$email=$this->reg['secur']->validation($vals['email'],'email');
			$message=$this->reg['secur']->validation($vals['message'],'string');

			date_default_timezone_set('America/Los_Angeles');
			$cur_date = date('Y-m-d h:i:s a', time());


			$ind = $this->reg['db']->prepare("INSERT INTO messages (dates, name, email, texts) VALUES (?, ?, ?, ?)");
			$ind -> execute(array($cur_date, $name, $email, $message));
											
			if($this->reg['db']->lastInsertId()){
				return $this->reg['db']->lastInsertId();
			}else{
				return false;
			}
		
		}
	

	}
?>
