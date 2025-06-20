<?php
header("Cache-Control: public, max-age=3600"); // Кэшировать на 1 час
header("Expires: " . gmdate("D, d M Y H:i:s", time() + 3600) . " GMT");
?>
<!DOCTYPE html>
<?php
// Включаем вывод всех ошиок для отладки
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
error_reporting(E_ERROR | E_PARSE);
include_once('config/config.php');
include_once('config/translate.php');
include 'scripts/search-handler.php';
//echo basename($_SERVER['REQUEST_URI']);
?>
<html lang="<?php echo $htmllang;?>" data-bs-theme="dark">
  <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)">
<meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
    <head>
      <meta charset="UTF-8">

<title><?php echo $maintitle;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="description" content="<?php echo $metadesc;?>" />
<meta name="author" content="" />
<meta name="keywords" content="<?php echo $metakeywords;?>">
<meta property="og:locale" content="<?php echo $oglocale;?>" />
<meta property="og:type" content="website" />
<meta property="og:title" content="Dhamma.gift" />
<meta property="og:description" content="<?php echo $ogdesc;?>" />

<style>
    body {
        opacity: 0;
        background: black;
        visibility: hidden;
        transition: opacity 0.3s ease-in-out; /* Плавное появление */
    }
</style>

  <!-- PWA-метатеги -->
  <meta name="theme-color" content="#ffffff">
<link rel="manifest" href="<?php echo $mainpagenoslash ;?>/manifest.php">
<link rel="canonical" href="<?php echo $canonicalPage;?>">
<link rel="alternate" href="https://dhamma.gift/ru/" hreflang="ru">
<link rel="alternate" href="https://dhamma.gift/" hreflang="en">
<link rel="alternate" href="https://dhamma.gift/" hreflang="x-default">

<!-- для PWA где нет адресной строки, но нужно установить язык по умолчанию. --> 
<script>
// Проверяем, есть ли параметр source=pwa в URL
const urlParams = new URLSearchParams(window.location.search);
const isPWA = urlParams.get('source') === 'pwa';

// Если это PWA или TWA (и нужно принудительно задать язык)
if (isPWA) {
    // Проверяем значение siteLanguage в localStorage
    let siteLanguage = localStorage.getItem('siteLanguage');

    // Если siteLanguage не задан, определяем язык по URL или браузеру
    if (!siteLanguage) {
        const currentPath = window.location.pathname;
        
        // Если язык уже указан в URL, используем его
        if (currentPath.includes('/ru/')) {
            siteLanguage = 'ru';
        } else if (currentPath.includes('/th/')) {
            siteLanguage = 'th';
        } else {
            // Если язык не в URL, берём язык браузера
            const browserLang = navigator.language || navigator.userLanguage;
            siteLanguage = browserLang.startsWith('ru') ? 'ru' : 
                          browserLang.startsWith('th') ? 'th' : 'en';
        }

        // Сохраняем язык в localStorage
        localStorage.setItem('siteLanguage', siteLanguage);
    }

    // Если текущий URL не соответствует выбранному языку, делаем редирект
    const currentPath = window.location.pathname;
    const currentHash = window.location.hash;

    if (siteLanguage === 'ru' && !currentPath.includes('/ru/')) {
        window.location.href = '/ru/' + currentHash;
    } else if (siteLanguage === 'th' && !currentPath.includes('/th/')) {
        window.location.href = '/th/' + currentHash;
    } else if (siteLanguage === 'en' && currentPath !== '/') {
        window.location.href = '/' + currentHash;
    }
}
</script>

<meta property="og:url" content="https://Dhamma.gift" />
<meta property="og:site_name" content="Dhamma.gift" />
<meta property="og:image" content="<?php echo $ogshare;?>" />

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo $titletwit;?>">
<meta name="twitter:description" content="<?php echo $ogdesc;?>">
<!-- Favicon favico-noglass
<link href="/assets/img/gray.png" rel="icon" media="(prefers-color-scheme: light)">
<link href="/assets/img/gray-white.png" rel="icon" media="(prefers-color-scheme: dark)"> -->

<link rel="icon" type="image/png" sizes="56x56" href="/assets/img/favicon-56x56.png">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon-16x16.png">
<link rel="icon" href="/assets/img/favicon.ico">

  <!-- Загрузка иконки для iOS -->
  <link rel="apple-touch-icon" sizes="152x152" href="/assets/img/favico-noglass.png">
  
  
  
  <!-- iOS-специфичные -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="Dhamma.Gift">
  <link rel="apple-touch-icon" href="/icons/icon-180x180.png">
  <link rel="apple-touch-startup-image" href="/splash.png">
    <meta name="mobile-web-app-capable" content="yes">
  
  
  
<!-- Google fonts
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
-->

<!--  Core theme CSS (includes Bootstrap)-->
<link href="/assets/css/paliLookup.css" rel="stylesheet" />


<link rel="stylesheet" href="/assets/css/jquery-ui.min.css">
<!-- -->

<link href="/assets/css/styles.css" rel="stylesheet" />


<link href="/assets/css/extrastyles.css" rel="stylesheet" />
<script src="/assets/js/loadCssJsMain.js"></script>

<script src="/assets/js/jquery-3.7.0.min.js"></script>
<script src="/assets/js/jquery-ui.min.js"></script>

<?php echo $fontawesomejs;?> 
</head>


<!-- <script>window.location.href="https://f.dhamma.gift";</script> -->
    <body id="page-top"> 
  <script>
const url = new URL(window.location);
const searchParams = new URLSearchParams(url.search);

// Удаляем параметры, которые пустые или содержат только пробелы
for (let key of [...searchParams.keys()]) {
    if (!searchParams.get(key).trim()) {
        searchParams.delete(key);
    }
}


// Получаем текущий якорь
const currentHash = window.location.hash;

// Обновляем URL без перезагрузки, если есть изменения, и сохраняем якорь
const newUrl = url.pathname + (searchParams.toString() ? "?" + searchParams.toString() : "") + currentHash;
if (newUrl !== window.location.href) {
    history.replaceState(null, "", newUrl);
}

function updateURL(params) {
  //  console.log("Before update:", location.href);
    
    const updatedParams = new URLSearchParams();
    if (params.q) updatedParams.set("q", params.q);
    if (params.s) updatedParams.set("s", params.s);
    
    history.replaceState(null, "", `?${updatedParams.toString()}${window.location.hash}`);
   // console.log("After update:", location.href);
}

