<?php

class Controller_Signin extends Controller
{

	function action_index(){
		$this->view->show_content('signin');
	}

	function action_signout(){

		$sign_out=$this->reg['login']->sign_out();
		if($sign_out){
			//$this->view->show_content('home_page_view', true);
			$this->reg->success_submit(PATH);
		}
		
			
	}

	function action_handling(){

		if(!isset($this->reg['post']['email'])||!isset($this->reg['post']['password'])) $this->reg->error(ERR1);

		if( !$this->reg['post']['email']||!$this->reg['post']['password']) {
			$this->reg->error(ERR1);
					
		}else{$email= $this->reg['secur']->validation($this->reg['post']['email'], 'email');
			$password= $this->reg['secur']->validation($this->reg['post']['password'], 'string');}
				
		
		if(!$email||!$password){
			$this->reg->error(ERR3);
		}else {
			$unique_id = $this->reg['login']->check_reglogin($email,$password);  
		}

		if(!$unique_id){
			$this->reg->error(ERR4);
		}else{

			$login_reg=$this->reg['login']->login($unique_id); 

			if($login_reg){
				$check_login = $this->reg['login']->check_login();
				$this->reg->success_submit(PATH);
			}else{echo "Something Does Not Work!";}
		
		}

	}



	function action_linkedin(){

		$in = $this->reg['login']->linked_in('signin/linkedin');

		if(isset($in['url_linkedin'])){
			
				$this->reg->success(array('href_url'=>$in['url_linkedin']));
			
		}elseif(isset($in['data'])){

			$login_linkedin=$this->reg['login']->login_linkedin($in['data']);
		
			if($login_linkedin){ 

				$check_login = $this->reg['login']->check_login();
				$this->reg->success(array('address_url'=>PATH));
			}

		}

	}


}