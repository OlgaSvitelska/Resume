<?php

class Controller_Work extends Controller
{

	function action_index(){	

	}


	function action_tricotage(){
			$this->view->show_content('tricotage', 'menu');
	}	

	function action_cloux(){
			$this->view->show_content('cloux', 'menu');
	}	

	function action_bubble(){
			$this->view->show_content('bubble', 'menu');
	}	

	function action_knomaad(){
			$this->view->show_content('knomaad', 'menu');
	}	


	function action_framework(){
			$this->view->show_content('framework', 'menu');
	}	



	
		
}