</script>

        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg bg-secondary text-uppercase" id="mainNav">
            <a class="navbar-brand mobile-center" href="<?php echo $mainpage;?>"> <div class="container">
              
              
    <!--    <img loading="lazy" alt="Precise search in Pali Suttas and Vinaya" src="/assets/img/gray-white.png"  style="width:50px;"></a>
   
   -->
   <img loading="lazy" alt="Precise search in Pali Suttas and Vinaya" src="/assets/img/dhammafindlogo.webp"  style="width:100px;"></a>

            
                <a class="navbar-brand mobile-none" href="/">Dhamma.gift</a>
                <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                   <?php echo $menu;?>
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
      <!-- <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="/">Main</a></li> -->
            
<li class="nav-item mb-3 mx-lg-2"><a class="nav-link py-3 px-0 px-lg-0 rounded" href="<?php echo $mainreadlink;?>"><?php echo $menuread;?></a></li>
<li class="nav-item mb-3 mx-lg-2"><a class="nav-link py-3 px-0 px-lg-0 rounded" href="<?php echo $mainpagenoslash;?>/history.php"><?php echo $menuhist;?></a></li>
<li class="nav-item mb-3 mx-lg-2"><a class="nav-link py-3 px-0 px-lg-0 rounded" href="#help"><?php echo $menuhowto;?></a></li>
<li class="nav-item mb-3 mx-lg-2"><a class="nav-link py-3 px-0 px-lg-0 rounded" href="#about"><?php echo $menuabout;?></a></li>             
<li class="nav-item mb-3 mx-lg-2"><a class="nav-link py-3 px-0 px-lg-0 rounded" href="#<?php echo $menuuseful;?>"><?php echo $menulinks;?></a></li>
<li class="nav-item mb-3 mx-lg-2"><a class="nav-link py-3 px-0 px-lg-0 rounded" href="#contacts"><?php echo $menucontact;?></a></li>
<li class="nav-item mb-0 mx-lg-2"><p><a class="py-1 text-decoration-none px-0 px-lg-1 rounded link-light" href="/" onclick="localStorage.siteLanguage = 'en';">En</a> 
<a class="link-light text-decoration-none py-1 px-0 px-lg-1 rounded" href="/ru/" onclick="localStorage.siteLanguage = 'ru';">Ru</a>

</p></li>
<li>

<div class="align-items-center form-check-inline mx-0">
     <a id="theme-button" class=" mb-1 text-white ">
<i onclick="switchIcon(this)" class="fa-solid fa-circle-half-stroke"></i>
</a>	  
</div>


</li>
       </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead bg-primary text-white text-center">
            <div class="container d-flex align-items-center flex-column mb-2">

                <!-- Masthead Heading-->
<div class="hideOnMobile">
<h1 class="masthead-heading mb-5">
    <div data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo $tooltiptitle;?>">
        <?php echo $title;?>
    </div>
</h1>

 <!--Icon Divider    
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                        <div class="lock example divider-custom-icon">
                                        <i class="fa-solid fa-circle example icon-unlock" ></i>
 <i class="fa-solid fa-circle icon-lock bigger"></i>
                      </div>
                    <div class="divider-custom-line"></div>
                </div>
                -->
</div>

<form method="GET" id="searchForm" action="" class="justify-content-center">
<div class="mb-3 form-group input-group ui-widget dropup rounded-pill">

<label class="sr-only dropup rounded-pill" for="paliauto"></label>

<?php
if (isset($_GET['q'])) {
    $q = htmlspecialchars($_GET['q']);
} else {
    $q = '';
}
?>

<div class="searchinputdiv">
  <input name="q" type="text" class="form-control rounded-pill searchinput" id="paliauto" placeholder="e.g. Kāyagat or sn56.11" value="<?php echo $q; ?>" multiple>
  <button type="button" id="clearbtn" class="btn btn-sm ms-1 me-1 rounded-pill">
    <i class="fas fa-times" aria-hidden="true"></i>
    <span class="visually-hidden"><?php echo $clearaption;?></span>
  </button>
</div>    

<!-- submit button -->
<div class="input-group-append">
<button onclick="document.getElementById( 'spinner' ).style.display = 'block'" type="submit" id="searchbtn" class="btn btn-primary mainbutton ms-2 mt-0 rounded-pill ">
<i class="fas fa-search fa-flip-horizontal" aria-hidden="true"></i>
    <span class="visually-hidden"><?php echo $searchcaption;?></span>
</button>
 <div class="text-start text-muted form-check-inline" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo $tooltipsearchbar;?>">*</div>
</div>

</div>

<div class="d-flex align-items-center flex-nowrap">
    <select class="dropdown droponmain rounded-pill text-muted border-2 border-primary text-center flex-shrink-1" id="pOptions" name="p">
        <option value="-kn" <?php if (isset($extra) && $p == "-kn") echo "selected";?> ><?php echo "$radiokn";?></option>
        <option value="" <?php if (isset($extra) && $p == "Pāḷi") echo "selected";?> ><?php echo $radiopli;?></option>
        <option value="-vin" <?php if (isset($extra) && $p == "-vin") echo "selected";?> ><?php echo "$radiovin";?></option>
        <option value="-all" <?php if (isset($extra) && $p == "-all") echo "selected";?> ><?php echo "$radioltr";?></option>
        <option value="-all -vin" <?php if (isset($extra) && $p == "-all -vin") echo "selected";?> ><?php echo "$radiovinall";?></option>
        <option value="-b" <?php if (isset($p) && $p == "-b") echo "selected";?> ><?php echo $radiotbw;?></option>
        <option value="-en" <?php if (isset($p) && $p == "-en") echo "selected";?> ><?php echo $radioen;?></option>
        <option value="-tru" <?php if (isset($p) && $p == "-tru") echo "selected";?> ><?php echo $radiotru;?></option>        
    </select>

    <div class="text-start text-muted form-check-inline me-0" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo $tooltiptextype;?>">*</div>

    <select class="dropdown droponmain rounded-pill text-muted border-2 border-primary text-center flex-shrink-1" id="extraOptions" name="extra">
        <option value="" <?php if (isset($extra)) echo "selected";?> ><?php echo "$liststd";?></option>
        <option value="dictLookup" <?php if (isset($extra) && $extra == "dictLookup") echo "selected";?> ><?php echo "$dictLookup";?></option>
        <option value="wordRep" <?php if (isset($extra) && $extra == "wordRep") echo "selected";?> ><?php echo "$listwords";?></option>
        <option value="-def" <?php if (isset($extra) && $extra == "-def") echo "selected";?> ><?php echo "$listdef";?></option>
        <option value="-sml" <?php if (isset($extra) && $extra == "-sml") echo "selected";?> ><?php echo "$listsml";?></option>
        <option value="-defall" <?php if (isset($extra) && $extra == "-defall") echo "selected";?> ><?php echo "$listdefall";?></option>
        <option value="-nm10" <?php if (isset($extra) && $extra == "-nm10") echo "selected";?> ><?php echo "$listnm10";?></option>
        <option value="-nm5" <?php if (isset($extra) && $extra == "-nm5") echo "selected";?> ><?php echo "$listnm";?></option>
    </select>

    <div class="text-muted text-decoration-none me-0 form-check-inline" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo $tooltipsearchtype;?>">*</div>

    <div id="gear" class="text-white ms-1 flex-shrink-0" data-bs-toggle="collapse" href="#collapseSettings" role="button" aria-expanded="false" aria-controls="collapseSettings">
        <i class="fa-solid fa-gear fa-lg"></i>
        <span class="visually-hidden"><?php echo $searchcaption;?></span>
    </div>
