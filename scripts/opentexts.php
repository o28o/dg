<?php
include_once('./config/config.php');
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
function getRanges($string) {
  include_once('./config/config.php');
  $check = shell_exec("grep -m1 -i \"{$string}_\" $indexesfile | awk '{print \$0}'");


//if this empty then find range
if (empty($check)) {
  $command = escapeshellcmd("bash $scriptfile $string");
  $string = trim(shell_exec($command));
  echo strtolower($string);
}
}


if ( preg_match('/\/ru/', $actual_link)) {
  $defaultlang = 'lang=pli-rus';
  $outputlang = "-oru";
  $base = "/ru/";
  $readerlang = "/r/";
  $aksharatext = "На латинице вы искали ";
  function afterAkhsaramukhaResponse($convertedStr) {
    echo "На латинице вы искали $convertedStr<br><br>";
  }
}
else if ( preg_match('/\/th/', $actual_link)) {
  $defaultlang = 'lang=pli-eng';
  $outputlang = "";
  $base = "/th/";
  $readerlang = $base . "read/";
  $aksharatext = "You search ";
  function afterAkhsaramukhaResponse($convertedStr) {
    echo "in Latin script $convertedStr<br><br>";
  }
}

else {
    $defaultlang = 'lang=pli-eng';
    $outputlang = "";
    $base = "/";
  $readerlang = $base . "read/";
    $aksharatext = "Romanized string is ";
    function afterAkhsaramukhaResponse($convertedStr) {
    echo "Romanized string is $convertedStr<br><br>";
  }
    }
	
	if ( preg_match('/\/ml\//', $actual_link)) {
  $defaultlang = 'lang=pli-rus';
  $outputlang = "-oru";
  $base = "/";
  $readerlang = $base . "/ml/";

} 	if ( preg_match('/mlth.html/', $actual_link)) {
  $defaultlang = 'lang=pli-rus';
  $outputlang = "";
  $base = "/";
  $readerlang = $base . "read/mlth.html";

}

    
		// Defining variables
$nameErr = $languageErr  = "";
$cb = $q = $extra = $la = $p = $arg = $string = $sutta = $ml = "";
		// Checking for a GET request
		
if (isset($_GET['reader'])) {
    $reader = $_GET['reader']; // Получаем значение выбранной радиокнопки

    switch ($reader) {
        case 'ml':
          $base = "/";
            $readerlang = $base . "ml/";
            break;
        case 'rv':
          $base = "/";
            $readerlang = $base . "rev/";
            break;
        case 'd':
          $base = "/";
            $readerlang = $base . "d/";
            break;
        case 'mem':
                    $base = "/";
            $readerlang = $base . "memorize/";
            break;
        case 'fr':
                    $base = "/";
            $readerlang = $base . "frev/";
            break;
        default:
            // Значение по умолчанию, если ни один вариант не подошел
            $readerlang = $base . "read/";
            break;
    }
} else {
    // Если параметр 'reader' не передан, используем значение по умолчанию
    $readerlang = $base . "read/";
}
		
		
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (empty($_GET["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_GET["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }
	if (empty($_GET["p"])) {
    $p = "";
  } else {
    $p = test_input($_GET["p"]);
  }
}	

   		if ($_SERVER["REQUEST_METHOD"] == "GET") {
   		$extra = test_input($_GET["extra"]);
/* 		$pitaka = test_input($_GET["pitaka"]);
 */		}
 
 
/**
 * Перенаправляет на URL, сохраняя якорь (#...) из текущего запроса или реферера.
 * 
 * @param string $readerlang Базовый URL (например, 'https://dhamma.gift/ru/')
 * @param string $stringForOpen Основной параметр (например, 'mn14')
 * @param string|null $s Дополнительный параметр (опционально)
 */
function redirectWithAnchor($readerlang, $stringForOpen, $s = null) {
    // Пытаемся получить якорь из текущего URL (REQUEST_URI)
    $anchor = '';
    $requestUri = $_SERVER['REQUEST_URI'] ?? '';
    
    if (strpos($requestUri, '#') !== false) {
        $anchor = '#' . explode('#', $requestUri)[1];
    } 
    // Если якоря нет в текущем URL, проверяем реферер
    elseif (!empty($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], '#') !== false) {
        $anchor = '#' . explode('#', $_SERVER['HTTP_REFERER'])[1];
    }

    // Формируем URL с параметрами и якорем
    $url = "$readerlang?q=$stringForOpen" . (!empty($s) ? "&s=$s" : "") . $anchor;
    
    // Редирект
    echo "<script>window.location.href='$url';</script>";
    exit;
}
 
   	  	if ($_SERVER["REQUEST_METHOD"] == "GET") {
   	  	$q = test_input($_GET["q"]);
/* 	  	$pitaka = test_input($_GET["pitaka"]);
 */	  	}

   	  	// Removing the redundant HTML characters if any exist.
   	  	function test_input($data) {
   	  	$data = trim($data);
   	/*	$data = stripslashes($data);
   	  	$data = htmlspecialchars($data); */
   	  	return $data;
   	  	}
   	  	
      if (empty($_GET["p"])) {
    $p = "";
  } else {
    $p = test_input($_GET["p"]);
  }


