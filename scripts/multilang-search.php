<?php
error_reporting(E_ERROR | E_PARSE);
include_once('./config/config.php');

foreach ($extra as $value) {
    $extraString .= " $value"; // Добавьте каждый элемент массива к строке с пробелом
}

$stringForWord = $string;
$string = "\"$string\"";

//$string = "uttarimanussadham";
//$p = "-vin";
if ( preg_match('/\/ru/', $actual_link)) {
  $outputlang = "-oru";
  $langinurl = "/ru";
} else {
    $outputlang = "";
  $langinurl = "/";
    }
//echo "$p $q $extra $cb";
//echo "<script>document.getElementById( 'spinner' ).style.display = 'block';</script>";

// Получаем текущий URL (путь и параметры запроса)
$currentUrl = $_SERVER['REQUEST_URI'] ?? '';

// Разбираем URL на компоненты
$parsedUrl = parse_url($currentUrl);

// Извлекаем путь (без параметров)
$path = $parsedUrl['path'] ?? '';

// Извлекаем параметры запроса
$query = $parsedUrl['query'] ?? '';

// Очищаем параметры
if (!empty($query)) {
    parse_str($query, $params); // Преобразуем строку параметров в массив

    // Удаляем пустые параметры или параметры, содержащие только пробелы
    foreach ($params as $key => $value) {
        if (trim($value) === '') {
            unset($params[$key]); // Удаляем параметр, если он пустой или содержит только пробелы
        }
    }

    // Собираем параметры обратно в строку
    $query = http_build_query($params);
}

// Собираем очищенный URL
$cleanedUrl = $path;
if (!empty($query)) {
    $cleanedUrl .= '?' . $query;
}

// Формируем путь к файлу
$filePath = $basedir . '/result/params.txt';

// Убедимся, что директория существует
if (!is_dir($basedir . '/result')) {
    mkdir($basedir . '/result', 0755, true);
}

// Записываем очищенный URL в файл
if (file_put_contents($filePath, $cleanedUrl . PHP_EOL) === false) {
    error_log("Не удалось записать URL в файл: $filePath");
} 
//else { echo "Очищенный URL успешно записан: $cleanedUrl"; }

// Режим Словаря 
if (preg_match('/dictLookup/', $p) || preg_match('/dictLookup/', $extra)) {
    $stringForWord = urlencode(htmlspecialchars(strtolower($stringForWord), ENT_QUOTES));
    $dictType = 'https://dict.dhamma.gift';
    
    if (preg_match('/\/ru/', $actual_link)) {
        $outputlang = "-oru";
        $langinurl = "/ru";
    } else {
        $outputlang = "";
        $langinurl = "";
    }

    if (empty($stringForWord) || $stringForWord === '""') {
        $stringForWord = "dukkha";
    }

    $server_name = $_SERVER['SERVER_NAME'];
    if ($server_name === 'localhost' || $server_name === '127.0.0.1') {
        $dictUrl = "dttp://app.dicttango/WordLookup?word="; // Исправлен протокол
    } else {
        $dictUrl = "/assets/openDDG.html?url={$dictType}{$langinurl}/search_html?q=";  
    }
    
    echo "<script>
    setTimeout(function() {
window.location.href = '{$dictUrl}' + '{$stringForWord}';
        document.getElementById('spinner').style.display = 'none';
    }, 100);
    </script>";
    return;
}


// Проверка условий
if (preg_match('/wordRep/', $p) || preg_match('/wordRep/', $extra)) {
    // Действие при выполнении условия
    $stringForWord = urlencode($stringForWord); 
    
    if ( preg_match('/\/ru/', $actual_link)) {
  $outputlang = "-oru";
  $langinurl = "/ru";
} else {
    $outputlang = "";
  $langinurl = "";
    }
    
echo "<script>
window.location.href='$langinurl/w.php?&d=an,sn,mn,dn,kn&s=$stringForWord';
</script>";
    exit();
}

if (preg_match('/(-abhi )/', $q)) {
  $fdgscript = "./scripts/finddhamma.sh";
      $q = trim(preg_replace('/-abhi/', ' ', $q));    
$p = "-abhi"; 
} 

