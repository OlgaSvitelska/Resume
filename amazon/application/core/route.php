<?php
class Route
{
	private $reg;
	private $path;
	function  __construct($reg){

		$this->reg=$reg;
	
	}
	function post_handling(){

 		$arr_post=array();
		foreach ($_POST as $key=>$value){
			if(is_array($value)&&count($value)>1){
				$arr_post[$key]=$value;
			}else{
				$arr_post[$key]=$value[0];
			}
		} 	

		$this->reg->set('post', $arr_post);

	}
	
	
    function start()
    {
	
	
        $controller_name = 'Main';
        $action_name = 'index';

		$route=false;
		if(isset($_GET['route'])) $route=$_GET['route'];

        if((isset($_GET['route'])&&isset($_GET['a']['address']))||(isset($_GET['route'])&&isset($_GET['post']))) { 
            $routes = explode('/', $_GET['route']) ;

           if ( !empty($routes[0]) ){   
                $controller_name = $routes[0];
            }

            if ( !empty($routes[1]) ){
                $action_name = $routes[1];
            }

            $this->reg->set('address', true);
        }
		
		$this->post_handling();

        $model_name = 'Model_'.$controller_name;
        $controller_name = 'Controller_'.$controller_name;
        $action_name = 'action_'.$action_name;


        $model_file = strtolower($model_name).'.php';
        $model_path = "application/models/".$model_file;
        
        if(file_exists($model_path)){
            
            include "application/models/".$model_file;
        }


        $controller_file = strtolower($controller_name).'.php';
        $controller_path = "application/controllers/".$controller_file;
//print_r($controller_path)  ;     
        
        if(file_exists($controller_path)){

            include "application/controllers/".$controller_file;
        }else{

            Route::ErrorPage404();
        }
        
        $controller = new $controller_name($this->reg);
        $action = $action_name;
     // print_r($action)  ; 
        if(method_exists($controller, $action)){
            $controller->$action();
        }else{
           Route::ErrorPage404();
        } 
    
    }
   


    function ErrorPage404()
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }
}
?>