//для поделиться pwa share api 
$q = urldecode($q);

if (strpos($q, 'http') !== false || strpos($q, 'https') !== false) {
    if (preg_match('/"([^"]+)"/u', $q, $matches)) {
        $q = $matches[1]; // оставить только текст в кавычках
        $p = '-kn';
    } else {
        $q = ''; // если кавычек нет — очистить
    }
}

// Если шеринг внутри приложения (нет URL, но есть текст в кавычках)
else if (preg_match('/"([^"]+)"/u', $q, $matches)) {
    $q = $matches[1]; // оставить только текст в кавычках
    $p = '-kn';
}

	
	if (empty($_GET["la"])) {
    $la = "";
  } else {
    $la = test_input($_GET["la"]);
  }
  
     	  	if ($_SERVER["REQUEST_METHOD"] == "GET") {
       if (empty($_GET["s"])) {
    $s = "";
  } else {
$s = urlencode($_GET['s']);  // Кодируем параметр s
  } 
  	}
// echo 's is ' . $s . '<br>'; 
// Получаем текущие параметры

$anchor = isset(parse_url($_SERVER['REQUEST_URI'])['fragment']) ? parse_url($_SERVER['REQUEST_URI'])['fragment'] : '';

// echo 'anchor is' . $anchor . '<br>'; 
	
		$string = str_replace("`", "", $q);
$stringForOpen = strtolower($string);
$stringForOpen = preg_replace('/([a-zA-Z])\s+(\d)/', '$1$2', $stringForOpen);
$stringForOpen = preg_replace('/([^\d])\s+(\d)/u', '$1$2', $stringForOpen);
$stringForOpen = preg_replace('/(\d+)\s*\.\s*(\d+)/', '$1.$2', $stringForOpen);
$stringForOpen = preg_replace('/([0-9]) ([0-9])/', '$1.$2', $stringForOpen);
$stringForOpen = preg_replace('/([0-9])\. ([0-9])/', '$1.$2', $stringForOpen);
$stringForOpen = str_replace(
    ['й','ц','у','к','е','н','г','ш','щ','з','х','ъ','ф','ы','в','а','п','р','о','л','д','ж','э','я','ч','с','м','и','т','ь','б','ю','.'],
    ['q','w','e','r','t','y','u','i','o','p','[',']','a','s','d','f','g','h','j','k','l',';',"'",'z','x','c','v','b','n','m',',','.','.'],
    $stringForOpen
);

// Дебаг-вывод
/* echo "<pre>После замены: ";
var_dump($stringForOpen);
echo "</pre>";
exit("=== ДЕБАГ: Скрипт остановлен ===");
 */
// Включаем сессию ТОЛЬКО если запрос содержит проблемные slug
$problematicSlugs = ['pli-tv-bu-vb-', 'bu-', 'bi-'];
$isProblematicSlug = false;

foreach ($problematicSlugs as $slugPattern) {
    if (strpos($stringForOpen, $slugPattern) !== false) {
        $isProblematicSlug = true;
        break;
    }
}

if ($isProblematicSlug) {
    session_start(); // Активируем сессию только для проблемных slug

    // Проверяем, не был ли этот slug уже обработан
    if (isset($_SESSION['processed_slug']) && $_SESSION['processed_slug'] === $stringForOpen) {
        die("Ошибка: обнаружен бесконечный редирект. Запрос: " . htmlspecialchars($stringForOpen));
    }

    // Запоминаем slug в сессии
    $_SESSION['processed_slug'] = $stringForOpen;
}