//-vin was here
if (preg_match('/(-def|-sml|-nm|-b|-onl|-tru|-si|-abhi)/', $p)  || preg_match('/(-onl|-def|-sml|-nm|-b|-tru|-si|-la2|-lb2)/', $extra)) {
  $fdgscript = "./scripts/finddhamma.sh";
} 
else if (preg_match('/(-anyd)/', $extra)) {
  $fdgscript = "./new/fdgnew.sh";
  $p = "-kn";
}
/* elseif (preg_match('/(-vin)/', $p)) {
  $fdgscript = "./new/fdgnew.sh -src vn";
}
elseif (preg_match('/(-all -vin)/', $p)) {
  $fdgscript = "./new/fdgnew.sh -src vn,kp";
} */
else {
  $fdgscript = "./new/finddhamma2.sh";
}

/* single search no radiobuttons */
if (preg_match('/-tru/', $p) || preg_match('/-tru/', $q) || preg_match('/-tru/', $extra)) {
$p = "-tru"; 
$fdgscript = "./scripts/finddhamma.sh";

$output = shell_exec("bash $fdgscript $outputlang $la $extra $cb $p $string"); 

$output = trim(preg_replace('/\s\s+/', ' ', $output));  
$outforjs = $output . "<br>";
    
}
else if (preg_match('/[А-Яа-яЁё]/u', $string) ) {

$p = "-ru"; 

//|| ( $p == "-ru" ) || ( $p == "-tru" )

$output = shell_exec("bash $fdgscript $outputlang $la $extra $cb $p $string"); 
//$fdgscript
//$fdgscript

// sed -i 's@$fdgscript@$fdgscript@g' scripts/multilang-search.php

//echo "<p class='mt-3'>$output</p>";
$output = trim(preg_replace('/\s\s+/', ' ', $output));  
$outforjs = $output . "<br>";


$check = ru2lat( $output );

        if ((( $p == "-ru" ) && ( preg_match('/(-not-in-|-net-v-)/', $check)  )) || ( ( $p != "-vin" ) && ( preg_match('/(-not-in-|-net-v-)/', $check)  ))) {

$fdgscript = "./scripts/finddhamma.sh";
     $output = shell_exec("bash $fdgscript $outputlang $la $extra $cb -tru $string");
//   echo "<script>document.getElementById( 'spinner' ).style.display = 'none';</script>";
    // echo                                                 "<p>$output</p>";
     $output = trim(preg_replace('/\s\s+/', ' ', $output)); 
     $outforjs .= $output;
            }   

#Devanagari
} else if (preg_match('/\p{Devanagari}/u', $string) || ( $p == "-dv" )) {
  $p = "";
  if ( $mode == "offline" ) {
  $command = escapeshellcmd("$adapterscriptlocation $string");
  $convertedStr = shell_exec($command);
 $output = $aksharatext . $convertedStr; 
 $output = trim(preg_replace('/\s\s+/', ' ', $output)); 
 $outforjs .= $output . "<br>";
  $output = shell_exec("bash $fdgscript $outputlang -conv $la $extra $cb $convertedStr");
 // echo "<p>$output</p>";
 $output = trim(preg_replace('/\s\s+/', ' ', $output)); 
$outforjs .= $output . "<br>";
  
      } else {
        
      $cURLConnection = curl_init();
 $param = urlencode($string);
curl_setopt($cURLConnection, CURLOPT_URL, "https://aksharamukha-plugin.appspot.com/api/public?target=IASTPali&text=$param");
curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
    'Content-Type: text/plain'
));
$convertedStr = curl_exec($cURLConnection);
curl_close($cURLConnection);
 $output = $aksharatext . $convertedStr; 
 $output = trim(preg_replace('/\s\s+/', ' ', $output)); 
 $outforjs .= $output . "<br>";
  $output = shell_exec("bash $fdgscript $outputlang -conv $la $extra $cb $convertedStr");
//  echo "<p>$output</p>";
$output = trim(preg_replace('/\s\s+/', ' ', $output));  
$outforjs .= $output . "<br>";
      }
   
      $output = shell_exec("bash $fdgscript $outputlang $la $extra $cb $p $string");
//    echo "<p class='mt-3'>$output</p>";
      $output = trim(preg_replace('/\s\s+/', ' ', $output));    
$outforjs .= $output . "<br>"; 

//echo "<script>document.getElementById( 'spinner' ).style.display = 'none';</script>";
            
} 

