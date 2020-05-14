<?php
session_start();
header('Cache-control: private'); // IE 6 FIX

if(isSet($_GET['lang']))
{
$language = $_GET['lang'];

// register the session and set the cookie
$_SESSION['lang'] = $language;

setcookie("lang", $language, time() + (3600 * 24 * 30));
}
else if(isSet($_SESSION['lang']))
{
$language = $_SESSION['lang'];
}
else if(isSet($_COOKIE['lang']))
{
$language = $_COOKIE['lang'];
}
else
{
	$language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	switch ($language){
		case "it":
			break;
	//	case "en":
	//		break;       
		default:
		$language="it";
			break;
	}
}

Header( "HTTP/1.1 301 Moved Permanently" );
Header( "Location: http://www.matteobecucciofficial.com/".$language."/home.php" ); 

?>