if (preg_match("/^(ja|snp|iti|thig|thag)[0-9].*/i", $stringForOpen)) {
  
redirectWithAnchor($readerlang, $stringForOpen, $s ?? null, $anchor); 	  
//for patimokkha and vinaya vibhanga
} else if (preg_match("/pli-tv-/i", $stringForOpen)) {
  
//  echo "<script>window.location.href='$readerlang?q=$stringForOpen&s=$s';</script>";

// echo "<script>window.location.href='$readerlang?s=$s&q=$stringForOpen#$anchor';</script>";
 if ($isProblematicSlug) {
        unset($_SESSION['processed_slug']);
        session_write_close();
    }
	
redirectWithAnchor($readerlang, $stringForOpen, $s ?? null, $anchor); 
	  
} else if (preg_match("/^(bu|bi)-pm$/i", $stringForOpen)) {
//echo "<script>alert('case 1');</script>";	
redirectWithAnchor($readerlang, $stringForOpen, $s ?? null, $anchor); 

}  else if (preg_match("/^(bu|pm|bpm|bupm)$/i", $stringForOpen)) {
  
	//echo "<script>window.location.href='$readerlang?q=bu-{$stringForOpen}';</script>";	
	echo "<script>window.location.href='/pm.php?expand=true';</script>";	
	  exit(); 
} else if (preg_match("/^(bi|bipm)$/i", $stringForOpen)) {

//echo "<script>alert('case 1');</script>";	
//	echo "<script>window.location.href='$readerlang?q={$stringForOpen}';</script>";	
	echo "<script>window.location.href='/bipm.php?expand=true';</script>";	
} else if  (preg_match("/^(pj|ss|ay|np|pc|pd|sk|as)$/i", $stringForOpen)) {

  //open read.php Bu
  $stringForOpen = str_replace (" ", "", $stringForOpen);
$stringForOpen = strtolower($stringForOpen);
echo "<script>window.location.href='{$base}read.php#{$stringForOpen}CollapseBu';
    addToSearchHistory();
</script>";
  exit();
} else if  (preg_match("/^bi-(pj|ss|ay|np|pc|pd|sk|as)$/i", $stringForOpen)) {
  //open read.php Bi
  $stringForOpen = str_replace (" ", "", $stringForOpen);
  $stringForOpen = str_replace ("bi-", "", $stringForOpen);
$stringForOpen = strtolower($stringForOpen);
echo "<script>window.location.href='{$base}read.php#{$stringForOpen}CollapseBi';
    addToSearchHistory();
</script>";
  exit();
} else if (preg_match("/(bu|bi)-([a-z][a-z])[0-9]*/i", $stringForOpen)) {
 // echo "<script>alert('case 2');</script>";	
if (strpos($stringForOpen, 'vb-') === false) {
    $stringForOpen = str_replace('bi-', 'bi-vb-', $stringForOpen);
    $stringForOpen = str_replace('bu-', 'bu-vb-', $stringForOpen);
}

  $check = shell_exec("grep -m1 -i \"{$stringForOpen}_\" $indexesfile | awk '{print \$0}'");
//if this empty then find range
if (empty($check)) {
  //echo "<script>alert('case 3');</script>";	
  $command = escapeshellcmd("bash $scriptfile $stringForOpen");
  $stringForOpen = trim(shell_exec($command));
  $stringForOpen = str_replace(PHP_EOL, '', $stringForOpen);
}	  
if (empty($stringForOpen)) {
  //echo "<script>alert('case 31');</script>";	
  echo "<script>window.location.href='$readerlang';</script>";	
  exit();
}	  

  $stringForOpen = str_replace('bi-vb-', 'bi-', $stringForOpen);
    $stringForOpen = str_replace('bu-vb-', 'bu-', $stringForOpen);
 redirectWithAnchor($readerlang, $stringForOpen, $s ?? null, $anchor); 

} else if (preg_match("/(bu|bi)-(vb|[a-z][a-z]*)/i", $stringForOpen)) {
//echo "<script>alert('case 4');</script>";	
 $stringForOpen = $stringForOpen . "1";
 	redirectWithAnchor($readerlang, $stringForOpen, $s ?? null, $anchor); 

} else if (preg_match("/(pj|ss|ay|np|pc|pd|sk|as)([0-9]{1,3}|[0-9]-[0-9])/i", $stringForOpen)) {
 // echo "<script>alert('case 5');</script>";	
  $stringForOpen = "bu-" . $stringForOpen;

if (strpos($stringForOpen, 'vb-') === false) {
    $stringForOpen = str_replace('bi-', 'bi-vb-', $stringForOpen);
    $stringForOpen = str_replace('bu-', 'bu-vb-', $stringForOpen);
}

  $check = shell_exec("grep -m1 -i \"{$stringForOpen}_\" $indexesfile | awk '{print \$0}'");
//if this empty then find range
if (empty($check)) {
  //echo "<script>alert('case 3');</script>";	
  $command = escapeshellcmd("bash $scriptfile $stringForOpen");
  $stringForOpen = trim(shell_exec($command));
  $stringForOpen = str_replace(PHP_EOL, '', $stringForOpen);
}	  
if (empty($stringForOpen)) {
  //echo "<script>alert('case 31');</script>";	
  echo "<script>window.location.href='$readerlang';</script>";	
  exit();
}	  

  $stringForOpen = str_replace('bi-vb-', 'bi-', $stringForOpen);
    $stringForOpen = str_replace('bu-vb-', 'bu-', $stringForOpen);
    redirectWithAnchor($readerlang, $stringForOpen, $s ?? null, $anchor); 

} else if (preg_match("/(kd|pvr)([0-9]{1,3}|[0-9][ \.][0-9])/i", $stringForOpen)) {
 // echo "<script>alert('case 5');</script>";	
  $stringForOpen = "pli-tv-" . $stringForOpen;

    redirectWithAnchor($readerlang, $stringForOpen, $s ?? null, $anchor); 
}