</div>

<script>
$(document).ready(function() {
  // Обработчик для нажатия клавиши Enter
  $(document).on('keydown', function(event) {
    if (event.key === 'Enter') {
      $('#collapseSettings').collapse('hide'); // Здесь меняем 'toggle' на 'hide'
     $('#navbarResponsive').collapse('hide');
    }
  });

  // Обработчик для отправки формы
  $('#searchbtn').on('click', function() {
    $('#collapseSettings').collapse('hide'); // Здесь меняем 'toggle' на 'hide'
          $('#navbarResponsive').collapse('hide');
  });
});


</script>

 <?php
if (strpos($_SERVER['REQUEST_URI'], "/ru") !== false){
echo '<div style="max-width: 450px; display: none;" class="alert alert-primary alert-dismissible fade show mt-3" role="alert" id="infoUpdate">
Добавить <strong>Dhamma.gift</strong> на Домашний Экран?
    <a class="btn btn-secondary installButton" id="" style="display:none;">' . $installpwalong . '</a>
   <br>
   <strong>iOS</strong> Safari: Поделиться -> добавить на Главную.<br> 
   <strong>Android</strong> Chrome: Настройки -> добавить на Главную<br>
   Теперь на Андроид можно: выделить слово <b>на любом сайте и приложении</b> -> и выбрать DG в меню "Поделиться" ОС<br>

<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
} else {
echo '<div style="max-width: 450px; display: none;" class="alert alert-primary alert-dismissible fade show mt-3" role="alert" id="infoUpdate">
Add <strong>Dhamma.gift</strong> to your Home Screen?
    <a class="btn btn-secondary installButton" id="" style="display:none;">' . $installpwalong . '</a>
   <br>
   <strong>iOS</strong> Safari: Share -> Add to Home Screen.<br>
   <strong>Android</strong> Chrome: Settings -> Add to Home Screen<br>
   After that on Android you can select word <b>on any site or app</b>-> and send it to DG app via "Share" OS menu<br>

<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
}
?>
<div style="max-width: 450px; display: none;" class='alert alert-warning alert-dismissible fade show container-lg mt-3 text-start' role='alert' id='successAlert'>
  <div id="response"></div>
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>

<div class="collapse" id="collapseSettings">
  
  <div class="float-start mt-2">

 <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="onlCheckbox" name="extra" <?php if (isset($extra) && $extra=="-anyd ") echo "checked";?>  value="-anyd">
  <div data-bs-toggle="tooltip" data-bs-placement="bottom" title='<?php echo $tooltiponl;?>'><?php echo $checkboxonl;?><span class="text-muted">*</span></div>
  </div>

  
  
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" id="laCheckbox" name="la" <?php if (isset($extra) && $extra=="-la$defaultla -lb$defaultla") echo "checked";?>  value='<?php echo "-la$defaultla -lb$defaultla"?>'>
  <div data-bs-toggle="tooltip" data-bs-placement="bottom" title='<?php echo $tooltipla;?>'><?php echo $checkboxla;?><span class="text-muted">*</span></div>
  </div>
  
         <div style="max-width: 300px;" class="my-2"> 
    
<div class="align-items-center form-check-inline mt-3">
  <div class="mb-2"><button class="btn btn-secondary rounded-pill insert-letter" data-letter="ā" autocomplete="off">ā</button>
  <button class="btn btn-secondary rounded-pill insert-letter" data-letter="ṁ" autocomplete="off">ṁ</button>
  <button class="btn btn-secondary rounded-pill insert-letter" data-letter="ñ" autocomplete="off">ñ</button>
 <button class="btn btn-secondary rounded-pill insert-letter" data-letter="ṭ" autocomplete="off">ṭ</button>
  <button class="btn btn-secondary rounded-pill insert-letter" data-letter="ī" autocomplete="off">ī</button> </div>
  <button class="btn btn-secondary rounded-pill insert-letter" data-letter="ṇ" autocomplete="off">ṇ</button>
  <button class="btn btn-secondary rounded-pill insert-letter" data-letter="ū" autocomplete="off">ū</button>

  <button class="btn btn-secondary rounded-pill insert-letter" data-letter="ṅ" autocomplete="off">ṅ</button>
  <button class="btn btn-secondary rounded-pill insert-letter" data-letter="ḍ" autocomplete="off">ḍ</button>
  <button class="btn btn-secondary rounded-pill insert-letter" data-letter="ḷ" autocomplete="off">ḷ</button>
 <!-- <button class="btn btn-secondary rounded-pill insert-letter" data-letter="ṃ" autocomplete="off">ṃ</button> -->
</div>

<div class="mt-3">
<button type="button" class="btn btn-sm btn-primary rounded-pill" onclick="savePreferences()"><?php echo $btnsave;?></button>
<button type="button" class="btn btn-sm btn-secondary rounded-pill" onclick="resetPreferences()"><?php echo $btnreset;?></button>

     <div class="modal fade" id="copyPopup" tabindex="-1" role="dialog" aria-labelledby="copyPopupLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body text-muted">
                 Done
            </div>
        </div>
    </div>
</div>
  
  
</div>


 <h5 class="mt-4"><?php echo $regexMemoh5;?></h5> 
