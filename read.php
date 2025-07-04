<?php
header("Cache-Control: public, max-age=3600"); // Кэшировать на 1 час
header("Expires: " . gmdate("D, d M Y H:i:s", time() + 3600) . " GMT");
?>
<!DOCTYPE html>
<?php
error_reporting(E_ERROR | E_PARSE);
include_once('config/config.php');
include_once('config/translate.php');
include 'scripts/search-handler.php';
//echo $readerPage;

// Получить значение из GET параметра
if (isset($_GET['ml']) && $_GET['ml'] === 'on') {
    // Чекбокс активен
    $readerlang = "/ml/";
    $readerPage = "/ml/";
} 
?>
<html lang="<?php echo $htmllang;?>" data-bs-theme="dark">
    <head>
      <meta charset="UTF-8">

<title><?php echo $maintitle;?></title>
 <meta http-equiv="Cache-control" content="public">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="keywords" content="<?php echo $metakeywords;?>">
<meta name="description" content="<?php echo $metadesc;?>" />
<meta name="author" content="" />
<link rel="canonical" href="<?php echo $canonicalPage;?>read.php">
<link rel="alternate" href="https://dhamma.gift/ru/read.php" hreflang="ru">
<link rel="alternate" href="https://dhamma.gift/read.php" hreflang="en">
<link rel="alternate" href="https://dhamma.gift/read.php" hreflang="x-default">


<meta property="og:locale" content="<?php echo $oglocale;?>" />
<meta property="og:type" content="website" />
<meta property="og:title" content="Dhamma.gift Read" />
<meta property="og:description" content="<?php echo $ogdesc;?>" />
<link rel="manifest" href="<?php echo $mainpagenoslash ;?>/manifest.php">

<meta property="og:url" content="https://Dhamma.gift/read.php" />
<meta property="og:site_name" content="Dhamma.gift Read" />
<meta property="og:image" itemprop="image" content="<?php echo $ogshare;?>" />

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo $titletwit;?>">
<meta name="twitter:description" content="<?php echo $ogdesc;?>">

<style>
    body {
        opacity: 0;
        visibility: hidden;
        background: black;
     /*   transition: opacity 0.3s ease-in-out; Плавное появление */
    }
</style>

<script>
// Получаем текущие параметры URL
const urlParams = new URLSearchParams(window.location.search);
const isPWA = urlParams.get('source') === 'pwa';

// Если это PWA и нужно принудительно задать язык
if (isPWA) {
    // Удаляем параметр source=pwa (чтобы он не дублировался после редиректа)
    urlParams.delete('source');

    // Сохраняем оставшиеся параметры в строку (если они есть)
    const remainingQuery = urlParams.toString();
    const queryString = remainingQuery ? `?${remainingQuery}` : '';

    // Проверяем язык в localStorage или определяем его
    let siteLanguage = localStorage.getItem('siteLanguage');

    if (!siteLanguage) {
        const currentPath = window.location.pathname;
        
        if (currentPath.includes('/ru/')) {
            siteLanguage = 'ru';
        } else if (currentPath.includes('/th/')) {
            siteLanguage = 'th';
        } else {
            const browserLang = navigator.language || navigator.userLanguage;
            siteLanguage = browserLang.startsWith('ru') ? 'ru' : 
                          browserLang.startsWith('th') ? 'th' : 'en';
        }
        localStorage.setItem('siteLanguage', siteLanguage);
    }

    // Получаем текущий путь и хэш
    const currentPath = window.location.pathname;
    const currentHash = window.location.hash;

    // Делаем редирект с сохранением всех параметров (кроме source=pwa) и хэша
    if (siteLanguage === 'ru' && !currentPath.includes('/ru/')) {
        window.location.href = `/ru/${queryString}${currentHash}`;
    } else if (siteLanguage === 'th' && !currentPath.includes('/th/')) {
        window.location.href = `/th/${queryString}${currentHash}`;
    } else if (siteLanguage === 'en' && currentPath !== '/') {
        window.location.href = `/${queryString}${currentHash}`;
    }
}
</script>
<!-- Favicon favico-noglass
<link href="/assets/img/gray.png" rel="icon" media="(prefers-color-scheme: light)">
<link href="/assets/img/gray-white.png" rel="icon" media="(prefers-color-scheme: dark)">-->

<link rel="icon" type="image/png" sizes="56x56" href="/assets/img/favicon-56x56.png">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon-16x16.png">
<link rel="icon" href="/assets/img/favicon.ico">

  <!-- Загрузка иконки для iOS  -->
  <link rel="apple-touch-icon" sizes="152x152" href="/assets/img/favico-noglass.png">

<!-- Google fonts
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
-->

<!--  Core theme CSS (includes Bootstrap)-->
<link href="/assets/css/jquery-ui.min.css" rel="stylesheet"/>
 
<link href="/assets/css/styles.css" rel="stylesheet" />

<script src="/assets/js/loadCssJsMain.js"></script>

<link href="/assets/css/extrastyles.css" rel="stylesheet" />


<script src="/assets/js/jquery-3.7.0.min.js"></script>
<script src="/assets/js/jquery-ui.min.js"></script>
<link href="/assets/css/paliLookup.css" rel="stylesheet" />
<style>
</style>

<?php echo $fontawesomejs;?> 

</head>
<!-- <script>window.location.href="https://f.dhamma.gift";</script> -->
    <body id="page-top"> 
<!--    <script>
  
  const url = new URL(window.location);
const params = new URLSearchParams(url.search);

// Удаляем параметры, которые пустые или содержат только пробелы
for (let key of [...params.keys()]) {
    if (!params.get(key).trim()) { // Проверяем, если пусто или пробелы
        params.delete(key);
    }
}

// Обновляем URL без перезагрузки, если есть изменения
const newUrl = url.pathname + (params.toString() ? "?" + params.toString() : "");
if (newUrl !== window.location.href) {
    history.replaceState(null, "", newUrl);
}

  function updateURL(params) {
    console.log("Before update:", location.href);
    // код, изменяющий URL
    history.replaceState(null, "", `?q=${params.q}&s=${params.s}`);
    console.log("After update:", location.href);
}
</script> -->

        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg bg-secondary text-uppercase" id="mainNav">
            <a class="navbar-brand mobile-center" href="<?php echo $mainpage;?>"> <div class="container"><img loading="lazy" alt="Precise search in Pali Suttas and Vinaya" src="./assets/img/dhammafindlogo.webp"  style="width:100px;"></a>
                <a class="navbar-brand mobile-none" href="<?php echo $mainpage; ?>">Dhamma.gift Read</a>
                <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                   <?php echo $menu;?>
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse showkeep navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
      <!-- <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="/">Main</a></li> -->
            
<li class="nav-item mb-3 mx-lg-2"><a class="nav-link py-3 px-0 px-lg-0 rounded" href="<?php echo $mainpage;?>"><?php echo $menumain;?></a></li>
<li class="nav-item mb-3 mx-lg-2"><a class="nav-link py-3 px-0 px-lg-0 rounded" href="<?php echo $mainpagenoslash;?>/history.php"><?php echo $menuhist;?></a></li>
<li class="nav-item mb-3 mx-lg-2"><a class="nav-link py-3 px-0 px-lg-0 rounded" href="/#help"><?php echo $menuhowto;?></a></li>
<li class="nav-item mb-3 mx-lg-2"><a class="nav-link py-3 px-0 px-lg-0 rounded" href="#about"><?php echo $menuabout;?></a></li>             
<li class="nav-item mb-3 mx-lg-2"><a class="nav-link py-3 px-0 px-lg-0 rounded" href="read.php#<?php echo $menuuseful;?>"><?php echo $menulinks;?></a></li>
<li class="nav-item mb-3 mx-lg-2"><a class="nav-link py-3 px-0 px-lg-0 rounded" href="#contacts"><?php echo $menucontact;?></a></li>
<li class="nav-item mb-0 mx-lg-2"><p><a class="py-1 text-decoration-none px-0 px-lg-1 rounded link-light" href="/read.php">En</a> 
<a class="link-light text-decoration-none py-1 px-0 px-lg-1 rounded" href="/ru/read.php">Ru</a>
</p></li>
<li>
<div class="align-items-center form-check-inline mx-0">
     <a id="theme-button" class="mb-1 text-white">
      <i onclick="switchIcon(this)" class="fa-solid fa-circle-half-stroke"></i>
</a>	   
</div>


</li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="bg-primary text-white text-center">
            <div class="container d-flex align-items-center flex-column pt-3 pb-3">

                        
<form method="GET" action="" class="justify-content-center">
<div class="mb-0 form-group input-group ui-widget dropup rounded-pill">
<label class="sr-only dropup rounded-pill" for="paliauto"></label>

<?php
if (isset($_GET['q'])) {
    $q = htmlspecialchars($_GET['q']);
} else {
    $q = '';
}
?>

<div class="searchinputdiv">
<input name="q" type="text"
       class="form-control rounded-pill searchinput searchinput-read"
       id="paliauto"
       placeholder="e.g. Kāyagat or sn56.11"
       value="<?php echo $q; ?>"
       style="max-width: 230px;">
  <button type="button" id="clearbtn" class="btn btn-sm ms-1 me-1 rounded-pill">
    <i class="fas fa-times" aria-hidden="true"></i>
    <span class="visually-hidden"><?php echo $clearaption;?></span>
  </button>
</div>


<div class="input-group-append">
<button onclick="document.getElementById( 'spinner' ).style.display = 'block'" type="submit" id="searchbtn" class="btn btn-primary mainbutton ms-1 me-1 rounded-pill ">
<i class="fas fa-search fa-flip-horizontal" aria-hidden="true"></i>
    <span class="visually-hidden"><?php echo $searchcaption;?></span>
</button>
<div id="gear" class="text-white input-group-append form-check-inline" data-bs-toggle="collapse" href="#collapseSettings" role="button" aria-expanded="false" aria-controls="collapseSettings">
  <i class="fa-solid fa-gear fa-lg" aria-hidden="true"></i>
  <span class="visually-hidden"><?php echo $searchcaption;?></span>
  </div> 

 <div class="text-start text-muted form-check-inline" data-bs-toggle="tooltip" style="cursor: pointer;" data-bs-placement="bottom" data-bs-html="true" title="<?php echo $tooltipsearchbar;?>">*</div>
</div>


</div>

<script>
$(document).ready(function() {
  // Обработчик для нажатия клавиши Enter
  $(document).on('keydown', function(event) {
    if (event.key === 'Enter') {
      if (!$('#navbarResponsive').hasClass('showkeep')) {
        $('#navbarResponsive').collapse('hide');
      }
    }
  });

  // Обработчик для отправки формы
  $('#searchbtn').on('click', function() {
    if (!$('#navbarResponsive').hasClass('showkeep')) {
      $('#navbarResponsive').collapse('hide');
    }
  });
});
</script>

      	<div style="max-width: 450px; display: none;" class='alert alert-warning alert-dismissible fade show container-lg mt-3 mb-1 text-start' role='alert' id='successAlert'>
  <div id="response"></div>
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>		  
  

<div class="collapse" id="collapseSettings">
  <div class="float-start">

	<div class="align-items-center form-check-inline mt-2 mx-0">
    <select class="dropdown droponmain rounded-pill text-muted border-2 border-primary text-center input-group-append" id="pOptions" name="p">
     <option value="-kn" <?php if (isset($extra) && $p == "-kn") echo "selected";?> ><?php echo "$radiokn";?></option>
        <option value="" <?php if (isset($extra) && $p == "Pāḷi") echo "selected";?> ><?php echo $radiopli;?></option>
        <option value="-vin" <?php if (isset($extra) && $p == "-vin") echo "selected";?> ><?php echo "$radiovin";?></option>
        <option value="-all" <?php if (isset($extra) && $p == "-all") echo "selected";?> ><?php echo "$radioltr";?></option>
       <option value="-all -vin" <?php if (isset($extra) && $p == "-all -vin") echo "selected";?> ><?php echo "$radiovinall";?></option>
        <option value="-b" <?php if (isset($p) && $p == "-b") echo "selected";?> ><?php echo $radiotbw;?></option>
        <option value="-en" <?php if (isset($p) && $p == "-en") echo "selected";?> ><?php echo $radioen;?></option>
    </select>
       <div class="text-start text-muted form-check-inline me-0" data-bs-html="true" data-bs-toggle="tooltip" style="cursor: pointer;" data-bs-placement="bottom" title="<?php echo $tooltiptextype;?>">*</div>

    <select class="dropdown droponmain rounded-pill text-muted border-2 border-primary text-center input-group-append" id="extraOptions" name="extra">
        <option value="" <?php if (isset($extra) && $p == "") echo "selected";?> ><?php echo "$liststd";?></option>
           <option value="wordRep" <?php if (isset($extra) && $extra == "wordRep") echo "selected";?> ><?php echo "$listwords";?></option>
      
        <option value="-def" <?php if (isset($extra) && $extra == "-def") echo "selected";?> ><?php echo "$listdef";?></option>
        <option value="-sml" <?php if (isset($extra) && $extra == "-sml") echo "selected";?> ><?php echo "$listsml";?></option>
        <option value="-defall" <?php if (isset($extra) && $extra == "-defall") echo "selected";?> ><?php echo "$listdefall";?></option>
        <option value="-nm10" <?php if (isset($extra) && $extra == "-nm10") echo "selected";?> ><?php echo "$listnm10";?></option>
      <option value="-nm5" <?php if (isset($extra) && $extra == "-nm5") echo "selected";?> ><?php echo "$listnm";?></option>
    </select>
	  <div class="text-muted text-decoration-none me-1 form-check-inline" data-bs-html="true" data-bs-toggle="tooltip" style="cursor: pointer;" data-bs-placement="bottom" title="<?php echo $tooltipsearchtype;?>">*</div>
</div>
  <!--  <label for="pOptions"></label> -->
  <!-- extra options -->

         <div style="max-width: 300px;" class="my-2"> 
     <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="onlCheckbox" name="extra" <?php if (isset($extra) && $extra=="-anyd ") echo "checked";?>  value="-anyd">
  <div data-bs-toggle="tooltip" style="cursor: pointer;" data-bs-placement="bottom" title='<?php echo $tooltiponl;?>'><?php echo $checkboxonl;?></div>
  </div>
  
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" id="laCheckbox" name="la" <?php if (isset($extra) && $extra=="-la$defaultla ") echo "checked";?>  value='<?php echo "-la$defaultla"?>'>
  <div data-bs-toggle="tooltip" style="cursor: pointer;" data-bs-placement="bottom" title='<?php echo $tooltipla;?>'><?php echo $checkboxla;?></div>
  </div>
  
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
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter='(\\S*\\s){0,3}'><strong>X(\S*\s){0,3}Y</strong></button> - <?php echo $fewwords;?> <br>
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter='[aā]'><strong>a[ṁ]?</strong></button> - <?php echo $optionalletter;?> <br>
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter='[aā]'><strong>[aā]</strong></button> - <?php echo $variants;?> <br>
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter='tatt($|[^h])'><strong>tatt($|[^h])</strong></button> - <?php echo $variantsexc;?> <br>
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter='(a|b|c)'><strong>(a|b|c)</strong></button> - <?php echo $searchfewwords;?> <br>
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter="mn[0-9].*X"><strong>mn[0-9].*X</strong></button> - <?php echo $inallnikaya;?> <br>
  <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter="dn22.*"><strong>dn22.*Y</strong></button> - <?php echo $inonesutta;?> <br>
    <button class="btn btn-primary btn-sm rounded-pill insert-letter" data-letter='sn56.*(seyyathāpi|adhivacan|ūpama|opama)'><strong>sn56.*(seyyathāpi|adhivacan|ūpama|opama)</strong></button> - <?php echo $metaphorssmlletter;?> <br><br>
</div>

  <?php echo $regexlink;?> 
  
        <!-- Dictionary OnClick Popup -->
        <a alt="onclick popup dictionary" class="common-size-icon4 toggle-dict-btn text-decoration-none text-black">
            <img src="/assets/svg/comment.svg" class="dictIcon"></img>
        </a>  
		
		
<script>

const openQuickModalBtn = document.getElementById("openQuickModalBtn");
if (openQuickModalBtn) { // Проверяем, что элемент существует
  openQuickModalBtn.addEventListener("click", toggleQuickModal);
}
</script>

<a 
  type="button"
  onclick="toggleQuickModal()" 
  aria-label="Открыть Cattāri Ariyasaccāni" 
  class="common-size-icon4" 
  style="cursor: pointer; height: 25px">
  <i class="fa-solid fa-compass"></i>
</a>

    <?php echo $defaults;?> 
    <?php echo $defaultsJS;?> 
    <script src="/assets/js/setDefaultMode.js"></script>
    
 </p>

<script>
  $(document).ready(function () {

    function saveCollapseState(collapseId, isCollapsed) {
      localStorage.setItem("coll_" + collapseId, isCollapsed);
    }

    function loadCollapseState(collapseId) {
      var isCollapsed = localStorage.getItem("coll_" + collapseId) === "true";
      return isCollapsed;
    }

    function handleCollapse(collapseId, isCollapsed) {
      if (collapseId !== "navbarResponsive" && collapseId !== "collapseSettings") {
        if (isCollapsed) {
          $("#" + collapseId).collapse("show");
        } else {
          $("#" + collapseId).collapse("hide");
        }
      }
    }

    $(".collapse").on("shown.bs.collapse", function () {
      saveCollapseState(this.id, true);
    });

    $(".collapse").on("hidden.bs.collapse", function () {
      saveCollapseState(this.id, false);
    });

    $(".collapse").each(function () {
      var isCollapsed = loadCollapseState(this.id);
      handleCollapse(this.id, isCollapsed);
    });

    // Save and restore scroll position
    var scrollPos = localStorage.getItem("scrollPos");
    if (scrollPos) {
      window.scrollTo(0, scrollPos);
    }

    $(window).on("beforeunload", function () {
      localStorage.setItem("scrollPos", window.scrollY);
    });

    // Smooth scroll
    $("a[href^='#']").on("click", function (e) {
      e.preventDefault();

      var target = $(this).attr("href");
      $("html, body").animate({
        scrollTop: $(target).offset().top
      }, 1000, "easeInOutExpo");
    });
  });
</script>

	  <script src="/assets/js/smoothScroll.js" defer></script>

<script>
  
//  autocomplete part
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