/* ru with arg */ 
/* for th.su dn */
  if (preg_match("/^(dn|mn)[0-9]{1,3}s$/i",$stringForOpen)) {

if ( $mode == "offline" ) {
  
$forthsu = preg_replace("/dn/i","","$stringForOpen");
$forthsu = preg_replace("/s/i","","$forthsu");

$link = shell_exec("ls $thsulocation/dn | grep \"dn{$forthsu}.html\" | awk '{print \"$linkforthsu\"$0}'");
      } else {

$forthsu = preg_replace("/s$/i","","$stringForOpen");
$nikaya = preg_replace("/[0-9]/i","","$forthsu");
$forthsu = preg_replace("/[a-z]/i","","$stringForOpen");

switch (strtolower($nikaya)) {
  case "dn":
    $thsulink = "https://tipitaka.theravada.su/toc/translations/1098";
    $grepfor = "ДН";
     // curl -s $thsulink
    //$sourcefile = "$locationTocThsu/dn_toc_thsu.txt";
    // cat $sourcefile
    $link = shell_exec("curl -s $thsulink | grep \"$grepfor $forthsu \" | grep translations | sed 's#href=\"/toc/translations/#href=\"https://tipitaka.theravada.su/node/table/#' |awk -F'\"' '{print \$2}' | tail -n1");
    break;
  case "mn":
    $thsulink = "https://tipitaka.theravada.su/toc/translations/1549";
    $grepfor = "МН";
    $sourcefile = "$locationTocThsu/mn_toc_thsu.txt";
    $link = shell_exec("curl -s $thsulink | grep -A3 \"$grepfor $forthsu \" | grep Таблица | sed 's#href=\"/node/table/#href=\"https://tipitaka.theravada.su/node/table/#' |awk -F'\"' '{print \$2}' | tail -n1");
    break;
  case "sn":
    $thsulink = "https://tipitaka.theravada.su/toc/translations/1549";
    $grepfor = "СН";
  case "an":
    $thsulink = "https://tipitaka.theravada.su/toc/translations/1549";
    $grepfor = "СН";
  default:
    echo $nikaya;
    echo "Your favorite color is neither red, blue, nor green! ";

}

}
$link = str_replace(PHP_EOL, '', $link);
echo '<script>window.open("' . $link . '", "_self");</script>';
  exit();
  
}

