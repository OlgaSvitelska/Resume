<?php

	function __autoload ($class_name) {
 		

        $filename = strtolower($class_name) . '.php';
		
 		$file_classes = MAIN_PATH . 'application' . DIRSEP. 'models' . DIRSEP . $filename;
		$file_core = MAIN_PATH . 'application' . DIRSEP. 'core' . DIRSEP . $filename;
		$file_helper = MAIN_PATH . 'application' . DIRSEP. 'helpers' . DIRSEP . $filename;

        if(file_exists($file_classes)){
            require_once $file_classes;
        
        }  elseif(file_exists($file_core)){
            require_once $file_core;

        }  elseif(file_exists($file_helper)){
            require_once $file_helper;
      
        }   else {
            return false;
        }

     }


?>