<div class="mt-4" style="text-align: left;">
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter=" -exc "><strong>X -exc Y Z</strong></button> - <?php echo $exc;?> <br>
  <button class="btn rounded-pill btn-primary btn-sm rounded-pill insert-letter" data-letter=" -la<?php echo $defaultla;?> "><strong>-la<?php echo $defaultla;?> X</strong></button> - <?php echo $lax;?> <br>
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter=" -lb<?php echo $defaultla;?> "><strong>-lb<?php echo $defaultla;?> X</strong></button> - <?php echo $lbx;?> <br>
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter=' -exc "Y(ti|nti)"'><strong>X -exc Y(ti|nti)</strong></button> - <?php echo $excfew;?> <br>
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter='\b'><strong>\bX</strong></button> - <?php echo $begin;?>
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter='\b'><strong>Y\b</strong></button> <?php echo $end;?><br>
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter='.*'><strong>X.*Y</strong></button> - <?php echo $anynumber;?> <br>
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter='.{0,10}'><strong>X.{0,10}Y</strong></button> - <?php echo $fewsymbols;?> <br>
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter='\S*\s'><strong>X\S*\sY</strong></button> - <?php echo $nextwords;?> <br>
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter='(\S*\s){0,3}'><strong>X(\S*\s){0,3}Y</strong></button> - <?php echo $fewwords;?> <br>
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter='[aā]'><strong>a[ṁ]?</strong></button> - <?php echo $optionalletter;?> <br>
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter='[aā]'><strong>[aā]</strong></button> - <?php echo $variants;?> <br>
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter='tatt($|[^h])'><strong>tatt($|[^h])</strong></button> - <?php echo $variantsexc;?> <br>
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter='(a|b|c)'><strong>(a|b|c)</strong></button> - <?php echo $searchfewwords;?> <br>
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter="mn[0-9].*X"><strong>mn[0-9].*X</strong></button> - <?php echo $inallnikaya;?> <br>
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter="dn22.*"><strong>dn22.*Y</strong></button> - <?php echo $inonesutta;?> <br>
    <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter='sn56.*(seyyathāpi|adhivacan|ūpama|opama)'><strong>sn56.*(seyyathāpi|adhivacan|ūpama|opama)</strong></button> - <?php echo $metaphorssmlletter;?> <br><br>
</div>

  <?php echo $regexlink;?> 
  
<a 
  type="button"
  onclick="toggleQuickModal()" 
  aria-label="Открыть Cattāri Ariyasaccāni" 
  class="common-size-icon4" 
  style="cursor: pointer; height: 25px">
  <i class="fa-solid fa-compass"></i>
</a> 

<script>
if (!document.getElementById("openQuickModalBtn")) {
  const openQuickModalBtn = document.getElementById("openQuickModalBtn");
  openQuickModalBtn.addEventListener("click", toggleQuickModal);
}
</script>

  <?php echo $defaults;?> 
  <?php echo $defaultsJS;?> 
    <script src="/assets/js/setDefaultMode.js"></script>

 </p>
 
 
 
 
 <script>
  $(document).ready(function() {
  // Обработчик для отправки формы
  $('#searchForm').on('submit', function() {
    // Закрываем выпадающий список автозаполнения
    $('#paliauto').autocomplete('close');
    $('#collapseSettings').collapse('hide');
    $('#navbarResponsive').collapse('hide');
  });
  
  // Обработчик для нажатия клавиши Enter
  $(document).on('keydown', function(event) {
    if (event.key === 'Enter') {
      $('#paliauto').autocomplete('close');
      $('#collapseSettings').collapse('hide');
      $('#navbarResponsive').collapse('hide');
    }
  });
  
  // Обработчик для клика по кнопке поиска
  $('#searchbtn').on('click', function() {
    $('#paliauto').autocomplete('close');
    $('#collapseSettings').collapse('hide');
    $('#navbarResponsive').collapse('hide');
  });
});

</script>

<script>
  
// Event listener to submit the form when Enter key is pressed
var input = document.getElementById("paliauto");
input.addEventListener("keypress", function(event) {
  if (event.key === "Enter") {
    event.preventDefault();
    document.getElementById("searchbtn").click();
  }
});  
  
  
  // Function to reset all form elements
function resetForm() {
  document.getElementById("paliauto").value = "";
  document.getElementById("pOptions").selectedIndex = 0;
  document.getElementById("extraOptions").selectedIndex = 0;
  document.getElementById("onlCheckbox").checked = false;
  document.getElementById("laCheckbox").checked = false;
  // Reset other checkboxes and dropdowns as needed
  checkInput(); // Check input after resetting form
}

// Event listener for the clear button
document.getElementById("clearbtn").addEventListener("click", function() {
  resetForm();
});




// Получаем кнопки для вставки букв
var buttons = document.querySelectorAll('.insert-letter');

// Добавляем обработчики событий для каждой кнопки
buttons.forEach(function(button) {
  button.addEventListener('click', function(event) {
    event.preventDefault();
    var letterValue = this.getAttribute('data-letter');
    var currentValue = input.value;
    var selectionStart = input.selectionStart;
    var selectionEnd = input.selectionEnd;
    var newValue = currentValue.substring(0, selectionStart) + letterValue + currentValue.substring(selectionEnd);
    input.value = newValue;

    // Перемещаем курсор после вставленных символов
    var newCursorPosition = selectionStart + letterValue.length;
    input.setSelectionRange(newCursorPosition, newCursorPosition);

    // Имитируем событие ввода, чтобы обновить состояние автозаполнения
    var inputEvent = new Event('input', { bubbles: true });
    input.dispatchEvent(inputEvent);

    // Перемещаем фокус на поле ввода
    input.focus();
  });
});

// Получаем чекбоксы и выпадающие списки
var checkboxes = document.querySelectorAll('input[type="checkbox"]');
var selects = document.querySelectorAll('select');

// Добавляем обработчики событий для чекбоксов
checkboxes.forEach(function(checkbox) {
  checkbox.addEventListener('change', checkInput);
});

// Добавляем обработчики событий для выпадающих списков
selects.forEach(function(select) {
  select.addEventListener('change', checkInput);
});

var clearButton = document.getElementById('clearbtn');

// Проверяем поле при загрузке страницы
checkInput();

// Добавляем обработчик события input
input.addEventListener('input', checkInput);

// Очистка поля и скрытие кнопки при клике на кнопку очистки
clearButton.addEventListener('click', function() {
  input.value = '';
  checkInput();
});

function checkInput() {
  if (
    input.value.trim().length > 0 ||
    Array.from(checkboxes).some(function(checkbox) {
      return checkbox.checked;
    }) ||
    Array.from(selects).some(function(select) {
      return select.value !== "";
    })
  ) {
    clearButton.style.display = 'block'; // Показываем кнопку, если есть текст или выбраны чекбоксы/списки
  } else {
    clearButton.style.display = 'none'; // Скрываем кнопку, если нет текста и не выбраны чекбоксы/списки
  }
}

// Поместить курсор в конец строки в поле ввода
input.focus();
input.setSelectionRange(input.value.length, input.value.length);
</script>


</div>    
</div>
</div>

<!--
-->

<script src="/assets/js/themeswitch.js"></script>

<script src="/assets/js/uihelp.js"></script>

  </div>
  
            <div id="spinner" class="justify-content-center">
              <div class="spinner-border mt-3" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              </div>
			  

	  <script src="/assets/js/smoothScroll.js" defer></script>
	
