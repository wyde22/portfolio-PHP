<?php
define('WWW_ROOT', dirname(dirname(__FILE__)));
$directory = basename(WWW_ROOT);

$url = explode($directory,$_SERVER['REQUEST_URI']);

if(count($url) == 1){
	define('WEBROOT', '/');
}else{
	define('WEBROOT', $url[0] .'portfolioV3/');
}

define('IMAGES',WWW_ROOT . DIRECTORY_SEPARATOR . 'img');



/*essai avec calcul du chemin. inefficace
$url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
var_dump($url);
define('WEBROOT', 'http://' . $url .'/');*/

?>