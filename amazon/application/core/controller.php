<?php

class Controller {
	
	public $model;
	public $view;
	public $reg;
	
	function __construct($reg)
	{

		$this->view = new View($reg);
		$this->model = new Model($reg);
		$this->reg=$reg;

	}

}