<script defer>
window.addEventListener('pageshow', function(event) {
  if (event.persisted) {
    // Событие pageshow возникает при возврате назад с помощью кнопки "назад" браузера
    // Скрываем спиннер
    document.getElementById('spinner').style.display = 'none';
  }
});

    document.getElementById('spinner').style.display = 'none';
</script>

  <!-- extra options end -->
</form>

<div class="hideOnMobile">
  <p><br>
  <br>
  </p>
  </div>
</header>

<!-- Portfolio Section-->
<section class="page-section portfolio">
<div class="container text-center">
<?php
if ( $lang == "ru" ) {
include 'assets/common/horizontalMenuRu.php'; 
}
else {
include 'assets/common/horizontalMenuEn.php'; 
} 
?>

<!--Slideshow section-->
<div style="max-width: 450px;" class="container-lg my-5">
 <!-- <h4><?php echo $carouseltitle;?>:</h4><br> -->
 
<div id="carouselWithCaptions" class="carousel slide " data-bs-ride="carousel">
<!-- <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselWithCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselWithCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselWithCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div> -->
  <div class="carousel-inner">


<?php
shuffle($slides);
foreach ($slides as $index => $slide) {
    $title = $slide['title'];
    $desc = $slide['desc'];
    $link = $slide['link'];
    $isActive = ($index === 0) ? 'active' : '';
?>

<div class="carousel-item <?php echo $isActive; ?>">
    <h5><?php echo $title; ?></h5>
    <span><?php echo $desc; ?></span>
	<br>
    <a href="<?php echo $link; ?>" style="text-align: left;"><?php echo $read; ?></a>
</div>

<?php
}
?>

  </div>
 <button class="carousel-control-prev" type="button" data-bs-target="#carouselWithCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselWithCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
</div>



<!-- Dukkha section Item 3-->
<div class="portfolio-item mx-auto mt-4" data-bs-toggle="modal" data-bs-target="#portfolioModal3">
<div class="font-italic"> 
<p class="font-italic text-center ">
<?php echo $fntmessage;?>
</p>
</div> 
<div class="col-md-6 col-lg-4 mb-3">
						                     
			
<div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
<div class="portfolio-item-caption-content text-center text-white">
<i class="fas fa-search fa-flip-horizontal fa-3x"></i></div>
</div>
</div>
</div>

<h4 class="page-section-heading text-center mb-4"><?php echo $howtovideo;?></h4>	

<div class="embed-container mt-4 mb-5 text-center">
<a href="<?php echo $linkhowtovideo;?>" target="_blank" ><img width="350" class="imgonmain" src="<?php echo $demovideoimg2;?>" title="<?php echo $titledeschowtovideo;?>" loading="lazy"></a>
</div>
<!--<div class="embed-container mt-4 mb-5"> 
<iframe src="<?php echo $linkhowtovideo;?>" title="<?php echo $titledeschowtovideo;?>" frameborder="0" allowfullscreen></iframe>
</div>-->

<div style="max-width: 600px;" class="container-lg">
<div class="alert alert-warning float-start text-left mb-3" role="alert">
<?php echo $transwarning;?>
</div>
</div>
   
<div style="max-width: 992px;" class="container-lg">
<h2 class="page-section-heading text-center text-uppercase text-secondary mb-3"><?php echo $headerexamples; ?></h2>  
<div class="container mb-5">
<ol class="col-lg-8 col-md-10 ms-auto text-start">
<?php echo $examplelist; ?>
              </ol>
			  </div>  

  </div>
  
<!-- Portfolio Section Heading-->
<h2 id="help" class="page-section-heading text-center text-uppercase text-secondary mb-0"><?php echo $howtoheader; ?></h2>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                        <div class="lock example divider-custom-icon">
                                        <i class="fa-solid fa-circle example icon-unlock" ></i>
 <i class="fa-solid fa-circle icon-lock bigger"></i>
                      </div>
                    <div class="divider-custom-line"></div>
                </div>
                <!-- Portfolio Grid Items-->
<div class="row justify-content-center">

<div style="max-width: 600px;" class="container-lg">
<div data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo $howtosearchquotetooltip;?>"></div>
<?php echo $howtosearchquote;?>

</div>

<div class="clearfix"></div> 
	 

<div class="col-md-6 col-lg-4 mb-0">
<div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal6">
<div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
<div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
</div>
<div class="imgcontainer">

<div class="centered">
<h4 class="page-section-heading text-center text-white"><?php echo $demovideo;?> </h4>
  </div>

<img class="img-fluid" src="assets/img/portfolio/awakening.webp" alt="Search in Pali Suttas and Vinaya" loading="lazy" />
</div>					
</div>
<!-- text here --> <p class="mb-4">
</p>
</div>

<div class="col-md-6 col-lg-4 mb-0">
<div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal5">
<div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
<div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
</div>

<div class="imgcontainer">

  <div class="centered">
  <h4 class="page-section-heading text-center text-white"><?php echo $basics;?></h4>
  </div>
             
<img class="img-fluid" src="assets/img/portfolio/dhammawheelgreen.webp" alt="Search in Pali Suttas and Vinaya" loading="lazy" />
		</div>					             
               
              
                        </div>
			
						<!-- text here --> <p class="mb-4">
		</p>

				
                    </div>

                    <div class="col-md-6 col-lg-4 mb-0">
                        <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal4">
                            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
             
                 <div class="imgcontainer">

  <div class="centered">
  <h4 class="page-section-heading text-center text-white"><?php echo $advanced;?></h4>
  </div>

<img class="img-fluid" src="assets/img/portfolio/sangha.webp" alt="Search in Pali Suttas and Vinaya" loading="lazy"/>
		</div>		
         </div>
<!-- text here --> <p class="mb-4"></p>
</div>

</div>
</div>
        </section>
        <!-- About Section-->
        <section class="page-section bg-primary text-white mb-0" id="about">
            <div class="container">
                <!-- About Section Heading-->
                <h2 class="page-section-heading text-center text-uppercase text-white"><?php echo $aboutheader; ?></h2>
                <!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                        <div class="lock example divider-custom-icon">
                                        <i class="fa-solid fa-circle example icon-unlock" ></i>
 <i class="fa-solid fa-circle icon-lock bigger"></i>
                      </div>
                    <div class="divider-custom-line"></div>
                </div>
                <!-- About Section Content-->
                <div class="row">
