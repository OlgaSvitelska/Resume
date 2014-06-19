<?php 

session_start();
//print_r($_SESSION);
//session_destroy();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'defines.php';
require_once 'autoload.php';
require_once 'config_pdo.php';
 
$reg = new Registry;

$db= new PDO($host, $user, $passw);
$reg->set('db',$db);

$bf= new MyBlowfish(SOLT);
$reg->set('bf',$bf);

$secur= new Security($reg);
$reg->set('secur', $secur);

$login= new Login ($reg);
$reg->set('login', $login);


$check_login = $login->check_login();
$reg->set('check_login', $check_login, true);



//print_r($reg['data_user']);
//$update= new Update ($reg);
//$reg->set('update',$update);

if(!isset($reg['data_user']['language'])){
	$language='en';
}else{
	$language=$reg['data_user']['language'];
} 

$data= new Data ($reg);
$reg->set('data',$data);

$data->get_language($language);

//print_r($reg);

$route = new Route($reg);
$route->start();

?>


