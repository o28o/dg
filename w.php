<!DOCTYPE html>
<?php
error_reporting(E_ERROR | E_PARSE);
include_once('config/config.php');
include_once('config/translate.php');

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$uri = $_SERVER['REQUEST_URI'];
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$query = $_SERVER['QUERY_STRING'];

// Use parse_url() function to parse the URL
// and return an associative array which
// contains its various components
// $url_components = parse_url($url);
// Use parse_str() function to parse the
// string passed via URL
// parse_str($url_components['query'], $params);
// Display result

/* echo ' '.$params['lang']; */

/*if ($_SERVER["REQUEST_METHOD"] == "GET") {

    // Перебираем все GET-параметры и выводим их

    foreach ($_GET as $key => $value) {
        echo $key . ' => ' . $value . '<br>';
    }
} */
if ( preg_match('/\/ru/', $actual_link)) {
  $outputlang = "-oru";
} else {
    $outputlang = "";
    }

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $p = trim($_GET["p"]);
}
	$s = isset($_GET['s']) ? htmlspecialchars($_GET['s']) : '';
	
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET['d'])) {
        $selectedParams = $_GET['d'];
        $searchIn = "-src " . $selectedParams; 
    } else {
        $searchIn = "";
    }
}
 //$s ="lobh";
 $stringForOpen = isset($s) ? strtolower(trim(str_replace("`", "", $s))) : '';


$command = escapeshellcmd("bash ./new/words.sh $p $outputlang $searchIn $stringForOpen");


//$command = escapeshellcmd("bash ./db/fdg3.5.sh $stringForOpen");

   $output = shell_exec($command); 
   echo "$output";


?>