// Event listener to submit the form when Enter key is pressed
var input = document.getElementById("paliauto");
input.addEventListener("keypress", function(event) {
  if (event.key === "Enter") {
    event.preventDefault();
    document.getElementById("searchbtn").click();
  }
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
  </div>
    
            <div id="spinner" class="justify-content-center">
              <div class="spinner-border mb-3" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              </div>
                


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

</header>

<!-- Portfolio Section-->
<section class="mt-3 portfolio">
<div class="container text-center">
<?php
if ( $lang == "ru" ) {
include 'assets/common/horizontalMenuRu.php'; 
} else {
include 'assets/common/horizontalMenuEn.php'; 
} 
?>

<script>
  window.onload = function() {
    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);

    
  };
</script>

 		  <script defer>
 document.addEventListener('DOMContentLoaded', function() {
  var hash = window.location.hash;

  if (hash) {

var hashForInput = hash.replace(/#/, '');
var hashForInput = hashForInput.replace(/Collapse.*/, '');

if (/.*CollapseBi/.test(hash)) {
 hashForInput = "bi-" + hashForInput;
}

document.getElementById('paliauto').value = hashForInput;

var clearBtn = document.getElementById('clearbtn');
clearBtn.style.display = 'block';

    var element = document.getElementById(hash.substring(1));
    if (element) {

      var collapseTargets = [];
      var currentCollapse = element.closest('.collapse');
      while (currentCollapse) {
        collapseTargets.push(currentCollapse);
        currentCollapse = currentCollapse.parentElement.closest('.collapse');
      }

      collapseTargets.forEach(function(collapseTarget) {
        var bsCollapse = new bootstrap.Collapse(collapseTarget, { toggle: false });
        bsCollapse.show();
      });

      setTimeout(function() {
        element.scrollIntoView({ behavior: 'smooth' });
      }, 1000);
    }
  }
});
  </script>


<div style="max-width: 450px;" class="container-lg my-4">

<div class="container text-start input-group-append pli-lang" >

 <div class="level1 d-flex align-items-center">
  <span class="toggle-button btn btn-primary btn-sm form-check-inline btn-fixed-width btn-rotate"
    data-bs-toggle="collapse" id="collapseAll">+</span>
  <h2 style="level1">Dhamma</h2>
 </div>
 
 <div class="my-2">
 <div class="level1">
 <h2><a href=# data-bs-toggle="collapse"
 data-bs-target="#dnCollapse">Dīgha Nikāya</a></h2>
 </div>
	 <div class="collapse right-text reverse-order" id="dnCollapse">
<div class="my-3">
<div class="level4 my-3">
		 <h5>Sīlakkhandhavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn1">dn1</a> Brahmajālasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn2">dn2</a> Sāmaññaphalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn3">dn3</a> Ambaṭṭhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn4">dn4</a> Soṇadaṇḍasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn5">dn5</a> Kūṭadantasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn6">dn6</a> Mahālisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn7">dn7</a> Jāliyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn8">dn8</a> Mahāsīhanādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn9">dn9</a> Poṭṭhapādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn10">dn10</a> Subhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn11">dn11</a> Kevaṭṭasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn12">dn12</a> Lohiccasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn13">dn13</a> Tevijjasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>Mahāvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn14">dn14</a> Mahāpadānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn15">dn15</a> Mahānidānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn16">dn16</a> Mahāparinibbānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn17">dn17</a> Mahāsudassanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn18">dn18</a> Janavasabhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn19">dn19</a> Mahāgovindasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn20">dn20</a> Mahāsamayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn21">dn21</a> Sakkapañhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn22">dn22</a> Mahāsatipaṭṭhānasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn23">dn23</a> Pāyāsisutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>Pāthikavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn24">dn24</a> Pāthikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn25">dn25</a> Udumbarikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn26">dn26</a> Cakkavattisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn27">dn27</a> Aggaññasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn28">dn28</a> Sampasādanīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn29">dn29</a> Pāsādikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn30">dn30</a> Lakkhaṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn31">dn31</a> Siṅgālasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn32">dn32</a> Āṭānāṭiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn33">dn33</a> Saṅgītisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dn34">dn34</a> Dasuttarasutta</span>
</div>
 
</div> <!-- Nikaya collapse -->
</div> <!-- Nikaya title + Nikaya collapse inside -->
</div> <!-- Container --> 
<div class="my-2">
 <div class="level1">
 <h2><a href=# data-bs-toggle="collapse"
 data-bs-target="#mnCollapse">Majjhima Nikāya</a></h2>
 </div>
	 <div class="collapse right-text reverse-order" id="mnCollapse">
<div class="level2">
	 <h3><a href=# data-bs-toggle="collapse" data-bs-target="#mn1Collapse">Mūlapaṇṇāsaka</a></h3>
	 </div> 
	 <div class="collapse" id="mn1Collapse">
	 <div class="my-3">
<div class="my-3">
<div class="level4 my-3">
		 <h5>Mūlapariyāyavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn1">mn1</a> Mūlapariyāyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn2">mn2</a> Sabbāsavasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn3">mn3</a> Dhammadāyādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn4">mn4</a> Bhayabheravasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn5">mn5</a> Anaṅgaṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn6">mn6</a> Ākaṅkheyyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn7">mn7</a> Vatthasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn8">mn8</a> Sallekhasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn9">mn9</a> Sammādiṭṭhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn10">mn10</a> Satipaṭṭhānasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>Sīhanādavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn11">mn11</a> Cūḷasīhanādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn12">mn12</a> Mahāsīhanādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn13">mn13</a> Mahādukkhakkhandhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn14">mn14</a> Cūḷadukkhakkhandhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn15">mn15</a> Anumānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn16">mn16</a> Cetokhilasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn17">mn17</a> Vanapatthasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn18">mn18</a> Madhupiṇḍikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn19">mn19</a> Dvedhāvitakkasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn20">mn20</a> Vitakkasaṇṭhānasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>Opammavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn21">mn21</a> Kakacūpamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn22">mn22</a> Alagaddūpamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn23">mn23</a> Vammikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn24">mn24</a> Rathavinītasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn25">mn25</a> Nivāpasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn26">mn26</a> Pāsarāsisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn27">mn27</a> Cūḷahatthipadopamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn28">mn28</a> Mahāhatthipadopamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn29">mn29</a> Mahāsāropamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn30">mn30</a> Cūḷasāropamasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>Mahāyamakavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn31">mn31</a> Cūḷagosiṅgasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn32">mn32</a> Mahāgosiṅgasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn33">mn33</a> Mahāgopālakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn34">mn34</a> Cūḷagopālakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn35">mn35</a> Cūḷasaccakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn36">mn36</a> Mahāsaccakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn37">mn37</a> Cūḷataṇhāsaṅkhayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn38">mn38</a> Mahātaṇhāsaṅkhayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn39">mn39</a> Mahāassapurasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn40">mn40</a> Cūḷaassapurasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>Cūḷayamakavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn41">mn41</a> Sāleyyakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn42">mn42</a> Verañjakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn43">mn43</a> Mahāvedallasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn44">mn44</a> Cūḷavedallasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn45">mn45</a> Cūḷadhammasamādānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn46">mn46</a> Mahādhammasamādānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn47">mn47</a> Vīmaṁsakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn48">mn48</a> Kosambiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn49">mn49</a> Brahmanimantanikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn50">mn50</a> Māratajjanīyasutta</span>
</div>
 
</div> <!-- my-3 inside nipata collapse close prev my div -->
</div> <!-- nipata collapse close prev nipata div -->
</div> <!-- nipata collapse close prev nipata div -->
<div class="level2">
	 <h3><a href=# data-bs-toggle="collapse" data-bs-target="#mn2Collapse">Majjhimapaṇṇāsaka</a></h3>
	 </div> 
	 <div class="collapse" id="mn2Collapse">
	 <div class="my-3">
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>Gahapativagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn51">mn51</a> Kandarakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn52">mn52</a> Aṭṭhakanāgarasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn53">mn53</a> Sekhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn54">mn54</a> Potaliyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn55">mn55</a> Jīvakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn56">mn56</a> Upālisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn57">mn57</a> Kukkuravatikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn58">mn58</a> Abhayarājakumārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn59">mn59</a> Bahuvedanīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn60">mn60</a> Apaṇṇakasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>Bhikkhuvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn61">mn61</a> Ambalaṭṭhikarāhulovādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn62">mn62</a> Mahārāhulovādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn63">mn63</a> Cūḷamālukyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn64">mn64</a> Mahāmālukyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn65">mn65</a> Bhaddālisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn66">mn66</a> Laṭukikopamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn67">mn67</a> Cātumasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn68">mn68</a> Naḷakapānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn69">mn69</a> Goliyānisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn70">mn70</a> Kīṭāgirisutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>Paribbājakavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn71">mn71</a> Tevijjavacchasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn72">mn72</a> Aggivacchasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn73">mn73</a> Mahāvacchasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn74">mn74</a> Dīghanakhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn75">mn75</a> Māgaṇḍiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn76">mn76</a> Sandakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn77">mn77</a> Mahāsakuludāyisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn78">mn78</a> Samaṇamuṇḍikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn79">mn79</a> Cūḷasakuludāyisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn80">mn80</a> Vekhanasasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>Rājavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn81">mn81</a> Ghaṭikārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn82">mn82</a> Raṭṭhapālasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn83">mn83</a> Maghadevasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn84">mn84</a> Madhurasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn85">mn85</a> Bodhirājakumārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn86">mn86</a> Aṅgulimālasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn87">mn87</a> Piyajātikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn88">mn88</a> Bāhitikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn89">mn89</a> Dhammacetiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn90">mn90</a> Kaṇṇakatthalasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>Brāhmaṇavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn91">mn91</a> Brahmāyusutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn92">mn92</a> Selasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn93">mn93</a> Assalāyanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn94">mn94</a> Ghoṭamukhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn95">mn95</a> Caṅkīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn96">mn96</a> Esukārīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn97">mn97</a> Dhanañjānisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn98">mn98</a> Vāseṭṭhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn99">mn99</a> Subhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn100">mn100</a> Saṅgāravasutta</span>
</div>
 
</div> <!-- my-3 inside nipata collapse close prev my div -->
</div> <!-- nipata collapse close prev nipata div -->
<div class="level2">
	 <h3><a href=# data-bs-toggle="collapse" data-bs-target="#mn3Collapse">Uparipaṇṇāsaka</a></h3>
	 </div> 
	 <div class="collapse" id="mn3Collapse">
	 <div class="my-3">
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>Devadahavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn101">mn101</a> Devadahasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn102">mn102</a> Pañcattayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn103">mn103</a> Kintisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn104">mn104</a> Sāmagāmasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn105">mn105</a> Sunakkhattasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn106">mn106</a> Āneñjasappāyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn107">mn107</a> Gaṇakamoggallānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn108">mn108</a> Gopakamoggallānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn109">mn109</a> Mahāpuṇṇamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn110">mn110</a> Cūḷapuṇṇamasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>Anupadavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn111">mn111</a> Anupadasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn112">mn112</a> Chabbisodhanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn113">mn113</a> Sappurisasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn114">mn114</a> Sevitabbāsevitabbasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn115">mn115</a> Bahudhātukasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn116">mn116</a> Isigilisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn117">mn117</a> Mahācattārīsakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn118">mn118</a> Ānāpānassatisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn119">mn119</a> Kāyagatāsatisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn120">mn120</a> Saṅkhārupapattisutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>Suññatavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn121">mn121</a> Cūḷasuññatasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn122">mn122</a> Mahāsuññatasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn123">mn123</a> Acchariyaabbhutasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn124">mn124</a> Bākulasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn125">mn125</a> Dantabhūmisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn126">mn126</a> Bhūmijasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn127">mn127</a> Anuruddhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn128">mn128</a> Upakkilesasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn129">mn129</a> Bālapaṇḍitasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn130">mn130</a> Devadūtasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>Vibhaṅgavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn131">mn131</a> Bhaddekarattasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn132">mn132</a> Ānandabhaddekarattasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn133">mn133</a> Mahākaccānabhaddekarattasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn134">mn134</a> Lomasakaṅgiyabhaddekarattasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn135">mn135</a> Cūḷakammavibhaṅgasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn136">mn136</a> Mahākammavibhaṅgasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn137">mn137</a> Saḷāyatanavibhaṅgasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn138">mn138</a> Uddesavibhaṅgasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn139">mn139</a> Araṇavibhaṅgasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn140">mn140</a> Dhātuvibhaṅgasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn141">mn141</a> Saccavibhaṅgasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn142">mn142</a> Dakkhiṇāvibhaṅgasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>Saḷāyatanavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn143">mn143</a> Anāthapiṇḍikovādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn144">mn144</a> Channovādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn145">mn145</a> Puṇṇovādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn146">mn146</a> Nandakovādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn147">mn147</a> Cūḷarāhulovādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn148">mn148</a> Chachakkasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn149">mn149</a> Mahāsaḷāyatanikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn150">mn150</a> Nagaravindeyyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn151">mn151</a> Piṇḍapātapārisuddhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=mn152">mn152</a> Indriyabhāvanāsutta <?php echo $ifRuLitTrn;?></span>
</div>
 
</div> <!-- Nikaya collapse -->
</div> <!-- Nikaya title + Nikaya collapse inside -->
</div> <!-- Container -->
</div>
<div class="my-2">
 <div class="level1">
 <h2><a href=# data-bs-toggle="collapse"
 data-bs-target="#snCollapse">Saṁyutta Nikāya</a></h2>
 </div>
	 <div class="collapse right-text reverse-order" id="snCollapse">
<div class="level2">
 <h3>Sagāthāvaggasaṁyuttapāḷi</h3>
</div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn1Collapse">1. Devatāsaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn1Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Naḷavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.1">sn1.1</a> Oghataraṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.2">sn1.2</a> Nimokkhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.3">sn1.3</a> Upanīyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.4">sn1.4</a> Accentisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.5">sn1.5</a> Katichindasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.6">sn1.6</a> Jāgarasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.7">sn1.7</a> Appaṭividitasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.8">sn1.8</a> Susammuṭṭhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.9">sn1.9</a> Mānakāmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.10">sn1.10</a> Araññasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Nandanavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.11">sn1.11</a> Nandanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.12">sn1.12</a> Nandatisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.13">sn1.13</a> Natthiputtasamasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.14">sn1.14</a> Khattiyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.15">sn1.15</a> Saṇamānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.16">sn1.16</a> Niddātandīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.17">sn1.17</a> Dukkarasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.18">sn1.18</a> Hirīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.19">sn1.19</a> Kuṭikāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.20">sn1.20</a> Samiddhisutta</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Sattivagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.21">sn1.21</a> Sattisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.22">sn1.22</a> Phusatisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.23">sn1.23</a> Jaṭāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.24">sn1.24</a> Manonivāraṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.25">sn1.25</a> Arahantasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.26">sn1.26</a> Pajjotasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.27">sn1.27</a> Sarasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.28">sn1.28</a> Mahaddhanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.29">sn1.29</a> Catucakkasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.30">sn1.30</a> Eṇijaṅghasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>4. Satullapakāyikavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.31">sn1.31</a> Sabbhisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.32">sn1.32</a> Maccharisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.33">sn1.33</a> Sādhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.34">sn1.34</a> Nasantisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.35">sn1.35</a> Ujjhānasaññisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.36">sn1.36</a> Saddhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.37">sn1.37</a> Samayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.38">sn1.38</a> Sakalikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.39">sn1.39</a> Paṭhamapajjunnadhītusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.40">sn1.40</a> Dutiyapajjunnadhītusuttaṁ</span>
 </div>
<div class="level4 my-3">
		 <h5>5. Ādittavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.41">sn1.41</a> Ādittasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.42">sn1.42</a> Kiṁdadasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.43">sn1.43</a> Annasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.44">sn1.44</a> Ekamūlasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.45">sn1.45</a> Anomasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.46">sn1.46</a> Accharāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.47">sn1.47</a> Vanaropasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.48">sn1.48</a> Jetavanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.49">sn1.49</a> Maccharisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.50">sn1.50</a> Ghaṭīkārasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>6. Jarāvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.51">sn1.51</a> Jarāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.52">sn1.52</a> Ajarasāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.53">sn1.53</a> Mittasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.54">sn1.54</a> Vatthusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.55">sn1.55</a> Paṭhamajanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.56">sn1.56</a> Dutiyajanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.57">sn1.57</a> Tatiyajanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.58">sn1.58</a> Uppathasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.59">sn1.59</a> Dutiyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.60">sn1.60</a> Kavisutta</span>
 </div>
<div class="level4 my-3">
		 <h5>7. Addhavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.61">sn1.61</a> Nāmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.62">sn1.62</a> Cittasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.63">sn1.63</a> Taṇhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.64">sn1.64</a> Saṁyojanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.65">sn1.65</a> Bandhanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.66">sn1.66</a> Attahatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.67">sn1.67</a> Uḍḍitasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.68">sn1.68</a> Pihitasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.69">sn1.69</a> Icchāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.70">sn1.70</a> Lokasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>8. Chetvāvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.71">sn1.71</a> Chetvāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.72">sn1.72</a> Rathasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.73">sn1.73</a> Vittasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.74">sn1.74</a> Vuṭṭhisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.75">sn1.75</a> Bhītāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.76">sn1.76</a> Najīratisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.77">sn1.77</a> Issariyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.78">sn1.78</a> Kāmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.79">sn1.79</a> Pātheyyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.80">sn1.80</a> Pajjotasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn1.81">sn1.81</a> Araṇasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn2Collapse">2. Devaputtasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn2Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Paṭhamavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.1">sn2.1</a> Paṭhamakassapasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.2">sn2.2</a> Dutiyakassapasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.3">sn2.3</a> Māghasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.4">sn2.4</a> Māgadhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.5">sn2.5</a> Dāmalisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.6">sn2.6</a> Kāmadasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.7">sn2.7</a> Pañcālacaṇḍasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.8">sn2.8</a> Tāyanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.9">sn2.9</a> Candimasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.10">sn2.10</a> Sūriyasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Anāthapiṇḍikavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.11">sn2.11</a> Candimasasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.12">sn2.12</a> Veṇḍusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.13">sn2.13</a> Dīghalaṭṭhisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.14">sn2.14</a> Nandanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.15">sn2.15</a> Candanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.16">sn2.16</a> Vāsudattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.17">sn2.17</a> Subrahmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.18">sn2.18</a> Kakudhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.19">sn2.19</a> Uttarasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.20">sn2.20</a> Anāthapiṇḍikasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Nānātitthiyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.21">sn2.21</a> Sivasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.22">sn2.22</a> Khemasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.23">sn2.23</a> Serīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.24">sn2.24</a> Ghaṭīkārasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.25">sn2.25</a> Jantusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.26">sn2.26</a> Rohitassasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.27">sn2.27</a> Nandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.28">sn2.28</a> Nandivisālasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.29">sn2.29</a> Susimasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn2.30">sn2.30</a> Nānātitthiyasāvakasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn3Collapse">3. Kosalasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn3Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Paṭhamavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.1">sn3.1</a> Daharasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.2">sn3.2</a> Purisasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.3">sn3.3</a> Jarāmaraṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.4">sn3.4</a> Piyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.5">sn3.5</a> Attarakkhitasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.6">sn3.6</a> Appakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.7">sn3.7</a> Aḍḍakaraṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.8">sn3.8</a> Mallikāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.9">sn3.9</a> Yaññasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.10">sn3.10</a> Bandhanasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Dutiyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.11">sn3.11</a> Sattajaṭilasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.12">sn3.12</a> Pañcarājasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.13">sn3.13</a> Doṇapākasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.14">sn3.14</a> Paṭhamasaṅgāmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.15">sn3.15</a> Dutiyasaṅgāmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.16">sn3.16</a> Mallikāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.17">sn3.17</a> Appamādasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.18">sn3.18</a> Kalyāṇamittasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.19">sn3.19</a> Paṭhamaaputtakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.20">sn3.20</a> Dutiyaaputtakasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Tatiyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.21">sn3.21</a> Puggalasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.22">sn3.22</a> Ayyikāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.23">sn3.23</a> Lokasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.24">sn3.24</a> Issattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn3.25">sn3.25</a> Pabbatūpamasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn4Collapse">4. Mārasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn4Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Paṭhamavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.1">sn4.1</a> Tapokammasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.2">sn4.2</a> Hatthirājavaṇṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.3">sn4.3</a> Subhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.4">sn4.4</a> Paṭhamamārapāsasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.5">sn4.5</a> Dutiyamārapāsasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.6">sn4.6</a> Sappasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.7">sn4.7</a> Supatisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.8">sn4.8</a> Nandatisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.9">sn4.9</a> Paṭhamaāyusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.10">sn4.10</a> Dutiyaāyusutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Dutiyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.11">sn4.11</a> Pāsāṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.12">sn4.12</a> Kinnusīhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.13">sn4.13</a> Sakalikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.14">sn4.14</a> Patirūpasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.15">sn4.15</a> Mānasasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.16">sn4.16</a> Pattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.17">sn4.17</a> Chaphassāyatanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.18">sn4.18</a> Piṇḍasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.19">sn4.19</a> Kassakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.20">sn4.20</a> Rajjasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Tatiyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.21">sn4.21</a> Sambahulasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.22">sn4.22</a> Samiddhisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.23">sn4.23</a> Godhikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.24">sn4.24</a> Sattavassānubandhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn4.25">sn4.25</a> Māradhītusutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn5Collapse">5. Bhikkhunīsaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn5Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Bhikkhunīvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn5.1">sn5.1</a> Āḷavikāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn5.2">sn5.2</a> Somāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn5.3">sn5.3</a> Kisāgotamīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn5.4">sn5.4</a> Vijayāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn5.5">sn5.5</a> Uppalavaṇṇāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn5.6">sn5.6</a> Cālāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn5.7">sn5.7</a> Upacālāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn5.8">sn5.8</a> Sīsupacālāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn5.9">sn5.9</a> Selāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn5.10">sn5.10</a> Vajirāsutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn6Collapse">6. Brahmasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn6Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Paṭhamavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn6.1">sn6.1</a> Brahmāyācanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn6.2">sn6.2</a> Gāravasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn6.3">sn6.3</a> Brahmadevasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn6.4">sn6.4</a> Bakabrahmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn6.5">sn6.5</a> Aññatarabrahmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn6.6">sn6.6</a> Brahmalokasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn6.7">sn6.7</a> Kokālikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn6.8">sn6.8</a> Katamodakatissasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn6.9">sn6.9</a> Turūbrahmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn6.10">sn6.10</a> Kokālikasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Dutiyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn6.11">sn6.11</a> Sanaṅkumārasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn6.12">sn6.12</a> Devadattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn6.13">sn6.13</a> Andhakavindasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn6.14">sn6.14</a> Aruṇavatīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn6.15">sn6.15</a> Parinibbānasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn7Collapse">7. Brāhmaṇasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn7Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Arahantavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.1">sn7.1</a> Dhanañjānīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.2">sn7.2</a> Akkosasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.3">sn7.3</a> Asurindakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.4">sn7.4</a> Bilaṅgikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.5">sn7.5</a> Ahiṁsakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.6">sn7.6</a> Jaṭāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.7">sn7.7</a> Suddhikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.8">sn7.8</a> Aggikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.9">sn7.9</a> Sundarikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.10">sn7.10</a> Bahudhītarasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Upāsakavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.11">sn7.11</a> Kasibhāradvājasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.12">sn7.12</a> Udayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.13">sn7.13</a> Devahitasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.14">sn7.14</a> Mahāsālasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.15">sn7.15</a> Mānatthaddhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.16">sn7.16</a> Paccanīkasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.17">sn7.17</a> Navakammikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.18">sn7.18</a> Kaṭṭhahārasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.19">sn7.19</a> Mātuposakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.20">sn7.20</a> Bhikkhakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.21">sn7.21</a> Saṅgāravasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn7.22">sn7.22</a> Khomadussasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn8Collapse">8. Vaṅgīsasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn8Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Vaṅgīsavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn8.1">sn8.1</a> Nikkhantasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn8.2">sn8.2</a> Aratīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn8.3">sn8.3</a> Pesalasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn8.4">sn8.4</a> Ānandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn8.5">sn8.5</a> Subhāsitasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn8.6">sn8.6</a> Sāriputtasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn8.7">sn8.7</a> Pavāraṇāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn8.8">sn8.8</a> Parosahassasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn8.9">sn8.9</a> Koṇḍaññasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn8.10">sn8.10</a> Moggallānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn8.11">sn8.11</a> Gaggarāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn8.12">sn8.12</a> Vaṅgīsasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn9Collapse">9. Vanasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn9Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Vanavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn9.1">sn9.1</a> Vivekasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn9.2">sn9.2</a> Upaṭṭhānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn9.3">sn9.3</a> Kassapagottasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn9.4">sn9.4</a> Sambahulasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn9.5">sn9.5</a> Ānandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn9.6">sn9.6</a> Anuruddhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn9.7">sn9.7</a> Nāgadattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn9.8">sn9.8</a> Kulagharaṇīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn9.9">sn9.9</a> Vajjiputtasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn9.10">sn9.10</a> Sajjhāyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn9.11">sn9.11</a> Akusalavitakkasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn9.12">sn9.12</a> Majjhanhikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn9.13">sn9.13</a> Pākatindriyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn9.14">sn9.14</a> Gandhatthenasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn10Collapse">10. Yakkhasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn10Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Indakavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn10.1">sn10.1</a> Indakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn10.2">sn10.2</a> Sakkanāmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn10.3">sn10.3</a> Sūcilomasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn10.4">sn10.4</a> Maṇibhaddasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn10.5">sn10.5</a> Sānusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn10.6">sn10.6</a> Piyaṅkarasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn10.7">sn10.7</a> Punabbasusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn10.8">sn10.8</a> Sudattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn10.9">sn10.9</a> Paṭhamasukkāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn10.10">sn10.10</a> Dutiyasukkāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn10.11">sn10.11</a> Cīrāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn10.12">sn10.12</a> Āḷavakasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn11Collapse">11. Sakkasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn11Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Paṭhamavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.1">sn11.1</a> Suvīrasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.2">sn11.2</a> Susīmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.3">sn11.3</a> Dhajaggasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.4">sn11.4</a> Vepacittisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.5">sn11.5</a> Subhāsitajayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.6">sn11.6</a> Kulāvakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.7">sn11.7</a> Nadubbhiyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.8">sn11.8</a> Verocanaasurindasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.9">sn11.9</a> Araññāyatanaisisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.10">sn11.10</a> Samuddakasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Dutiyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.11">sn11.11</a> Vatapadasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.12">sn11.12</a> Sakkanāmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.13">sn11.13</a> Mahālisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.14">sn11.14</a> Daliddasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.15">sn11.15</a> Rāmaṇeyyakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.16">sn11.16</a> Yajamānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.17">sn11.17</a> Buddhavandanāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.18">sn11.18</a> Gahaṭṭhavandanāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.19">sn11.19</a> Satthāravandanāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.20">sn11.20</a> Saṅghavandanāsutta</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Tatiyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.21">sn11.21</a> Chetvāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.22">sn11.22</a> Dubbaṇṇiyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.23">sn11.23</a> Sambarimāyāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.24">sn11.24</a> Accayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn11.25">sn11.25</a> Akkodhasutta</span>
 </div>
</div>
	 </div>
<div class="level2">
 <h3>Nidānavaggasaṁyuttapāḷi</h3>
</div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn12Collapse">12. Nidānasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn12Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Buddhavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.1">sn12.1</a> Paṭiccasamuppādasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.2">sn12.2</a> Vibhaṅgasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.3">sn12.3</a> Paṭipadāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.4">sn12.4</a> Vipassīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.5">sn12.5</a> Sikhīsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.6">sn12.6</a> Vessabhūsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.7">sn12.7</a> Kakusandhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.8">sn12.8</a> Koṇāgamanasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.9">sn12.9</a> Kassapasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.10">sn12.10</a> Gotamasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Āhāravagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.11">sn12.11</a> Āhārasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.12">sn12.12</a> Moḷiyaphaggunasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.13">sn12.13</a> Samaṇabrāhmaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.14">sn12.14</a> Dutiyasamaṇabrāhmaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.15">sn12.15</a> Kaccānagottasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.16">sn12.16</a> Dhammakathikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.17">sn12.17</a> Acelakassapasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.18">sn12.18</a> Timbarukasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.19">sn12.19</a> Bālapaṇḍitasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.20">sn12.20</a> Paccayasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Dasabalavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.21">sn12.21</a> Dasabalasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.22">sn12.22</a> Dutiyadasabalasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.23">sn12.23</a> Upanisasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.24">sn12.24</a> Aññatitthiyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.25">sn12.25</a> Bhūmijasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.26">sn12.26</a> Upavāṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.27">sn12.27</a> Paccayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.28">sn12.28</a> Bhikkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.29">sn12.29</a> Samaṇabrāhmaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.30">sn12.30</a> Dutiyasamaṇabrāhmaṇasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>4. Kaḷārakhattiyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.31">sn12.31</a> Bhūtasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.32">sn12.32</a> Kaḷārasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.33">sn12.33</a> Ñāṇavatthusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.34">sn12.34</a> Dutiyañāṇavatthusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.35">sn12.35</a> Avijjāpaccayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.36">sn12.36</a> Dutiyaavijjāpaccayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.37">sn12.37</a> Natumhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.38">sn12.38</a> Cetanāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.39">sn12.39</a> Dutiyacetanāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.40">sn12.40</a> Tatiyacetanāsutta</span>
 </div>
<div class="level4 my-3">
		 <h5>5. Gahapativagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.41">sn12.41</a> Pañcaverabhayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.42">sn12.42</a> Dutiyapañcaverabhayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.43">sn12.43</a> Dukkhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.44">sn12.44</a> Lokasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.45">sn12.45</a> Ñātikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.46">sn12.46</a> Aññatarabrāhmaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.47">sn12.47</a> Jāṇussoṇisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.48">sn12.48</a> Lokāyatikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.49">sn12.49</a> Ariyasāvakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.50">sn12.50</a> Dutiyaariyasāvakasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>6. Dukkhavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.51">sn12.51</a> Parivīmaṁsanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.52">sn12.52</a> Upādānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.53">sn12.53</a> Saṁyojanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.54">sn12.54</a> Dutiyasaṁyojanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.55">sn12.55</a> Mahārukkhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.56">sn12.56</a> Dutiyamahārukkhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.57">sn12.57</a> Taruṇarukkhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.58">sn12.58</a> Nāmarūpasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.59">sn12.59</a> Viññāṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.60">sn12.60</a> Nidānasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>7. Mahāvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.61">sn12.61</a> Assutavāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.62">sn12.62</a> Dutiyaassutavāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.63">sn12.63</a> Puttamaṁsasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.64">sn12.64</a> Atthirāgasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.65">sn12.65</a> Nagarasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.66">sn12.66</a> Sammasasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.67">sn12.67</a> Naḷakalāpīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.68">sn12.68</a> Kosambisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.69">sn12.69</a> Upayantisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.70">sn12.70</a> Susimaparibbājakasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>8. Samaṇabrāhmaṇavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.71">sn12.71</a> Jarāmaraṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.72-81">sn12.72-81</a> Jātisuttādidasaka</span>
 </div>
<div class="level4 my-3">
		 <h5>9. Antarapeyyāla</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.82">sn12.82</a> Satthusutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.83-92">sn12.83-92</a> Dutiyasatthusuttādidasaka <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn12.93-213">sn12.93-213</a> Sikkhāsuttādipeyyālaekādasaka <?php echo $ifRuLitTrn;?></span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn13Collapse">13. Abhisamayasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn13Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Abhisamayavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn13.1">sn13.1</a> Nakhasikhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn13.2">sn13.2</a> Pokkharaṇīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn13.3">sn13.3</a> Sambhejjaudakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn13.4">sn13.4</a> Dutiyasambhejjaudakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn13.5">sn13.5</a> Pathavīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn13.6">sn13.6</a> Dutiyapathavīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn13.7">sn13.7</a> Samuddasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn13.8">sn13.8</a> Dutiyasamuddasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn13.9">sn13.9</a> Pabbatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn13.10">sn13.10</a> Dutiyapabbatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn13.11">sn13.11</a> Tatiyapabbatasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn14Collapse">14. Dhātusaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn14Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Nānattavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.1">sn14.1</a> Dhātunānattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.2">sn14.2</a> Phassanānattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.3">sn14.3</a> Nophassanānattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.4">sn14.4</a> Vedanānānattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.5">sn14.5</a> Dutiyavedanānānattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.6">sn14.6</a> Bāhiradhātunānattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.7">sn14.7</a> Saññānānattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.8">sn14.8</a> Nopariyesanānānattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.9">sn14.9</a> Bāhiraphassanānattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.10">sn14.10</a> Dutiyabāhiraphassanānattasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Dutiyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.11">sn14.11</a> Sattadhātusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.12">sn14.12</a> Sanidānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.13">sn14.13</a> Giñjakāvasathasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.14">sn14.14</a> Hīnādhimuttikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.15">sn14.15</a> Caṅkamasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.16">sn14.16</a> Sagāthāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.17">sn14.17</a> Assaddhasaṁsandanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.18">sn14.18</a> Assaddhamūlakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.19">sn14.19</a> Ahirikamūlakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.20">sn14.20</a> Anottappamūlakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.21">sn14.21</a> Appassutamūlakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.22">sn14.22</a> Kusītamūlakasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Kammapathavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.23">sn14.23</a> Asamāhitasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.24">sn14.24</a> Dussīlasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.25">sn14.25</a> Pañcasikkhāpadasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.26">sn14.26</a> Sattakammapathasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.27">sn14.27</a> Dasakammapathasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.28">sn14.28</a> Aṭṭhaṅgikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.29">sn14.29</a> Dasaṅgasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>4. Catutthavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.30">sn14.30</a> Catudhātusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.31">sn14.31</a> Pubbesambodhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.32">sn14.32</a> Acariṁsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.33">sn14.33</a> Nocedaṁsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.34">sn14.34</a> Ekantadukkhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.35">sn14.35</a> Abhinandasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.36">sn14.36</a> Uppādasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.37">sn14.37</a> Samaṇabrāhmaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.38">sn14.38</a> Dutiyasamaṇabrāhmaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn14.39">sn14.39</a> Tatiyasamaṇabrāhmaṇasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn15Collapse">15. Anamataggasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn15Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Paṭhamavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn15.1">sn15.1</a> Tiṇakaṭṭhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn15.2">sn15.2</a> Pathavīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn15.3">sn15.3</a> Assusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn15.4">sn15.4</a> Khīrasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn15.5">sn15.5</a> Pabbatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn15.6">sn15.6</a> Sāsapasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn15.7">sn15.7</a> Sāvakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn15.8">sn15.8</a> Gaṅgāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn15.9">sn15.9</a> Daṇḍasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn15.10">sn15.10</a> Puggalasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Dutiyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn15.11">sn15.11</a> Duggatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn15.12">sn15.12</a> Sukhitasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn15.13">sn15.13</a> Tiṁsamattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn15.14">sn15.14</a> Mātusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn15.15">sn15.15</a> Pitusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn15.16">sn15.16</a> Bhātusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn15.17">sn15.17</a> Bhaginisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn15.18">sn15.18</a> Puttasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn15.19">sn15.19</a> Dhītusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn15.20">sn15.20</a> Vepullapabbatasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn16Collapse">16. Kassapasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn16Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Kassapavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn16.1">sn16.1</a> Santuṭṭhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn16.2">sn16.2</a> Anottappīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn16.3">sn16.3</a> Candūpamāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn16.4">sn16.4</a> Kulūpakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn16.5">sn16.5</a> Jiṇṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn16.6">sn16.6</a> Ovādasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn16.7">sn16.7</a> Dutiyaovādasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn16.8">sn16.8</a> Tatiyaovādasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn16.9">sn16.9</a> Jhānābhiññasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn16.10">sn16.10</a> Upassayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn16.11">sn16.11</a> Cīvarasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn16.12">sn16.12</a> Paraṁmaraṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn16.13">sn16.13</a> Saddhammappatirūpakasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn17Collapse">17. Lābhasakkārasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn17Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Paṭhamavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.1">sn17.1</a> Dāruṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.2">sn17.2</a> Baḷisasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.3">sn17.3</a> Kummasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.4">sn17.4</a> Dīghalomikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.5">sn17.5</a> Mīḷhakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.6">sn17.6</a> Asanisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.7">sn17.7</a> Diddhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.8">sn17.8</a> Siṅgālasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.9">sn17.9</a> Verambhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.10">sn17.10</a> Sagāthakasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Dutiyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.11">sn17.11</a> Suvaṇṇapātisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.12">sn17.12</a> Rūpiyapātisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.13-20">sn17.13-20</a> Suvaṇṇanikkhasuttādiaṭṭhaka</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Tatiyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.21">sn17.21</a> Mātugāmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.22">sn17.22</a> Kalyāṇīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.23">sn17.23</a> Ekaputtakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.24">sn17.24</a> Ekadhītusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.25">sn17.25</a> Samaṇabrāhmaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.26">sn17.26</a> Dutiyasamaṇabrāhmaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.27">sn17.27</a> Tatiyasamaṇabrāhmaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.28">sn17.28</a> Chavisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.29">sn17.29</a> Rajjusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.30">sn17.30</a> Bhikkhusutta</span>
 </div>
<div class="level4 my-3">
		 <h5>4. Catutthavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.31">sn17.31</a> Bhindisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.32">sn17.32</a> Kusalamūlasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.33">sn17.33</a> Kusaladhammasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.34">sn17.34</a> Sukkadhammasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.35">sn17.35</a> Acirapakkantasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.36">sn17.36</a> Pañcarathasatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.37">sn17.37</a> Mātusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn17.38-43">sn17.38-43</a> Pitusuttādichakka</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn18Collapse">18. Rāhulasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn18Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Paṭhamavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn18.1">sn18.1</a> Cakkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn18.2">sn18.2</a> Rūpasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn18.3">sn18.3</a> Viññāṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn18.4">sn18.4</a> Samphassasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn18.5">sn18.5</a> Vedanāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn18.6">sn18.6</a> Saññāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn18.7">sn18.7</a> Sañcetanāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn18.8">sn18.8</a> Taṇhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn18.9">sn18.9</a> Dhātusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn18.10">sn18.10</a> Khandhasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Dutiyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn18.11">sn18.11</a> Cakkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn18.12-20">sn18.12-20</a> Rūpādisuttanavaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn18.21">sn18.21</a> Anusayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn18.22">sn18.22</a> Apagatasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn19Collapse">19. Lakkhaṇasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn19Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Paṭhamavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.1">sn19.1</a> Aṭṭhisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.2">sn19.2</a> Pesisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.3">sn19.3</a> Piṇḍasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.4">sn19.4</a> Nicchavisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.5">sn19.5</a> Asilomasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.6">sn19.6</a> Sattisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.7">sn19.7</a> Usulomasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.8">sn19.8</a> Sūcilomasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.9">sn19.9</a> Dutiyasūcilomasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.10">sn19.10</a> Kumbhaṇḍasutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>2. Dutiyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.11">sn19.11</a> Sasīsakasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.12">sn19.12</a> Gūthakhādasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.13">sn19.13</a> Nicchavitthisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.14">sn19.14</a> Maṅgulitthisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.15">sn19.15</a> Okilinīsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.16">sn19.16</a> Asīsakasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.17">sn19.17</a> Pāpabhikkhusutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.18">sn19.18</a> Pāpabhikkhunīsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.19">sn19.19</a> Pāpasikkhamānasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.20">sn19.20</a> Pāpasāmaṇerasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn19.21">sn19.21</a> Pāpasāmaṇerīsutta <?php echo $ifRuLitTrn;?></span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn20Collapse">20. Opammasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn20Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Opammavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn20.1">sn20.1</a> Kūṭasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn20.2">sn20.2</a> Nakhasikhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn20.3">sn20.3</a> Kulasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn20.4">sn20.4</a> Okkhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn20.5">sn20.5</a> Sattisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn20.6">sn20.6</a> Dhanuggahasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn20.7">sn20.7</a> Āṇisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn20.8">sn20.8</a> Kaliṅgarasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn20.9">sn20.9</a> Nāgasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn20.10">sn20.10</a> Biḷārasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn20.11">sn20.11</a> Siṅgālasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn20.12">sn20.12</a> Dutiyasiṅgālasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn21Collapse">21. Bhikkhusaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn21Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Bhikkhuvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn21.1">sn21.1</a> Kolitasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn21.2">sn21.2</a> Upatissasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn21.3">sn21.3</a> Ghaṭasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn21.4">sn21.4</a> Navasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn21.5">sn21.5</a> Sujātasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn21.6">sn21.6</a> Lakuṇḍakabhaddiyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn21.7">sn21.7</a> Visākhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn21.8">sn21.8</a> Nandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn21.9">sn21.9</a> Tissasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn21.10">sn21.10</a> Theranāmakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn21.11">sn21.11</a> Mahākappinasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn21.12">sn21.12</a> Sahāyakasutta</span>
 </div>
</div>
	 </div>
<div class="level2">
 <h3>Khandhavaggasaṁyuttapāḷi</h3>
</div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn22Collapse">22. Khandhasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn22Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Nakulapituvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.1">sn22.1</a> Nakulapitusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.2">sn22.2</a> Devadahasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.3">sn22.3</a> Hāliddikānisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.4">sn22.4</a> Dutiyahāliddikānisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.5">sn22.5</a> Samādhisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.6">sn22.6</a> Paṭisallāṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.7">sn22.7</a> Upādāparitassanāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.8">sn22.8</a> Dutiyaupādāparitassanāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.9">sn22.9</a> Kālattayaaniccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.10">sn22.10</a> Kālattayadukkhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.11">sn22.11</a> Kālattayaanattasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Aniccavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.12">sn22.12</a> Aniccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.13">sn22.13</a> Dukkhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.14">sn22.14</a> Anattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.15">sn22.15</a> Yadaniccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.16">sn22.16</a> Yaṁdukkhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.17">sn22.17</a> Yadanattāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.18">sn22.18</a> Sahetuaniccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.19">sn22.19</a> Sahetudukkhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.20">sn22.20</a> Sahetuanattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.21">sn22.21</a> Ānandasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Bhāravagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.22">sn22.22</a> Bhārasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.23">sn22.23</a> Pariññasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.24">sn22.24</a> Abhijānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.25">sn22.25</a> Chandarāgasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.26">sn22.26</a> Assādasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.27">sn22.27</a> Dutiyaassādasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.28">sn22.28</a> Tatiyaassādasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.29">sn22.29</a> Abhinandanasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.30">sn22.30</a> Uppādasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.31">sn22.31</a> Aghamūlasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.32">sn22.32</a> Pabhaṅgusutta</span>
 </div>
<div class="level4 my-3">
		 <h5>4. Natumhākavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.33">sn22.33</a> Natumhākasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.34">sn22.34</a> Dutiyanatumhākasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.35">sn22.35</a> Aññatarabhikkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.36">sn22.36</a> Dutiyaaññatarabhikkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.37">sn22.37</a> Ānandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.38">sn22.38</a> Dutiyaānandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.39">sn22.39</a> Anudhammasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.40">sn22.40</a> Dutiyaanudhammasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.41">sn22.41</a> Tatiyaanudhammasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.42">sn22.42</a> Catutthaanudhammasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>5. Attadīpavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.43">sn22.43</a> Attadīpasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.44">sn22.44</a> Paṭipadāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.45">sn22.45</a> Aniccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.46">sn22.46</a> Dutiyaaniccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.47">sn22.47</a> Samanupassanāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.48">sn22.48</a> Khandhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.49">sn22.49</a> Soṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.50">sn22.50</a> Dutiyasoṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.51">sn22.51</a> Nandikkhayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.52">sn22.52</a> Dutiyanandikkhayasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>6. Upayavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.53">sn22.53</a> Upayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.54">sn22.54</a> Bījasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.55">sn22.55</a> Udānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.56">sn22.56</a> Upādānaparipavattasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.57">sn22.57</a> Sattaṭṭhānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.58">sn22.58</a> Sammāsambuddhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.59">sn22.59</a> Anattalakkhaṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.60">sn22.60</a> Mahālisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.61">sn22.61</a> Ādittasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.62">sn22.62</a> Niruttipathasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>7. Arahantavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.63">sn22.63</a> Upādiyamānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.64">sn22.64</a> Maññamānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.65">sn22.65</a> Abhinandamānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.66">sn22.66</a> Aniccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.67">sn22.67</a> Dukkhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.68">sn22.68</a> Anattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.69">sn22.69</a> Anattaniyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.70">sn22.70</a> Rajanīyasaṇṭhitasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.71">sn22.71</a> Rādhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.72">sn22.72</a> Surādhasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>8. Khajjanīyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.73">sn22.73</a> Assādasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.74">sn22.74</a> Samudayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.75">sn22.75</a> Dutiyasamudayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.76">sn22.76</a> Arahantasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.77">sn22.77</a> Dutiyaarahantasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.78">sn22.78</a> Sīhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.79">sn22.79</a> Khajjanīyasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.80">sn22.80</a> Piṇḍolyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.81">sn22.81</a> Pālileyyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.82">sn22.82</a> Puṇṇamasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>9. Theravagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.83">sn22.83</a> Ānandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.84">sn22.84</a> Tissasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.85">sn22.85</a> Yamakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.86">sn22.86</a> Anurādhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.87">sn22.87</a> Vakkalisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.88">sn22.88</a> Assajisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.89">sn22.89</a> Khemakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.90">sn22.90</a> Channasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.91">sn22.91</a> Rāhulasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.92">sn22.92</a> Dutiyarāhulasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>10. Pupphavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.93">sn22.93</a> Nadīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.94">sn22.94</a> Pupphasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.95">sn22.95</a> Pheṇapiṇḍūpamasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.96">sn22.96</a> Gomayapiṇḍasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.97">sn22.97</a> Nakhasikhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.98">sn22.98</a> Suddhikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.99">sn22.99</a> Gaddulabaddhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.100">sn22.100</a> Dutiyagaddulabaddhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.101">sn22.101</a> Vāsijaṭasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.102">sn22.102</a> Aniccasaññāsutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>11. Antavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.103">sn22.103</a> Antasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.104">sn22.104</a> Dukkhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.105">sn22.105</a> Sakkāyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.106">sn22.106</a> Pariññeyyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.107">sn22.107</a> Samaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.108">sn22.108</a> Dutiyasamaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.109">sn22.109</a> Sotāpannasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.110">sn22.110</a> Arahantasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.111">sn22.111</a> Chandappahānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.112">sn22.112</a> Dutiyachandappahānasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>12. Dhammakathikavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.113">sn22.113</a> Avijjāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.114">sn22.114</a> Vijjāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.115">sn22.115</a> Dhammakathikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.116">sn22.116</a> Dutiyadhammakathikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.117">sn22.117</a> Bandhanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.118">sn22.118</a> Paripucchitasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.119">sn22.119</a> Dutiyaparipucchitasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.120">sn22.120</a> Saṁyojaniyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.121">sn22.121</a> Upādāniyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.122">sn22.122</a> Sīlavantasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.123">sn22.123</a> Sutavantasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.124">sn22.124</a> Kappasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.125">sn22.125</a> Dutiyakappasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>13. Avijjāvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.126">sn22.126</a> Samudayadhammasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.127">sn22.127</a> Dutiyasamudayadhammasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.128">sn22.128</a> Tatiyasamudayadhammasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.129">sn22.129</a> Assādasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.130">sn22.130</a> Dutiyaassādasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.131">sn22.131</a> Samudayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.132">sn22.132</a> Dutiyasamudayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.133">sn22.133</a> Koṭṭhikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.134">sn22.134</a> Dutiyakoṭṭhikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.135">sn22.135</a> Tatiyakoṭṭhikasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>14. Kukkuḷavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.136">sn22.136</a> Kukkuḷasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.137">sn22.137</a> Aniccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.138">sn22.138</a> Dutiyaaniccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.139">sn22.139</a> Tatiyaaniccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.140">sn22.140</a> Dukkhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.141">sn22.141</a> Dutiyadukkhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.142">sn22.142</a> Tatiyadukkhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.143">sn22.143</a> Anattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.144">sn22.144</a> Dutiyaanattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.145">sn22.145</a> Tatiyaanattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.146">sn22.146</a> Nibbidābahulasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.147">sn22.147</a> Aniccānupassīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.148">sn22.148</a> Dukkhānupassīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.149">sn22.149</a> Anattānupassīsutta</span>
 </div>
<div class="level4 my-3">
		 <h5>15. Diṭṭhivagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.150">sn22.150</a> Ajjhattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.151">sn22.151</a> Etaṁmamasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.152">sn22.152</a> Soattāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.153">sn22.153</a> Nocamesiyāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.154">sn22.154</a> Micchādiṭṭhisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.155">sn22.155</a> Sakkāyadiṭṭhisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.156">sn22.156</a> Attānudiṭṭhisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.157">sn22.157</a> Abhinivesasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.158">sn22.158</a> Dutiyaabhinivesasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn22.159">sn22.159</a> Ānandasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn23Collapse">23. Rādhasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn23Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Paṭhamamāravagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.1">sn23.1</a> Mārasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.2">sn23.2</a> Sattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.3">sn23.3</a> Bhavanettisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.4">sn23.4</a> Pariññeyyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.5">sn23.5</a> Samaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.6">sn23.6</a> Dutiyasamaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.7">sn23.7</a> Sotāpannasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.8">sn23.8</a> Arahantasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.9">sn23.9</a> Chandarāgasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.10">sn23.10</a> Dutiyachandarāgasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Dutiyamāravagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.11">sn23.11</a> Mārasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.12">sn23.12</a> Māradhammasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.13">sn23.13</a> Aniccasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.14">sn23.14</a> Aniccadhammasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.15">sn23.15</a> Dukkhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.16">sn23.16</a> Dukkhadhammasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.17">sn23.17</a> Anattasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.18">sn23.18</a> Anattadhammasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.19">sn23.19</a> Khayadhammasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.20">sn23.20</a> Vayadhammasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.21">sn23.21</a> Samudayadhammasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.22">sn23.22</a> Nirodhadhammasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Āyācanavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.23-33">sn23.23-33</a> Mārādisuttaekādasaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.34">sn23.34</a> Nirodhadhammasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>4. Upanisinnavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.35-45">sn23.35-45</a> Mārādisuttaekādasaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn23.46">sn23.46</a> Nirodhadhammasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn24Collapse">24. Diṭṭhisaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn24Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Sotāpattivagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.1">sn24.1</a> Vātasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.2">sn24.2</a> Etaṁmamasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.3">sn24.3</a> Soattāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.4">sn24.4</a> Nocamesiyāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.5">sn24.5</a> Natthidinnasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.6">sn24.6</a> Karotosutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.7">sn24.7</a> Hetusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.8">sn24.8</a> Mahādiṭṭhisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.9">sn24.9</a> Sassatadiṭṭhisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.10">sn24.10</a> Asassatadiṭṭhisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.11">sn24.11</a> Antavāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.12">sn24.12</a> Anantavāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.13">sn24.13</a> Taṁjīvaṁtaṁsarīraṁsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.14">sn24.14</a> Aññaṁjīvaṁaññaṁsarīraṁsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.15">sn24.15</a> Hotitathāgatosutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.16">sn24.16</a> Nahotitathāgatosutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.17">sn24.17</a> Hoticanacahotitathāgatosutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.18">sn24.18</a> Nevahotinanahotitathāgatosutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Dutiyagamanavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.19">sn24.19</a> Vātasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.20-35">sn24.20-35</a> Etaṁmamādisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.36">sn24.36</a> Nevahotinanahotisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.37">sn24.37</a> Rūpīattāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.38">sn24.38</a> Arūpīattāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.39">sn24.39</a> Rūpīcaarūpīcaattāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.40">sn24.40</a> Nevarūpīnārūpīattāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.41">sn24.41</a> Ekantasukhīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.42">sn24.42</a> Ekantadukkhīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.43">sn24.43</a> Sukhadukkhīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.44">sn24.44</a> Adukkhamasukhīsutta</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Tatiyagamanavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.45">sn24.45</a> Navātasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.46-69">sn24.46-69</a> Etaṁmamādisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.70">sn24.70</a> Adukkhamasukhīsutta</span>
 </div>
<div class="level4 my-3">
		 <h5>4. Catutthagamanavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.71">sn24.71</a> Navātasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.72-95">sn24.72-95</a> Etaṁmamādisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn24.96">sn24.96</a> Adukkhamasukhīsutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn25Collapse">25. Okkantasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn25Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Cakkhuvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn25.1">sn25.1</a> Cakkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn25.2">sn25.2</a> Rūpasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn25.3">sn25.3</a> Viññāṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn25.4">sn25.4</a> Samphassasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn25.5">sn25.5</a> Samphassajasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn25.6">sn25.6</a> Rūpasaññāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn25.7">sn25.7</a> Rūpasañcetanāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn25.8">sn25.8</a> Rūpataṇhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn25.9">sn25.9</a> Pathavīdhātusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn25.10">sn25.10</a> Khandhasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn26Collapse">26. Uppādasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn26Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Uppādavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn26.1">sn26.1</a> Cakkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn26.2">sn26.2</a> Rūpasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn26.3">sn26.3</a> Viññāṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn26.4">sn26.4</a> Samphassasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn26.5">sn26.5</a> Samphassajasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn26.6">sn26.6</a> Saññāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn26.7">sn26.7</a> Sañcetanāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn26.8">sn26.8</a> Taṇhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn26.9">sn26.9</a> Dhātusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn26.10">sn26.10</a> Khandhasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn27Collapse">27. Kilesasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn27Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Kilesavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn27.1">sn27.1</a> Cakkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn27.2">sn27.2</a> Rūpasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn27.3">sn27.3</a> Viññāṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn27.4">sn27.4</a> Samphassasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn27.5">sn27.5</a> Samphassajasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn27.6">sn27.6</a> Saññāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn27.7">sn27.7</a> Sañcetanāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn27.8">sn27.8</a> Taṇhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn27.9">sn27.9</a> Dhātusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn27.10">sn27.10</a> Khandhasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn28Collapse">28. Sāriputtasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn28Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Sāriputtavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn28.1">sn28.1</a> Vivekajasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn28.2">sn28.2</a> Avitakkasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn28.3">sn28.3</a> Pītisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn28.4">sn28.4</a> Upekkhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn28.5">sn28.5</a> Ākāsānañcāyatanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn28.6">sn28.6</a> Viññāṇañcāyatanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn28.7">sn28.7</a> Ākiñcaññāyatanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn28.8">sn28.8</a> Nevasaññānāsaññāyatanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn28.9">sn28.9</a> Nirodhasamāpattisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn28.10">sn28.10</a> Sucimukhīsutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn29Collapse">29. Nāgasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn29Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Nāgavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn29.1">sn29.1</a> Suddhikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn29.2">sn29.2</a> Paṇītatarasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn29.3">sn29.3</a> Uposathasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn29.4">sn29.4</a> Dutiyauposathasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn29.5">sn29.5</a> Tatiyauposathasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn29.6">sn29.6</a> Catutthauposathasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn29.7">sn29.7</a> Sutasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn29.8">sn29.8</a> Dutiyasutasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn29.9">sn29.9</a> Tatiyasutasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn29.10">sn29.10</a> Catutthasutasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn29.11-20">sn29.11-20</a> Aṇḍajadānūpakārasuttadasaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn29.21-50">sn29.21-50</a> Jalābujādidānūpakārasuttattiṁsaka</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn30Collapse">30. Supaṇṇasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn30Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Supaṇṇavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn30.1">sn30.1</a> Suddhikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn30.2">sn30.2</a> Harantisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn30.3">sn30.3</a> Dvayakārīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn30.4-6">sn30.4-6</a> Dutiyādidvayakārīsuttattika</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn30.7-16">sn30.7-16</a> Aṇḍajadānūpakārasuttadasaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn30.17-46">sn30.17-46</a> Jalābujadānūpakārasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn31Collapse">31. Gandhabbakāyasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn31Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Gandhabbavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn31.1">sn31.1</a> Suddhikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn31.2">sn31.2</a> Sucaritasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn31.3">sn31.3</a> Mūlagandhadātāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn31.4-12">sn31.4-12</a> Sāragandhādidātāsuttanavaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn31.13-22">sn31.13-22</a> Mūlagandhadānūpakārasuttadasaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn31.23-112">sn31.23-112</a> Sāragandhādidānūpakārasuttanavutika</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn32Collapse">32. Valāhakasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn32Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Valāhakavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn32.1">sn32.1</a> Suddhikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn32.2">sn32.2</a> Sucaritasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn32.3-12">sn32.3-12</a> Sītavalāhakadānūpakārasuttadasaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn32.13-52">sn32.13-52</a> Uṇhavalāhakadānūpakārasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn32.53">sn32.53</a> Sītavalāhakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn32.54">sn32.54</a> Uṇhavalāhakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn32.55">sn32.55</a> Abbhavalāhakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn32.56">sn32.56</a> Vātavalāhakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn32.57">sn32.57</a> Vassavalāhakasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn33Collapse">33. Vacchagottasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn33Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Vacchagottavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn33.1">sn33.1</a> Rūpaaññāṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn33.2">sn33.2</a> Vedanāaññāṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn33.3">sn33.3</a> Saññāaññāṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn33.4">sn33.4</a> Saṅkhāraaññāṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn33.5">sn33.5</a> Viññāṇaaññāṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn33.6-10">sn33.6-10</a> Rūpaadassanādisuttapañcaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn33.11-15">sn33.11-15</a> Rūpaanabhisamayādisuttapañcaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn33.16-20">sn33.16-20</a> Rūpaananubodhādisuttapañcaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn33.21-25">sn33.21-25</a> Rūpaappaṭivedhādisuttapañcaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn33.26-30">sn33.26-30</a> Rūpaasallakkhaṇādisuttapañcaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn33.31-35">sn33.31-35</a> Rūpaanupalakkhaṇādisuttapañcaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn33.36-40">sn33.36-40</a> Rūpaappaccupalakkhaṇādisuttapañcaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn33.41-45">sn33.41-45</a> Rūpaasamapekkhaṇādisuttapañcaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn33.46-50">sn33.46-50</a> Rūpaappaccupekkhaṇādisuttapañcaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn33.51-54">sn33.51-54</a> Rūpaappaccakkhakammādisuttacatukka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn33.55">sn33.55</a> Viññāṇaappaccakkhakammasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn34Collapse">34. Jhānasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn34Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Jhānavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.1">sn34.1</a> Samādhimūlakasamāpattisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.2">sn34.2</a> Samādhimūlakaṭhitisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.3">sn34.3</a> Samādhimūlakavuṭṭhānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.4">sn34.4</a> Samādhimūlakakallitasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.5">sn34.5</a> Samādhimūlakaārammaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.6">sn34.6</a> Samādhimūlakagocarasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.7">sn34.7</a> Samādhimūlakaabhinīhārasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.8">sn34.8</a> Samādhimūlakasakkaccakārīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.9">sn34.9</a> Samādhimūlakasātaccakārīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.10">sn34.10</a> Samādhimūlakasappāyakārīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.11">sn34.11</a> Samāpattimūlakaṭhitisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.12">sn34.12</a> Samāpattimūlakavuṭṭhānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.13">sn34.13</a> Samāpattimūlakakallitasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.14">sn34.14</a> Samāpattimūlakaārammaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.15">sn34.15</a> Samāpattimūlakagocarasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.16">sn34.16</a> Samāpattimūlakaabhinīhārasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.17">sn34.17</a> Samāpattimūlakasakkaccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.18">sn34.18</a> Samāpattimūlakasātaccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.19">sn34.19</a> Samāpattimūlakasappāyakārīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.20-27">sn34.20-27</a> Ṭhitimūlakavuṭṭhānasuttādiaṭṭhaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.28-34">sn34.28-34</a> Vuṭṭhānamūlakakallitasuttādisattaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.35-40">sn34.35-40</a> Kallitamūlakaārammaṇasuttādichakka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.41-45">sn34.41-45</a> Ārammaṇamūlakagocarasuttādipañcaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.46-49">sn34.46-49</a> Gocaramūlakaabhinīhārasuttādicatukka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.50-52">sn34.50-52</a> Abhinīhāramūlakasakkaccasuttāditika</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.53-54">sn34.53-54</a> Sakkaccamūlakasātaccakārīsuttadukādi</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn34.55">sn34.55</a> Sātaccamūlakasappāyakārīsutta</span>
 </div>
</div>
	 </div>
<div class="level2">
 <h3>Saḷāyatanavaggasaṁyuttapāḷi</h3>
</div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn35Collapse">35. Saḷāyatanasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn35Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Aniccavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.1">sn35.1</a> Ajjhattāniccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.2">sn35.2</a> Ajjhattadukkhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.3">sn35.3</a> Ajjhattānattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.4">sn35.4</a> Bāhirāniccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.5">sn35.5</a> Bāhiradukkhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.6">sn35.6</a> Bāhirānattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.7">sn35.7</a> Ajjhattāniccātītānāgatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.8">sn35.8</a> Ajjhattadukkhātītānāgatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.9">sn35.9</a> Ajjhattānattātītānāgatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.10">sn35.10</a> Bāhirāniccātītānāgatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.11">sn35.11</a> Bāhiradukkhātītānāgatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.12">sn35.12</a> Bāhirānattātītānāgatasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Yamakavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.13">sn35.13</a> Paṭhamapubbesambodhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.14">sn35.14</a> Dutiyapubbesambodhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.15">sn35.15</a> Paṭhamaassādapariyesanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.16">sn35.16</a> Dutiyaassādapariyesanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.17">sn35.17</a> Paṭhamanoceassādasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.18">sn35.18</a> Dutiyanoceassādasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.19">sn35.19</a> Paṭhamābhinandasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.20">sn35.20</a> Dutiyābhinandasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.21">sn35.21</a> Paṭhamadukkhuppādasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.22">sn35.22</a> Dutiyadukkhuppādasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Sabbavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.23">sn35.23</a> Sabbasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.24">sn35.24</a> Pahānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.25">sn35.25</a> Abhiññāpariññāpahānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.26">sn35.26</a> Paṭhamaaparijānanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.27">sn35.27</a> Dutiyaaparijānanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.28">sn35.28</a> Ādittasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.29">sn35.29</a> Addhabhūtasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.30">sn35.30</a> Samugghātasāruppasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.31">sn35.31</a> Paṭhamasamugghātasappāyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.32">sn35.32</a> Dutiyasamugghātasappāyasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>4. Jātidhammavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.33-42">sn35.33-42</a> Jātidhammādisuttadasaka</span>
 </div>
<div class="level4 my-3">
		 <h5>5. Sabbaaniccavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.43-51">sn35.43-51</a> Aniccādisuttanavaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.52">sn35.52</a> Upassaṭṭhasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>6. Avijjāvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.53">sn35.53</a> Avijjāpahānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.54">sn35.54</a> Saṁyojanappahānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.55">sn35.55</a> Saṁyojanasamugghātasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.56">sn35.56</a> Āsavapahānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.57">sn35.57</a> Āsavasamugghātasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.58">sn35.58</a> Anusayapahānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.59">sn35.59</a> Anusayasamugghātasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.60">sn35.60</a> Sabbupādānapariññāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.61">sn35.61</a> Paṭhamasabbupādānapariyādānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.62">sn35.62</a> Dutiyasabbupādānapariyādānasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>7. Migajālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.63">sn35.63</a> Paṭhamamigajālasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.64">sn35.64</a> Dutiyamigajālasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.65">sn35.65</a> Paṭhamasamiddhimārapañhāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.66">sn35.66</a> Samiddhisattapañhāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.67">sn35.67</a> Samiddhidukkhapañhāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.68">sn35.68</a> Samiddhilokapañhāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.69">sn35.69</a> Upasenaāsīvisasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.70">sn35.70</a> Upavāṇasandiṭṭhikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.71">sn35.71</a> Paṭhamachaphassāyatanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.72">sn35.72</a> Dutiyachaphassāyatanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.73">sn35.73</a> Tatiyachaphassāyatanasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>8. Gilānavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.74">sn35.74</a> Paṭhamagilānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.75">sn35.75</a> Dutiyagilānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.76">sn35.76</a> Rādhaaniccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.77">sn35.77</a> Rādhadukkhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.78">sn35.78</a> Rādhaanattasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.79">sn35.79</a> Paṭhamaavijjāpahānasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.80">sn35.80</a> Dutiyaavijjāpahānasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.81">sn35.81</a> Sambahulabhikkhusutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.82">sn35.82</a> Lokapañhāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.83">sn35.83</a> Phaggunapañhāsutta</span>
 </div>
<div class="level4 my-3">
		 <h5>9. Channavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.84">sn35.84</a> Palokadhammasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.85">sn35.85</a> Suññatalokasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.86">sn35.86</a> Saṅkhittadhammasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.87">sn35.87</a> Channasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.88">sn35.88</a> Puṇṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.89">sn35.89</a> Bāhiyasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.90">sn35.90</a> Paṭhamaejāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.91">sn35.91</a> Dutiyaejāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.92">sn35.92</a> Paṭhamadvayasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.93">sn35.93</a> Dutiyadvayasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>10. Saḷavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.94">sn35.94</a> Adantaaguttasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.95">sn35.95</a> Mālukyaputtasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.96">sn35.96</a> Parihānadhammasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.97">sn35.97</a> Pamādavihārīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.98">sn35.98</a> Saṁvarasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.99">sn35.99</a> Samādhisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.100">sn35.100</a> Paṭisallānasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.101">sn35.101</a> Paṭhamanatumhākasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.102">sn35.102</a> Dutiyanatumhākasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.103">sn35.103</a> Udakasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>11. Yogakkhemivagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.104">sn35.104</a> Yogakkhemisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.105">sn35.105</a> Upādāyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.106">sn35.106</a> Dukkhasamudayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.107">sn35.107</a> Lokasamudayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.108">sn35.108</a> Seyyohamasmisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.109">sn35.109</a> Saṁyojaniyasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.110">sn35.110</a> Upādāniyasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.111">sn35.111</a> Ajjhattikāyatanaparijānanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.112">sn35.112</a> Bāhirāyatanaparijānanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.113">sn35.113</a> Upassutisutta</span>
 </div>
<div class="level4 my-3">
		 <h5>12. Lokakāmaguṇavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.114">sn35.114</a> Paṭhamamārapāsasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.115">sn35.115</a> Dutiyamārapāsasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.116">sn35.116</a> Lokantagamanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.117">sn35.117</a> Kāmaguṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.118">sn35.118</a> Sakkapañhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.119">sn35.119</a> Pañcasikhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.120">sn35.120</a> Sāriputtasaddhivihārikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.121">sn35.121</a> Rāhulovādasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.122">sn35.122</a> Saṁyojaniyadhammasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.123">sn35.123</a> Upādāniyadhammasutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>13. Gahapativagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.124">sn35.124</a> Vesālīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.125">sn35.125</a> Vajjīsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.126">sn35.126</a> Nāḷandasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.127">sn35.127</a> Bhāradvājasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.128">sn35.128</a> Soṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.129">sn35.129</a> Ghositasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.130">sn35.130</a> Hāliddikānisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.131">sn35.131</a> Nakulapitusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.132">sn35.132</a> Lohiccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.133">sn35.133</a> Verahaccānisutta</span>
 </div>
<div class="level4 my-3">
		 <h5>14. Devadahavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.134">sn35.134</a> Devadahasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.135">sn35.135</a> Khaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.136">sn35.136</a> Paṭhamarūpārāmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.137">sn35.137</a> Dutiyarūpārāmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.138">sn35.138</a> Paṭhamanatumhākasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.139">sn35.139</a> Dutiyanatumhākasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.140">sn35.140</a> Ajjhattaaniccahetusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.141">sn35.141</a> Ajjhattadukkhahetusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.142">sn35.142</a> Ajjhattānattahetusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.143">sn35.143</a> Bāhirāniccahetusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.144">sn35.144</a> Bāhiradukkhahetusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.145">sn35.145</a> Bāhirānattahetusutta</span>
 </div>
<div class="level4 my-3">
		 <h5>15. Navapurāṇavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.146">sn35.146</a> Kammanirodhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.147">sn35.147</a> Aniccanibbānasappāyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.148">sn35.148</a> Dukkhanibbānasappāyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.149">sn35.149</a> Anattanibbānasappāyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.150">sn35.150</a> Nibbānasappāyapaṭipadāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.151">sn35.151</a> Antevāsikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.152">sn35.152</a> Kimatthiyabrahmacariyasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.153">sn35.153</a> Atthinukhopariyāyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.154">sn35.154</a> Indriyasampannasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.155">sn35.155</a> Dhammakathikapucchasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>16. Nandikkhayavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.156">sn35.156</a> Ajjhattanandikkhayasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.157">sn35.157</a> Bāhiranandikkhayasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.158">sn35.158</a> Ajjhattaaniccanandikkhayasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.159">sn35.159</a> Bāhiraaniccanandikkhayasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.160">sn35.160</a> Jīvakambavanasamādhisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.161">sn35.161</a> Jīvakambavanapaṭisallānasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.162">sn35.162</a> Koṭṭhikaaniccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.163">sn35.163</a> Koṭṭhikadukkhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.164">sn35.164</a> Koṭṭhikaanattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.165">sn35.165</a> Micchādiṭṭhipahānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.166">sn35.166</a> Sakkāyadiṭṭhipahānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.167">sn35.167</a> Attānudiṭṭhipahānasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>17. Saṭṭhipeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.168">sn35.168</a> Ajjhattaaniccachandasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.169">sn35.169</a> Ajjhattaaniccarāgasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.170">sn35.170</a> Ajjhattaaniccachandarāgasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.171-173">sn35.171-173</a> Dukkhachandādisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.174-176">sn35.174-176</a> Anattachandādisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.177-179">sn35.177-179</a> Bāhirāniccachandādisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.180-182">sn35.180-182</a> Bāhiradukkhachandādisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.183-185">sn35.183-185</a> Bāhirānattachandādisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.186">sn35.186</a> Ajjhattātītāniccasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.187">sn35.187</a> Ajjhattānāgatāniccasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.188">sn35.188</a> Ajjhattapaccuppannāniccasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.189-191">sn35.189-191</a> Ajjhattātītādidukkhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.192-194">sn35.192-194</a> Ajjhattātītādianattasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.195-197">sn35.195-197</a> Bāhirātītādianiccasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.198-200">sn35.198-200</a> Bāhirātītādidukkhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.201-203">sn35.201-203</a> Bāhirātītādianattasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.204">sn35.204</a> Ajjhattātītayadaniccasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.205">sn35.205</a> Ajjhattānāgatayadaniccasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.206">sn35.206</a> Ajjhattapaccuppannayadaniccasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.207-209">sn35.207-209</a> Ajjhattātītādiyaṁdukkhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.210-212">sn35.210-212</a> Ajjhattātītādiyadanattasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.213-215">sn35.213-215</a> Bāhirātītādiyadaniccasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.216-218">sn35.216-218</a> Bāhirātītādiyaṁdukkhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.219-221">sn35.219-221</a> Bāhirātītādiyadanattasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.222">sn35.222</a> Ajjhattāyatanaaniccasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.223">sn35.223</a> Ajjhattāyatanadukkhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.224">sn35.224</a> Ajjhattāyatanaanattasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.225">sn35.225</a> Bāhirāyatanaaniccasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.226">sn35.226</a> Bāhirāyatanadukkhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.227">sn35.227</a> Bāhirāyatanaanattasutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>18. Samuddavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.228">sn35.228</a> Paṭhamasamuddasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.229">sn35.229</a> Dutiyasamuddasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.230">sn35.230</a> Bāḷisikopamasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.231">sn35.231</a> Khīrarukkhopamasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.232">sn35.232</a> Koṭṭhikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.233">sn35.233</a> Kāmabhūsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.234">sn35.234</a> Udāyīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.235">sn35.235</a> Ādittapariyāyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.236">sn35.236</a> Paṭhamahatthapādopamasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.237">sn35.237</a> Dutiyahatthapādopamasutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>19. Āsīvisavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.238">sn35.238</a> Āsīvisopamasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.239">sn35.239</a> Rathopamasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.240">sn35.240</a> Kummopamasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.241">sn35.241</a> Paṭhamadārukkhandhopamasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.242">sn35.242</a> Dutiyadārukkhandhopamasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.243">sn35.243</a> Avassutapariyāyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.244">sn35.244</a> Dukkhadhammasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.245">sn35.245</a> Kiṁsukopamasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.246">sn35.246</a> Vīṇopamasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.247">sn35.247</a> Chappāṇakopamasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn35.248">sn35.248</a> Yavakalāpisutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn36Collapse">36. Vedanāsaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn36Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Sagāthāvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.1">sn36.1</a> Samādhisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.2">sn36.2</a> Sukhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.3">sn36.3</a> Pahānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.4">sn36.4</a> Pātālasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.5">sn36.5</a> Daṭṭhabbasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.6">sn36.6</a> Sallasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.7">sn36.7</a> Paṭhamagelaññasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.8">sn36.8</a> Dutiyagelaññasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.9">sn36.9</a> Aniccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.10">sn36.10</a> Phassamūlakasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Rahogatavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.11">sn36.11</a> Rahogatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.12">sn36.12</a> Paṭhamaākāsasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.13">sn36.13</a> Dutiyaākāsasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.14">sn36.14</a> Agārasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.15">sn36.15</a> Paṭhamaānandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.16">sn36.16</a> Dutiyaānandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.17">sn36.17</a> Paṭhamasambahulasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.18">sn36.18</a> Dutiyasambahulasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.19">sn36.19</a> Pañcakaṅgasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.20">sn36.20</a> Bhikkhusutta</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Aṭṭhasatapariyāyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.21">sn36.21</a> Sīvakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.22">sn36.22</a> Aṭṭhasatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.23">sn36.23</a> Aññatarabhikkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.24">sn36.24</a> Pubbasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.25">sn36.25</a> Ñāṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.26">sn36.26</a> Sambahulabhikkhusutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.27">sn36.27</a> Paṭhamasamaṇabrāhmaṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.28">sn36.28</a> Dutiyasamaṇabrāhmaṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.29">sn36.29</a> Tatiyasamaṇabrāhmaṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.30">sn36.30</a> Suddhikasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn36.31">sn36.31</a> Nirāmisasutta <?php echo $ifRuLitTrn;?></span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn37Collapse">37. Mātugāmasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn37Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Paṭhamapeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.1">sn37.1</a> Mātugāmasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.2">sn37.2</a> Purisasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.3">sn37.3</a> Āveṇikadukkhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.4">sn37.4</a> Tīhidhammehisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.5">sn37.5</a> Kodhanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.6">sn37.6</a> Upanāhīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.7">sn37.7</a> Issukīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.8">sn37.8</a> Maccharīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.9">sn37.9</a> Aticārīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.10">sn37.10</a> Dussīlasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.11">sn37.11</a> Appassutasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.12">sn37.12</a> Kusītasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.13">sn37.13</a> Muṭṭhassatisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.14">sn37.14</a> Pañcaverasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Dutiyapeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.15">sn37.15</a> Akkodhanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.16">sn37.16</a> Anupanāhīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.17">sn37.17</a> Anissukīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.18">sn37.18</a> Amaccharīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.19">sn37.19</a> Anaticārīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.20">sn37.20</a> Susīlasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.21">sn37.21</a> Bahussutasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.22">sn37.22</a> Āraddhavīriyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.23">sn37.23</a> Upaṭṭhitassatisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.24">sn37.24</a> Pañcasīlasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Balavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.25">sn37.25</a> Visāradasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.26">sn37.26</a> Pasayhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.27">sn37.27</a> Abhibhuyyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.28">sn37.28</a> Ekasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.29">sn37.29</a> Aṅgasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.30">sn37.30</a> Nāsentisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.31">sn37.31</a> Hetusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.32">sn37.32</a> Ṭhānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.33">sn37.33</a> Pañcasīlavisāradasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn37.34">sn37.34</a> Vaḍḍhīsutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn38Collapse">38. Jambukhādakasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn38Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Jambukhādakavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn38.1">sn38.1</a> Nibbānapañhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn38.2">sn38.2</a> Arahattapañhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn38.3">sn38.3</a> Dhammavādīpañhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn38.4">sn38.4</a> Kimatthiyasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn38.5">sn38.5</a> Assāsappattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn38.6">sn38.6</a> Paramassāsappattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn38.7">sn38.7</a> Vedanāpañhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn38.8">sn38.8</a> Āsavapañhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn38.9">sn38.9</a> Avijjāpañhāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn38.10">sn38.10</a> Taṇhāpañhāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn38.11">sn38.11</a> Oghapañhāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn38.12">sn38.12</a> Upādānapañhāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn38.13">sn38.13</a> Bhavapañhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn38.14">sn38.14</a> Dukkhapañhāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn38.15">sn38.15</a> Sakkāyapañhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn38.16">sn38.16</a> Dukkarapañhāsutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn39Collapse">39. Sāmaṇḍakasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn39Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Sāmaṇḍakavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn39.1-15">sn39.1-15</a> Sāmaṇḍakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn39.16">sn39.16</a> Dukkarasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn40Collapse">40. Moggallānasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn40Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Moggallānavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn40.1">sn40.1</a> Paṭhamajhānapañhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn40.2">sn40.2</a> Dutiyajhānapañhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn40.3">sn40.3</a> Tatiyajhānapañhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn40.4">sn40.4</a> Catutthajhānapañhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn40.5">sn40.5</a> Ākāsānañcāyatanapañhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn40.6">sn40.6</a> Viññāṇañcāyatanapañhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn40.7">sn40.7</a> Ākiñcaññāyatanapañhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn40.8">sn40.8</a> Nevasaññānāsaññāyatanapañhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn40.9">sn40.9</a> Animittapañhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn40.10">sn40.10</a> Sakkasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn40.11">sn40.11</a> Candanasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn41Collapse">41. Cittasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn41Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Cittavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn41.1">sn41.1</a> Saṁyojanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn41.2">sn41.2</a> Paṭhamaisidattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn41.3">sn41.3</a> Dutiyaisidattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn41.4">sn41.4</a> Mahakapāṭihāriyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn41.5">sn41.5</a> Paṭhamakāmabhūsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn41.6">sn41.6</a> Dutiyakāmabhūsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn41.7">sn41.7</a> Godattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn41.8">sn41.8</a> Nigaṇṭhanāṭaputtasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn41.9">sn41.9</a> Acelakassapasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn41.10">sn41.10</a> Gilānadassanasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn42Collapse">42. Gāmaṇisaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn42Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Gāmaṇivagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn42.1">sn42.1</a> Caṇḍasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn42.2">sn42.2</a> Tālapuṭasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn42.3">sn42.3</a> Yodhājīvasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn42.4">sn42.4</a> Hatthārohasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn42.5">sn42.5</a> Assārohasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn42.6">sn42.6</a> Asibandhakaputtasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn42.7">sn42.7</a> Khettūpamasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn42.8">sn42.8</a> Saṅkhadhamasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn42.9">sn42.9</a> Kulasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn42.10">sn42.10</a> Maṇicūḷakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn42.11">sn42.11</a> Bhadrakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn42.12">sn42.12</a> Rāsiyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn42.13">sn42.13</a> Pāṭaliyasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn43Collapse">43. Asaṅkhatasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn43Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Paṭhamavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn43.1">sn43.1</a> Kāyagatāsatisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn43.2">sn43.2</a> Samathavipassanāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn43.3">sn43.3</a> Savitakkasavicārasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn43.4">sn43.4</a> Suññatasamādhisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn43.5">sn43.5</a> Satipaṭṭhānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn43.6">sn43.6</a> Sammappadhānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn43.7">sn43.7</a> Iddhipādasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn43.8">sn43.8</a> Indriyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn43.9">sn43.9</a> Balasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn43.10">sn43.10</a> Bojjhaṅgasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn43.11">sn43.11</a> Maggaṅgasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Dutiyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn43.12">sn43.12</a> Asaṅkhatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn43.13">sn43.13</a> Anatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn43.14-43">sn43.14-43</a> Anāsavādisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn43.44">sn43.44</a> Parāyanasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn44Collapse">44. Abyākatasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn44Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Abyākatavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn44.1">sn44.1</a> Khemāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn44.2">sn44.2</a> Anurādhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn44.3">sn44.3</a> Paṭhamasāriputtakoṭṭhikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn44.4">sn44.4</a> Dutiyasāriputtakoṭṭhikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn44.5">sn44.5</a> Tatiyasāriputtakoṭṭhikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn44.6">sn44.6</a> Catutthasāriputtakoṭṭhikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn44.7">sn44.7</a> Moggallānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn44.8">sn44.8</a> Vacchagottasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn44.9">sn44.9</a> Kutūhalasālāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn44.10">sn44.10</a> Ānandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn44.11">sn44.11</a> Sabhiyakaccānasutta</span>
 </div>
</div>
	 </div>
<div class="level2">
 <h3>Mahāvaggasaṁyuttapāḷi</h3>
</div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn45Collapse">45. Maggasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn45Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Avijjāvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.1">sn45.1</a> Avijjāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.2">sn45.2</a> Upaḍḍhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.3">sn45.3</a> Sāriputtasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.4">sn45.4</a> Jāṇussoṇibrāhmaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.5">sn45.5</a> Kimatthiyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.6">sn45.6</a> Paṭhamaaññatarabhikkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.7">sn45.7</a> Dutiyaaññatarabhikkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.8">sn45.8</a> Vibhaṅgasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.9">sn45.9</a> Sūkasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.10">sn45.10</a> Nandiyasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Vihāravagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.11">sn45.11</a> Paṭhamavihārasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.12">sn45.12</a> Dutiyavihārasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.13">sn45.13</a> Sekkhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.14">sn45.14</a> Paṭhamauppādasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.15">sn45.15</a> Dutiyauppādasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.16">sn45.16</a> Paṭhamaparisuddhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.17">sn45.17</a> Dutiyaparisuddhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.18">sn45.18</a> Paṭhamakukkuṭārāmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.19">sn45.19</a> Dutiyakukkuṭārāmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.20">sn45.20</a> Tatiyakukkuṭārāmasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Micchattavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.21">sn45.21</a> Micchattasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.22">sn45.22</a> Akusaladhammasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.23">sn45.23</a> Paṭhamapaṭipadāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.24">sn45.24</a> Dutiyapaṭipadāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.25">sn45.25</a> Paṭhamaasappurisasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.26">sn45.26</a> Dutiyaasappurisasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.27">sn45.27</a> Kumbhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.28">sn45.28</a> Samādhisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.29">sn45.29</a> Vedanāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.30">sn45.30</a> Uttiyasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>4. Paṭipattivagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.31">sn45.31</a> Paṭhamapaṭipattisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.32">sn45.32</a> Dutiyapaṭipattisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.33">sn45.33</a> Viraddhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.34">sn45.34</a> Pāraṅgamasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.35">sn45.35</a> Paṭhamasāmaññasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.36">sn45.36</a> Dutiyasāmaññasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.37">sn45.37</a> Paṭhamabrahmaññasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.38">sn45.38</a> Dutiyabrahmaññasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.39">sn45.39</a> Paṭhamabrahmacariyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.40">sn45.40</a> Dutiyabrahmacariyasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>5. Aññatitthiyapeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.41">sn45.41</a> Rāgavirāgasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.42-47">sn45.42-47</a> Saṁyojanappahānādisuttachakka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.48">sn45.48</a> Anupādāparinibbānasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>6. Sūriyapeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.49">sn45.49</a> Kalyāṇamittasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.50-54">sn45.50-54</a> Sīlasampadādisuttapañcaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.55">sn45.55</a> Yonisomanasikārasampadāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.56">sn45.56</a> Dutiyakalyāṇamittasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.57-61">sn45.57-61</a> Dutiyasīlasampadādisuttapañcaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.62">sn45.62</a> Dutiyayonisomanasikārasampadāsutta</span>
 </div>
<div class="level4 my-3">
		 <h5>7. Ekadhammapeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.63">sn45.63</a> Kalyāṇamittasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.64-68">sn45.64-68</a> Sīlasampadādisuttapañcaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.69">sn45.69</a> Yonisomanasikārasampadāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.70">sn45.70</a> Dutiyakalyāṇamittasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.71-75">sn45.71-75</a> Dutiyasīlasampadādisuttapañcaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.76">sn45.76</a> Dutiyayonisomanasikārasampadāsutta</span>
 </div>
<div class="level4 my-3">
		 <h5>8. Dutiyaekadhammapeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.77">sn45.77</a> Kalyāṇamittasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.78-82">sn45.78-82</a> Sīlasampadādisuttapañcaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.83">sn45.83</a> Yonisomanasikārasampadāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.84">sn45.84</a> Dutiyakalyāṇamittasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.85-89">sn45.85-89</a> Dutiyasīlasampadādisuttapañcaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.90">sn45.90</a> Dutiyayonisomanasikārasampadāsutta</span>
 </div>
<div class="level4 my-3">
		 <h5>9. Gaṅgāpeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.91">sn45.91</a> Paṭhamapācīnaninnasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.92-95">sn45.92-95</a> Dutiyādipācīnaninnasuttacatukka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.96">sn45.96</a> Chaṭṭhapācīnaninnasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.97">sn45.97</a> Paṭhamasamuddaninnasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.98-102">sn45.98-102</a> Dutiyādisamuddaninnasuttapañcaka</span>
 </div>
<div class="level4 my-3">
		 <h5>10. Dutiyagaṅgāpeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.103">sn45.103</a> Paṭhamapācīnaninnasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.104-108">sn45.104-108</a> Dutiyādipācīnaninnasuttapañcaka</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.109">sn45.109</a> Paṭhamasamuddaninnasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.110-114">sn45.110-114</a> Dutiyādisamuddaninnasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.115">sn45.115</a> Paṭhamapācīnaninnasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.116-120">sn45.116-120</a> Dutiyādipācīnaninnasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.121">sn45.121</a> Paṭhamasamuddaninnasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.122-126">sn45.122-126</a> Dutiyādisamuddaninnasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.127">sn45.127</a> Paṭhamapācīnaninnasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.128-132">sn45.128-132</a> Dutiyādipācīnaninnasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.133">sn45.133</a> Paṭhamasamuddaninnasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.134-138">sn45.134-138</a> Dutiyādisamuddaninnasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>11. Appamādapeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.139">sn45.139</a> Tathāgatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.140">sn45.140</a> Padasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.141-145">sn45.141-145</a> Kūṭādisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.146-148">sn45.146-148</a> Candimādisutta</span>
 </div>
<div class="level4 my-3">
		 <h5>12. Balakaraṇīyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.149">sn45.149</a> Balasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.150">sn45.150</a> Bījasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.151">sn45.151</a> Nāgasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.152">sn45.152</a> Rukkhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.153">sn45.153</a> Kumbhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.154">sn45.154</a> Sūkasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.155">sn45.155</a> Ākāsasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.156">sn45.156</a> Paṭhamameghasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.157">sn45.157</a> Dutiyameghasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.158">sn45.158</a> Nāvāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.159">sn45.159</a> Āgantukasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.160">sn45.160</a> Nadīsutta</span>
 </div>
<div class="level4 my-3">
		 <h5>13. Esanāvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.161">sn45.161</a> Esanāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.162">sn45.162</a> Vidhāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.163">sn45.163</a> Āsavasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.164">sn45.164</a> Bhavasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.165">sn45.165</a> Dukkhatāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.166">sn45.166</a> Khilasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.167">sn45.167</a> Malasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.168">sn45.168</a> Nīghasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.169">sn45.169</a> Vedanāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.170">sn45.170</a> Taṇhāsutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>14. Oghavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.171">sn45.171</a> Oghasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.172">sn45.172</a> Yogasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.173">sn45.173</a> Upādānasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.174">sn45.174</a> Ganthasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.175">sn45.175</a> Anusayasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.176">sn45.176</a> Kāmaguṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.177">sn45.177</a> Nīvaraṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.178">sn45.178</a> Upādānakkhandhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.179">sn45.179</a> Orambhāgiyasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn45.180">sn45.180</a> Uddhambhāgiyasutta <?php echo $ifRuLitTrn;?></span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn46Collapse">46. Bojjhaṅgasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn46Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Pabbatavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.1">sn46.1</a> Himavantasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.2">sn46.2</a> Kāyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.3">sn46.3</a> Sīlasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.4">sn46.4</a> Vatthasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.5">sn46.5</a> Bhikkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.6">sn46.6</a> Kuṇḍaliyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.7">sn46.7</a> Kūṭāgārasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.8">sn46.8</a> Upavānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.9">sn46.9</a> Paṭhamauppannasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.10">sn46.10</a> Dutiyauppannasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Gilānavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.11">sn46.11</a> Pāṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.12">sn46.12</a> Paṭhamasūriyūpamasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.13">sn46.13</a> Dutiyasūriyūpamasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.14">sn46.14</a> Paṭhamagilānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.15">sn46.15</a> Dutiyagilānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.16">sn46.16</a> Tatiyagilānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.17">sn46.17</a> Pāraṅgamasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.18">sn46.18</a> Viraddhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.19">sn46.19</a> Ariyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.20">sn46.20</a> Nibbidāsutta</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Udāyivagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.21">sn46.21</a> Bodhāyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.22">sn46.22</a> Bojjhaṅgadesanāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.23">sn46.23</a> Ṭhāniyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.24">sn46.24</a> Ayonisomanasikārasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.25">sn46.25</a> Aparihāniyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.26">sn46.26</a> Taṇhakkhayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.27">sn46.27</a> Taṇhānirodhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.28">sn46.28</a> Nibbedhabhāgiyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.29">sn46.29</a> Ekadhammasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.30">sn46.30</a> Udāyisutta</span>
 </div>
<div class="level4 my-3">
		 <h5>4. Nīvaraṇavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.31">sn46.31</a> Paṭhamakusalasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.32">sn46.32</a> Dutiyakusalasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.33">sn46.33</a> Upakkilesasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.34">sn46.34</a> Anupakkilesasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.35">sn46.35</a> Ayonisomanasikārasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.36">sn46.36</a> Buddhisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.37">sn46.37</a> Āvaraṇanīvaraṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.38">sn46.38</a> Anīvaraṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.39">sn46.39</a> Rukkhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.40">sn46.40</a> Nīvaraṇasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>5. Cakkavattivagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.41">sn46.41</a> Vidhāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.42">sn46.42</a> Cakkavattisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.43">sn46.43</a> Mārasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.44">sn46.44</a> Duppaññasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.45">sn46.45</a> Paññavantasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.46">sn46.46</a> Daliddasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.47">sn46.47</a> Adaliddasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.48">sn46.48</a> Ādiccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.49">sn46.49</a> Ajjhattikaṅgasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.50">sn46.50</a> Bāhiraṅgasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>6. Sākacchavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.51">sn46.51</a> Āhārasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.52">sn46.52</a> Pariyāyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.53">sn46.53</a> Aggisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.54">sn46.54</a> Mettāsahagatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.55">sn46.55</a> Saṅgāravasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.56">sn46.56</a> Abhayasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>7. Ānāpānavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.57">sn46.57</a> Aṭṭhikamahapphalasutta
<?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.58">sn46.58</a> Puḷavakasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.59">sn46.59</a> Vinīlakasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.60">sn46.60</a> Vicchiddakasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.61">sn46.61</a> Uddhumātakasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.62">sn46.62</a> Mettāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.63">sn46.63</a> Karuṇāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.64">sn46.64</a> Muditāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.65">sn46.65</a> Upekkhāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.66">sn46.66</a> Ānāpānasutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>8. Nirodhavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.67">sn46.67</a> Asubhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.68">sn46.68</a> Maraṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.69">sn46.69</a> Āhārepaṭikūlasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.70">sn46.70</a> Anabhiratisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.71">sn46.71</a> Aniccasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.72">sn46.72</a> Dukkhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.73">sn46.73</a> Anattasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.74">sn46.74</a> Pahānasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.75">sn46.75</a> Virāgasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.76">sn46.76</a> Nirodhasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>9. Gaṅgāpeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.77-88">sn46.77-88</a> Gaṅgānadīādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>10. Appamādavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.89-98">sn46.89-98</a> Tathāgatādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>11. Balakaraṇīyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.99-110">sn46.99-110</a> Balādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>12. Esanāvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.111-120">sn46.111-120</a> Esanādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>13. Oghavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.121-129">sn46.121-129</a> Oghādisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.130">sn46.130</a> Uddhambhāgiyasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>14. Punagaṅgāpeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.131-142">sn46.131-142</a> Punagaṅgānadīādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>15. Punaappamādavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.143-152">sn46.143-152</a> Punatathāgatādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>16. Punabalakaraṇīyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.153-164">sn46.153-164</a> Punabalādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>17. Punaesanāvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.165-174">sn46.165-174</a> Punaesanādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>18. Punaoghavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn46.175-184">sn46.175-184</a> Punaoghādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn47Collapse">47. Satipaṭṭhānasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn47Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Ambapālivagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.1">sn47.1</a> Ambapālisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.2">sn47.2</a> Satisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.3">sn47.3</a> Bhikkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.4">sn47.4</a> Sālasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.5">sn47.5</a> Akusalarāsisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.6">sn47.6</a> Sakuṇagghisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.7">sn47.7</a> Makkaṭasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.8">sn47.8</a> Sūdasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.9">sn47.9</a> Gilānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.10">sn47.10</a> Bhikkhunupassayasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Nālandavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.11">sn47.11</a> Mahāpurisasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.12">sn47.12</a> Nālandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.13">sn47.13</a> Cundasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.14">sn47.14</a> Ukkacelasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.15">sn47.15</a> Bāhiyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.16">sn47.16</a> Uttiyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.17">sn47.17</a> Ariyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.18">sn47.18</a> Brahmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.19">sn47.19</a> Sedakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.20">sn47.20</a> Janapadakalyāṇīsutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>3. Sīlaṭṭhitivagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.21">sn47.21</a> Sīlasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.22">sn47.22</a> Ciraṭṭhitisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.23">sn47.23</a> Parihānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.24">sn47.24</a> Suddhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.25">sn47.25</a> Aññatarabrāhmaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.26">sn47.26</a> Padesasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.27">sn47.27</a> Samattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.28">sn47.28</a> Lokasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.29">sn47.29</a> Sirivaḍḍhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.30">sn47.30</a> Mānadinnasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>4. Ananussutavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.31">sn47.31</a> Ananussutasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.32">sn47.32</a> Virāgasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.33">sn47.33</a> Viraddhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.34">sn47.34</a> Bhāvitasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.35">sn47.35</a> Satisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.36">sn47.36</a> Aññāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.37">sn47.37</a> Chandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.38">sn47.38</a> Pariññātasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.39">sn47.39</a> Bhāvanāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.40">sn47.40</a> Vibhaṅgasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>5. Amatavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.41">sn47.41</a> Amatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.42">sn47.42</a> Samudayasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.43">sn47.43</a> Maggasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.44">sn47.44</a> Satisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.45">sn47.45</a> Kusalarāsisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.46">sn47.46</a> Pātimokkhasaṁvarasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.47">sn47.47</a> Duccaritasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.48">sn47.48</a> Mittasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.49">sn47.49</a> Vedanāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.50">sn47.50</a> Āsavasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>6. Gaṅgāpeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.51-62">sn47.51-62</a> Gaṅgānadīādisuttadvādasaka</span>
 </div>
<div class="level4 my-3">
		 <h5>7. Appamādavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.63-72">sn47.63-72</a> Tathāgatādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>8. Balakaraṇīyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.73-84">sn47.73-84</a> Balādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>9. Esanāvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.85-94">sn47.85-94</a> Esanādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>10. Oghavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn47.95-104">sn47.95-104</a> Uddhambhāgiyādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn48Collapse">48. Indriyasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn48Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Suddhikavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.1">sn48.1</a> Suddhikasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.2">sn48.2</a> Paṭhamasotāpannasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.3">sn48.3</a> Dutiyasotāpannasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.4">sn48.4</a> Paṭhamaarahantasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.5">sn48.5</a> Dutiyaarahantasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.6">sn48.6</a> Paṭhamasamaṇabrāhmaṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.7">sn48.7</a> Dutiyasamaṇabrāhmaṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.8">sn48.8</a> Daṭṭhabbasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.9">sn48.9</a> Paṭhamavibhaṅgasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.10">sn48.10</a> Dutiyavibhaṅgasutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>2. Mudutaravagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.11">sn48.11</a> Paṭilābhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.12">sn48.12</a> Paṭhamasaṅkhittasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.13">sn48.13</a> Dutiyasaṅkhittasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.14">sn48.14</a> Tatiyasaṅkhittasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.15">sn48.15</a> Paṭhamavitthārasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.16">sn48.16</a> Dutiyavitthārasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.17">sn48.17</a> Tatiyavitthārasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.18">sn48.18</a> Paṭipannasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.19">sn48.19</a> Sampannasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.20">sn48.20</a> Āsavakkhayasutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>3. Chaḷindriyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.21">sn48.21</a> Punabbhavasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.22">sn48.22</a> Jīvitindriyasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.23">sn48.23</a> Aññindriyasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.24">sn48.24</a> Ekabījīsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.25">sn48.25</a> Suddhakasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.26">sn48.26</a> Sotāpannasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.27">sn48.27</a> Arahantasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.28">sn48.28</a> Sambuddhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.29">sn48.29</a> Paṭhamasamaṇabrāhmaṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.30">sn48.30</a> Dutiyasamaṇabrāhmaṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>4. Sukhindriyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.31">sn48.31</a> Suddhikasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.32">sn48.32</a> Sotāpannasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.33">sn48.33</a> Arahantasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.34">sn48.34</a> Paṭhamasamaṇabrāhmaṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.35">sn48.35</a> Dutiyasamaṇabrāhmaṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.36">sn48.36</a> Paṭhamavibhaṅgasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.37">sn48.37</a> Dutiyavibhaṅgasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.38">sn48.38</a> Tatiyavibhaṅgasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.39">sn48.39</a> Kaṭṭhopamasutta<?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.40">sn48.40</a> Uppaṭipāṭikasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>5. Jarāvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.41">sn48.41</a> Jarādhammasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.42">sn48.42</a> Uṇṇābhabrāhmaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.43">sn48.43</a> Sāketasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.44">sn48.44</a> Pubbakoṭṭhakasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.45">sn48.45</a> Paṭhamapubbārāmasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.46">sn48.46</a> Dutiyapubbārāmasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.47">sn48.47</a> Tatiyapubbārāmasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.48">sn48.48</a> Catutthapubbārāmasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.49">sn48.49</a> Piṇḍolabhāradvājasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.50">sn48.50</a> Āpaṇasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>6. Sūkarakhatavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.51">sn48.51</a> Sālasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.52">sn48.52</a> Mallikasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.53">sn48.53</a> Sekhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.54">sn48.54</a> Padasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.55">sn48.55</a> Sārasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.56">sn48.56</a> Patiṭṭhitasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.57">sn48.57</a> Sahampatibrahmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.58">sn48.58</a> Sūkarakhatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.59">sn48.59</a> Paṭhamauppādasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.60">sn48.60</a> Dutiyauppādasutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>7. Bodhipakkhiyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.61">sn48.61</a> Saṁyojanasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.62">sn48.62</a> Anusayasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.63">sn48.63</a> Pariññāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.64">sn48.64</a> Āsavakkhayasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.65">sn48.65</a> Paṭhamaphalasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.66">sn48.66</a> Dutiyaphalasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.67">sn48.67</a> Paṭhamarukkhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.68">sn48.68</a> Dutiyarukkhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.69">sn48.69</a> Tatiyarukkhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.70">sn48.70</a> Catuttharukkhasutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>8. Gaṅgāpeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.71-82">sn48.71-82</a> Pācīnādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>9. Appamādavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.83-92">sn48.83-92</a> Appamādavagga <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>10. Balakaraṇīyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.93-104">sn48.93-104</a> Balakaraṇīyavagga <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>11. Esanāvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.105-114">sn48.105-114</a> Esanāvagga <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>12. Oghavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.115-124">sn48.115-124</a> Oghādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>13. Punagaṅgāpeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.125-136">sn48.125-136</a> Punapācīnādisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.137-146">sn48.137-146</a> Punaappamādavagga <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.147-158">sn48.147-158</a> Punabalakaraṇīyavagga <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>14. Punaesanāvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.159-168">sn48.159-168</a> Punaesanāvagga <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>15. Punaoghavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn48.169-178">sn48.169-178</a> punaoghādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn49Collapse">49. Sammappadhānasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn49Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Gaṅgāpeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn49.1-12">sn49.1-12</a> Pācīnādisutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Appamādavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn49.13-22">sn49.13-22</a> Appamādavagga</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Balakaraṇīyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn49.23-34">sn49.23-34</a> Balakaraṇīyādisutta</span>
 </div>
<div class="level4 my-3">
		 <h5>4. Esanāvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn49.35-44">sn49.35-44</a> Esanādisuttadasaka</span>
 </div>
<div class="level4 my-3">
		 <h5>5. Oghavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn49.45-54">sn49.45-54</a> Oghādisutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn50Collapse">50. Balasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn50Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Gaṅgāpeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn50.1-12">sn50.1-12</a> Balādisutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Appamādavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn50.13-22">sn50.13-22</a> Appamādavagga</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Balakaraṇīyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn50.23-34">sn50.23-34</a> Balakaraṇīyavagga</span>
 </div>
<div class="level4 my-3">
		 <h5>4. Esanāvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn50.35-44">sn50.35-44</a> Esanāvagga</span>
 </div>
<div class="level4 my-3">
		 <h5>5. Oghavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn50.45-54">sn50.45-54</a> Oghādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>6. Punagaṅgāpeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn50.55-66">sn50.55-66</a> Pācīnādisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn50.67-76">sn50.67-76</a> Punaappamādavagga</span>
 </div>
<div class="level4 my-3">
		 <h5>7. Punabalakaraṇīyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn50.77-88">sn50.77-88</a> Punabalakaraṇīyavagga</span>
 </div>
<div class="level4 my-3">
		 <h5>8. Punaesanāvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn50.89-98">sn50.89-98</a> Punaesanādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>9. Punaoghavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn50.99-108">sn50.99-108</a> Punaoghādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn51Collapse">51. Iddhipādasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn51Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Cāpālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.1">sn51.1</a> Apārasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.2">sn51.2</a> Viraddhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.3">sn51.3</a> Ariyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.4">sn51.4</a> Nibbidāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.5">sn51.5</a> Iddhipadesasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.6">sn51.6</a> Samattasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.7">sn51.7</a> Bhikkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.8">sn51.8</a> Buddhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.9">sn51.9</a> Ñāṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.10">sn51.10</a> Cetiyasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Pāsādakampanavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.11">sn51.11</a> Pubbasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.12">sn51.12</a> Mahapphalasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.13">sn51.13</a> Chandasamādhisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.14">sn51.14</a> Moggallānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.15">sn51.15</a> Uṇṇābhabrāhmaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.16">sn51.16</a> Paṭhamasamaṇabrāhmaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.17">sn51.17</a> Dutiyasamaṇabrāhmaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.18">sn51.18</a> Bhikkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.19">sn51.19</a> Iddhādidesanāsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.20">sn51.20</a> Vibhaṅgasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Ayoguḷavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.21">sn51.21</a> Maggasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.22">sn51.22</a> Ayoguḷasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.23">sn51.23</a> Bhikkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.24">sn51.24</a> Suddhikasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.25">sn51.25</a> Paṭhamaphalasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.26">sn51.26</a> Dutiyaphalasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.27">sn51.27</a> Paṭhamaānandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.28">sn51.28</a> Dutiyaānandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.29">sn51.29</a> Paṭhamabhikkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.30">sn51.30</a> Dutiyabhikkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.31">sn51.31</a> Moggallānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.32">sn51.32</a> Tathāgatasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>4. Gaṅgāpeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.33-44">sn51.33-44</a> Gaṅgānadīādisutta</span>
 </div>
<div class="level4 my-3">
		 <h5>5. Appamādavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.45-54">sn51.45-54</a> Appamādavagga <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>6. Balakaraṇīyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.55-66">sn51.55-66</a> Balakaraṇīyavagga <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>7. Esanāvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.67-76">sn51.67-76</a> Esanāvagga <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>8. Oghavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn51.77-86">sn51.77-86</a> Oghādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn52Collapse">52. Anuruddhasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn52Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Rahogatavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.1">sn52.1</a> Paṭhamarahogatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.2">sn52.2</a> Dutiyarahogatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.3">sn52.3</a> Sutanusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.4">sn52.4</a> Paṭhamakaṇḍakīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.5">sn52.5</a> Dutiyakaṇḍakīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.6">sn52.6</a> Tatiyakaṇḍakīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.7">sn52.7</a> Taṇhākkhayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.8">sn52.8</a> Salaḷāgārasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.9">sn52.9</a> Ambapālivanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.10">sn52.10</a> Bāḷhagilānasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Dutiyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.11">sn52.11</a> Kappasahassasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.12">sn52.12</a> Iddhividhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.13">sn52.13</a> Dibbasotasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.14">sn52.14</a> Cetopariyasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.15">sn52.15</a> Ṭhānasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.16">sn52.16</a> Kammasamādānasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.17">sn52.17</a> Sabbatthagāminisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.18">sn52.18</a> Nānādhātusutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.19">sn52.19</a> Nānādhimuttisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.20">sn52.20</a> Indriyaparopariyattasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.21">sn52.21</a> Jhānādisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.22">sn52.22</a> Pubbenivāsasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.23">sn52.23</a> Dibbacakkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn52.24">sn52.24</a> Āsavakkhayasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn53Collapse">53. Jhānasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn53Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Gaṅgāpeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn53.1-12">sn53.1-12</a> Jhānādisutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Appamādavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn53.13-22">sn53.13-22</a> Appamādavagga</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Balakaraṇīyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn53.23-34">sn53.23-34</a> Balakaraṇīyavagga</span>
 </div>
<div class="level4 my-3">
		 <h5>4. Esanāvagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn53.35-44">sn53.35-44</a> Esanāvagga</span>
 </div>
<div class="level4 my-3">
		 <h5>5. Oghavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn53.45-54">sn53.45-54</a> Oghādisutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn54Collapse">54. Ānāpānasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn54Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Ekadhammavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn54.1">sn54.1</a> Ekadhammasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn54.2">sn54.2</a> Bojjhaṅgasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn54.3">sn54.3</a> Suddhikasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn54.4">sn54.4</a> Paṭhamaphalasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn54.5">sn54.5</a> Dutiyaphalasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn54.6">sn54.6</a> Ariṭṭhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn54.7">sn54.7</a> Mahākappinasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn54.8">sn54.8</a> Padīpopamasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn54.9">sn54.9</a> Vesālīsutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn54.10">sn54.10</a> Kimilasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Dutiyavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn54.11">sn54.11</a> Icchānaṅgalasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn54.12">sn54.12</a> Kaṅkheyyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn54.13">sn54.13</a> Paṭhamaānandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn54.14">sn54.14</a> Dutiyaānandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn54.15">sn54.15</a> Paṭhamabhikkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn54.16">sn54.16</a> Dutiyabhikkhusutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn54.17">sn54.17</a> Saṁyojanappahānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn54.18">sn54.18</a> Anusayasamugghātasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn54.19">sn54.19</a> Addhānapariññāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn54.20">sn54.20</a> Āsavakkhayasutta</span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn55Collapse">55. Sotāpattisaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn55Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Veḷudvāravagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.1">sn55.1</a> Cakkavattirājasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.2">sn55.2</a> Brahmacariyogadhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.3">sn55.3</a> Dīghāvuupāsakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.4">sn55.4</a> Paṭhamasāriputtasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.5">sn55.5</a> Dutiyasāriputtasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.6">sn55.6</a> Thapatisutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.7">sn55.7</a> Veḷudvāreyyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.8">sn55.8</a> Paṭhamagiñjakāvasathasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.9">sn55.9</a> Dutiyagiñjakāvasathasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.10">sn55.10</a> Tatiyagiñjakāvasathasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>2. Rājakārāmavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.11">sn55.11</a> Sahassabhikkhunisaṅghasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.12">sn55.12</a> Brāhmaṇasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.13">sn55.13</a> Ānandattherasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.14">sn55.14</a> Duggatibhayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.15">sn55.15</a> Duggativinipātabhayasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.16">sn55.16</a> Paṭhamamittāmaccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.17">sn55.17</a> Dutiyamittāmaccasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.18">sn55.18</a> Paṭhamadevacārikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.19">sn55.19</a> Dutiyadevacārikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.20">sn55.20</a> Tatiyadevacārikasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>3. Saraṇānivagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.21">sn55.21</a> Paṭhamamahānāmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.22">sn55.22</a> Dutiyamahānāmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.23">sn55.23</a> Godhasakkasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.24">sn55.24</a> Paṭhamasaraṇānisakkasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.25">sn55.25</a> Dutiyasaraṇānisakkasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.26">sn55.26</a> Paṭhamaanāthapiṇḍikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.27">sn55.27</a> Dutiyaanāthapiṇḍikasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.28">sn55.28</a> Paṭhamabhayaverūpasantasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.29">sn55.29</a> Dutiyabhayaverūpasantasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.30">sn55.30</a> Nandakalicchavisutta</span>
 </div>
<div class="level4 my-3">
		 <h5>4. Puññābhisandavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.31">sn55.31</a> Paṭhamapuññābhisandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.32">sn55.32</a> Dutiyapuññābhisandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.33">sn55.33</a> Tatiyapuññābhisandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.34">sn55.34</a> Paṭhamadevapadasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.35">sn55.35</a> Dutiyadevapadasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.36">sn55.36</a> Devasabhāgatasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.37">sn55.37</a> Mahānāmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.38">sn55.38</a> Vassasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.39">sn55.39</a> Kāḷigodhasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.40">sn55.40</a> Nandiyasakkasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>5. Sagāthakapuññābhisandavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.41">sn55.41</a> Paṭhamaabhisandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.42">sn55.42</a> Dutiyaabhisandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.43">sn55.43</a> Tatiyaabhisandasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.44">sn55.44</a> Paṭhamamahaddhanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.45">sn55.45</a> Dutiyamahaddhanasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.46">sn55.46</a> Suddhakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.47">sn55.47</a> Nandiyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.48">sn55.48</a> Bhaddiyasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.49">sn55.49</a> Mahānāmasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.50">sn55.50</a> Aṅgasutta</span>
 </div>
<div class="level4 my-3">
		 <h5>6. Sappaññavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.51">sn55.51</a> Sagāthakasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.52">sn55.52</a> Vassaṁvutthasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.53">sn55.53</a> Dhammadinnasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.54">sn55.54</a> Gilānasutta</span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.55">sn55.55</a> Sotāpattiphalasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.56">sn55.56</a> Sakadāgāmiphalasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.57">sn55.57</a> Anāgāmiphalasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.58">sn55.58</a> Arahattaphalasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.59">sn55.59</a> Paññāpaṭilābhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.60">sn55.60</a> Paññāvuddhisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.61">sn55.61</a> Paññāvepullasutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>7. Mahāpaññavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.62">sn55.62</a> Mahāpaññāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.63">sn55.63</a> Puthupaññāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.64">sn55.64</a> Vipulapaññāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.65">sn55.65</a> Gambhīrapaññāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.66">sn55.66</a> Appamattapaññāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.67">sn55.67</a> Bhūripaññāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.68">sn55.68</a> Paññābāhullasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.69">sn55.69</a> Sīghapaññāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.70">sn55.70</a> Lahupaññāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.71">sn55.71</a> Hāsapaññāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.72">sn55.72</a> Javanapaññāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.73">sn55.73</a> Tikkhapaññāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn55.74">sn55.74</a> Nibbedhikapaññāsutta <?php echo $ifRuLitTrn;?></span>
 </div>
</div>
	 </div>
<div class="level3">
	 <h4><a href=# data-bs-toggle="collapse" data-bs-target="#sn56Collapse">56. Saccasaṁyuttaṁ</a></h4>
	 </div>
	 <div class="collapse" id="sn56Collapse">
	 <div class="my-3">
<div class="level4 my-3">
		 <h5>1. Samādhivagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.1">sn56.1</a> Samādhisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.2">sn56.2</a> Paṭisallānasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.3">sn56.3</a> Paṭhamakulaputtasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.4">sn56.4</a> Dutiyakulaputtasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.5">sn56.5</a> Paṭhamasamaṇabrāhmaṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.6">sn56.6</a> Dutiyasamaṇabrāhmaṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.7">sn56.7</a> Vitakkasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.8">sn56.8</a> Cintasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.9">sn56.9</a> Viggāhikakathāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.10">sn56.10</a> Tiracchānakathāsutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>2. Dhammacakkappavattanavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.11">sn56.11</a> Dhammacakkappavattanasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.12">sn56.12</a> Tathāgatasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.13">sn56.13</a> Khandhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.14">sn56.14</a> Ajjhattikāyatanasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.15">sn56.15</a> Paṭhamadhāraṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.16">sn56.16</a> Dutiyadhāraṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.17">sn56.17</a> Avijjāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.18">sn56.18</a> Vijjāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.19">sn56.19</a> Saṅkāsanasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.20">sn56.20</a> Tathasutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>3. Koṭigāmavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.21">sn56.21</a> Paṭhamakoṭigāmasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.22">sn56.22</a> Dutiyakoṭigāmasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.23">sn56.23</a> Sammāsambuddhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.24">sn56.24</a> Arahantasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.25">sn56.25</a> Āsavakkhayasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.26">sn56.26</a> Mittasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.27">sn56.27</a> Tathasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.28">sn56.28</a> Lokasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.29">sn56.29</a> Pariññeyyasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.30">sn56.30</a> Gavampatisutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>4. Sīsapāvanavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.31">sn56.31</a> Sīsapāvanasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.32">sn56.32</a> Khadirapattasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.33">sn56.33</a> Daṇḍasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.34">sn56.34</a> Celasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.35">sn56.35</a> Sattisatasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.36">sn56.36</a> Pāṇasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.37">sn56.37</a> Paṭhamasūriyasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.38">sn56.38</a> Dutiyasūriyasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.39">sn56.39</a> Indakhīlasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.40">sn56.40</a> Vādatthikasutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>5. Papātavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.41">sn56.41</a> Lokacintāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.42">sn56.42</a> Papātasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.43">sn56.43</a> Mahāpariḷāhasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.44">sn56.44</a> Kūṭāgārasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.45">sn56.45</a> Vālasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.46">sn56.46</a> Andhakārasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.47">sn56.47</a> Paṭhamachiggaḷayugasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.48">sn56.48</a> Dutiyachiggaḷayugasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.49">sn56.49</a> Paṭhamasinerupabbatarājasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.50">sn56.50</a> Dutiyasinerupabbatarājasutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>6. Abhisamayavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.51">sn56.51</a> Nakhasikhāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.52">sn56.52</a> Pokkharaṇīsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.53">sn56.53</a> Paṭhamasambhejjasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.54">sn56.54</a> Dutiyasambhejjasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.55">sn56.55</a> Paṭhamamahāpathavīsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.56">sn56.56</a> Dutiyamahāpathavīsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.57">sn56.57</a> Paṭhamamahāsamuddasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.58">sn56.58</a> Dutiyamahāsamuddasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.59">sn56.59</a> Paṭhamapabbatūpamasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.60">sn56.60</a> Dutiyapabbatūpamasutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>7. Paṭhamaāmakadhaññapeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.61">sn56.61</a> Aññatrasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.62">sn56.62</a> Paccantasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.63">sn56.63</a> Paññāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.64">sn56.64</a> Surāmerayasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.65">sn56.65</a> Odakasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.66">sn56.66</a> Matteyyasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.67">sn56.67</a> Petteyyasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.68">sn56.68</a> Sāmaññasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.69">sn56.69</a> Brahmaññasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.70">sn56.70</a> Pacāyikasutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>8. Dutiyaāmakadhaññapeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.71">sn56.71</a> Pāṇātipātasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.72">sn56.72</a> Adinnādānasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.73">sn56.73</a> Kāmesumicchācārasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.74">sn56.74</a> Musāvādasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.75">sn56.75</a> Pesuññasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.76">sn56.76</a> Pharusavācāsutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.77">sn56.77</a> Samphappalāpasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.78">sn56.78</a> Bījagāmasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.79">sn56.79</a> Vikālabhojanasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.80">sn56.80</a> Gandhavilepanasutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>9. Tatiyaāmakadhaññapeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.81">sn56.81</a> Naccagītasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.82">sn56.82</a> Uccāsayanasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.83">sn56.83</a> Jātarūparajatasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.84">sn56.84</a> Āmakadhaññasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.85">sn56.85</a> Āmakamaṁsasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.86">sn56.86</a> Kumārikasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.87">sn56.87</a> Dāsidāsasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.88">sn56.88</a> Ajeḷakasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.89">sn56.89</a> Kukkuṭasūkarasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.90">sn56.90</a> Hatthigavassasutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>10. Catutthaāmakadhaññapeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.91">sn56.91</a> Khettavatthusutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.92">sn56.92</a> Kayavikkayasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.93">sn56.93</a> Dūteyyasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.94">sn56.94</a> Tulākūṭasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.95">sn56.95</a> Ukkoṭanasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.96-101">sn56.96-101</a> Chedanādisutta <?php echo $ifRuLitTrn;?></span>
 </div>
<div class="level4 my-3">
		 <h5>11. Pañcagatipeyyālavagga</h5>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.102">sn56.102</a> Manussacutinirayasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.103">sn56.103</a> Manussacutitiracchānasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.104">sn56.104</a> Manussacutipettivisayasutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.105-107">sn56.105-107</a> Manussacutidevanirayādisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.108-110">sn56.108-110</a> Devacutinirayādisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.111-113">sn56.111-113</a> Devamanussanirayādisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.114-116">sn56.114-116</a> Nirayamanussanirayādisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.117-119">sn56.117-119</a> Nirayadevanirayādisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.120-122">sn56.120-122</a> Tiracchānamanussanirayādisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.123-125">sn56.123-125</a> Tiracchānadevanirayādisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.126-128">sn56.126-128</a> Pettimanussanirayādisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.129-130">sn56.129-130</a> Pettidevanirayādisutta <?php echo $ifRuLitTrn;?></span>
 </div>

		 
		 <div class="mt-3">
 <span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=sn56.131">sn56.131</a> Pettidevapettivisayasutta <?php echo $ifRuLitTrn;?></span>
 </div>
</div>
	 </div>
</div>
</div>
<div class="my-2">
 <div class="level1">
 <h2><a href=# data-bs-toggle="collapse"
 data-bs-target="#anCollapse">Aṅguttara Nikāya</a></h2>
 </div>
	 <div class="collapse right-text reverse-order" id="anCollapse">
<div class="level2">
	 <h3><a href=# data-bs-toggle="collapse" data-bs-target="#an1Collapse">1. Ekakanipāta </a></h3>
	 </div> 
	 <div class="collapse" id="an1Collapse">
	 <div class="my-3">
<div class="my-3">
<div class="level4 my-3">
		 <h5>1. Rūpādivagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.1-10">an1.1-10</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>2. Nīvaraṇappahānavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.11-20">an1.11-20</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>3. Akammaniyavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.21-30">an1.21-30</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>4. Adantavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.31-40">an1.31-40</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>5. Paṇihitaacchavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.41-50">an1.41-50</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>6. Accharāsaṅghātavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.51-60">an1.51-60</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>7. Vīriyārambhādivagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.61-70">an1.61-70</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>8. Kalyāṇamittādivagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.71-81">an1.71-81</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>9. Pamādādivagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.82-97">an1.82-97</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>10. Dutiyapamādādivagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.98-139">an1.98-139</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>11. Adhammavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.140-149">an1.140-149</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>12. Anāpattivagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.150-169">an1.150-169</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>13. Ekapuggalavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.170-187">an1.170-187</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>14. Paṭhamavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.188-197">an1.188-197</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>15. Dutiyavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.198-208">an1.198-208</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>16. Tatiyavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.209-218">an1.209-218</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>17. Catutthavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.219-234">an1.219-234</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>18. Pañcamavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.235-247">an1.235-247</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>19. Chaṭṭhavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.248-257">an1.248-257</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>20. Sattamavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.258-267">an1.258-267</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>21. Paṭhamavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.268-277">an1.268-277</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>22. Dutiyavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.278-286">an1.278-286</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>23. Tatiyavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.287-295">an1.287-295</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>24. Paṭhamavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.296-305">an1.296-305</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>25. Dutiyavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.306-315">an1.306-315</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>26. Tatiyavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.316-332">an1.316-332</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>27. Catutthavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.333-377">an1.333-377</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>28. Pasādakaradhammavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.378-393">an1.378-393</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>29. Aparaaccharāsaṅghātavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.394-574">an1.394-574</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>30. Kāyagatāsativagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.575-615">an1.575-615</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>31. Amatavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an1.616-627">an1.616-627</a> </span>
</div>
 
</div> <!-- my-3 inside nipata collapse close prev my div -->
</div> <!-- nipata collapse close prev nipata div -->
</div> <!-- nipata collapse close prev nipata div -->
<div class="level2">
	 <h3><a href=# data-bs-toggle="collapse" data-bs-target="#an2Collapse">2. Dukanipāta</a></h3>
	 </div> 
	 <div class="collapse" id="an2Collapse">
	 <div class="my-3">
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>1. Kammakaraṇavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an2.1-10">an2.1-10</a> 1. Vajjasutta
 2. Padhānasutta
 3. Tapanīyasutta
 4. Atapanīyasutta
 5. Upaññātasutta
 6. Saṁyojanasutta
 7. Kaṇhasutta
 8. Sukkasutta
 9. Cariyasutta
 10. Vassūpanāyikasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>2. Adhikaraṇavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an2.11-20">an2.11-20</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>3. Bālavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an2.21-31">an2.21-31</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>4. Samacittavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an2.32-41">an2.32-41</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>5. Parisavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an2.42-51">an2.42-51</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>6. Puggalavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an2.52-63">an2.52-63</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>7. Sukhavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an2.64-76">an2.64-76</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>8. Sanimittavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an2.77-86">an2.77-86</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>9. Dhammavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an2.87-97">an2.87-97</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>10. Bālavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an2.98-117">an2.98-117</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>11. Āsāduppajahavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an2.118-129">an2.118-129</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>12. Āyācanavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an2.130-140">an2.130-140</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>13. Dānavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an2.141-150">an2.141-150</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>14. Santhāravagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an2.151-162">an2.151-162</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>15. Samāpattivagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an2.163-179">an2.163-179</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5></h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an2.180-229">an2.180-229</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an2.230-279">an2.230-279</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an2.280-309">an2.280-309</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an2.310-479">an2.310-479</a> </span>
</div>
 
</div> <!-- my-3 inside nipata collapse close prev my div -->
</div> <!-- nipata collapse close prev nipata div -->

<div class="level2">
	 <h3><a href=# data-bs-toggle="collapse" data-bs-target="#an3Collapse">3. Tikanipāta</a></h3>
	 </div> 
	 <div class="collapse" id="an3Collapse">
	 <div class="my-3">
<div class="my-3">
<div class="level4 my-3">
		 <h5>1. Bālavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.1">an3.1</a> Bhayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.2">an3.2</a> Lakkhaṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.3">an3.3</a> Cintīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.4">an3.4</a> Accayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.5">an3.5</a> Ayonisosutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.6">an3.6</a> Akusalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.7">an3.7</a> Sāvajjasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.8">an3.8</a> Sabyābajjhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.9">an3.9</a> Khatasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.10">an3.10</a> Malasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>2. Rathakāravagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.11">an3.11</a> Ñātasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.12">an3.12</a> Sāraṇīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.13">an3.13</a> Āsaṁsasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.14">an3.14</a> Cakkavattisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.15">an3.15</a> Sacetanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.16">an3.16</a> Apaṇṇakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.17">an3.17</a> Attabyābādhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.18">an3.18</a> Devalokasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.19">an3.19</a> Paṭhamapāpaṇikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.20">an3.20</a> Dutiyapāpaṇikasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>3. Puggalavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.21">an3.21</a> Samiddhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.22">an3.22</a> Gilānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.23">an3.23</a> Saṅkhārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.24">an3.24</a> Bahukārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.25">an3.25</a> Vajirūpamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.26">an3.26</a> Sevitabbasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.27">an3.27</a> Jigucchitabbasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.28">an3.28</a> Gūthabhāṇīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.29">an3.29</a> Andhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.30">an3.30</a> Avakujjasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>4. Devadūtavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.31">an3.31</a> Sabrahmakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.32">an3.32</a> Ānandasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.33">an3.33</a> Sāriputtasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.34">an3.34</a> Nidānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.35">an3.35</a> Hatthakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.36">an3.36</a> Devadūtasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.37">an3.37</a> Catumahārājasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.38">an3.38</a> Dutiyacatumahārājasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.39">an3.39</a> Sukhumālasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.40">an3.40</a> Ādhipateyyasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>5. Cūḷavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.41">an3.41</a> Sammukhībhāvasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.42">an3.42</a> Tiṭhānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.43">an3.43</a> Atthavasasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.44">an3.44</a> Kathāpavattisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.45">an3.45</a> Paṇḍitasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.46">an3.46</a> Sīlavantasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.47">an3.47</a> Saṅkhatalakkhaṇasutta
 Asaṅkhatalakkhaṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.48">an3.48</a> Pabbatarājasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.49">an3.49</a> Ātappakaraṇīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.50">an3.50</a> Mahācorasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>6. Brāhmaṇavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.51">an3.51</a> Paṭhamadvebrāhmaṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.52">an3.52</a> Dutiyadvebrāhmaṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.53">an3.53</a> Aññatarabrāhmaṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.54">an3.54</a> Paribbājakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.55">an3.55</a> Nibbutasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.56">an3.56</a> Palokasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.57">an3.57</a> Vacchagottasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.58">an3.58</a> Tikaṇṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.59">an3.59</a> Jāṇussoṇisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.60">an3.60</a> Saṅgāravasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>7. Mahāvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.61">an3.61</a> Titthāyatanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.62">an3.62</a> Bhayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.63">an3.63</a> Venāgapurasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.64">an3.64</a> Sarabhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.65">an3.65</a> Kesamuttisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.66">an3.66</a> Sāḷhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.67">an3.67</a> Kathāvatthusutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.68">an3.68</a> Aññatitthiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.69">an3.69</a> Akusalamūlasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.70">an3.70</a> Uposathasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>8. Ānandavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.71">an3.71</a> Channasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.72">an3.72</a> Ājīvakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.73">an3.73</a> Mahānāmasakkasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.74">an3.74</a> Nigaṇṭhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.75">an3.75</a> Nivesakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.76">an3.76</a> Paṭhamabhavasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.77">an3.77</a> Dutiyabhavasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.78">an3.78</a> Sīlabbatasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.79">an3.79</a> Gandhajātasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.80">an3.80</a> Cūḷanikāsutta <?php echo $ifRuLitTrn;?></span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>9. Samaṇavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.81">an3.81</a> Samaṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.82">an3.82</a> Gadrabhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.83">an3.83</a> Khettasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.84">an3.84</a> Vajjiputtasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.85">an3.85</a> Sekkhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.86">an3.86</a> Paṭhamasikkhāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.87">an3.87</a> Dutiyasikkhāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.88">an3.88</a> Tatiyasikkhāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.89">an3.89</a> Paṭhamasikkhattayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.90">an3.90</a> Dutiyasikkhattayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.91">an3.91</a> Saṅkavāsutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>10. Loṇakapallavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.92">an3.92</a> Accāyikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.93">an3.93</a> Pavivekasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.94">an3.94</a> Saradasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.95">an3.95</a> Parisāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.96">an3.96</a> Paṭhamaājānīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.97">an3.97</a> Dutiyaājānīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.98">an3.98</a> Tatiyaājānīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.99">an3.99</a> Potthakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.100">an3.100</a> Loṇakapallasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.101">an3.101</a> Paṁsudhovakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.102">an3.102</a> Nimittasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>11. Sambodhavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.103">an3.103</a> Pubbevasambodhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.104">an3.104</a> Paṭhamaassādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.105">an3.105</a> Dutiyaassādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.106">an3.106</a> Samaṇabrāhmaṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.107">an3.107</a> Ruṇṇasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.108">an3.108</a> Atittisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.109">an3.109</a> Arakkhitasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.110">an3.110</a> Byāpannasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.111">an3.111</a> Paṭhamanidānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.112">an3.112</a> Dutiyanidānasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>12. Āpāyikavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.113">an3.113</a> Āpāyikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.114">an3.114</a> Dullabhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.115">an3.115</a> Appameyyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.116">an3.116</a> Āneñjasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.117">an3.117</a> Vipattisampadāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.118">an3.118</a> Apaṇṇakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.119">an3.119</a> Kammantasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.120">an3.120</a> Paṭhamasoceyyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.121">an3.121</a> Dutiyasoceyyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.122">an3.122</a> Moneyyasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>13. Kusināravagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.123">an3.123</a> Kusinārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.124">an3.124</a> Bhaṇḍanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.125">an3.125</a> Gotamakacetiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.126">an3.126</a> Bharaṇḍukālāmasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.127">an3.127</a> Hatthakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.128">an3.128</a> Kaṭuviyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.129">an3.129</a> Paṭhamaanuruddhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.130">an3.130</a> Dutiyaanuruddhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.131">an3.131</a> Paṭicchannasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.132">an3.132</a> Lekhasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>14. Yodhājīvavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.133">an3.133</a> Yodhājīvasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.134">an3.134</a> Parisāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.135">an3.135</a> Mittasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.136">an3.136</a> Uppādāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.137">an3.137</a> Kesakambalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.138">an3.138</a> Sampadāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.139">an3.139</a> Vuddhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.140">an3.140</a> Assakhaḷuṅkasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.141">an3.141</a> Assaparassasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.142">an3.142</a> Assājānīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.143">an3.143</a> Paṭhamamoranivāpasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.144">an3.144</a> Dutiyamoranivāpasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.145">an3.145</a> Tatiyamoranivāpasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>15. Maṅgalavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.146">an3.146</a> Akusalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.147">an3.147</a> Sāvajjasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.148">an3.148</a> Visamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.149">an3.149</a> Asucisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.150">an3.150</a> Paṭhamakhatasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.151">an3.151</a> Dutiyakhatasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.152">an3.152</a> Tatiyakhatasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.153">an3.153</a> Catutthakhatasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.154">an3.154</a> Vandanāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.155">an3.155</a> Pubbaṇhasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>16. Acelakavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.156-162">an3.156-162</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5></h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.163-182">an3.163-182</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an3.183-352">an3.183-352</a> </span>
</div>
 
</div> <!-- my-3 inside nipata collapse close prev my div -->
</div> <!-- nipata collapse close prev nipata div -->
</div> <!-- nipata collapse close prev nipata div -->
<div class="level2">
	 <h3><a href=# data-bs-toggle="collapse" data-bs-target="#an4Collapse">4. Catukkanipāta </a></h3>
	 </div> 
	 <div class="collapse" id="an4Collapse">
	 <div class="my-3">
<div class="my-3">
<div class="level4 my-3">
		 <h5>1. Bhaṇḍagāmavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.1">an4.1</a> Anubuddhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.2">an4.2</a> Papatitasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.3">an4.3</a> Paṭhamakhatasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.4">an4.4</a> Dutiyakhatasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.5">an4.5</a> Anusotasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.6">an4.6</a> Appassutasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.7">an4.7</a> Sobhanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.8">an4.8</a> Vesārajjasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.9">an4.9</a> Taṇhuppādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.10">an4.10</a> Yogasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>2. Caravagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.11">an4.11</a> Carasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.12">an4.12</a> Sīlasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.13">an4.13</a> Padhānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.14">an4.14</a> Saṁvarasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.15">an4.15</a> Paññattisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.16">an4.16</a> Sokhummasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.17">an4.17</a> Paṭhamaagatisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.18">an4.18</a> Dutiyaagatisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.19">an4.19</a> Tatiyaagatisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.20">an4.20</a> Bhattuddesakasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>3. Uruvelavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.21">an4.21</a> Paṭhamauruvelasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.22">an4.22</a> Dutiyauruvelasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.23">an4.23</a> Lokasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.24">an4.24</a> Kāḷakārāmasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.25">an4.25</a> Brahmacariyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.26">an4.26</a> Kuhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.27">an4.27</a> Santuṭṭhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.28">an4.28</a> Ariyavaṁsasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.29">an4.29</a> Dhammapadasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.30">an4.30</a> Paribbājakasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>4. Cakkavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.31">an4.31</a> Cakkasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.32">an4.32</a> Saṅgahasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.33">an4.33</a> Sīhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.34">an4.34</a> Aggappasādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.35">an4.35</a> Vassakārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.36">an4.36</a> Doṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.37">an4.37</a> Aparihāniyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.38">an4.38</a> Patilīnasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.39">an4.39</a> Ujjayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.40">an4.40</a> Udāyīsutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>5. Rohitassavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.41">an4.41</a> Samādhibhāvanāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.42">an4.42</a> Pañhabyākaraṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.43">an4.43</a> Paṭhamakodhagarusutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.44">an4.44</a> Dutiyakodhagarusutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.45">an4.45</a> Rohitassasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.46">an4.46</a> Dutiyarohitassasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.47">an4.47</a> Suvidūrasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.48">an4.48</a> Visākhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.49">an4.49</a> Vipallāsasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.50">an4.50</a> Upakkilesasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>6. Puññābhisandavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.51">an4.51</a> Paṭhamapuññābhisandasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.52">an4.52</a> Dutiyapuññābhisandasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.53">an4.53</a> Paṭhamasaṁvāsasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.54">an4.54</a> Dutiyasaṁvāsasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.55">an4.55</a> Paṭhamasamajīvīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.56">an4.56</a> Dutiyasamajīvīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.57">an4.57</a> Suppavāsāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.58">an4.58</a> Sudattasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.59">an4.59</a> Bhojanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.60">an4.60</a> Gihisāmīcisutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>7. Pattakammavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.61">an4.61</a> Pattakammasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.62">an4.62</a> Ānaṇyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.63">an4.63</a> Brahmasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.64">an4.64</a> Nirayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.65">an4.65</a> Rūpasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.66">an4.66</a> Sarāgasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.67">an4.67</a> Ahirājasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.68">an4.68</a> Devadattasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.69">an4.69</a> Padhānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.70">an4.70</a> Adhammikasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>8. Apaṇṇakavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.71">an4.71</a> Padhānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.72">an4.72</a> Sammādiṭṭhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.73">an4.73</a> Sappurisasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.74">an4.74</a> Paṭhamaaggasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>8. Apaṇṇakavagga Rūpaggaṁ, vedanāggaṁ,</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.75">an4.75</a> Dutiyaaggasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>8. Apaṇṇakavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.76">an4.76</a> Kusinārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.77">an4.77</a> Acinteyyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.78">an4.78</a> Dakkhiṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.79">an4.79</a> Vaṇijjasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.80">an4.80</a> Kambojasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>9. Macalavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.81">an4.81</a> Pāṇātipātasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.82">an4.82</a> Musāvādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.83">an4.83</a> Avaṇṇārahasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.84">an4.84</a> Kodhagarusutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.85">an4.85</a> Tamotamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.86">an4.86</a> Oṇatoṇatasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.87">an4.87</a> Puttasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.88">an4.88</a> Saṁyojanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.89">an4.89</a> Sammādiṭṭhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.90">an4.90</a> Khandhasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>10. Asuravagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.91">an4.91</a> Asurasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.92">an4.92</a> Paṭhamasamādhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.93">an4.93</a> Dutiyasamādhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.94">an4.94</a> Tatiyasamādhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.95">an4.95</a> Chavālātasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.96">an4.96</a> Rāgavinayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.97">an4.97</a> Khippanisantisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.98">an4.98</a> Attahitasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.99">an4.99</a> Sikkhāpadasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.100">an4.100</a> Potaliyasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>11. Valāhakavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.101">an4.101</a> Paṭhamavalāhakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.102">an4.102</a> Dutiyavalāhakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.103">an4.103</a> Kumbhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.104">an4.104</a> Udakarahadasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.105">an4.105</a> Ambasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.106">an4.106</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.107">an4.107</a> Mūsikasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.108">an4.108</a> Balībaddasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.109">an4.109</a> Rukkhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.110">an4.110</a> Āsīvisasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>12. Kesivagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.111">an4.111</a> Kesisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.112">an4.112</a> Javasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.113">an4.113</a> Patodasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.114">an4.114</a> Nāgasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.115">an4.115</a> Ṭhānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.116">an4.116</a> Appamādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.117">an4.117</a> Ārakkhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.118">an4.118</a> Saṁvejanīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.119">an4.119</a> Paṭhamabhayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.120">an4.120</a> Dutiyabhayasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>13. Bhayavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.121">an4.121</a> Attānuvādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.122">an4.122</a> Ūmibhayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.123">an4.123</a> Paṭhamanānākaraṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.124">an4.124</a> Dutiyanānākaraṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.125">an4.125</a> Paṭhamamettāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.126">an4.126</a> Dutiyamettāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.127">an4.127</a> Paṭhamatathāgataacchariyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.128">an4.128</a> Dutiyatathāgataacchariyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.129">an4.129</a> Ānandaacchariyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.130">an4.130</a> Cakkavattiacchariyasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>14. Puggalavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.131">an4.131</a> Saṁyojanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.132">an4.132</a> Paṭibhānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.133">an4.133</a> Ugghaṭitaññūsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.134">an4.134</a> Uṭṭhānaphalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.135">an4.135</a> Sāvajjasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.136">an4.136</a> Paṭhamasīlasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.137">an4.137</a> Dutiyasīlasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.138">an4.138</a> Nikaṭṭhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.139">an4.139</a> Dhammakathikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.140">an4.140</a> Vādīsutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>15. Ābhāvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.141">an4.141</a> Ābhāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.142">an4.142</a> Pabhāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.143">an4.143</a> Ālokasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.144">an4.144</a> Obhāsasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.145">an4.145</a> Pajjotasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.146">an4.146</a> Paṭhamakālasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.147">an4.147</a> Dutiyakālasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.148">an4.148</a> Duccaritasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.149">an4.149</a> Sucaritasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.150">an4.150</a> Sārasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>16. Indriyavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.151">an4.151</a> Indriyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.152">an4.152</a> Saddhābalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.153">an4.153</a> Paññābalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.154">an4.154</a> Satibalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.155">an4.155</a> Paṭisaṅkhānabalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.156">an4.156</a> Kappasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.157">an4.157</a> Rogasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.158">an4.158</a> Parihānisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.159">an4.159</a> Bhikkhunīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.160">an4.160</a> Sugatavinayasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>17. Paṭipadāvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.161">an4.161</a> Saṅkhittasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.162">an4.162</a> Vitthārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.163">an4.163</a> Asubhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.164">an4.164</a> Paṭhamakhamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.165">an4.165</a> Dutiyakhamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.166">an4.166</a> Ubhayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.167">an4.167</a> Mahāmoggallānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.168">an4.168</a> Sāriputtasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.169">an4.169</a> Sasaṅkhārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.170">an4.170</a> Yuganaddhasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>18. Sañcetaniyavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.171">an4.171</a> Cetanāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.172">an4.172</a> Vibhattisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.173">an4.173</a> Mahākoṭṭhikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.174">an4.174</a> Ānandasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.175">an4.175</a> Upavāṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.176">an4.176</a> Āyācanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.177">an4.177</a> Rāhulasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.178">an4.178</a> Jambālīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.179">an4.179</a> Nibbānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.180">an4.180</a> Mahāpadesasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>19. Brāhmaṇavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.181">an4.181</a> Yodhājīvasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.182">an4.182</a> Pāṭibhogasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.183">an4.183</a> Sutasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.184">an4.184</a> Abhayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.185">an4.185</a> Brāhmaṇasaccasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.186">an4.186</a> Ummaggasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.187">an4.187</a> Vassakārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.188">an4.188</a> Upakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.189">an4.189</a> Sacchikaraṇīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.190">an4.190</a> Uposathasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>20. Mahāvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.191">an4.191</a> Sotānugatasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.192">an4.192</a> Ṭhānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.193">an4.193</a> Bhaddiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.194">an4.194</a> Sāmugiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.195">an4.195</a> Vappasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.196">an4.196</a> Sāḷhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.197">an4.197</a> Mallikādevīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.198">an4.198</a> Attantapasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.199">an4.199</a> Taṇhāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.200">an4.200</a> Pemasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>21. Sappurisavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.201">an4.201</a> Sikkhāpadasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.202">an4.202</a> Assaddhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.203">an4.203</a> Sattakammasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.204">an4.204</a> Dasakammasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.205">an4.205</a> Aṭṭhaṅgikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.206">an4.206</a> Dasamaggasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.207">an4.207</a> Paṭhamapāpadhammasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.208">an4.208</a> Dutiyapāpadhammasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.209">an4.209</a> Tatiyapāpadhammasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.210">an4.210</a> Catutthapāpadhammasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>22. Parisāvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.211">an4.211</a> Parisāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.212">an4.212</a> Diṭṭhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.213">an4.213</a> Akataññutāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.214">an4.214</a> Pāṇātipātīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.215">an4.215</a> Paṭhamamaggasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.216">an4.216</a> Dutiyamaggasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.217">an4.217</a> Paṭhamavohārapathasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.218">an4.218</a> Dutiyavohārapathasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.219">an4.219</a> Ahirikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.220">an4.220</a> Dussīlasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>23. Duccaritavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.221">an4.221</a> Duccaritasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.222">an4.222</a> Diṭṭhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.223">an4.223</a> Akataññutāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.224">an4.224</a> Pāṇātipātīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.225">an4.225</a> Paṭhamamaggasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.226">an4.226</a> Dutiyamaggasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.227">an4.227</a> Paṭhamavohārapathasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.228">an4.228</a> Dutiyavohārapathasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.229">an4.229</a> Ahirikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.230">an4.230</a> Duppaññasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.231">an4.231</a> Kavisutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>24. Kammavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.232">an4.232</a> Saṅkhittasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.233">an4.233</a> Vitthārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.234">an4.234</a> Soṇakāyanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.235">an4.235</a> Paṭhamasikkhāpadasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.236">an4.236</a> Dutiyasikkhāpadasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.237">an4.237</a> Ariyamaggasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.238">an4.238</a> Bojjhaṅgasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.239">an4.239</a> Sāvajjasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.240">an4.240</a> Abyābajjhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.241">an4.241</a> Samaṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.242">an4.242</a> Sappurisānisaṁsasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>25. Āpattibhayavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.243">an4.243</a> Saṅghabhedakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.244">an4.244</a> Āpattibhayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.245">an4.245</a> Sikkhānisaṁsasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.246">an4.246</a> Seyyāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.247">an4.247</a> Thūpārahasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.248">an4.248</a> Paññāvuddhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.249">an4.249</a> Bahukārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.250">an4.250</a> Paṭhamavohārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.251">an4.251</a> Dutiyavohārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.252">an4.252</a> Tatiyavohārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.253">an4.253</a> Catutthavohārasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>26. Abhiññāvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.254">an4.254</a> Abhiññāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.255">an4.255</a> Pariyesanāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.256">an4.256</a> Saṅgahavatthusutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.257">an4.257</a> Mālukyaputtasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.258">an4.258</a> Kulasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.259">an4.259</a> Paṭhamaājānīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.260">an4.260</a> Dutiyaājānīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.261">an4.261</a> Balasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.262">an4.262</a> Araññasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.263">an4.263</a> Kammasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>27. Kammapathavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.264">an4.264</a> Pāṇātipātīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.265">an4.265</a> Adinnādāyīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.266">an4.266</a> Micchācārīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.267">an4.267</a> Musāvādīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.268">an4.268</a> Pisuṇavācāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.269">an4.269</a> Pharusavācāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.270">an4.270</a> Samphappalāpasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.271">an4.271</a> Abhijjhālusutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.272">an4.272</a> Byāpannacittasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.273">an4.273</a> Micchādiṭṭhisutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5></h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.274">an4.274</a> Satipaṭṭhānasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.275">an4.275</a> Sammappadhānasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.276">an4.276</a> Iddhipādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.277-303">an4.277-303</a> Pariññādisutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an4.304-783">an4.304-783</a> Dosaabhiññādisutta <?php echo $ifRuLitTrn;?></span>
</div>
 
</div> <!-- my-3 inside nipata collapse close prev my div -->
</div> <!-- nipata collapse close prev nipata div -->
</div> <!-- nipata collapse close prev nipata div -->
<div class="level2">
	 <h3><a href=# data-bs-toggle="collapse" data-bs-target="#an5Collapse">5. Pañcakanipāta </a></h3>
	 </div> 
	 <div class="collapse" id="an5Collapse">
	 <div class="my-3">
<div class="my-3">
<div class="level4 my-3">
		 <h5>1. Sekhabalavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.1">an5.1</a> Saṅkhittasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.2">an5.2</a> Vitthatasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.3">an5.3</a> Dukkhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.4">an5.4</a> Yathābhatasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.5">an5.5</a> Sikkhāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.6">an5.6</a> Samāpattisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.7">an5.7</a> Kāmasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.8">an5.8</a> Cavanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.9">an5.9</a> Paṭhamaagāravasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.10">an5.10</a> Dutiyaagāravasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>2. Balavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.11">an5.11</a> Ananussutasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.12">an5.12</a> Kūṭasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.13">an5.13</a> Saṅkhittasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.14">an5.14</a> Vitthatasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.15">an5.15</a> Daṭṭhabbasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.16">an5.16</a> Punakūṭasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.17">an5.17</a> Paṭhamahitasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.18">an5.18</a> Dutiyahitasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.19">an5.19</a> Tatiyahitasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.20">an5.20</a> Catutthahitasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>3. Pañcaṅgikavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.21">an5.21</a> Paṭhamaagāravasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.22">an5.22</a> Dutiyaagāravasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.23">an5.23</a> Upakkilesasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.24">an5.24</a> Dussīlasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.25">an5.25</a> Anuggahitasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.26">an5.26</a> Vimuttāyatanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.27">an5.27</a> Samādhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.28">an5.28</a> Pañcaṅgikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.29">an5.29</a> Caṅkamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.30">an5.30</a> Nāgitasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>4. Sumanavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.31">an5.31</a> Sumanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.32">an5.32</a> Cundīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.33">an5.33</a> Uggahasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.34">an5.34</a> Sīhasenāpatisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.35">an5.35</a> Dānānisaṁsasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.36">an5.36</a> Kāladānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.37">an5.37</a> Bhojanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.38">an5.38</a> Saddhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.39">an5.39</a> Puttasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.40">an5.40</a> Mahāsālaputtasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>5. Muṇḍarājavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.41">an5.41</a> Ādiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.42">an5.42</a> Sappurisasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.43">an5.43</a> Iṭṭhasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.44">an5.44</a> Manāpadāyīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.45">an5.45</a> Puññābhisandasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.46">an5.46</a> Sampadāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.47">an5.47</a> Dhanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.48">an5.48</a> Alabbhanīyaṭhānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.49">an5.49</a> Kosalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.50">an5.50</a> Nāradasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>6. Nīvaraṇavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.51">an5.51</a> Āvaraṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.52">an5.52</a> Akusalarāsisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.53">an5.53</a> Padhāniyaṅgasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.54">an5.54</a> Samayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.55">an5.55</a> Mātāputtasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.56">an5.56</a> Upajjhāyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.57">an5.57</a> Abhiṇhapaccavekkhitabbaṭhānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.58">an5.58</a> Licchavikumārakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.59">an5.59</a> Paṭhamavuḍḍhapabbajitasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.60">an5.60</a> Dutiyavuḍḍhapabbajitasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>7. Saññāvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.61">an5.61</a> Paṭhamasaññāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.62">an5.62</a> Dutiyasaññāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.63">an5.63</a> Paṭhamavaḍḍhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.64">an5.64</a> Dutiyavaḍḍhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.65">an5.65</a> Sākacchasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.66">an5.66</a> Sājīvasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.67">an5.67</a> Paṭhamaiddhipādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.68">an5.68</a> Dutiyaiddhipādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.69">an5.69</a> Nibbidāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.70">an5.70</a> Āsavakkhayasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>8. Yodhājīvavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.71">an5.71</a> Paṭhamacetovimuttiphalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.72">an5.72</a> Dutiyacetovimuttiphalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.73">an5.73</a> Paṭhamadhammavihārīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.74">an5.74</a> Dutiyadhammavihārīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.75">an5.75</a> Paṭhamayodhājīvasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.76">an5.76</a> Dutiyayodhājīvasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.77">an5.77</a> Paṭhamaanāgatabhayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.78">an5.78</a> Dutiyaanāgatabhayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.79">an5.79</a> Tatiyaanāgatabhayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.80">an5.80</a> Catutthaanāgatabhayasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>9. Theravagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.81">an5.81</a> Rajanīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.82">an5.82</a> Vītarāgasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.83">an5.83</a> Kuhakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.84">an5.84</a> Assaddhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.85">an5.85</a> Akkhamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.86">an5.86</a> Paṭisambhidāpattasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.87">an5.87</a> Sīlavantasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.88">an5.88</a> Therasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.89">an5.89</a> Paṭhamasekhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.90">an5.90</a> Dutiyasekhasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>10. Kakudhavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.91">an5.91</a> Paṭhamasampadāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.92">an5.92</a> Dutiyasampadāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.93">an5.93</a> Byākaraṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.94">an5.94</a> Phāsuvihārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.95">an5.95</a> Akuppasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.96">an5.96</a> Sutadharasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.97">an5.97</a> Kathāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.98">an5.98</a> Āraññakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.99">an5.99</a> Sīhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.100">an5.100</a> Kakudhatherasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>11. Phāsuvihāravagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.101">an5.101</a> Sārajjasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.102">an5.102</a> Ussaṅkitasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.103">an5.103</a> Mahācorasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.104">an5.104</a> Samaṇasukhumālasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.105">an5.105</a> Phāsuvihārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.106">an5.106</a> Ānandasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.107">an5.107</a> Sīlasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.108">an5.108</a> Asekhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.109">an5.109</a> Cātuddisasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.110">an5.110</a> Araññasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>12. Andhakavindavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.111">an5.111</a> Kulūpakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.112">an5.112</a> Pacchāsamaṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.113">an5.113</a> Sammāsamādhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.114">an5.114</a> Andhakavindasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.115">an5.115</a> Maccharinīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.116">an5.116</a> Vaṇṇanāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.117">an5.117</a> Issukinīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.118">an5.118</a> Micchādiṭṭhikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.119">an5.119</a> Micchāvācāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.120">an5.120</a> Micchāvāyāmasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>13. Gilānavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.121">an5.121</a> Gilānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.122">an5.122</a> Satisūpaṭṭhitasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.123">an5.123</a> Paṭhamaupaṭṭhākasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.124">an5.124</a> Dutiyaupaṭṭhākasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.125">an5.125</a> Paṭhamaanāyussāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.126">an5.126</a> Dutiyaanāyussāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.127">an5.127</a> Vapakāsasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.128">an5.128</a> Samaṇasukhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.129">an5.129</a> Parikuppasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.130">an5.130</a> Byasanasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>14. Rājavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.131">an5.131</a> Paṭhamacakkānuvattanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.132">an5.132</a> Dutiyacakkānuvattanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.133">an5.133</a> Dhammarājāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.134">an5.134</a> Yassaṁdisaṁsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.135">an5.135</a> Paṭhamapatthanāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.136">an5.136</a> Dutiyapatthanāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.137">an5.137</a> Appaṁsupatisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.138">an5.138</a> Bhattādakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.139">an5.139</a> Akkhamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.140">an5.140</a> Sotasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>15. Tikaṇḍakīvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.141">an5.141</a> Avajānātisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.142">an5.142</a> Ārabhatisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.143">an5.143</a> Sārandadasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.144">an5.144</a> Tikaṇḍakīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.145">an5.145</a> Nirayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.146">an5.146</a> Mittasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.147">an5.147</a> Asappurisadānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.148">an5.148</a> Sappurisadānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.149">an5.149</a> Paṭhamasamayavimuttasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.150">an5.150</a> Dutiyasamayavimuttasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>16. Saddhammavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.151">an5.151</a> Paṭhamasammattaniyāmasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.152">an5.152</a> Dutiyasammattaniyāmasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.153">an5.153</a> Tatiyasammattaniyāmasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.154">an5.154</a> Paṭhamasaddhammasammosasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.155">an5.155</a> Dutiyasaddhammasammosasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.156">an5.156</a> Tatiyasaddhammasammosasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.157">an5.157</a> Dukkathāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.158">an5.158</a> Sārajjasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.159">an5.159</a> Udāyīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.160">an5.160</a> Duppaṭivinodayasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>17. Āghātavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.161">an5.161</a> Paṭhamaāghātapaṭivinayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.162">an5.162</a> Dutiyaāghātapaṭivinayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.163">an5.163</a> Sākacchasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.164">an5.164</a> Sājīvasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.165">an5.165</a> Pañhapucchāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.166">an5.166</a> Nirodhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.167">an5.167</a> Codanāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.168">an5.168</a> Sīlasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.169">an5.169</a> Khippanisantisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.170">an5.170</a> Bhaddajisutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>18. Upāsakavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.171">an5.171</a> Sārajjasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.172">an5.172</a> Visāradasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.173">an5.173</a> Nirayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.174">an5.174</a> Verasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.175">an5.175</a> Caṇḍālasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.176">an5.176</a> Pītisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.177">an5.177</a> Vaṇijjāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.178">an5.178</a> Rājāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.179">an5.179</a> Gihisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.180">an5.180</a> Gavesīsutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>19. Araññavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.181">an5.181</a> Āraññikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.182">an5.182</a> Cīvarasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.183">an5.183</a> Rukkhamūlikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.184">an5.184</a> Sosānikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.185">an5.185</a> Abbhokāsikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.186">an5.186</a> Nesajjikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.187">an5.187</a> Yathāsanthatikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.188">an5.188</a> Ekāsanikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.189">an5.189</a> Khalupacchābhattikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.190">an5.190</a> Pattapiṇḍikasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>20. Brāhmaṇavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.191">an5.191</a> Soṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.192">an5.192</a> Doṇabrāhmaṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.193">an5.193</a> Saṅgāravasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.194">an5.194</a> Kāraṇapālīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.195">an5.195</a> Piṅgiyānīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.196">an5.196</a> Mahāsupinasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.197">an5.197</a> Vassasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.198">an5.198</a> Vācāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.199">an5.199</a> Kulasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.200">an5.200</a> Nissāraṇīyasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>21. Kimilavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.201">an5.201</a> Kimilasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.202">an5.202</a> Dhammassavanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.203">an5.203</a> Assājānīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.204">an5.204</a> Balasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.205">an5.205</a> Cetokhilasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.206">an5.206</a> Vinibandhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.207">an5.207</a> Yāgusutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.208">an5.208</a> Dantakaṭṭhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.209">an5.209</a> Gītassarasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.210">an5.210</a> Muṭṭhassatisutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>22. Akkosakavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.211">an5.211</a> Akkosakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.212">an5.212</a> Bhaṇḍanakārakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.213">an5.213</a> Sīlasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.214">an5.214</a> Bahubhāṇisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.215">an5.215</a> Paṭhamaakkhantisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.216">an5.216</a> Dutiyaakkhantisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.217">an5.217</a> Paṭhamaapāsādikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.218">an5.218</a> Dutiyaapāsādikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.219">an5.219</a> Aggisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.220">an5.220</a> Madhurāsutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>23. Dīghacārikavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.221">an5.221</a> Paṭhamadīghacārikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.222">an5.222</a> Dutiyadīghacārikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.223">an5.223</a> Atinivāsasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.224">an5.224</a> Maccharīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.225">an5.225</a> Paṭhamakulūpakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.226">an5.226</a> Dutiyakulūpakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.227">an5.227</a> Bhogasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.228">an5.228</a> Ussūrabhattasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.229">an5.229</a> Paṭhamakaṇhasappasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.230">an5.230</a> Dutiyakaṇhasappasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>24. Āvāsikavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.231">an5.231</a> Āvāsikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.232">an5.232</a> Piyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.233">an5.233</a> Sobhanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.234">an5.234</a> Bahūpakārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.235">an5.235</a> Anukampasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.236">an5.236</a> Paṭhamaavaṇṇārahasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.237">an5.237</a> Dutiyaavaṇṇārahasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.238">an5.238</a> Tatiyaavaṇṇārahasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.239">an5.239</a> Paṭhamamacchariyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.240">an5.240</a> Dutiyamacchariyasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>25. Duccaritavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.241">an5.241</a> Paṭhamaduccaritasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.242">an5.242</a> Paṭhamakāyaduccaritasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.243">an5.243</a> Paṭhamavacīduccaritasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.244">an5.244</a> Paṭhamamanoduccaritasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.245">an5.245</a> Dutiyaduccaritasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.246">an5.246</a> Dutiyakāyaduccaritasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.247">an5.247</a> Dutiyavacīduccaritasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.248">an5.248</a> Dutiyamanoduccaritasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.249">an5.249</a> Sivathikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.250">an5.250</a> Puggalappasādasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>26. Upasampadāvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.251">an5.251</a> Upasampādetabbasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.252">an5.252</a> Nissayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.253">an5.253</a> Sāmaṇerasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.254">an5.254</a> Pañcamacchariyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.255">an5.255</a> Macchariyappahānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.256">an5.256</a> Paṭhamajhānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.257-263">an5.257-263</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.264">an5.264</a> Aparapaṭhamajhānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.265-271">an5.265-271</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5></h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.272">an5.272</a> Bhattuddesakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.273-285">an5.273-285</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.286">an5.286</a> Bhikkhusutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.287-292">an5.287-292</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.293">an5.293</a> Ājīvakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.294-302">an5.294-302</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.303">an5.303</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.304">an5.304</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.305">an5.305</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.306">an5.306</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.307">an5.307</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an5.308-1152">an5.308-1152</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
</div> <!-- my-3 inside nipata collapse close prev my div -->
</div> <!-- nipata collapse close prev nipata div -->
</div> <!-- nipata collapse close prev nipata div -->
<div class="level2">
	 <h3><a href=# data-bs-toggle="collapse" data-bs-target="#an6Collapse">6. Chakkanipāta </a></h3>
	 </div> 
	 <div class="collapse" id="an6Collapse">
	 <div class="my-3">
<div class="my-3">
<div class="level4 my-3">
		 <h5>1. Āhuneyyavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.1">an6.1</a> Paṭhamaāhuneyyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.2">an6.2</a> Dutiyaāhuneyyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.3">an6.3</a> Indriyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.4">an6.4</a> Balasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.5">an6.5</a> Paṭhamaājānīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.6">an6.6</a> Dutiyaājānīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.7">an6.7</a> Tatiyaājānīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.8">an6.8</a> Anuttariyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.9">an6.9</a> Anussatiṭṭhānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.10">an6.10</a> Mahānāmasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>2. Sāraṇīyavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.11">an6.11</a> Paṭhamasāraṇīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.12">an6.12</a> Dutiyasāraṇīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.13">an6.13</a> Nissāraṇīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.14">an6.14</a> Bhaddakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.15">an6.15</a> Anutappiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.16">an6.16</a> Nakulapitusutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.17">an6.17</a> Soppasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.18">an6.18</a> Macchabandhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.19">an6.19</a> Paṭhamamaraṇassatisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.20">an6.20</a> Dutiyamaraṇassatisutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>3. Anuttariyavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.21">an6.21</a> Sāmakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.22">an6.22</a> Aparihāniyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.23">an6.23</a> Bhayasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.24">an6.24</a> Himavantasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.25">an6.25</a> Anussatiṭṭhānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.26">an6.26</a> Mahākaccānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.27">an6.27</a> Paṭhamasamayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.28">an6.28</a> Dutiyasamayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.29">an6.29</a> Udāyīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.30">an6.30</a> Anuttariyasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>4. Devatāvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.31">an6.31</a> Sekhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.32">an6.32</a> Paṭhamaaparihānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.33">an6.33</a> Dutiyaaparihānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.34">an6.34</a> Mahāmoggallānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.35">an6.35</a> Vijjābhāgiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.36">an6.36</a> Vivādamūlasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.37">an6.37</a> Chaḷaṅgadānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.38">an6.38</a> Attakārīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.39">an6.39</a> Nidānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.40">an6.40</a> Kimilasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.41">an6.41</a> Dārukkhandhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.42">an6.42</a> Nāgitasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>5. Dhammikavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.43">an6.43</a> Nāgasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.44">an6.44</a> Migasālāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.45">an6.45</a> Iṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.46">an6.46</a> Mahācundasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.47">an6.47</a> Paṭhamasandiṭṭhikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.48">an6.48</a> Dutiyasandiṭṭhikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.49">an6.49</a> Khemasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.50">an6.50</a> Indriyasaṁvarasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.51">an6.51</a> Ānandasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.52">an6.52</a> Khattiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.53">an6.53</a> Appamādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.54">an6.54</a> Dhammikasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>6. Mahāvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.55">an6.55</a> Soṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.56">an6.56</a> Phaggunasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.57">an6.57</a> Chaḷabhijātisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.58">an6.58</a> Āsavasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.59">an6.59</a> Dārukammikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.60">an6.60</a> Hatthisāriputtasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.61">an6.61</a> Majjhesutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.62">an6.62</a> Purisindriyañāṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.63">an6.63</a> Nibbedhikasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.64">an6.64</a> Sīhanādasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>7. Devatāvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.65">an6.65</a> Anāgāmiphalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.66">an6.66</a> Arahattasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.67">an6.67</a> Mittasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.68">an6.68</a> Saṅgaṇikārāmasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.69">an6.69</a> Devatāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.70">an6.70</a> Samādhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.71">an6.71</a> Sakkhibhabbasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.72">an6.72</a> Balasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.73">an6.73</a> Paṭhamatajjhānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.74">an6.74</a> Dutiyatajjhānasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>8. Arahattavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.75">an6.75</a> Dukkhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.76">an6.76</a> Arahattasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.77">an6.77</a> Uttarimanussadhammasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.78">an6.78</a> Sukhasomanassasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.79">an6.79</a> Adhigamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.80">an6.80</a> Mahantattasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.81">an6.81</a> Paṭhamanirayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.82">an6.82</a> Dutiyanirayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.83">an6.83</a> Aggadhammasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.84">an6.84</a> Rattidivasasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>9. Sītivagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.85">an6.85</a> Sītibhāvasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.86">an6.86</a> Āvaraṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.87">an6.87</a> Voropitasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.88">an6.88</a> Sussūsatisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.89">an6.89</a> Appahāyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.90">an6.90</a> Pahīnasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.91">an6.91</a> Abhabbasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.92">an6.92</a> Paṭhamaabhabbaṭṭhānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.93">an6.93</a> Dutiyaabhabbaṭṭhānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.94">an6.94</a> Tatiyaabhabbaṭṭhānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.95">an6.95</a> Catutthaabhabbaṭṭhānasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>10. Ānisaṁsavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.96">an6.96</a> Pātubhāvasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.97">an6.97</a> Ānisaṁsasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.98">an6.98</a> Aniccasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.99">an6.99</a> Dukkhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.100">an6.100</a> Anattasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.101">an6.101</a> Nibbānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.102">an6.102</a> Anavatthitasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.103">an6.103</a> Ukkhittāsikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.104">an6.104</a> Atammayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.105">an6.105</a> Bhavasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.106">an6.106</a> Taṇhāsutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>11. Tikavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.107">an6.107</a> Rāgasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.108">an6.108</a> Duccaritasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.109">an6.109</a> Vitakkasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.110">an6.110</a> Saññāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.111">an6.111</a> Dhātusutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.112">an6.112</a> Assādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.113">an6.113</a> Aratisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.114">an6.114</a> Santuṭṭhitāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.115">an6.115</a> Dovacassatāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.116">an6.116</a> Uddhaccasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>12. Sāmaññavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.117">an6.117</a> Kāyānupassīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.118">an6.118</a> Dhammānupassīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.119">an6.119</a> Tapussasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.120-139">an6.120-139</a> Bhallikādisutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5></h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.140">an6.140</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.141">an6.141</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.142">an6.142</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.143-169">an6.143-169</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an6.170-649">an6.170-649</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
</div> <!-- my-3 inside nipata collapse close prev my div -->
</div> <!-- nipata collapse close prev nipata div -->
</div> <!-- nipata collapse close prev nipata div -->
<div class="level2">
	 <h3><a href=# data-bs-toggle="collapse" data-bs-target="#an7Collapse">7. Sattakanipāta </a></h3>
	 </div> 
	 <div class="collapse" id="an7Collapse">
	 <div class="my-3">
<div class="my-3">
<div class="level4 my-3">
		 <h5>1. Dhanavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.1">an7.1</a> Paṭhamapiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.2">an7.2</a> Dutiyapiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.3">an7.3</a> Saṅkhittabalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.4">an7.4</a> Vitthatabalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.5">an7.5</a> Saṅkhittadhanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.6">an7.6</a> Vitthatadhanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.7">an7.7</a> Uggasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.8">an7.8</a> Saṁyojanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.9">an7.9</a> Pahānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.10">an7.10</a> Macchariyasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>2. Anusayavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.11">an7.11</a> Paṭhamaanusayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.12">an7.12</a> Dutiyaanusayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.13">an7.13</a> Kulasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.14">an7.14</a> Puggalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.15">an7.15</a> Udakūpamāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.16">an7.16</a> Aniccānupassīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.17">an7.17</a> Dukkhānupassīsutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.18">an7.18</a> Anattānupassīsutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.19">an7.19</a> Nibbānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.20">an7.20</a> Niddasavatthusutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>3. Vajjisattakavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.21">an7.21</a> Sārandadasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.22">an7.22</a> Vassakārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.23">an7.23</a> Paṭhamasattakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.24">an7.24</a> Dutiyasattakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.25">an7.25</a> Tatiyasattakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.26">an7.26</a> Bojjhaṅgasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.27">an7.27</a> Saññāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.28">an7.28</a> Paṭhamaparihānisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.29">an7.29</a> Dutiyaparihānisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.30">an7.30</a> Vipattisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.31">an7.31</a> Parābhavasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>4. Devatāvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.32">an7.32</a> Appamādagāravasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.33">an7.33</a> Hirigāravasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.34">an7.34</a> Paṭhamasovacassatāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.35">an7.35</a> Dutiyasovacassatāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.36">an7.36</a> Paṭhamamittasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.37">an7.37</a> Dutiyamittasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.38">an7.38</a> Paṭhamapaṭisambhidāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.39">an7.39</a> Dutiyapaṭisambhidāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.40">an7.40</a> Paṭhamavasasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.41">an7.41</a> Dutiyavasasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.42">an7.42</a> Paṭhamaniddasasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.43">an7.43</a> Dutiyaniddasasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>5. Mahāyaññavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.44">an7.44</a> Sattaviññāṇaṭṭhitisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.45">an7.45</a> Samādhiparikkhārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.46">an7.46</a> Paṭhamaaggisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.47">an7.47</a> Dutiyaaggisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.48">an7.48</a> Paṭhamasaññāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.49">an7.49</a> Dutiyasaññāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.50">an7.50</a> Methunasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.51">an7.51</a> Saṁyogasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.52">an7.52</a> Dānamahapphalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.53">an7.53</a> Nandamātāsutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>6. Abyākatavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.54">an7.54</a> Abyākatasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.55">an7.55</a> Purisagatisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.56">an7.56</a> Tissabrahmāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.57">an7.57</a> Sīhasenāpatisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.58">an7.58</a> Arakkheyyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.59">an7.59</a> Kimilasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.60">an7.60</a> Sattadhammasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.61">an7.61</a> Pacalāyamānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.62">an7.62</a> Mettasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.63">an7.63</a> Bhariyāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.64">an7.64</a> Kodhanasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>7. Mahāvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.65">an7.65</a> Hirīottappasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.66">an7.66</a> Sattasūriyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.67">an7.67</a> Nagaropamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.68">an7.68</a> Dhammaññūsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.69">an7.69</a> Pāricchattakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.70">an7.70</a> Sakkaccasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.71">an7.71</a> Bhāvanāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.72">an7.72</a> Aggikkhandhopamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.73">an7.73</a> Sunettasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.74">an7.74</a> Arakasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>8. Vinayavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.75">an7.75</a> Paṭhamavinayadharasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.76">an7.76</a> Dutiyavinayadharasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.77">an7.77</a> Tatiyavinayadharasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.78">an7.78</a> Catutthavinayadharasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.79">an7.79</a> Paṭhamavinayadharasobhanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.80">an7.80</a> Dutiyavinayadharasobhanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.81">an7.81</a> Tatiyavinayadharasobhanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.82">an7.82</a> Catutthavinayadharasobhanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.83">an7.83</a> Satthusāsanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.84">an7.84</a> Adhikaraṇasamathasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>9. Samaṇavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.85">an7.85</a> Bhikkhusutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.86">an7.86</a> Samaṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.87">an7.87</a> Brāhmaṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.88">an7.88</a> Sottiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.89">an7.89</a> Nhātakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.90">an7.90</a> Vedagūsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.91">an7.91</a> Ariyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.92">an7.92</a> Arahāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.93">an7.93</a> Asaddhammasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.94">an7.94</a> Saddhammasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>10. Āhuneyyavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.95">an7.95</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.96-614">an7.96-614</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5></h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.615">an7.615</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.616">an7.616</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.617">an7.617</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.618-644">an7.618-644</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an7.645-1124">an7.645-1124</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
</div> <!-- my-3 inside nipata collapse close prev my div -->
</div> <!-- nipata collapse close prev nipata div -->
</div> <!-- nipata collapse close prev nipata div -->
<div class="level2">
	 <h3><a href=# data-bs-toggle="collapse" data-bs-target="#an8Collapse">8. Aṭṭhakanipāta </a></h3>
	 </div> 
	 <div class="collapse" id="an8Collapse">
	 <div class="my-3">
<div class="my-3">
<div class="level4 my-3">
		 <h5>1. Mettāvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.1">an8.1</a> Mettāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.2">an8.2</a> Paññāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.3">an8.3</a> Paṭhamaappiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.4">an8.4</a> Dutiyaappiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.5">an8.5</a> Paṭhamalokadhammasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.6">an8.6</a> Dutiyalokadhammasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.7">an8.7</a> Devadattavipattisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.8">an8.8</a> Uttaravipattisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.9">an8.9</a> Nandasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.10">an8.10</a> Kāraṇḍavasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>2. Mahāvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.11">an8.11</a> Verañjasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.12">an8.12</a> Sīhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.13">an8.13</a> Assājānīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.14">an8.14</a> Assakhaḷuṅkasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.15">an8.15</a> Malasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.16">an8.16</a> Dūteyyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.17">an8.17</a> Paṭhamabandhanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.18">an8.18</a> Dutiyabandhanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.19">an8.19</a> Pahārādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.20">an8.20</a> Uposathasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>3. Gahapativagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.21">an8.21</a> Paṭhamauggasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.22">an8.22</a> Dutiyauggasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.23">an8.23</a> Paṭhamahatthakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.24">an8.24</a> Dutiyahatthakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.25">an8.25</a> Mahānāmasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.26">an8.26</a> Jīvakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.27">an8.27</a> Paṭhamabalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.28">an8.28</a> Dutiyabalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.29">an8.29</a> Akkhaṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.30">an8.30</a> Anuruddhamahāvitakkasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>4. Dānavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.31">an8.31</a> Paṭhamadānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.32">an8.32</a> Dutiyadānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.33">an8.33</a> Dānavatthusutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.34">an8.34</a> Khettasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.35">an8.35</a> Dānūpapattisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.36">an8.36</a> Puññakiriyavatthusutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.37">an8.37</a> Sappurisadānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.38">an8.38</a> Sappurisasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.39">an8.39</a> Abhisandasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.40">an8.40</a> Duccaritavipākasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>5. Uposathavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.41">an8.41</a> Saṅkhittūposathasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.42">an8.42</a> Vitthatūposathasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.43">an8.43</a> Visākhāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.44">an8.44</a> Vāseṭṭhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.45">an8.45</a> Bojjhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.46">an8.46</a> Anuruddhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.47">an8.47</a> Dutiyavisākhāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.48">an8.48</a> Nakulamātāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.49">an8.49</a> Paṭhamaidhalokikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.50">an8.50</a> Dutiyaidhalokikasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>6. Gotamīvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.51">an8.51</a> Gotamīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.52">an8.52</a> Ovādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.53">an8.53</a> Saṅkhittasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.54">an8.54</a> Dīghajāṇusutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.55">an8.55</a> Ujjayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.56">an8.56</a> Bhayasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.57">an8.57</a> Paṭhamaāhuneyyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.58">an8.58</a> Dutiyaāhuneyyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.59">an8.59</a> Paṭhamapuggalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.60">an8.60</a> Dutiyapuggalasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>7. Bhūmicālavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.61">an8.61</a> Icchāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.62">an8.62</a> Alaṁsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.63">an8.63</a> Saṅkhittasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.64">an8.64</a> Gayāsīsasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.65">an8.65</a> Abhibhāyatanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.66">an8.66</a> Vimokkhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.67">an8.67</a> Anariyavohārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.68">an8.68</a> Ariyavohārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.69">an8.69</a> Parisāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.70">an8.70</a> Bhūmicālasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>8. Yamakavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.71">an8.71</a> Paṭhamasaddhāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.72">an8.72</a> Dutiyasaddhāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.73">an8.73</a> Paṭhamamaraṇassatisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.74">an8.74</a> Dutiyamaraṇassatisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.75">an8.75</a> Paṭhamasampadāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.76">an8.76</a> Dutiyasampadāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.77">an8.77</a> Icchāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.78">an8.78</a> Alaṁsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.79">an8.79</a> Parihānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.80">an8.80</a> Kusītārambhavatthusutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>9. Sativagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.81">an8.81</a> Satisampajaññasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.82">an8.82</a> Puṇṇiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.83">an8.83</a> Mūlakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.84">an8.84</a> Corasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.85">an8.85</a> Samaṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.86">an8.86</a> Yasasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.87">an8.87</a> Pattanikujjanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.88">an8.88</a> Appasādapavedanīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.89">an8.89</a> Paṭisāraṇīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.90">an8.90</a> Sammāvattanasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>10. Sāmaññavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.91-117">an8.91-117</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5></h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.118">an8.118</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.119">an8.119</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.120">an8.120</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.121-147">an8.121-147</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an8.148-627">an8.148-627</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
</div> <!-- my-3 inside nipata collapse close prev my div -->
</div> <!-- nipata collapse close prev nipata div -->
</div> <!-- nipata collapse close prev nipata div -->
<div class="level2">
	 <h3><a href=# data-bs-toggle="collapse" data-bs-target="#an9Collapse">9. Navakanipāta </a></h3>
	 </div> 
	 <div class="collapse" id="an9Collapse">
	 <div class="my-3">
<div class="my-3">
<div class="level4 my-3">
		 <h5>1. Sambodhivagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.1">an9.1</a> Sambodhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.2">an9.2</a> Nissayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.3">an9.3</a> Meghiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.4">an9.4</a> Nandakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.5">an9.5</a> Balasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.6">an9.6</a> Sevanāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.7">an9.7</a> Sutavāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.8">an9.8</a> Sajjhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.9">an9.9</a> Puggalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.10">an9.10</a> Āhuneyyasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>2. Sīhanādavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.11">an9.11</a> Sīhanādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.12">an9.12</a> Saupādisesasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.13">an9.13</a> Koṭṭhikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.14">an9.14</a> Samiddhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.15">an9.15</a> Gaṇḍasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.16">an9.16</a> Saññāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.17">an9.17</a> Kulasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.18">an9.18</a> Navaṅguposathasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.19">an9.19</a> Devatāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.20">an9.20</a> Velāmasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>3. Sattāvāsavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.21">an9.21</a> Tiṭhānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.22">an9.22</a> Assakhaḷuṅkasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.23">an9.23</a> Taṇhāmūlakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.24">an9.24</a> Sattāvāsasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.25">an9.25</a> Paññāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.26">an9.26</a> Silāyūpasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.27">an9.27</a> Paṭhamaverasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.28">an9.28</a> Dutiyaverasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.29">an9.29</a> Āghātavatthusutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.30">an9.30</a> Āghātapaṭivinayasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.31">an9.31</a> Anupubbanirodhasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>4. Mahāvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.32">an9.32</a> Anupubbavihārasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.33">an9.33</a> Anupubbavihārasamāpattisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.34">an9.34</a> Nibbānasukhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.35">an9.35</a> Gāvīupamāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.36">an9.36</a> Jhānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.37">an9.37</a> Ānandasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.38">an9.38</a> Lokāyatikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.39">an9.39</a> Devāsurasaṅgāmasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.40">an9.40</a> Nāgasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.41">an9.41</a> Tapussasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>5. Sāmaññavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.42">an9.42</a> Sambādhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.43">an9.43</a> Kāyasakkhīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.44">an9.44</a> Paññāvimuttasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.45">an9.45</a> Ubhatobhāgavimuttasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.46">an9.46</a> Sandiṭṭhikadhammasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.47">an9.47</a> Sandiṭṭhikanibbānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.48">an9.48</a> Nibbānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.49">an9.49</a> Parinibbānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.50">an9.50</a> Tadaṅganibbānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.51">an9.51</a> Diṭṭhadhammanibbānasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>6. Khemavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.52">an9.52</a> Khemasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.53">an9.53</a> Khemappattasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.54">an9.54</a> Amatasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.55">an9.55</a> Amatappattasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.56">an9.56</a> Abhayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.57">an9.57</a> Abhayappattasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.58">an9.58</a> Passaddhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.59">an9.59</a> Anupubbapassaddhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.60">an9.60</a> Nirodhasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.61">an9.61</a> Anupubbanirodhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.62">an9.62</a> Abhabbasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>7. Satipaṭṭhānavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.63">an9.63</a> Sikkhādubbalyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.64">an9.64</a> Nīvaraṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.65">an9.65</a> Kāmaguṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.66">an9.66</a> Upādānakkhandhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.67">an9.67</a> Orambhāgiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.68">an9.68</a> Gatisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.69">an9.69</a> Macchariyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.70">an9.70</a> Uddhambhāgiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.71">an9.71</a> Cetokhilasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.72">an9.72</a> Cetasovinibandhasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>8. Sammappadhānavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.73">an9.73</a> Sikkhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.74-81">an9.74-81</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.82">an9.82</a> Cetasovinibandhasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>9. Iddhipādavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.83">an9.83</a> Sikkhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.84-91">an9.84-91</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.92">an9.92</a> Cetasovinibandhasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5></h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.93">an9.93</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.94">an9.94</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.95-112">an9.95-112</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an9.113-432">an9.113-432</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
</div> <!-- my-3 inside nipata collapse close prev my div -->
</div> <!-- nipata collapse close prev nipata div -->
</div> <!-- nipata collapse close prev nipata div -->
<div class="level2">
	 <h3><a href=# data-bs-toggle="collapse" data-bs-target="#an10Collapse">10. Dasakanipāta </a></h3>
	 </div> 
	 <div class="collapse" id="an10Collapse">
	 <div class="my-3">
<div class="my-3">
<div class="level4 my-3">
		 <h5>1. Ānisaṁsavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.1">an10.1</a> Kimatthiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.2">an10.2</a> Cetanākaraṇīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.3">an10.3</a> Paṭhamaupanisasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.4">an10.4</a> Dutiyaupanisasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.5">an10.5</a> Tatiyaupanisasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.6">an10.6</a> Samādhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.7">an10.7</a> Sāriputtasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.8">an10.8</a> Jhānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.9">an10.9</a> Santavimokkhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.10">an10.10</a> Vijjāsutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>2. Nāthavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.11">an10.11</a> Senāsanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.12">an10.12</a> Pañcaṅgasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.13">an10.13</a> Saṁyojanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.14">an10.14</a> Cetokhilasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.15">an10.15</a> Appamādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.16">an10.16</a> Āhuneyyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.17">an10.17</a> Paṭhamanāthasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.18">an10.18</a> Dutiyanāthasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.19">an10.19</a> Paṭhamaariyāvāsasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.20">an10.20</a> Dutiyaariyāvāsasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>3. Mahāvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.21">an10.21</a> Sīhanādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.22">an10.22</a> Adhivuttipadasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.23">an10.23</a> Kāyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.24">an10.24</a> Mahācundasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.25">an10.25</a> Kasiṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.26">an10.26</a> Kāḷīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.27">an10.27</a> Paṭhamamahāpañhāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.28">an10.28</a> Dutiyamahāpañhāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.29">an10.29</a> Paṭhamakosalasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.30">an10.30</a> Dutiyakosalasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>4. Upālivagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.31">an10.31</a> Upālisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.32">an10.32</a> Pātimokkhaṭṭhapanāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.33">an10.33</a> Ubbāhikāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.34">an10.34</a> Upasampadāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.35">an10.35</a> Nissayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.36">an10.36</a> Sāmaṇerasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.37">an10.37</a> Saṅghabhedasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.38">an10.38</a> Saṅghasāmaggīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.39">an10.39</a> Paṭhamaānandasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.40">an10.40</a> Dutiyaānandasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>5. Akkosavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.41">an10.41</a> Vivādasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.42">an10.42</a> Paṭhamavivādamūlasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.43">an10.43</a> Dutiyavivādamūlasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.44">an10.44</a> Kusinārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.45">an10.45</a> Rājantepurappavesanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.46">an10.46</a> Sakkasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.47">an10.47</a> Mahālisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.48">an10.48</a> Pabbajitaabhiṇhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.49">an10.49</a> Sarīraṭṭhadhammasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.50">an10.50</a> Bhaṇḍanasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>6. Sacittavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.51">an10.51</a> Sacittasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.52">an10.52</a> Sāriputtasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.53">an10.53</a> Ṭhitisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.54">an10.54</a> Samathasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.55">an10.55</a> Parihānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.56">an10.56</a> Paṭhamasaññāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.57">an10.57</a> Dutiyasaññāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.58">an10.58</a> Mūlakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.59">an10.59</a> Pabbajjāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.60">an10.60</a> Girimānandasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>7. Yamakavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.61">an10.61</a> Avijjāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.62">an10.62</a> Taṇhāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.63">an10.63</a> Niṭṭhaṅgatasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.64">an10.64</a> Aveccappasannasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.65">an10.65</a> Paṭhamasukhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.66">an10.66</a> Dutiyasukhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.67">an10.67</a> Paṭhamanaḷakapānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.68">an10.68</a> Dutiyanaḷakapānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.69">an10.69</a> Paṭhamakathāvatthusutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.70">an10.70</a> Dutiyakathāvatthusutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>8. Ākaṅkhavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.71">an10.71</a> Ākaṅkhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.72">an10.72</a> Kaṇṭakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.73">an10.73</a> Iṭṭhadhammasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.74">an10.74</a> Vaḍḍhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.75">an10.75</a> Migasālāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.76">an10.76</a> Tayodhammasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.77">an10.77</a> Kākasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.78">an10.78</a> Nigaṇṭhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.79">an10.79</a> Āghātavatthusutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.80">an10.80</a> Āghātapaṭivinayasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>9. Theravagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.81">an10.81</a> Vāhanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.82">an10.82</a> Ānandasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.83">an10.83</a> Puṇṇiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.84">an10.84</a> Byākaraṇasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.85">an10.85</a> Katthīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.86">an10.86</a> Adhimānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.87">an10.87</a> Nappiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.88">an10.88</a> Akkosakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.89">an10.89</a> Kokālikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.90">an10.90</a> Khīṇāsavabalasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>10. Upālivagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.91">an10.91</a> Kāmabhogīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.92">an10.92</a> Bhayasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.93">an10.93</a> Kiṁdiṭṭhikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.94">an10.94</a> Vajjiyamāhitasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.95">an10.95</a> Uttiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.96">an10.96</a> Kokanudasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.97">an10.97</a> Āhuneyyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.98">an10.98</a> Therasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.99">an10.99</a> Upālisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.100">an10.100</a> Abhabbasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>11. Samaṇasaññāvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.101">an10.101</a> Samaṇasaññāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.102">an10.102</a> Bojjhaṅgasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.103">an10.103</a> Micchattasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.104">an10.104</a> Bījasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.105">an10.105</a> Vijjāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.106">an10.106</a> Nijjarasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.107">an10.107</a> Dhovanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.108">an10.108</a> Tikicchakasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.109">an10.109</a> Vamanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.110">an10.110</a> Niddhamanīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.111">an10.111</a> Paṭhamaasekhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.112">an10.112</a> Dutiyaasekhasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>12. Paccorohaṇivagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.113">an10.113</a> Paṭhamaadhammasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.114">an10.114</a> Dutiyaadhammasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.115">an10.115</a> Tatiyaadhammasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.116">an10.116</a> Ajitasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.117">an10.117</a> Saṅgāravasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.118">an10.118</a> Orimatīrasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.119">an10.119</a> Paṭhamapaccorohaṇīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.120">an10.120</a> Dutiyapaccorohaṇīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.121">an10.121</a> Pubbaṅgamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.122">an10.122</a> Āsavakkhayasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>13. Parisuddhavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.123">an10.123</a> Paṭhamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.124">an10.124</a> Dutiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.125">an10.125</a> Tatiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.126">an10.126</a> Catutthasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.127">an10.127</a> Pañcamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.128">an10.128</a> Chaṭṭhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.129">an10.129</a> Sattamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.130">an10.130</a> Aṭṭhamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.131">an10.131</a> Navamasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.132">an10.132</a> Dasamasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.133">an10.133</a> Ekādasamasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>14. Sādhuvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.134">an10.134</a> Sādhusutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.135">an10.135</a> Ariyadhammasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.136">an10.136</a> Akusalasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.137">an10.137</a> Atthasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.138">an10.138</a> Dhammasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.139">an10.139</a> Sāsavasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.140">an10.140</a> Sāvajjasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.141">an10.141</a> Tapanīyasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.142">an10.142</a> Ācayagāmisutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.143">an10.143</a> Dukkhudrayasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.144">an10.144</a> Dukkhavipākasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>15. Ariyavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.145">an10.145</a> Ariyamaggasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.146">an10.146</a> Kaṇhamaggasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.147">an10.147</a> Saddhammasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.148">an10.148</a> Sappurisadhammasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.149">an10.149</a> Uppādetabbasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.150">an10.150</a> Āsevitabbasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.151">an10.151</a> Bhāvetabbasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.152">an10.152</a> Bahulīkātabbasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.153">an10.153</a> Anussaritabbasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.154">an10.154</a> Sacchikātabbasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>16. Puggalavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.155">an10.155</a> Sevitabbasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.156-166">an10.156-166</a> Bhajitabbādisutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>17. Jāṇussoṇivagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.167">an10.167</a> Brāhmaṇapaccorohaṇīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.168">an10.168</a> Ariyapaccorohaṇīsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.169">an10.169</a> Saṅgāravasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.170">an10.170</a> Orimasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.171">an10.171</a> Paṭhamaadhammasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.172">an10.172</a> Dutiyaadhammasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.173">an10.173</a> Tatiyaadhammasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.174">an10.174</a> Kammanidānasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.175">an10.175</a> Parikkamanasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>17. Jāṇussoṇivagga Pisuṇavāco hoti.</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.176">an10.176</a> Cundasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>17. Jāṇussoṇivagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.177">an10.177</a> Jāṇussoṇisutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>18. Sādhuvagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.178">an10.178</a> Sādhusutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.179">an10.179</a> Ariyadhammasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.180">an10.180</a> Kusalasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.181">an10.181</a> Atthasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.182">an10.182</a> Dhammasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.183">an10.183</a> Āsavasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.184">an10.184</a> Vajjasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.185">an10.185</a> Tapanīyasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.186">an10.186</a> Ācayagāmisutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.187">an10.187</a> Dukkhudrayasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.188">an10.188</a> Vipākasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>19. Ariyamaggavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.189">an10.189</a> Ariyamaggasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.190">an10.190</a> Kaṇhamaggasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.191">an10.191</a> Saddhammasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.192">an10.192</a> Sappurisadhammasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.193">an10.193</a> Uppādetabbadhammasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.194">an10.194</a> Āsevitabbadhammasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.195">an10.195</a> Bhāvetabbadhammasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.196">an10.196</a> Bahulīkātabbasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.197">an10.197</a> Anussaritabbasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.198">an10.198</a> Sacchikātabbasutta <?php echo $ifRuLitTrn;?></span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>20. Aparapuggalavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.199-210">an10.199-210</a> Nasevitabbādisutta <?php echo $ifRuLitTrn;?></span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>21. Karajakāyavagga Pisuṇavāco hoti,</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.211">an10.211</a> Paṭhamanirayasaggasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>21. Karajakāyavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.212">an10.212</a> Dutiyanirayasaggasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.213">an10.213</a> Mātugāmasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.214">an10.214</a> Upāsikāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.215">an10.215</a> Visāradasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.216">an10.216</a> Saṁsappanīyasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>21. Karajakāyavagga Pisuṇavāco hoti,</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.217">an10.217</a> Paṭhamasañcetanikasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>21. Karajakāyavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.218">an10.218</a> Dutiyasañcetanikasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.219">an10.219</a> Karajakāyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.220">an10.220</a> Adhammacariyāsutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>22. Sāmaññavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.221">an10.221</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.222">an10.222</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.223">an10.223</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.224">an10.224</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.225-228">an10.225-228</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.229-232">an10.229-232</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.233-236">an10.233-236</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5></h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.237">an10.237</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.238">an10.238</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.239">an10.239</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.240-266">an10.240-266</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an10.267-746">an10.267-746</a>  <?php echo $ifRuLitTrn;?></span>
</div>
 
</div> <!-- my-3 inside nipata collapse close prev my div -->
</div> <!-- nipata collapse close prev nipata div -->
</div> <!-- nipata collapse close prev nipata div -->
<div class="level2">
	 <h3><a href=# data-bs-toggle="collapse" data-bs-target="#an11Collapse">11. Ekādasako nipāta</a></h3>
	 </div> 
	 <div class="collapse" id="an11Collapse">
	 <div class="my-3">
<div class="my-3">
<div class="level4 my-3">
		 <h5>1. Nissayavagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.1">an11.1</a> Kimatthiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.2">an11.2</a> Cetanākaraṇīyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.3">an11.3</a> Paṭhamaupanisāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.4">an11.4</a> Dutiyaupanisāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.5">an11.5</a> Tatiyaupanisāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.6">an11.6</a> Byasanasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.7">an11.7</a> Saññāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.8">an11.8</a> Manasikārasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.9">an11.9</a> Saddhasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.10">an11.10</a> Moranivāpasutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>2. Anussativagga</h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.11">an11.11</a> Paṭhamamahānāmasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.12">an11.12</a> Dutiyamahānāmasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.13">an11.13</a> Nandiyasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.14">an11.14</a> Subhūtisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.15">an11.15</a> Mettāsutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.16">an11.16</a> Aṭṭhakanāgarasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.17">an11.17</a> Gopālasutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.18">an11.18</a> Paṭhamasamādhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.19">an11.19</a> Dutiyasamādhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.20">an11.20</a> Tatiyasamādhisutta</span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.21">an11.21</a> Catutthasamādhisutta</span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5>Sāmaññavagga </h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.22-29">an11.22-29</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.30-69">an11.30-69</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.70-117">an11.70-117</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.118-165">an11.118-165</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.166-213">an11.166-213</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.214-261">an11.214-261</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.262-309">an11.262-309</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.310-357">an11.310-357</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.358-405">an11.358-405</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.406-453">an11.406-453</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.454-501">an11.454-501</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.502-981">an11.502-981</a> </span>
</div>
 
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		 <h5></h5>
 </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.982">an11.982</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.983-991">an11.983-991</a> </span>
</div>
 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=an11.992-1151">an11.992-1151</a> </span>
</div>
 
</div> <!-- Nikaya collapse -->
</div> <!-- Nikaya title + Nikaya collapse inside -->
</div>
</div><!-- Container -->
</div>
<div class="my-2">
      <div class="level1">
<h2>
  <a href="#" data-bs-toggle="collapse" data-bs-target="#knCollapse">Khuddaka Nikāya</a>
  <span style="font-size: 0.6em; vertical-align: middle;" 
        data-bs-html="true" 
        data-bs-toggle="tooltip" style="cursor: pointer;" 
        data-bs-placement="bottom" 
        title="<?php echo $tooltipknread;?>">*</span>
</h2>

      </div>
	  <div class="collapse show showkeep" id="knCollapse">
<div class="level3">
	  
	  <h3><a href=# data-bs-toggle="collapse" data-bs-target="#udCollapse">Udana</a></h3>
	  </div> 
	  <div class="collapse" id="udCollapse">  
<div class="my-3">
<div class="level4 my-3">
		   <h5>1. Bodhivagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud1.1">ud1.1</a>  Paṭhamabodhisutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud1.2">ud1.2</a>  Dutiyabodhisutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud1.3">ud1.3</a>  Tatiyabodhisutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud1.4">ud1.4</a>  Huṁhuṅkasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud1.5">ud1.5</a>  Brāhmaṇasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud1.6">ud1.6</a>  Mahākassapasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud1.7">ud1.7</a>  Ajakalāpakasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud1.8">ud1.8</a>  Saṅgāmajisutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud1.9">ud1.9</a>  Jaṭilasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud1.10">ud1.10</a>  Bāhiyasutta</span>
</div>
 </div>  <!-- close vagga div -->
  <div class="my-3">
<div class="level4 my-3">
		   <h5>2. Mucalindavagga </h5>
                  </div> 
                  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud2.1">ud2.1</a>  Mucalindasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud2.2">ud2.2</a>  Rājasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud2.3">ud2.3</a>  Daṇḍasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud2.4">ud2.4</a>  Sakkārasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud2.5">ud2.5</a>  Upāsakasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud2.6">ud2.6</a>  Gabbhinīsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud2.7">ud2.7</a>  Ekaputtakasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud2.8">ud2.8</a>  Suppavāsāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud2.9">ud2.9</a>  Visākhāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud2.10">ud2.10</a>  Bhaddiyasutta</span>
</div>

</div>  <!-- close vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>3. Nandavagga </h5>
                  </div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud3.1">ud3.1</a>  Kammavipākajasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud3.2">ud3.2</a>  Nandasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud3.3">ud3.3</a>  Yasojasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud3.4">ud3.4</a>  Sāriputtasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud3.5">ud3.5</a>  Mahāmoggallānasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud3.6">ud3.6</a>  Pilindavacchasutta <?php echo $ifRuLitTrn;?></span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud3.7">ud3.7</a>  Sakkudānasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud3.8">ud3.8</a>  Piṇḍapātikasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud3.9">ud3.9</a>  Sippasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud3.10">ud3.10</a>  Lokasutta</span>
</div>

</div>  <!-- close vagga div -->
 <div class="my-3">
<div class="level4 my-3">
		   <h5>4. Meghiyavagga </h5>
                  </div> 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud4.1">ud4.1</a>  Meghiyasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud4.2">ud4.2</a>  Uddhatasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud4.3">ud4.3</a>  Gopālakasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud4.4">ud4.4</a>  Yakkhapahārasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud4.5">ud4.5</a>  Nāgasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud4.6">ud4.6</a>  Piṇḍolasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud4.7">ud4.7</a>  Sāriputtasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud4.8">ud4.8</a>  Sundarīsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud4.9">ud4.9</a>  Upasenasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud4.10">ud4.10</a>  Sāriputtaupasamasutta</span>
</div>

</div>  <!-- close vagga div -->
  <div class="my-3">
<div class="level4 my-3">
		   <h5>5. Soṇavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud5.1">ud5.1</a>  Piyatarasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud5.2">ud5.2</a>  Appāyukasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud5.3">ud5.3</a>  Suppabuddhakuṭṭhisutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud5.4">ud5.4</a>  Kumārakasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud5.5">ud5.5</a>  Uposathasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud5.6">ud5.6</a>  Soṇasutta</span>
</div>

<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud5.7">ud5.7</a>  Kaṅkhārevatasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud5.8">ud5.8</a>  Saṅghabhedasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud5.9">ud5.9</a>  Sadhāyamānasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud5.10">ud5.10</a>  Cūḷapanthakasutta</span>
</div>
</div>  <!-- close vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>6. Jaccandhavagga </h5>
                  </div>  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud6.1">ud6.1</a>  Āyusaṅkhārossajjanasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud6.2">ud6.2</a>  Sattajaṭilasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud6.3">ud6.3</a>  Paccavekkhaṇasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud6.4">ud6.4</a>  Paṭhamanānātitthiyasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud6.5">ud6.5</a>  Dutiyanānātitthiyasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud6.6">ud6.6</a>  Tatiyanānātitthiyasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud6.7">ud6.7</a>  Subhūtisutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud6.8">ud6.8</a>  Gaṇikāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud6.9">ud6.9</a>  Upātidhāvantisutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud6.10">ud6.10</a>  Uppajjantisutta</span>
</div>
  </div>  <!-- close vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>7. Cūḷavagga </h5>
                  </div>  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud7.1">ud7.1</a>  Paṭhamalakuṇḍakabhaddiyasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud7.2">ud7.2</a>  Dutiyalakuṇḍakabhaddiyasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud7.3">ud7.3</a>  Paṭhamasattasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud7.4">ud7.4</a>  Dutiyasattasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud7.5">ud7.5</a>  Aparalakuṇḍakabhaddiyasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud7.6">ud7.6</a>  Taṇhāsaṅkhayasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud7.7">ud7.7</a>  Papañcakhayasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud7.8">ud7.8</a>  Kaccānasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud7.9">ud7.9</a>  Udapānasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud7.10">ud7.10</a>  Utenasutta</span>
</div>
  
  </div>  <!-- close vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>8. Pāṭaligāmiyavagga </h5>
                  </div>  
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud8.1">ud8.1</a>  Paṭhamanibbānapaṭisaṁyuttasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud8.2">ud8.2</a>  Dutiyanibbānapaṭisaṁyuttasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud8.3">ud8.3</a>  Tatiyanibbānapaṭisaṁyuttasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud8.4">ud8.4</a>  Catutthanibbānapaṭisaṁyuttasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud8.5">ud8.5</a>  Cundasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud8.6">ud8.6</a>  Pāṭaligāmiyasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud8.7">ud8.7</a>  Dvidhāpathasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud8.8">ud8.8</a>  Visākhāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud8.9">ud8.9</a>  Paṭhamadabbasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=ud8.10">ud8.10</a>  Dutiyadabbasutta</span>
</div>

</div> <!-- close prev vagga div -->

</div> <!-- close ud div -->
<div class="level3">
	  <h3><a href=# data-bs-toggle="collapse" data-bs-target="#itiCollapse">Itivuttaka</a></h3>
	  </div> 
	  <div class="collapse" id="itiCollapse">

<div class="level3">
	  <h3><a href=# data-bs-toggle="collapse" data-bs-target="#iti1Collapse">1. Ekakanipāta</a></h3>
	  </div> 
	  <div class="collapse" id="iti1Collapse">

<div class="my-3">
<div class="level4 my-3">
		   <h5>1. Paṭhamavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti1">iti1</a>  Lobhasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti2">iti2</a>  Dosasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti3">iti3</a>  Mohasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti4">iti4</a>  Kodhasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti5">iti5</a>  Makkhasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti6">iti6</a>  Mānasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti7">iti7</a>  Sabbapariññāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti8">iti8</a>  Mānapariññāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti9">iti9</a>  Lobhapariññāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti10">iti10</a>  Dosapariññāsutta</span>
</div>

</div> <!-- close prev vagga div -->
 <!--  <div class="my-3">
<div class="level4 my-3">
		   <h5>Paṭhamavagga Pakāsitā vaggamāhu</h5>
                  </div>

  
</div>close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>2. Dutiyavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti11">iti11</a>  Mohapariññāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti12">iti12</a>  Kodhapariññāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti13">iti13</a>  Makkhapariññāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti14">iti14</a>  Avijjānīvaraṇasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti15">iti15</a>  Taṇhāsaṁyojanasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti16">iti16</a>  Paṭhamasekhasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti17">iti17</a>  Dutiyasekhasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti18">iti18</a>  Saṅghabhedasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti19">iti19</a>  Saṅghasāmaggīsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti20">iti20</a>  Paduṭṭhacittasutta</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>3. Tatiyavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti21">iti21</a>  Pasannacittasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti22">iti22</a>  Mettasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti23">iti23</a>  Ubhayatthasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti24">iti24</a>  Aṭṭhipuñjasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti25">iti25</a>  Musāvādasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti26">iti26</a>  Dānasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti27">iti27</a>  Mettābhāvanāsutta</span>
</div>
  
</div> <!-- close prev vagga div -->
</div> <!-- close prev vagga div -->

<div class="level3">
	  <h3><a href=# data-bs-toggle="collapse" data-bs-target="#iti2Collapse">2. Dukanipāta</a></h3>
	  </div> 
	  <div class="collapse" id="iti2Collapse">


<div class="my-3">
<div class="level4 my-3">
		   <h5>1. Paṭhamavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti28">iti28</a>  Dukkhavihārasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti29">iti29</a>  Sukhavihārasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti30">iti30</a>  Tapanīyasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti31">iti31</a>  Atapanīyasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti32">iti32</a>  Paṭhamasīlasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti33">iti33</a>  Dutiyasīlasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti34">iti34</a>  Ātāpīsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti35">iti35</a>  Paṭhamajananakuhanasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti36">iti36</a>  Dutiyajananakuhanasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti37">iti37</a>  Somanassasutta</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>2. Dutiyavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti38">iti38</a>  Vitakkasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti39">iti39</a>  Desanāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti40">iti40</a>  Vijjāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti41">iti41</a>  Paññāparihīnasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti42">iti42</a>  Sukkadhammasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti43">iti43</a>  Ajātasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti44">iti44</a>  Nibbānadhātusutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti45">iti45</a>  Paṭisallānasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti46">iti46</a>  Sikkhānisaṁsasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti47">iti47</a>  Jāgariyasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti48">iti48</a>  Āpāyikasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti49">iti49</a>  Diṭṭhigatasutta</span>
</div>
  
</div> <!-- close prev vagga div -->
</div> <!-- close prev vagga div -->

<div class="level3">
	  <h3><a href=# data-bs-toggle="collapse" data-bs-target="#iti3Collapse">3. Tikanipāta</a></h3>
	  </div> 
	  <div class="collapse" id="iti3Collapse">

<div class="my-3">
<div class="level4 my-3">
		   <h5>1. Paṭhamavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti50">iti50</a>  Mūlasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti51">iti51</a>  Dhātusutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti52">iti52</a>  Paṭhamavedanāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti53">iti53</a>  Dutiyavedanāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti54">iti54</a>  Paṭhamaesanāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti55">iti55</a>  Dutiyaesanāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti56">iti56</a>  Paṭhamaāsavasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti57">iti57</a>  Dutiyaāsavasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti58">iti58</a>  Taṇhāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti59">iti59</a>  Māradheyyasutta</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>2. Dutiyavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti60">iti60</a>  Puññakiriyavatthusutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti61">iti61</a>  Cakkhusutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti62">iti62</a>  Indriyasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti63">iti63</a>  Addhāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti64">iti64</a>  Duccaritasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti65">iti65</a>  Sucaritasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti66">iti66</a>  Soceyyasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti67">iti67</a>  Moneyyasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti68">iti68</a>  Paṭhamarāgasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti69">iti69</a>  Dutiyarāgasutta</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>3. Tatiyavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti70">iti70</a>  Micchādiṭṭhikasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti71">iti71</a>  Sammādiṭṭhikasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti72">iti72</a>  Nissaraṇiyasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti73">iti73</a>  Santatarasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti74">iti74</a>  Puttasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti75">iti75</a>  Avuṭṭhikasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti76">iti76</a>  Sukhapatthanāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti77">iti77</a>  Bhidurasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti78">iti78</a>  Dhātusosaṁsandanasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti79">iti79</a>  Parihānasutta</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>4. Catutthavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti80">iti80</a>  Vitakkasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti81">iti81</a>  Sakkārasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti82">iti82</a>  Devasaddasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti83">iti83</a>  Pañcapubbanimittasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti84">iti84</a>  Bahujanahitasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti85">iti85</a>  Asubhānupassīsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti86">iti86</a>  Dhammānudhammapaṭipannasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti87">iti87</a>  Andhakaraṇasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti88">iti88</a>  Antarāmalasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti89">iti89</a>  Devadattasutta</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>5. Pañcamavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti90">iti90</a>  Aggappasādasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti91">iti91</a>  Jīvikasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti92">iti92</a>  Saṅghāṭikaṇṇasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti93">iti93</a>  Aggisutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti94">iti94</a>  Upaparikkhasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti95">iti95</a>  Kāmūpapattisutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti96">iti96</a>  Kāmayogasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti97">iti97</a>  Kalyāṇasīlasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti98">iti98</a>  Dānasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti99">iti99</a>  Tevijjasutta</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>6. Brāhmaṇadhammayāgavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti100">iti100</a>  Brāhmaṇadhammayāgasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti101">iti101</a>  Sulabhasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti102">iti102</a>  Āsavakkhayasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti103">iti103</a>  Samaṇabrāhmaṇasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti104">iti104</a>  Sīlasampannasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti105">iti105</a>  Taṇhuppādasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti106">iti106</a>  Sabrahmakasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti107">iti107</a>  Bahukārasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti108">iti108</a>  Kuhasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti109">iti109</a>  Nadīsotasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti110">iti110</a>  Carasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti111">iti111</a>  Sampannasīlasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=iti112">iti112</a>  Lokasutta</span>
</div>
  
</div> <!-- close prev vagga div -->


</div>  <!-- close iti div -->
</div>  <!-- close iti div -->

<div class="level3">
	  <h3><a href=# data-bs-toggle="collapse" data-bs-target="#snpCollapse">Sutta Nipāta</a></h3>
	  </div> 
	  <div class="collapse" id="snpCollapse">



<div class="my-3">
<div class="level4 my-3">
		   <h5>1. Uragavagga </h5>
                  </div>

<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp1.1">snp1.1</a>  Uragasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp1.2">snp1.2</a>  Dhaniyasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp1.3">snp1.3</a>  Khaggavisāṇasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp1.4">snp1.4</a>  Kasibhāradvājasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp1.5">snp1.5</a>  Cundasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp1.6">snp1.6</a>  Parābhavasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp1.7">snp1.7</a>  Vasalasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp1.8">snp1.8</a>  Mettasutta <?php echo $ifRuLitTrn;?></span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp1.9">snp1.9</a>  Hemavatasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp1.10">snp1.10</a>  Āḷavakasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp1.11">snp1.11</a>  Vijayasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp1.12">snp1.12</a>  Munisutta</span>
</div>
  </div> <!-- close prev vagga div -->
  
 <div class="my-3">
<div class="level4 my-3">
		   <h5>2. Cūḷavagga </h5>
                  </div> 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp2.1">snp2.1</a>  Ratanasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp2.2">snp2.2</a>  Āmagandhasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp2.3">snp2.3</a>  Hirisutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp2.4">snp2.4</a>  Maṅgalasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp2.5">snp2.5</a>  Sūcilomasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp2.6">snp2.6</a>  Kapilasutta (dhammacariyasutta)</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp2.7">snp2.7</a>  Brāhmaṇadhammikasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp2.8">snp2.8</a>  Dhamma (nāvā) sutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp2.9">snp2.9</a>  Kiṁsīlasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp2.10">snp2.10</a>  Uṭṭhānasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp2.11">snp2.11</a>  Rāhulasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp2.12">snp2.12</a>  Nigrodhakappa (vaṅgīsa) sutta</span>
</div>
  

<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp2.13">snp2.13</a>  Sammāparibbājanīyasutta</span>
</div>
  

<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp2.14">snp2.14</a>  Dhammikasutta</span>
</div>
  
</div> <!-- close prev vagga div -->  
<div class="my-3">
<div class="level4 my-3">
		   <h5>3. Mahāvagga</h5>
                  </div>
<div class="my-3">
<div class="level4 my-3">
		   <h5></h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp3.1">snp3.1</a>  Pabbajjāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp3.2">snp3.2</a>  Padhānasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp3.3">snp3.3</a>  Subhāsitasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp3.4">snp3.4</a>  Pūraḷāsa (sundarikabhāradvāja) sutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp3.5">snp3.5</a>  Māghasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp3.6">snp3.6</a>  Sabhiyasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp3.7">snp3.7</a>  Selasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp3.8">snp3.8</a>  Sallasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp3.9">snp3.9</a>  Vāseṭṭhasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp3.10">snp3.10</a>  Kokālikasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp3.11">snp3.11</a>  Nālakasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp3.12">snp3.12</a>  Dvayatānupassanāsutta</span>
</div>
  </div> <!-- close prev vagga div -->  
<div class="my-3">
<div class="level4 my-3">
		   <h5>4. Aṭṭhakavagga</h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp4.1">snp4.1</a>  Kāmasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp4.2">snp4.2</a>  Guhaṭṭhakasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp4.3">snp4.3</a>  Duṭṭhaṭṭhakasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp4.4">snp4.4</a>  Suddhaṭṭhakasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp4.5">snp4.5</a>  Paramaṭṭhakasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp4.6">snp4.6</a>  Jarāsutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp4.7">snp4.7</a>  Tissametteyyasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp4.8">snp4.8</a>  Pasūrasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp4.9">snp4.9</a>  Māgaṇḍiyasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp4.10">snp4.10</a>  Purābhedasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp4.11">snp4.11</a>  Kalahavivādasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp4.12">snp4.12</a>  Cūḷabyūhasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp4.13">snp4.13</a>  Mahābyūhasutta</span>
</div>
  
<div class="my-3">
<div class="level4 my-3">
		   <h5></h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp4.14">snp4.14</a>  Tuvaṭakasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp4.15">snp4.15</a>  Attadaṇḍasutta</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp4.16">snp4.16</a>  Sāriputtasutta</span>
</div>
  </div> <!-- close prev vagga div -->  
<div class="my-3">
<div class="level4 my-3">
		   <h5>5. Pārāyanavagga</h5>
                  </div>

 
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp5.1">snp5.1</a>Vatthugāthā
</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp5.2">snp5.2</a>  Ajitamāṇavapucchā
</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp5.3">snp5.3</a>  Tissametteyyamāṇavapucchā
</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp5.4">snp5.4</a>  Puṇṇakamāṇavapucchā
</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp5.5">snp5.5</a>  Mettagūmāṇavapucchā
</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp5.6">snp5.6</a>  Dhotakamāṇavapucchā
</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp5.7">snp5.7</a>  Upasīvamāṇavapucchā
</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp5.8">snp5.8</a>  Nandamāṇavapucchā
</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp5.9">snp5.9</a>  Hemakamāṇavapucchā
</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp5.10">snp5.10</a>  Todeyyamāṇavapucchā
</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp5.11">snp5.11</a>  Kappamāṇavapucchā
</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp5.12">snp5.12</a>  Jatukaṇṇimāṇavapucchā
</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp5.13">snp5.13</a>  Bhadrāvudhamāṇavapucchā
</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp5.14">snp5.14</a>  Udayamāṇavapucchā
</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp5.15">snp5.15</a>  Posālamāṇavapucchā
</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp5.16">snp5.16</a>  Mogharājamāṇavapucchā
</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp5.17">snp5.17</a>  Piṅgiyamāṇavapucchā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp5.18">snp5.18</a>  Pārāyanatthutigāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=snp5.19">snp5.19</a>  Pārāyanānugītigāthā</span>
</div>
  



  
</div> <!-- close prev vagga div -->
</div>  <!-- close snp div -->
</div>  <!-- close snp div -->
</div>  <!-- close snp div -->
<div class="level3">
	  <h3><a href=# data-bs-toggle="collapse" data-bs-target="#dhpCollapse">Dhammapada</a></h3>
	  </div> 
	  <div class="collapse" id="dhpCollapse">


<div class="my-3">
<div class="level4 my-3">
		   <h5>Yamakavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp1-20">dhp1-20</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Appamādavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp21-32">dhp21-32</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Cittavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp33-43">dhp33-43</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Pupphavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp44-59">dhp44-59</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Bālavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp60-75">dhp60-75</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Paṇḍitavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp76-89">dhp76-89</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Arahantavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp90-99">dhp90-99</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Sahassavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp100-115">dhp100-115</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Pāpavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp116-128">dhp116-128</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Daṇḍavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp129-145">dhp129-145</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Jarāvagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp146-156">dhp146-156</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Attavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp157-166">dhp157-166</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Lokavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp167-178">dhp167-178</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Buddhavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp179-196">dhp179-196</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Sukhavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp197-208">dhp197-208</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Piyavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp209-220">dhp209-220</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Kodhavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp221-234">dhp221-234</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Malavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp235-255">dhp235-255</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Dhammaṭṭhavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp256-272">dhp256-272</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Maggavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp273-289">dhp273-289</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Pakiṇṇakavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp290-305">dhp290-305</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Nirayavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp306-319">dhp306-319</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Nāgavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp320-333">dhp320-333</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Taṇhāvagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp334-359">dhp334-359</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Bhikkhuvagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp360-382">dhp360-382</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>Brāhmaṇavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=dhp383-423">dhp383-423</a> </span>
</div>
  
</div> <!-- close prev vagga div -->
	  </div>  <!-- close dhp div -->


<div class="level3">

	  <h3><a href=# data-bs-toggle="collapse" data-bs-target="#thagCollapse">Theragāthā</a></h3>
	  </div> 
	  <div class="collapse" id="thagCollapse">

<div class="level3">
	  <h3><a href=# data-bs-toggle="collapse" data-bs-target="#thag1Collapse">1. Ekakanipāta</a></h3>
	  </div> 
	  <div class="collapse" id="thag1Collapse">

<div class="my-3">
<div class="level4 my-3">
		   <h5>1. Paṭhamavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.1">thag1.1</a>  Subhūtittheragāthā
 Nidānagāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.2">thag1.2</a>  Mahākoṭṭhikattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.3">thag1.3</a>  Kaṅkhārevatattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.4">thag1.4</a>  Puṇṇattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.5">thag1.5</a>  Dabbattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.6">thag1.6</a>  Sītavaniyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.7">thag1.7</a>  Bhalliyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.8">thag1.8</a>  Vīrattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.9">thag1.9</a>  Pilindavacchattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.10">thag1.10</a>  Puṇṇamāsattheragāthā</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>2. Dutiyavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.11">thag1.11</a>  Cūḷavacchattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.12">thag1.12</a>  Mahāvacchattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.13">thag1.13</a>  Vanavacchattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.14">thag1.14</a>  Sivakasāmaṇeragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.15">thag1.15</a>  Kuṇḍadhānattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.16">thag1.16</a>  Belaṭṭhasīsattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.17">thag1.17</a>  Dāsakattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.18">thag1.18</a>  Siṅgālapituttheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.19">thag1.19</a>  Kulattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.20">thag1.20</a>  Ajitattheragāthā</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>3. Tatiyavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.21">thag1.21</a>  Nigrodhattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.22">thag1.22</a>  Cittakattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.23">thag1.23</a>  Gosālattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.24">thag1.24</a>  Sugandhattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.25">thag1.25</a>  Nandiyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.26">thag1.26</a>  Abhayattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.27">thag1.27</a>  Lomasakaṅgiyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.28">thag1.28</a>  Jambugāmikaputtattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.29">thag1.29</a>  Hāritattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.30">thag1.30</a>  Uttiyattheragāthā</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>4. Catutthavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.31">thag1.31</a>  Gahvaratīriyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.32">thag1.32</a>  Suppiyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.33">thag1.33</a>  Sopākattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.34">thag1.34</a>  Posiyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.35">thag1.35</a>  Sāmaññakānittheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.36">thag1.36</a>  Kumāputtattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.37">thag1.37</a>  Kumāputtasahāyakattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.38">thag1.38</a>  Gavampatittheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.39">thag1.39</a>  Tissattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.40">thag1.40</a>  Vaḍḍhamānattheragāthā</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>5. Pañcamavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.41">thag1.41</a>  Sirivaḍḍhattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.42">thag1.42</a>  Khadiravaniyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.43">thag1.43</a>  Sumaṅgalattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.44">thag1.44</a>  Sānuttheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.45">thag1.45</a>  Ramaṇīyavihārittheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.46">thag1.46</a>  Samiddhittheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.47">thag1.47</a>  Ujjayattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.48">thag1.48</a>  Sañjayattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.49">thag1.49</a>  Rāmaṇeyyakattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.50">thag1.50</a>  Vimalattheragāthā</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>6. Chaṭṭhavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.51">thag1.51</a>  Godhikattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.52">thag1.52</a>  Subāhuttheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.53">thag1.53</a>  Valliyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.54">thag1.54</a>  Uttiyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.55">thag1.55</a>  Añjanavaniyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.56">thag1.56</a>  Kuṭivihārittheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.57">thag1.57</a>  Dutiyakuṭivihārittheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.58">thag1.58</a>  Ramaṇīyakuṭikattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.59">thag1.59</a>  Kosalavihārittheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.60">thag1.60</a>  Sīvalittheragāthā</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>7. Sattamavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.61">thag1.61</a>  Vappattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.62">thag1.62</a>  Vajjiputtattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.63">thag1.63</a>  Pakkhattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.64">thag1.64</a>  Vimalakoṇḍaññattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.65">thag1.65</a>  Ukkhepakatavacchattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.66">thag1.66</a>  Meghiyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.67">thag1.67</a>  Ekadhammasavanīyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.68">thag1.68</a>  Ekudāniyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.69">thag1.69</a>  Channattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.70">thag1.70</a>  Puṇṇattheragāthā</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>8. Aṭṭhamavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.71">thag1.71</a>  Vacchapālattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.72">thag1.72</a>  Ātumattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.73">thag1.73</a>  Māṇavattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.74">thag1.74</a>  Suyāmanattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.75">thag1.75</a>  Susāradattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.76">thag1.76</a>  Piyañjahattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.77">thag1.77</a>  Hatthārohaputtattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.78">thag1.78</a>  Meṇḍasirattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.79">thag1.79</a>  Rakkhitattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.80">thag1.80</a>  Uggattheragāthā</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>9. Navamavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.81">thag1.81</a>  Samitiguttattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.82">thag1.82</a>  Kassapattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.83">thag1.83</a>  Sīhattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.84">thag1.84</a>  Nītattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.85">thag1.85</a>  Sunāgattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.86">thag1.86</a>  Nāgitattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.87">thag1.87</a>  Paviṭṭhattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.88">thag1.88</a>  Ajjunattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.89">thag1.89</a>  (Paṭhama) Devasabhattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.90">thag1.90</a>  Sāmidattattheragāthā</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>10. Dasamavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.91">thag1.91</a>  Paripuṇṇakattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.92">thag1.92</a>  Vijayattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.93">thag1.93</a>  Erakattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.94">thag1.94</a>  Mettajittheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.95">thag1.95</a>  Cakkhupālattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.96">thag1.96</a>  Khaṇḍasumanattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.97">thag1.97</a>  Tissattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.98">thag1.98</a>  Abhayattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.99">thag1.99</a>  Uttiyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.100">thag1.100</a>  (Dutiya) Devasabhattheragāthā</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>11. Ekādasamavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.101">thag1.101</a>  Belaṭṭhānikattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.102">thag1.102</a>  Setucchattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.103">thag1.103</a>  Bandhurattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.104">thag1.104</a>  Khitakattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.105">thag1.105</a>  Malitavambhattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.106">thag1.106</a>  Suhemantattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.107">thag1.107</a>  Dhammasavattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.108">thag1.108</a>  Dhammasavapituttheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.109">thag1.109</a>  Saṅgharakkhitattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.110">thag1.110</a>  Usabhattheragāthā</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>12. Dvādasamavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.111">thag1.111</a>  Jentattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.112">thag1.112</a>  Vacchagottattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.113">thag1.113</a>  Vanavacchattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.114">thag1.114</a>  Adhimuttattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.115">thag1.115</a>  Mahānāmattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.116">thag1.116</a>  Pārāpariyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.117">thag1.117</a>  Yasattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.118">thag1.118</a>  Kimilattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.119">thag1.119</a>  Vajjiputtattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag1.120">thag1.120</a>  Isidattattheragāthā</span>
</div>
  
</div> <!-- close prev vagga div -->
</div> <!-- close prev ekekanipata div -->

<div class="level3">
	  <h3><a href=# data-bs-toggle="collapse" data-bs-target="#thag2Collapse">2. Dukanipāta</a></h3>
	  </div> 
	  <div class="collapse" id="thag2Collapse">

<div class="my-3">
<div class="level4 my-3">
		   <h5>1. Paṭhamavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.1">thag2.1</a>  Uttarattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.2">thag2.2</a>  Piṇḍolabhāradvājattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.3">thag2.3</a>  Valliyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.4">thag2.4</a>  Gaṅgātīriyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.5">thag2.5</a>  Ajinattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.6">thag2.6</a>  Meḷajinattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.7">thag2.7</a>  Rādhattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.8">thag2.8</a>  Surādhattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.9">thag2.9</a>  Gotamattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.10">thag2.10</a>  Vasabhattheragāthā</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>2. Dutiyavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.11">thag2.11</a>  Mahācundattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.12">thag2.12</a>  Jotidāsattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.13">thag2.13</a>  Heraññakānittheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.14">thag2.14</a>  Somamittattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.15">thag2.15</a>  Sabbamittattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.16">thag2.16</a>  Mahākāḷattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.17">thag2.17</a>  Tissattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.18">thag2.18</a>  Kimilattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.19">thag2.19</a>  Nandattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.20">thag2.20</a>  Sirimattheragāthā</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>3. Tatiyavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.21">thag2.21</a>  Uttarattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.22">thag2.22</a>  Bhaddajittheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.23">thag2.23</a>  Sobhitattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.24">thag2.24</a>  Valliyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.25">thag2.25</a>  Vītasokattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.26">thag2.26</a>  Puṇṇamāsattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.27">thag2.27</a>  Nandakattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.28">thag2.28</a>  Bharatattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.29">thag2.29</a>  Bhāradvājattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.30">thag2.30</a>  Kaṇhadinnattheragāthā</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>4. Catutthavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.31">thag2.31</a>  Migasirattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.32">thag2.32</a>  Sivakattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.33">thag2.33</a>  Upavāṇattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.34">thag2.34</a>  Isidinnattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.35">thag2.35</a>  Sambulakaccānattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.36">thag2.36</a>  Nitakattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.37">thag2.37</a>  Soṇapoṭiriyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.38">thag2.38</a>  Nisabhattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.39">thag2.39</a>  Usabhattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.40">thag2.40</a>  Kappaṭakurattheragāthā</span>
</div>
  
</div> <!-- close prev vagga div -->
<div class="my-3">
<div class="level4 my-3">
		   <h5>5. Pañcamavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.41">thag2.41</a>  Kumārakassapattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.42">thag2.42</a>  Dhammapālattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.43">thag2.43</a>  Brahmālittheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.44">thag2.44</a>  Mogharājattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.45">thag2.45</a>  Visākhapañcālaputtattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.46">thag2.46</a>  Cūḷakattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.47">thag2.47</a>  Anūpamattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.48">thag2.48</a>  Vajjitattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag2.49">thag2.49</a>  Sandhitattheragāthā</span>
</div>
  
</div> <!-- close prev vagga div -->
</div> <!-- close prev dukanupata div -->

<div class="level3">
	  <h3><a href=# data-bs-toggle="collapse" data-bs-target="#thag3Collapse">3. Tikanipāta</a></h3>
	  </div> 
	  <div class="collapse" id="thag3Collapse">


<div class="level4 my-3">
		   <h5>1. Paṭhamavagga </h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag3.1">thag3.1</a>  Aṅgaṇikabhāradvājattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag3.2">thag3.2</a>  Paccayattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag3.3">thag3.3</a>  Bākulattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag3.4">thag3.4</a>  Dhaniyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag3.5">thag3.5</a>  Mātaṅgaputtattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag3.6">thag3.6</a>  Khujjasobhitattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag3.7">thag3.7</a>  Vāraṇattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag3.8">thag3.8</a>  Vassikattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag3.9">thag3.9</a>  Yasojattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag3.10">thag3.10</a>  Sāṭimattiyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag3.11">thag3.11</a>  Upālittheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag3.12">thag3.12</a>  Uttarapālattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag3.13">thag3.13</a>  Abhibhūtattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag3.14">thag3.14</a>  Gotamattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag3.15">thag3.15</a>  Hāritattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag3.16">thag3.16</a>  Vimalattheragāthā</span>
</div>
</div> 
  
  <div class="level3">
	  <h3><a href=# data-bs-toggle="collapse" data-bs-target="#iti4Collapse">4. Catukkanipāta</a></h3>
	  </div> 
	  <div class="collapse" id="iti4Collapse">
  
<div class="level4 my-3">
		   <h5>1. Paṭhamavagga </h5>
                  </div>  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag4.1">thag4.1</a>  Nāgasamālattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag4.2">thag4.2</a>  Bhaguttheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag4.3">thag4.3</a>  Sabhiyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag4.4">thag4.4</a>  Nandakattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag4.5">thag4.5</a>  Jambukattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag4.6">thag4.6</a>  Senakattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag4.7">thag4.7</a>  Sambhūtattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag4.8">thag4.8</a>  Rāhulattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag4.9">thag4.9</a>  Candanattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag4.10">thag4.10</a>  Dhammikattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag4.11">thag4.11</a>  Sappakattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag4.12">thag4.12</a>  Muditattheragāthā <?php echo $ifRuLitTrn;?></span>
</div>
</div>
  
  <div class="level3">
	  <h3><a href=# data-bs-toggle="collapse" data-bs-target="#thag5Collapse">5. Pañcakanipāta</a></h3>
	  </div> 
	  <div class="collapse" id="thag5Collapse">

  
  <div class="level4 my-3">
		   <h5>1. Paṭhamavagga </h5>
                  </div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag5.1">thag5.1</a>  Rājadattattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag5.2">thag5.2</a>  Subhūtattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag5.3">thag5.3</a>  Girimānandattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag5.4">thag5.4</a>  Sumanattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag5.5">thag5.5</a>  Vaḍḍhattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag5.6">thag5.6</a>  Nadīkassapattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag5.7">thag5.7</a>  Gayākassapattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag5.8">thag5.8</a>  Vakkalittheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag5.9">thag5.9</a>  Vijitasenattheragāthā</span>
</div>
  

<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag5.10">thag5.10</a>  Yasadattattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag5.11">thag5.11</a>  Soṇakuṭikaṇṇattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag5.12">thag5.12</a>  Kosiyattheragāthā</span>
</div>
</div>
  
   <div class="level3">
	  <h3><a href=# data-bs-toggle="collapse" data-bs-target="#thag6Collapse">6. Chakkanipāta</a></h3>
	  </div> 
	  <div class="collapse" id="thag6Collapse">

  
  <div class="level4 my-3">
		   <h5>1. Paṭhamavagga </h5>
                  </div>
   
  
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag6.1">thag6.1</a>  Uruveḷakassapattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag6.2">thag6.2</a>  Tekicchakārittheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag6.3">thag6.3</a>  Mahānāgattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag6.4">thag6.4</a>  Kullattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag6.5">thag6.5</a>  Mālukyaputtattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag6.6">thag6.6</a>  Sappadāsattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag6.7">thag6.7</a>  Kātiyānattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag6.8">thag6.8</a>  Migajālattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag6.9">thag6.9</a>  Purohitaputtajentattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag6.10">thag6.10</a>  Sumanattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag6.11">thag6.11</a>  Nhātakamunittheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag6.12">thag6.12</a>  Brahmadattattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag6.13">thag6.13</a>  Sirimaṇḍattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag6.14">thag6.14</a>  Sabbakāmittheragāthā</span>
</div>
</div>
    <div class="level3">
	  <h3><a href=# data-bs-toggle="collapse" data-bs-target="#thag7Collapse">7. Sattakanipāta</a></h3>
	  </div> 
	  <div class="collapse" id="thag7Collapse">

  
  <div class="level4 my-3">
		   <h5>1. Paṭhamavagga </h5>
                  </div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag7.1">thag7.1</a>  Sundarasamuddattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag7.2">thag7.2</a>  Lakuṇḍakabhaddiyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag7.3">thag7.3</a>  Bhaddattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag7.4">thag7.4</a>  Sopākattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag7.5">thag7.5</a>  Sarabhaṅgattheragāthā</span>
</div>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag8.1">thag8.1</a>  Mahākaccāyanattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag8.2">thag8.2</a>  Sirimittattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag8.3">thag8.3</a>  Mahāpanthakattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag9.1">thag9.1</a>  Bhūtattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag10.1">thag10.1</a>  Kāḷudāyittheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag10.2">thag10.2</a>  Ekavihāriyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag10.3">thag10.3</a>  Mahākappinattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag10.4">thag10.4</a>  Cūḷapanthakattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag10.5">thag10.5</a>  Kappattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag10.6">thag10.6</a>  Vaṅgantaputtaupasenattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag10.7">thag10.7</a>  (Apara) Gotamattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag11.1">thag11.1</a>  Saṅkiccattheragāthā</span>
</div>


<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag12.1">thag12.1</a>  Sīlavattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag12.2">thag12.2</a>  Sunītattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag13.1">thag13.1</a>  Soṇakoḷivisattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag14.1">thag14.1</a>  Khadiravaniyarevatattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag14.2">thag14.2</a>  Godattattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag15.1">thag15.1</a>  Aññāsikoṇḍaññattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag15.2">thag15.2</a>  Udāyittheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag16.1">thag16.1</a>  Adhimuttattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag16.2">thag16.2</a>  Pārāpariyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag16.3">thag16.3</a>  Telakānittheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag16.4">thag16.4</a>  Raṭṭhapālattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag16.5">thag16.5</a>  Mālukyaputtattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag16.6">thag16.6</a>  Selattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag16.7">thag16.7</a>  Kāḷigodhāputtabhaddiyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag16.8">thag16.8</a>  Aṅgulimālattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag16.9">thag16.9</a>  Anuruddhattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag16.10">thag16.10</a>  Pārāpariyattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag17.1">thag17.1</a>  Phussattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag17.2">thag17.2</a>  Sāriputtattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag17.3">thag17.3</a>  Ānandattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag18.1">thag18.1</a>  Mahākassapattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag19.1">thag19.1</a>  Tālapuṭattheragāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag20.1">thag20.1</a>  Mahāmoggallānattheragāthā</span>
</div>
  


<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thag21.1">thag21.1</a>  Vaṅgīsattheragāthā</span>
</div>
  


</div> <!-- close prev thag div -->

<div class="level3">
	  <h3><a href=# data-bs-toggle="collapse" data-bs-target="#thigCollapse">Therīgāthā</a></h3>
	  </div> 
	  <div class="collapse" id="thigCollapse">


<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig1.1">thig1.1</a>  Aññatarātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig1.2">thig1.2</a>  Muttātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig1.3">thig1.3</a>  Puṇṇātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig1.4">thig1.4</a>  Tissātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig1.5">thig1.5</a>  Aññatarātissātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig1.6">thig1.6</a>  Dhīrātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig1.7">thig1.7</a>  Vīrātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig1.8">thig1.8</a>  Mittātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig1.9">thig1.9</a>  Bhadrātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig1.10">thig1.10</a>  Upasamātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig1.11">thig1.11</a>  Muttātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig1.12">thig1.12</a>  Dhammadinnātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig1.13">thig1.13</a>  Visākhātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig1.14">thig1.14</a>  Sumanātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig1.15">thig1.15</a>  Uttarātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig1.16">thig1.16</a>  Vuḍḍhapabbajitasumanātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig1.17">thig1.17</a>  Dhammātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig1.18">thig1.18</a>  Saṅghātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig2.1">thig2.1</a>  Abhirūpanandātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig2.2">thig2.2</a>  Jentātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig2.3">thig2.3</a>  Sumaṅgalamātātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig2.4">thig2.4</a>  Aḍḍhakāsitherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig2.5">thig2.5</a>  Cittātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig2.6">thig2.6</a>  Mettikātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig2.7">thig2.7</a>  Mittātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig2.8">thig2.8</a>  Abhayamātutherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig2.9">thig2.9</a>  Abhayātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig2.10">thig2.10</a>  Sāmātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig3.1">thig3.1</a>  Aparāsāmātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig3.2">thig3.2</a>  Uttamātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig3.3">thig3.3</a>  Aparāuttamātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig3.4">thig3.4</a>  Dantikātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig3.5">thig3.5</a>  Ubbiritherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig3.6">thig3.6</a>  Sukkātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig3.7">thig3.7</a>  Selātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig3.8">thig3.8</a>  Somātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig4.1">thig4.1</a>  Bhaddākāpilānītherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig5.1">thig5.1</a>  Aññataratherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig5.2">thig5.2</a>  Vimalātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig5.3">thig5.3</a>  Sīhātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig5.4">thig5.4</a>  Sundarīnandātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig5.5">thig5.5</a>  Nanduttarātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig5.6">thig5.6</a>  Mittākāḷītherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig5.7">thig5.7</a>  Sakulātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig5.8">thig5.8</a>  Soṇātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig5.9">thig5.9</a>  Bhaddākuṇḍalakesātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig5.10">thig5.10</a>  Paṭācārātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig5.11">thig5.11</a>  Tiṁsamattātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig5.12">thig5.12</a>  Candātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig6.1">thig6.1</a>  Pañcasatamattātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig6.2">thig6.2</a>  Vāseṭṭhītherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig6.3">thig6.3</a>  Khemātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig6.4">thig6.4</a>  Sujātātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig6.5">thig6.5</a>  Anopamātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig6.6">thig6.6</a>  Mahāpajāpatigotamītherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig6.7">thig6.7</a>  Guttātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig6.8">thig6.8</a>  Vijayātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig7.1">thig7.1</a>  Uttarātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig7.2">thig7.2</a>  Cālātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig7.3">thig7.3</a>  Upacālātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig8.1">thig8.1</a>  Sīsūpacālātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig9.1">thig9.1</a>  Vaḍḍhamātutherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig10.1">thig10.1</a>  Kisāgotamītherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig11.1">thig11.1</a>  Uppalavaṇṇātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig12.1">thig12.1</a>  Puṇṇātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig13.1">thig13.1</a>  Ambapālītherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig13.2">thig13.2</a>  Rohinītherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig13.3">thig13.3</a>  Cāpātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig13.4">thig13.4</a>  Sundarītherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig13.5">thig13.5</a>  Subhākammāradhītutherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig14.1">thig14.1</a>  Subhājīvakambavanikātherīgāthā</span>
</div>
  
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig15.1">thig15.1</a>  Isidāsītherīgāthā</span>
</div>
  
<div class="my-3">
<div class="level4 my-3">
		   <h5></h5>
                  </div>
<div class="mt-3">
<span class="level5"><a class="setReader" href="<?php echo $readerPage;?>/?q=thig16.1">thig16.1</a>  Sumedhātherīgāthā</span>
</div>




  </div>  <!-- close thig div -->
  </div>  <!-- close thig div -->


</div> <!-- Nikaya collapse -->
</div> <!-- Nikaya title + Nikaya collapse inside -->

<script src="/assets/js/tocjs.js"></script>
</div>

<!-- Vinaya header + bu-pm -->
<?php
echo '
 <div class="container text-start mt-4">
   <!-- <div class="mt-3">
      <button class="btn btn-primary btn-sm" type="button" id="collapseAll">+</button>
    </div> -->
    <div class="mt-3">
   
<div class="level1 d-flex align-items-center">
  <span class="toggle-button btn btn-primary btn-sm form-check-inline btn-fixed-width btn-rotate"
    data-bs-toggle="collapse" data-bs-target="#bupmCollapse">+</span>
  <h2 class="level1" >Vinaya</h2>
</div>
     <span class="toggle-button form-check-inline"
    data-bs-toggle="collapse" data-bs-target="#bupmCollapse">    <h2 class="my-2"><a class="setReader" href="<?php echo $readerPage;?>/?q=bu-pm#0.2">Bhikkhupātimokkha</a></h2></span>	
	
      <div class="collapse " id="bupmCollapse">
      ';
include $basedir . "/assets/texts/bupm.php";

?>
<!-- bi-pm -->
<?php
echo '
 
     <span class="toggle-button form-check-inline"
    data-bs-toggle="collapse" data-bs-target="#bipmCollapse">    <h2 class="my-2"><a href="">Bhikkhunīpātimokkha</a></h2></span>	
	
      <div class="collapse " id="bipmCollapse">
      ';
include $basedir . "/assets/texts/bipm.php";

?>
  </div>
</div>
</div>
<div class="mb-5"></div>

 <script src="/assets/js/pmjs.js"></script>

<!-- Portfolio Item 3-->
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



<div style="max-width: 600px;" class="container-lg">
<div class="alert alert-warning float-start text-left mb-3" role="alert">
<?php echo $transwarning;?>
</div>
</div>
   
  
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
<div data-bs-toggle="tooltip" style="cursor: pointer;" data-bs-placement="bottom" title="<?php echo $howtosearchquotetooltip;?>"></div>
<?php echo $howtosearchquote;?>

</div>

<div class="clearfix"></div> 
	 



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

  <a href="read.php#<?php echo $mainpageextrasearchlink; ?>" class="list-group-item list-group-item-action">
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
  
  

  <a href="read.php#<?php echo $mainpageextrasourceslink; ?>" class="list-group-item list-group-item-action" >
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
 
 
  <a href="read.php#<?php echo $mainpageextrastudylink; ?>"  class="list-group-item list-group-item-action">
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
 <a class="text-white text-decoration-none me-0" data-bs-html="true" data-bs-toggle="tooltip" style="cursor: pointer;" data-bs-placement="top" title="<?php echo $tooltippoweredby;?>"> *</a></p>

                    </div>
                </div>
            </div>
        </footer>
        <!-- Copyright Section-->
<div id="copyright" class="copyright py-4 text-center text-white " >
<div class="container"> <a target="_blank" rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Creative Commons License" style="border-width:0" src="/assets/img/88x31.png" loading="lazy" /></a> <small>Copyright <a class="text-white text-decoration-none" href="/assets/readylinebyline.html">&copy;</a> Dhamma.gift <?php echo $mode; ?> <a class="text-white text-decoration-none" href="/assets/countdowntable.php">2022</a>-<?php echo date("Y"); ?></small>  <small id="copyrightnote" >
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
       // console.log('ServiceWorker registration successful with scope: ', registration.scope);
      })
      .catch(function(err) {
        console.log('ServiceWorker registration failed: ', err);
      });
  }

  //let deferredPrompt;
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


<script src="/assets/js/themeswitch.js"></script>

        <!-- 
Core theme JS
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
                <!-- Bootstrap core JS-->
		<script src="/assets/js/uihelp.js"></script>
		
 <script src="/assets/js/bootstrap.bundle.5.3.1.min.js"></script>

<!--
-->

<script defer>
$(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>

<!-- Font Awesome icons (free version) crossorigin="anonymous"  data-mutate-approach="sync"-->



<!-- <script type="module" src="/assets/js/autopali.js"></script> -->
<script src="/assets/js/autopali.js" defer>
</script>
<script src="/assets/js/randPlaceholder.js">
</script>
<script defer>
  randCallToAction();
  randPlaceholderOnMain();
 // console.log(window.location.href);

</script>
<script src="/assets/js/openFdg.js"></script>
<script>
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
      //  console.log('fetching dict');
    }, 2000);
});
</script>
<script src="/assets/js/paliLookup.js"></script>
<script src="/assets/js/settings.js"></script>

</body>
<?php
?>  

</html>
