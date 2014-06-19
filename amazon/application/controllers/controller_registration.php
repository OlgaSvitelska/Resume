<?php class Controller_Registration extends Controller{

	function action_index(){
		
		$this->view->show_content('registration', true);

	}



	function action_success(){
		$this->view->show_content('success_registration');
	}


	function action_handling(){

		if(!$this->reg['post']['email']||!$this->reg['post']['password']||!$this->reg['post']['confirm_password']){
			$this->reg->error(ERR2);

		}
			
		$email= $this->reg['secur']->validation($this->reg['post']['email'], 'email');
		$password= $this->reg['secur']->validation($this->reg['post']['password'], 'string');
		$confirm_password= $this->reg['secur']->validation($this->reg['post']['confirm_password'], 'string');
		$name= $this->reg['secur']->validation($this->reg['post']['name'], 'string');
		$lname= $this->reg['secur']->validation($this->reg['post']['lname'], 'string');

		if(!isset($email)||!isset($password)||!isset($confirm_password)){
			$this->reg->set('error', $error);
			$this->view->show_file('error');
		}

		$result = $this->reg['login']->registration($email, $password, $confirm_password, $name, $lname);  

		if($result){ 

			$login_reg=$this->reg['login']->login($result);  
			if($login_reg){

				$this->reg->success_submit(PATH.'registration/success');

			}
		} 

	}


}