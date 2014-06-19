	<?php

class Controller_Main extends Controller
{

	function action_index(){	
//print_r($this->reg['address']);

		if(isset($this->reg['address'])){
			$in = $this->reg['login']->linked_in('signin/linkedin');

			if(isset($in['url_linkedin'])){
				$this->reg->success(array('href_url'=>$in['url_linkedin']));
			}else{

				$this->view->show_content('home_page_view', '');
			}
			
		}else{
			$this->view->show_template('loading');
		}

	}

	function action_message(){
		//print_r($this->reg['post']);

		$save = $this->reg['data']->save_message($this->reg['post']);
		
		if($this->reg['post']['name']=='') $this->reg->error('You need enter Your name!'); 
		if($this->reg['post']['email']=='') $this->reg->error('You need enter Your e-mail!'); 
		if($this->reg['post']['message']=='') $this->reg->error('You need enter message!'); 

		if(!$save) $this->reg->error(); 
//print_r(PATH);

		$this->reg->success(array('notification'=>'Thank you, message was sent!'));



	}	


		
}