#thai
else if (preg_match('/\p{Thai}/u', $string) || ( $p == "-th" )) {
  $p = "-th";
  if ( $mode == "offline" ) {
  $command = escapeshellcmd("$adapterscriptlocation $string");
  $convertedStr = shell_exec($command);
 $output = $aksharatext . $convertedStr; 
 $output = trim(preg_replace('/\s\s+/', ' ', $output)); 
 $outforjs .= $output . "<br>";
  $output = shell_exec("bash $fdgscript $outputlang -conv $la $extra $cb $convertedStr");
 // echo "<p>$output</p>";
 $output = trim(preg_replace('/\s\s+/', ' ', $output)); 
$outforjs .= $output . "<br>";
  
      } else {
        
      $cURLConnection = curl_init();
 $param = urlencode($string);
curl_setopt($cURLConnection, CURLOPT_URL, "https://aksharamukha-plugin.appspot.com/api/public?target=IASTPali&text=$param");
curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
    'Content-Type: text/plain'
));
$convertedStr = curl_exec($cURLConnection);
curl_close($cURLConnection);
 $output = $aksharatext . $convertedStr; 
 $output = trim(preg_replace('/\s\s+/', ' ', $output)); 
 $outforjs .= $output . "<br>";
  $output = shell_exec("bash $fdgscript $outputlang -conv $la $extra $cb $convertedStr");
//  echo "<p>$output</p>";
$output = trim(preg_replace('/\s\s+/', ' ', $output));  
$outforjs .= $output . "<br>";
      }
   
      $output = shell_exec("bash $fdgscript $outputlang $la $extra $cb $p $string");
//    echo "<p class='mt-3'>$output</p>";
      $output = trim(preg_replace('/\s\s+/', ' ', $output));    
$outforjs .= $output . "<br>"; 

//echo "<script>document.getElementById( 'spinner' ).style.display = 'none';</script>";
            
} 
#sinhala
else if (preg_match('/\p{Sinhala}/u', $string) || ( $p == "-si" )) {
  $p = "-si";
  if ( $mode == "offline" ) {
    
  $command = escapeshellcmd("$adapterscriptlocation $string");
  $convertedStr = shell_exec($command);
 $output = $aksharatext . $convertedStr; 
 $output = trim(preg_replace('/\s\s+/', ' ', $output)); 
 $outforjs .= $output . "<br>";
  $output = shell_exec("bash $fdgscript $outputlang -conv $la $extra $cb $convertedStr");
 // echo "<p>$output</p>";
 $output = trim(preg_replace('/\s\s+/', ' ', $output)); 
$outforjs .= $output . "<br>";
  
      } else {
        
      $cURLConnection = curl_init();
 $param = urlencode($string);
curl_setopt($cURLConnection, CURLOPT_URL, "https://aksharamukha-plugin.appspot.com/api/public?target=IASTPali&text=$param");
curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
    'Content-Type: text/plain'
));
$convertedStr = curl_exec($cURLConnection);
curl_close($cURLConnection);
 $output = $aksharatext . $convertedStr; 
 $output = trim(preg_replace('/\s\s+/', ' ', $output)); 
 $outforjs .= $output . "<br>";
 echo "$outputlang $p -conv $la $extra $cb $convertedStr";
  $output = shell_exec("bash $fdgscript $outputlang -conv $la $extra $cb $convertedStr");
  
//  echo "<p>$output</p>";
$output = trim(preg_replace('/\s\s+/', ' ', $output));  
$outforjs .= $output . "<br>";
      }
   
      $output = shell_exec("bash $fdgscript $outputlang $la $extra $cb $p $string");
//    echo "<p class='mt-3'>$output</p>";
      $output = trim(preg_replace('/\s\s+/', ' ', $output));    
$outforjs .= $output . "<br>"; 

//echo "<script>document.getElementById( 'spinner' ).style.display = 'none';</script>";
            
} 

//english 
else if ( $p == "-en" ) {
$output = shell_exec("bash $fdgscript $outputlang $la -en $extra $cb $string");
                                                                //      echo "<p>$output</p>";
      $output = trim(preg_replace('/\s\s+/', ' ', $output));    
$outforjs .= $output . "<br>"; 

}
else if ( $p == "-b" ) {
$output = shell_exec("bash $fdgscript $outputlang $la -b $extra $cb $string");
                                                                //      echo "<p>$output</p>";
      $output = trim(preg_replace('/\s\s+/', ' ', $output));    
$outforjs .= $output . "<br>"; 

}

/* Pali def*/  
else if ( preg_match('/-def/', $p ) && preg_match('/-vin/', $p ))  {
$output = shell_exec("bash $fdgscript $outputlang $la -def -vin $extra $cb $string");
$output = trim(preg_replace('/\s\s+/', ' ', $output));  
$outforjs .= $output . "<br>"; 
}