<?php echo $aboutprp; ?>
                </div>
                <!-- About Section Button-->
         <!--       <div class="text-center mt-4">
                    <a class="btn btn-xl btn-outline-light" target="_blank" href="https://github.com/o28o/fdg">
                
                   <i class="fa-brands fa-github"></i><?php echo $prongh; ?>
                    </a>
                </div> -->
                                <div class="text-center mt-4">
                    <a class="btn btn-xl btn-outline-light" target="" href="/assets/common/<?php echo $prekeyfeatures; ?>">
    
                   <i class="fa-solid fa-star"></i><?php echo $premail; ?>
                    </a>
                </div>
            </div>
        </section>
  
        <!-- Footer-->
        <footer id="links" class="footer text-center ">
               <h2 class="page-section-heading text-center text-uppercase text-white mb-5"><?php echo $head2recomlinks;?></h2>
			   
            <div class="container">
			
			<?php echo $ctaButtons;?>
              

                <div  class="row">
                   <!-- Footer Location-->
                    <div class="col-lg-4 mb-5 mb-lg-0">
          

                        <h4 id="research" class="text-uppercase mb-4"><?php echo $anameresearch;?> </h4>
               
                <div class="list-group">
      <?php
      if ( $mode == "offline" ) {
        
      echo '  <a href="https://Dhamma.gift/" style="z-index:1" class="list-group-item list-group-item-action active">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Dhamma.gift</h5>
      <small class="text-muted">' . $detailonline . '</small>
    </div>
    <p class="mb-1">' . $pfdg . '</p>
    <small class="text-muted"></small>
  </a>';
      } else {

      echo '
  <a href="https://github.com/o28o/fdg" target=_blank style="z-index:1" class="list-group-item list-group-item-action active">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">' . $header5fdgoffline . '</h5>
      <small class="text-muted">' . $detailoffline . '</small>
    </div>
  <p class="mb-1">' . $pfdgoffline . '</p>
    <small class="text-muted"></small>
  </a>';

      }
      ?>
  
    <a href="/cse.php" target="_blank" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1"><?php echo $head5cse;?></h5>
      <small class="text-muted"><?php echo $detailonline;?> </small>
    </div>
    <p class="mb-1">
      <?php echo $psce;?>
    </p>
    <small class="text-muted"><?php echo $smcse;?></small>
  </a>
  
        <a target="_blank" href="https://dict.dhamma.gift/" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Digital Pali Dictionary</h5>
      <small class="text-muted"><?php echo $detailapp;?></small>
    </div>
    <p class="mb-1"><?php echo $pdpd;?></p>
    <small class="text-muted"><?php echo $smdpd;?></small>
  </a>

  <a href="#<?php echo $mainpageextrasearchlink; ?>" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1"><?php echo $mainpageextrasearchtitle; ?></h5>
      <small class="text-muted"><?php echo $detailonandoffline; ?></small>
    </div>
    <p class="mb-1"><?php echo $mainpageextrasearchdesc;?></p>
    <small class="text-muted"></small>
  </a>
<!-- <a target="_blank" href="https://play.google.com/store/apps/details?id=klye.plugin.pi1" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1"><?php echo $head5plikeyboard;?></h5>
      <small class="text-muted"><?php echo $detailapp;?></small>
    </div>
    <p class="mb-1"><?php echo $pplikeyboard;?></p>
    <small class="text-muted"><?php echo $smplikeyboard;?></small>
  </a> 

    <a target="_blank" href="https://dsal.uchicago.edu/dictionaries/pali/" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1"><?php echo $head5pts;?></h5>
      <small class="text-muted"><?php echo $detailonline;?></small>
    </div>
    <p class="mb-1"><?php echo $ppts;?></p>
    <small class="text-muted"></small>
  </a>


    <a target="_blank" href="https://www.wisdomlib.org/" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Wisdomlib.org</h5>
      <small class="text-muted"><?php echo $detailonline;?></small>
    </div>
    <p class="mb-1"><?php echo $pwids;?></p>
    <small class="text-muted"><?php echo $smwisd;?></small>
  </a>
  
      <a target="_blank" href="http://dictionary.tamilcube.com/pali-dictionary.aspx" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">TamilCube.com</h5>
      <small class="text-muted"><?php echo $detailonline;?></small>
    </div>
    <p class="mb-1"><?php echo $ptamilcube;?></p>
    <small class="text-muted"></small>
  </a> 

    <a target="_blank"  href="
  https://drive.google.com/drive/folders/1bdkm-g_ReZi5QEior_gNTok8r4flAfa3?usp=sharing" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1"><?php echo $head5words;?></h5>
      <small class="text-muted"><?php echo $detailoffline;?></small>
    </div>
    <p class="mb-1"><?php echo $pwords;?></p>
    <small class="text-muted"></small>
  </a>
  --> 


</div>  
  <p class="lead mb-0"> </p>
    </div>
                    <!-- Footer Social Icons-->
<div class="col-lg-4 mb-5 mb-lg-0">
  <h4 id="read" class="text-uppercase mb-4"><?php echo $anameread;?> </h4>
                       

 <div class="list-group">
  <a target="" href="<?php echo $mainreadlink; ?>" class="list-group-item list-group-item-action active" aria-current="true">
    <div class="d-flex w-100 justify-content-between text-left">
      <h5 class="mb-1">Dhamma.gift Read</h5>
      <small><?php echo $detailonandoffline;?></small>
    </div>
    <p class="mb-1 text-left"><?php echo $psclight; ?></p>
    <small><?php echo $smsclight; ?></small>
  </a>


  
    <a target="_blank" href="https://thebuddhaswords.net/home/index.html" class="list-group-item list-group-item-action" aria-current="true">
    <div class="d-flex w-100 justify-content-between text-left">
      <h5 class="mb-1">TheBuddhasWords.net</h5>
      <small><?php echo $detailonline;?></small>
    </div>
    <p class="mb-1 text-left"><?php echo $ptbw; ?></p>
    <small><?php echo $smtbw; ?></small>
  </a>
  
  
    <a target="_blank"   href="https://www.digitalpalireader.online/" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Digital Pali Reader</h5>
      <small class="text-muted"><?php echo $detailonandoffline;?></small>
    </div>
    <p class="mb-1"><?php echo $pdpr; ?></p>
    <small class="text-muted"><?php echo $smdpr; ?></small>
  </a>
  
  

  <a href="#<?php echo $mainpageextrasourceslink; ?>" class="list-group-item list-group-item-action" >
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1"><?php echo $mainpageextrasourcestitle; ?></h5>
      <small class="text-muted"><?php echo $detailonandoffline; ?></small>
    </div>
    <p class="mb-1"><?php echo $mainpageextrasourcesdesc;?></p>
    <small class="text-muted"></small>
  </a>
  
 <!--  <a href="https://play.google.com/store/apps/details?id=hesoft.T2S" target="_blank"   class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">T2S Android</h5>
      <small class="text-muted"><?php echo $detailapp;?></small>
    </div>
    <p class="mb-1"><?php echo $pt2s;?></p>
    <small class="text-muted"><?php echo $smt2s;?></small>
  </a>
  
   <a href="https://voice.suttacentral.net" target="_blank"   class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Voice.suttacentral.net</h5>
      <small class="text-muted"><?php echo $detailonline;?></small>
    </div>
    <p class="mb-1"><?php echo $pscvoice;?></p>
    <small class="text-muted"><?php echo $smscvoice;?></small>
  </a> -->
  