if( $p == "-ru" ) 
{
    if(preg_match("/^(mn|dn)[0-9]{1,3}$/i",$stringForOpen) || preg_match("/^(sn|an|ud)[0-9]{0,2}[\. ][0-9]*$/i",$stringForOpen) || preg_match("/^(sn|an|ud)[0-9]{0,2}[ \.][0-9]{0,3}-[0-9].*$/i",$stringForOpen)) 
    {
      $stringForOpen = str_replace (" ", ".", $stringForOpen);
  $forthru = str_replace(".","_","$stringForOpen"). '-';
  $filename = shell_exec("ls -R $thrulocation | grep -i -m1 $forthru" ); 
  if( $filename != "" ) {
  $link = $linkforthru . $filename;
 $link = str_replace(PHP_EOL, '', $link);
  } 
  else if (preg_match("/^dn[0-9]{1,2}$/i",$stringForOpen)) {

$forthsu = preg_replace("/dn/i","","$stringForOpen");

if ( $mode == "offline" ) {
    $link = shell_exec("ls $thsulocation | grep \"dn{$forthsu}.html\" | awk '{print \"$linkforthsu\"$0}'");
      } else {
$link = shell_exec("ls $thsulocation | grep \"dn{$forthsu}.html\" | awk '{print \"$linkforthsu\"$0}'");
}

$link = str_replace(PHP_EOL, '', $link);

}
echo '<script>window.open("' . $link . '", "_self");</script>';
  exit();
}

}

/* ru with layout */ 

function ru2lat($str)    {
    $tr = array(
    "А"=>"a", "Б"=>"b", "В"=>"v", "Г"=>"g", "Д"=>"d",
    "Е"=>"e", "Ё"=>"yo", "Ж"=>"zh", "З"=>"z", "И"=>"i", 
    "Й"=>"j", "К"=>"k", "Л"=>"l", "М"=>"m", "Н"=>"n", 
    "О"=>"o", "П"=>"p", "Р"=>"r", "С"=>"s", "Т"=>"t", 
    "У"=>"u", "Ф"=>"f", "Х"=>"kh", "Ц"=>"ts", "Ч"=>"ch", 
    "Ш"=>"sh", "Щ"=>"sch", "Ъ"=>"", "Ы"=>"y", "Ь"=>"", 
    "Э"=>"e", "Ю"=>"yu", "Я"=>"ya", "а"=>"a", "б"=>"b", 
    "в"=>"v", "г"=>"g", "д"=>"d", "е"=>"e", "ё"=>"yo", 
    "ж"=>"zh", "з"=>"z", "и"=>"i", "й"=>"j", "к"=>"k", 
    "л"=>"l", "м"=>"m", "н"=>"n", "о"=>"o", "п"=>"p", 
    "р"=>"r", "с"=>"s", "т"=>"t", "у"=>"u", "ф"=>"f", 
    "х"=>"kh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh", "щ"=>"sch", 
    "ъ"=>"", "ы"=>"y", "ь"=>"", "э"=>"e", "ю"=>"yu", 
    "я"=>"ya", " "=>"-", "."=>".", ","=>"", "/"=>"-",  
    ":"=>"", ";"=>"","—"=>"", "–"=>"-"
    );
    return strtr($str,$tr);
}
if (preg_match('/^[А-Яа-яЁё][А-Яа-яЁё][1-9]{1,3}/ui', $stringForOpen) || preg_match("/^(сн|ан|уд)[0-9]{0,2}[ \.][0-9]*$/ui",$stringForOpen) || preg_match("/^(сн|ан|уд)[0-9]{0,2}[ \.][0-9]{0,3}-[0-9].*$/ui",$stringForOpen)) 
    {
      $stringForOpen = str_replace (" ", ".", $stringForOpen);
     $trnstring = ru2lat( $stringForOpen );	
  $forthru = str_replace(".","_","$trnstring"). '-';
  $filename = shell_exec("ls -R $thrulocation | grep -i -m1 $forthru" ); 
 
  if( $filename != "" ) {
  $link = $linkforthru . $filename;
 $link = str_replace(PHP_EOL, '', $link);
  } 
  
  elseif (preg_match("/^dn[0-9]{1,2}$/i",$trnstring)) {
$forthsu = preg_replace("/dn/i","","$trnstring");
$link = shell_exec("ls $thsulocation | grep \"dn{$forthsu}.html\" | awk '{print \"$linkforthsu\"$0}'");

$link = str_replace(PHP_EOL, '', $link);

}
echo '<script>window.open("' . $link . '", "_self");</script>';
  exit();
}