else if ( preg_match('/-def/', $p ) && ( $p != "-vin" ))  {
$output = shell_exec("bash $fdgscript $outputlang $la -def $extra $cb $string");
//    echo "<p>$output</p>";
$check = ru2lat( $output );
      $output = trim(preg_replace('/\s\s+/', ' ', $output));    
$outforjs .= $output . "<br>"; 

if ( preg_match('/-def/', $p ) && ( preg_match('/(-not-in-|-net-v-)/', $check)))  {
$output = shell_exec("bash $fdgscript $outputlang $la -def -vin $extra $cb $string");
      $output = trim(preg_replace('/\s\s+/', ' ', $output));    
$outforjs .= $output . "<br>"; 
}   
/* Pali */  
}   else {
  
  $output = shell_exec("bash $fdgscript $outputlang $la $extra $cb $p $string"); 
    //      echo "<p class='mt-3'>$output</p>";
      $output = trim(preg_replace('/\s\s+/', ' ', $output));    
$outforjs .= $output . "<br>"; 


        $check = ru2lat( $output );
        
        
if ( preg_match('/(|-en)/', $p ) && ( preg_match('/(-not-in-|-net-v-)/', $check) ) && ( $p != "-vin" ) && ( $p != "-def" ))  {
  $fdgscript = "./new/finddhamma2.sh";
$output = shell_exec("bash $fdgscript $outputlang $la -vin $extra $cb $string");
//                                                                  echo "<p>$output</p>";
      $output = trim(preg_replace('/\s\s+/', ' ', $output));    
$outforjs .= $output . "<br>"; 

}   

$check = ru2lat( $output );

if ( preg_match('/(|-en)/', $p ) && ( preg_match('/(-not-in-|-net-v-)/', $check) ) && ( $p != "-vin" ) && ( $p != "-def" ))  {
  $fdgscript = "./new/finddhamma2.sh";
$output = shell_exec("bash $fdgscript $outputlang $la -en -kn $extra $cb $string");
//                                                                  echo "<p>$output</p>";
      $output = trim(preg_replace('/\s\s+/', ' ', $output));    
$outforjs .= $output . "<br>"; 

}

$check = ru2lat( $output );


if ( preg_match('/(|-en)/', $p ) && ( preg_match('/(-not-in-|-net-v-)/', $check) ) && ( $p != "-def" ))  {
$output = shell_exec("bash $fdgscript $outputlang $la -en -vin $extra $cb $string");
//                                                                  echo "<p>$output</p>";
      $output = trim(preg_replace('/\s\s+/', ' ', $output));    
$outforjs .= $output . "<br>"; 

}
}
//echo $outforjs;


$outputnonl = trim(preg_replace('/\s\s+/', ' ', $outforjs));

if (strpos($outputnonl, 'script') !== false || strpos($outputnonl, 'location.href') !== false) {
    // Ищем все скрипты в тексте
    preg_match_all('/<script\b[^>]*>(.*?)<\/script>/is', $outputnonl, $matches);
    // Собираем все найденные скрипты в одну строку
    $finaloutput = implode("\n", $matches[0]);

    // Добавляем скрытие страницы перед выполнением скриптов
    echo '<script>document.body.style.display = "none";
    </script>';
if (preg_match('/(-anyd)/', $extra)) {
  echo "<script>window.location.href='/result/r.html';
    addToSearchHistory();
  </script>";
}

    // Выполняем найденные скрипты
    echo '<script>addToSearchHistory();</script>';
    echo $finaloutput;
    exit;
} else {
    $finaloutput = "<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('$outputnonl');
        const successAlert = document.getElementById('successAlert');
        const responseElement = document.getElementById('response');
        
        if(responseElement && successAlert) {
            responseElement.innerHTML = '$outputnonl';
            
            // Показываем алерт только если есть содержимое
            if ('$outputnonl' !== '' && '$outputnonl' !== '<br>') {
                successAlert.style.display = 'block';
            }
        }
    });
    </script>";
}

if ($outputnonl !== '<br>' && !empty($outputnonl)) {
    echo $finaloutput;  
    
    echo "<script>document.getElementById( 'spinner' ).style.display = 'none';</script>";
}


/*
if ( preg_match('/(|-en|-b)/', $p ) && ( preg_match('/(-not-in-|-net-v-)/', $check) )  && ( $p != "-vin" ) && ( $p != "-def" ))  {
   $output = shell_exec("bash $fdgscript $outputlang $la -b $extra $cb $string");
//echo "<p>$output</p>";
      $output = trim(preg_replace('/\s\s+/', ' ', $output));    
$outforjs .= $output; 
}   
*/
?>  