</div>  

				
</div>
				
<div class="col-lg-4 mb-5 mb-lg-0">
<h4 id="study" class="text-uppercase mb-4"><?php echo $anamestudy;?></h4>
	
<div class="list-group">


  <a target="_blank" href="<?php echo $linktextbook;?>" class="list-group-item list-group-item-action active" aria-current="true">
    <div class="d-flex w-100 justify-content-between text-left ">
      <h5 class="mb-1"><?php echo $anametextbook;?></h5>
      <small><?php echo $detailtextbook;?></small>
    </div>
    <p class="mb-1 text-left"><?php echo $ptextbook;?></p>
    <small></small>
  </a>

    <a target="_blank"   href="<?php echo $linkcases;?>" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1"><?php echo $anamecases;?></h5>
      <small class="text-muted"><?php echo $detailtable;?></small>
    </div>
    <p class="mb-1"><?php echo $pcases;?></p>
    <small class="text-muted"><?php echo $smcheckpali;?></small>
  </a>

 
  <a target="_blank" href="<?php echo $linkconj; ?>" class="list-group-item list-group-item-action" aria-current="true">
    <div class="d-flex w-100 justify-content-between text-left">
      <h5 class="mb-1"><?php echo $anameconj; ?> </h5>
      <small><?php echo $detailtable;?></small>
    </div>
    <p class="mb-1 text-left"><?php echo $pconj;?></p>
    <small><?php echo $smcheckpali;?></small>
  </a>
  

  <a target="_blank"  href="<?php echo $linksothermat; ?>" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between text-left">
      <h5 class="mb-1"><?php echo $head5othermat;?></h5>
      <small class="text-muted"><?php echo $detailoffline;?></small>
    </div>
    <p class="mb-1"><?php echo $pothermat;?></p>
    <small class="text-muted"></small>
  </a>
 
 
  <a href="#<?php echo $mainpageextrastudylink; ?>"  class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1"><?php echo $mainpageextrastudytitle; ?></h5>
      <small class="text-muted"><?php echo $detailonandoffline; ?></small>
    </div>
    <p class="mb-1"><?php echo $mainpageextrastudydesc;?></p>
    <small class="text-muted"></small>
  </a>
 <!-- <a target="_blank"  href="/assets/diff/" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1"><?php echo $head5suttadiff;?></h5>
      <small class="text-muted"><?php echo $detailonline;?></small>
    </div>
    <p class="mb-1"><?php echo $psuttadiff;?></p>
    <small class="text-muted"></small>
  </a>

  <a target="_blank"  href="/assets/listdiff.html" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1"><?php echo $head5listdiff;?></h5>
      <small class="text-muted"><?php echo $detailoffline;?></small>
    </div>
    <p class="mb-1"><?php echo $plistdiff;?></p>
    <small class="text-muted"></small>
  </a>

  <a target="_blank"  href="/assets/makelist.html" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1"><?php echo $head5makelist;?></h5>
      <small class="text-muted"><?php echo $detailoffline;?></small>
    </div>
    <p class="mb-1"><?php echo $pmakelist;?></p>
    <small class="text-muted"></small>
  </a> -->
</div>  

</div>
<!-- Footer About Text-->
<div id="contacts" class="col-lg-0 text-center">
<h4 class="text-uppercase mt-5 mb-4">
<?php echo "$contactheader"; ?></h4>
						
<p class="lead mb-4">
<?php echo $contaccalltoaction; ?>
</p>
<a  target="_blank"  class="btn btn-outline-light btn-social mx-1" href="https://github.com/o28o/fdg#readme"><i class="fa-brands fa-github"></i></a>
<a  target="_blank"  class="btn btn-outline-light btn-social mx-1" href="mailto:agiftofdhamma@gmail.com"><i class="fa-solid fa-at"></i></a>
<a href="https://m.youtube.com/channel/UCoyL5T0wMubqrj4OnKVOlMw" class="btn btn-outline-light btn-social mx-1" title="YouTube" target="_blank" rel="nofollow"><i class="fa-brands fa-youtube"></i></a>
<a href="https://t.me/dhamma_gift" class="btn btn-outline-light btn-social mx-1" title="Telegram" target="_blank" rel="nofollow"><i class="fa-brands fa-telegram"></i></a>

<p class="lead mt-4">
<?php echo $poweredby; ?>
 <a class="text-white text-decoration-none me-0" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $tooltippoweredby;?>"> *</a></p>

                    </div>
                </div>
            </div>
        </footer>
		
        <!-- Copyright Section-->
<div id="copyright" class="copyright py-4 text-center text-white " >
<div class="container"> <a target="_blank" rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Creative Commons License" style="border-width:0" src="/assets/img/88x31.png" loading="lazy" /></a> <small>Copyright <a class="text-white text-decoration-none" href="/assets/readylinebyline.html">&copy;</a> Dhamma.gift <?php echo $mode; ?> <a class="text-white text-decoration-none" href="/assets/countdowntable.php">2022</a>-<?php echo date("Y"); ?></small>  <small id="copyrightnote">
 
<p class="text-muted text-center mx-auto" style="max-width: 650px;">
   <?php echo $copyrightnote; ?> 
</p>

</small> <button class="btn btn-secondary text-center installButton" id="" style="display:none;"><?php echo $installpwa;?></button></div>
        </div>
        <!-- Portfolio Modals-->
<script>
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js')
      .then(function(registration) {
    //    console.log('ServiceWorker registration successful with scope: ', registration.scope);
      })
      .catch(function(err) {
        console.log('ServiceWorker registration failed: ', err);
      });
  }

//  let deferredPrompt;
  const installButtons = document.querySelectorAll('.installButton');

  window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;

    // Показываем все кнопки с классом installButton
    installButtons.forEach(button => {
      button.style.display = 'inline-block';
    });
  });

  // Добавляем обработчик события click для каждой кнопки
  installButtons.forEach(button => {
    button.addEventListener('click', () => {
      if (deferredPrompt) {
        deferredPrompt.prompt();
        deferredPrompt.userChoice.then((choiceResult) => {
          if (choiceResult.outcome === 'accepted') {
            console.log('Пользователь принял предложение установки');
          } else {
            console.log('Пользователь отклонил предложение установки');
          }
          deferredPrompt = null;
        });
      }
    });
  });