if( $p == "-th" ) {
    if(preg_match("/^(mn|dn|dhp)[0-9]{1,3}$/i",$stringForOpen) || preg_match("/^(sn|an|ud)[0-9]{0,2}[ \.][0-9]{0,3}$/i",$stringForOpen) || preg_match("/^(sn|an|ud)[0-9]{0,2}[ \.][0-9]{0,3}-[0-9]{0,3}$/i",$stringForOpen)|| preg_match("/^dhp[0-9]{0,3}-[0-9]{0,3}$/i",$stringForOpen)){
      $stringForOpen = str_replace (" ", ".", $stringForOpen);
    {
      $check = shell_exec("grep -m1 -i \"{$stringForOpen}_\" $indexesfile | awk '{print \$0}'");
//if this empty then find range
if (empty($check)) {
  $command = escapeshellcmd("bash $scriptfile $stringForOpen");
  $stringForOpen = trim(shell_exec($command));
}	  

 // $link = "https://suttacentral.net/$stringForOpen/th/siam_rath";
 $link = $linkforthai. $stringForOpen. $linkforthaiend;
echo '<script>window.open("' . $link . '", "_self");</script>';
  exit();
}
}
}

#open text list onthe read.php page
if(preg_match("/^(mn|dn|sn|an|kn|snp|ud|iti|thag|thig|dhp)$/i",$stringForOpen) || preg_match("/^(sn|an)[0-9]{0,2}$/i",$stringForOpen)){
$stringForOpen = str_replace (" ", "", $stringForOpen);
$numberblock = preg_replace("/[a-z]*/i","","$stringForOpen");
$letterblock = preg_replace("/[0-9]*/i","","$stringForOpen");

$stringForOpen = strtolower($stringForOpen);
echo "<script>
window.location.href='{$base}read.php#{$stringForOpen}Collapse';
    addToSearchHistory();

</script>";
  exit();
}

#open sutta in sc light interface
if(preg_match("/^(mn|dn|dhp|iti)[0-9]{1,3}$/i",$stringForOpen) || preg_match("/^(snp|sn|an|ud|thig|thag)[0-9]{0,2}( |\.)[0-9]{0,3}$/i",$stringForOpen) || preg_match("/^(snp|sn|an|ud|dhp)[0-9]{0,2}( |\.)[0-9]{0,3}-[0-9]{0,3}$/i",$stringForOpen)|| preg_match("/^dhp[0-9]{0,3}-[0-9]{0,3}$/i",$stringForOpen)){
$stringForOpen = str_replace (" ", ".", $stringForOpen);
$check = shell_exec("grep -m1 -i \"{$stringForOpen}_\" $indexesfile | awk '{print \$0}'");
//if this empty then find range
if (empty($check)) {
  $command = escapeshellcmd("bash $scriptfile $stringForOpen");
  $stringForOpen = trim(shell_exec($command));
}	  

$numberblock = preg_replace("/[a-z]*/i","","$stringForOpen");
$letterblock = preg_replace("/[0-9]*/i","","$stringForOpen");

if ((  $numberblock <= $latestrusmn ) && ( preg_match("/mn/i",$letterblock) ) ){
$defaultlang = 'lang=pli-rus';
}
$stringForOpen = strtolower($stringForOpen);
redirectWithAnchor($readerlang, $stringForOpen, $s ?? null, $anchor); 

}
// &$defaultlang
if(preg_match("/^(mn|dn|dhp|iti)[0-9]{1,3}b$/i",$stringForOpen) || preg_match("/^(snp|sn|an|ud|thig|thag)[0-9]{0,2}( |\.)[0-9]{0,3}b$/i",$stringForOpen) || preg_match("/^(snp|sn|an|ud|dhp)[0-9]{0,2}( |\.)[0-9]{0,3}-[0-9]{0,3}b$/i",$stringForOpen)|| preg_match("/^dhp[0-9]{0,3}-[0-9]{0,3}b$/i",$stringForOpen)){
  $stringForOpen = str_replace (" ", ".", $stringForOpen);
  $forbwlink = strtolower(preg_replace("/b$/i","","$stringForOpen"));
  $bwprefix = strtolower(substr($forbwlink,0,2));
  
//  echo "<script>window.location.href='/bw/{$bwprefix}/{$forbwlink}.html';</script>";

 echo "<script>window.location.href='/bw/{$bwprefix}/{$forbwlink}.html" . (!empty($s) ? "&s=$s" : "") . "$anchor';</script>";
 
  exit(); 
}

?> 

