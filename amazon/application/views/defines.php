<?php

	define('SOLT', md5('M1a2G3i4K5'));
	
	define('DIRSEP',DIRECTORY_SEPARATOR);
	$path=dirname(__FILE__).DIRSEP.'..'.DIRSEP;
	define('MAIN_PATH', realpath($path).DIRSEP);
	
	define('PATH', substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/')).'/');
	define('PATH_ROOT','http://54.186.93.39/'.PATH);

?>