</script>

<!-- Portfolio Modal 3-->
<div class="portfolio-modal modal fade" id="portfolioModal3" tabindex="-1" aria-labelledby="portfolioModal3" aria-hidden="true">
<div class="modal-dialog modal-xl">
<div class="modal-content">
<div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
<div class="modal-body text-center pb-5">
<div class="container">
<div class="row justify-content-center">
<div class="col-lg-8">

<!-- Portfolio Modal - Title-->
<h4 class="text-secondary mb-0">
<?php echo $mainscrollmodalheader ; ?>
</h4>
<!-- Icon Divider-->
<div class="divider-custom">
<div class="divider-custom-line"></div>
<div class="divider-custom-icon"><i class="fa-solid fa-circle"></i></div>
<div class="divider-custom-line"></div>
</div>
<!-- Portfolio Modal - Image-->

<!-- Portfolio Modal - Text-->
<?php echo $mainscrollmodal; ?>
									
<button class="btn btn-primary" data-bs-dismiss="modal">
<i class="fas fa-xmark fa-fw"></i>
<?php echo "$closemodal"; ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Portfolio Modal 4-->
        <div class="portfolio-modal modal fade" id="portfolioModal4" tabindex="-1" aria-labelledby="portfolioModal4" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
                    <div class="modal-body text-center pb-5">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <!-- Portfolio Modal - Title-->
<h2 class="portfolio-modal-title text-secondary text-uppercase mb-0"><?php echo $advanced; ?></h2>
<!-- Icon Divider-->
<div class="divider-custom">
<div class="divider-custom-line"></div>
<div class="divider-custom-icon"><i class="fa-solid fa-circle"></i></div>
<div class="divider-custom-line"></div>
</div>
<!-- Portfolio Modal - Image
<img class="img-fluid rounded mb-5" src="assets/img/portfolio/sangha.jpg" alt="..." /> -->
<!-- Portfolio Modal - Text-->
            <p class="mb-4">
<?php echo $advancedcontent; ?>
</p>
                                    <button class="btn btn-primary" data-bs-dismiss="modal">
                                        <i class="fas fa-xmark fa-fw"></i>
                                        <?php echo "$closemodal"; ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Portfolio Modal 5-->
        <div class="portfolio-modal modal fade" id="portfolioModal5" tabindex="-1" aria-labelledby="portfolioModal5" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
                    <div class="modal-body text-center pb-5">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
<!-- Portfolio Modal - Title-->
<h2 class="portfolio-modal-title text-secondary text-uppercase mb-0"><?php echo $basics; ?></h2>
<!-- Icon Divider-->
<div class="divider-custom">
<div class="divider-custom-line"></div>
<div class="divider-custom-icon"><i class="fa-solid fa-circle"></i></div>
<div class="divider-custom-line"></div>
</div>
<!-- Portfolio Modal - Image
<img class="img-fluid rounded mb-5" src="assets/img/portfolio/dhammawheel.jpg" alt="..." /> -->
<!-- Portfolio Modal - Text-->
<?php echo $basicscontent;?>
<button class="btn btn-primary" data-bs-dismiss="modal">
<i class="fas fa-xmark fa-fw"></i> 
<?php echo "$closemodal"; ?>
</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Portfolio Modal 6-->
        <div class="portfolio-modal modal fade" id="portfolioModal6" tabindex="-1" aria-labelledby="portfolioModal6" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
<div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
<div class="modal-body text-center pb-5">
<div class="container">
<div class="row justify-content-center">
<div class="col-lg-8">
<!-- Portfolio Modal - Title-->
<h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">
<?php echo $demovideo; ?></h2>
<!-- Icon Divider-->
<div class="divider-custom">
<div class="divider-custom-line"></div>
<div class="divider-custom-icon"><i class="fa-solid fa-circle"></i></div>
<div class="divider-custom-line"></div>
</div>

<!-- Portfolio Modal - Image
<img class="img-fluid rounded mb-5" src="assets/img/portfolio/submarine.png" alt="..." /> -->
<!-- Portfolio Modal - Text-->
<div class="embed-container mb-3">
<a href="<?php echo $demovideolink;?>" target="_blank" ><img  class="imgonmain" src="<?php echo $demovideoimg;?>" title="How to search in Pali Suttas and Vinaya with Dhamma.gift" loading="lazy" ></a></div>

<!-- <div class="embed-container"> <iframe src="<?php echo $demovideolink;?> " title="How to search in Pali Suttas and Vinaya with Dhamma.gift" frameborder="0" allowfullscreen></iframe>
</div>-->

<button class="btn btn-primary" data-bs-dismiss="modal">
                                        <i class="fas fa-xmark fa-fw"></i>
                                        <?php echo "$closemodal"; ?>
                                    </button>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Core theme JS
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
                <!-- Bootstrap core JS-->

<script src="/assets/js/bootstrap.bundle.5.3.1.min.js"></script>

<script defer>
$(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
    
 // Инициализация всех тултипов с поддержкой HTML
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl, {
    html: true // ← ключевая опция
  })
})   
    
    
</script>

<!-- Font Awesome icons (free version) crossorigin="anonymous"  data-mutate-approach="sync"-->

<script src="/assets/js/autopali.js" defer></script>
	  
<script src="/assets/js/randPlaceholder.js">
</script>
<script defer>
  randCallToAction();
  randPlaceholderOnMain();
 // console.log(window.location.href);

</script>

<!-- 

<script src="/assets/js/paliLookup.js"></script>
-->
<script defer>
  window.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {

const isRuPath = /^\/(ru|r)\//.test(location.pathname);

const commonResources = [
    '/assets/js/standalone-dpd/dpd_i2h.js',
    '/assets/js/standalone-dpd/dpd_deconstructor.js'
];

const langSpecific = isRuPath
    ? '/assets/js/standalone-dpd/ru/dpd_ebts.js'
    : '/assets/js/standalone-dpd/dpd_ebts.js';

const resources = [...commonResources, langSpecific];

        resources.forEach(url => {
            // Вариант 1: Prefetch через Link header
            const link = document.createElement('link');
            link.rel = 'prefetch';
            link.href = url;
            link.as = 'script';
            document.head.appendChild(link);

            // Вариант 2: Фоновый fetch (для старых браузеров)
            fetch(url, {
                method: 'GET',
                credentials: 'same-origin',
                cache: 'force-cache'
            });
        });
    //    console.log('fetching dict');
    }, 5000);
});
</script>

<script src="/assets/js/settings.js"></script>

</body>

<?php

?>  

</html>
