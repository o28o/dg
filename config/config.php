<?php
setlocale(LC_CTYPE, "en_US.UTF-8");
$uname = shell_exec("uname -a"); 
//
//OFFLINE ANDROID
//
if ( preg_match('/Android/', $uname)  ) {
    $mode = 'offline';
//$mode = 'online';

$basedir = "/data/data/com.termux/files/usr/share/apache2/default-site/htdocs";
$fontawesomejs = '<script src="/assets/js/fontawesome.6.6.all.js"></script>';


//converter.php

//$adapterscriptlocation = '/data/data/com.termux/files/home/aksharamukha/bin/python3 /data/data/com.termux/files/usr/share/apache2/default-site/htdocs/scripts/aksharamukha-adapter.py';
$adapterscriptlocation = '/data/data/com.termux/files/usr/bin/python3.12 /data/data/com.termux/files/usr/share/apache2/default-site/htdocs/scripts/aksharamukha-adapter.py';
} else if ( preg_match('/Ubuntu/', $uname) || preg_match('/microsoft-standard/', $uname) ) {


//
//Offline laptop or server for apache default /var/www/html e.g. Linux Mint / Ubuntu
//
$mode = 'offline';

//$mode = 'online';
$fontawesomejs = '<script src="/assets/js/fontawesome.6.1.all.js" ></script>';
#$fontawesomejs = '<script src="https://kit.fontawesome.com/a2bd6cd99e.js" crossorigin="anonymous"></script>';

$basedir = "/var/www/html/";

//converter.php
$adapterscriptlocation = '/home/aksharamukha/aksharamukha/bin/python3 /var/www/html/scripts/aksharamukha-adapter.py';

      } 
      
   else if ( preg_match('/CentOS-Server/', $uname) ) {
//
// ONLINE KV Prod
//
  //preg_match('/rym.from.sh/', $uname) 
  $mode = 'online';
$fontawesomejs = '<script src="/assets/js/fontawesome.6.1.all.js" ></script>';

#$fontawesomejs = '<script src="https://kit.fontawesome.com/a2bd6cd99e.js" crossorigin="anonymous" ></script>';

$basedir = "/var/www/html/";
//converter.php
//not used currently. php curl for offline
$adapterscriptlocation = '/home/python/aksharamukha/bin/python3 /var/www/html/scripts/aksharamukha-adapter.py';

// include_once('../config/config.php');
      }    
else if ( preg_match('/.from.sh/', $uname) ) {
//
// ONLINE PROD
//
  //preg_match('/rym.from.sh/', $uname) 
  $mode = 'online';

$basedir = '/home/a0902785/domains/dhamma.gift/public_html/';

$fontawesomejs = '<script src="/assets/js/fontawesome.6.1.all.js" ></script>';

#$fontawesomejs = '<script src="https://kit.fontawesome.com/a2bd6cd99e.js" crossorigin="anonymous" ></script>';

$linkforthru = 'https://theravada.ru/Teaching/Canon/Suttanta/Texts/';
$linkforthai = "https://suttacentral.net/"; 
$linkforthaiend = '/th/siam_rath';

//converter.php
//not used currently. php curl for offline
$adapterscriptlocation = '/home/a0902785/domains/dhamma.gift/aksharamukha/bin/python3 /home/a0902785/domains/dhamma.gift/public_html/scripts/aksharamukha-adapter.py';

// include_once('../config/config.php');
      } 
  

if ( preg_match('/offline/', $mode)  ) {
  //offline specific
$linklearnpali = '/lp/';

$linktbw = '/bw';
$linktbwOnMain = '/bw/home/index.html';

$mainpagethrflink = "/theravada.rf/palicanon/суттанта.html";
$mainpagethrfvinayalink = "/theravada.rf/palicanon/виная.html";
$mainpagethrulink = "/theravada.ru/Teaching/Canon/Suttanta/samyutta.htm";
$mainpagethsulink = '/tipitaka.theravada.su/dn_toc_thsu.html' ;

$linkforthsu = '/tipitaka.theravada.su/dn/';
$linkforthru = '/theravada.ru/Teaching/Canon/Suttanta/Texts/';
$linkforthai = "/legacy.suttacentral.net/read/th/"; 
$linkforthaiend = '.html';
//extralinks.php

// mainmenu
$linkmolds = '/buddhadust.net/dhamma-vinaya/bd/dhamma-vinaya.htm';

$linknoblasc = '/en.dhammadana.org/sangha/dhutanga.htm';
$linkati = '/accesstoinsight.org/tipitaka/vin/sv/index.html';
$linktextbook = '/assets/materials/pali_textbook_eng.pdf';
$linkconj = '/assets/materials/pali_conjugations_eng.pdf';
$linkwarder = '/assets/materials/warder_intr_pali.pdf';
$linkmagadhabhasa = '/assets/materials/magadhabhasa_3rd.pdf';
$linkcases = '/assets/materials/declensions_and_conjugations_eng.xlsx';
$linkcasesru = '/assets/materials/pali_cases_rus.pdf';
$linktextbookru = '/assets/materials/pali_textbook_rus.pdf';

} else if ( preg_match('/online/', $mode)  ) {
  //online specific
$linklearnpali = 'https://palistudies.blogspot.com/2019/04/intro-kaya-section-satipatthana-sutta.html?m=1';
$linktbw = '/bw';
$linktbwOnMain = '/bw/home/index.html';
//$linktbw = 'https://thebuddhaswords.net';

$mainpagethrflink =  "https://xn--80aaaglc1fo1a.xn--p1ai/palicanon/%D1%81%D1%83%D1%82%D1%82%D0%B0%D0%BD%D1%82%D0%B0";
$mainpagethrfvinayalink = "http://xn--80aaaglc1fo1a.xn--p1ai/palicanon/%d0%b2%d0%b8%d0%bd%d0%b0%d1%8f"; 
  $mainpagethrulink = "https://theravada.ru/Teaching/Canon/Suttanta/samyutta.htm";

  $mainpagethsulink = 'https://tipitaka.theravada.su/toc/translations/1097' ;

$linkforthsu = 'https://tipitaka.theravada.su/toc/translations/1098';

$linkforthru = 'https://theravada.ru/Teaching/Canon/Suttanta/Texts/';

$linkforthai = "https://suttacentral.net/"; 
$linkforthaiend = '/th/siam_rath';

// mainmenu
$linkmolds = 'https://buddhadust.net/dhamma-vinaya/bd/dhamma-vinaya.htm';

$linknoblasc = 'https://en.dhammadana.org/sangha/dhutanga.htm';
$linkati = 'https://www.accesstoinsight.org/tipitaka/vin/sv/index.html';
$linktextbook = 'https://drive.google.com/file/d/1HYI0psEjzl5SHDTSI1arAVJMiJdO862G/view?usp=drivesdk';
$linktextbookru = 'https://drive.google.com/file/d/1H_mhKNgrBYevOOnax-FUBgxkfSuwHItu/view?usp=share_link';
$linkwarder = 'https://drive.google.com/file/d/1b0sTtKF5wuGcDtr_u5sSSWGY5_QzBF-h/view?usp=drivesdk';
$linkmagadhabhasa = 'https://drive.google.com/file/d/1jeXT4tkuudnN2EB1ABp4eHLGXbw-_EBk/view?usp=drivesdk';

$linkconj = 'https://drive.google.com/file/d/1HzPCYsVBEkWErAk6TqSWRYKseM1hqMCb/view?usp=sharing';
$linkcases = 'https://docs.google.com/spreadsheets/d/1wo8YEXX72DEV7L2jH5FUBdmeQPdiyAIN/edit?usp=drivesdk&ouid=110812668327988798342&rtpof=true&sd=true';
$linkcasesru = 'https://drive.google.com/file/d/1HVRK6yTMT59uHCCvTdQukRy7fmHNntOr/view?usp=drivesdk';
} 
      
//
// Common Variables
//

$linebylinerulocation = $basedir. '/assets/texts/';
//translator-lookup.php
$translatorlocation = $basedir. '/assets/texts/';
$thtranslatorlocation = $basedir. '/assets/texts/th/translation/';

$linksc = 'https://suttacentral.net/';
$anamesc = 'SuttaCentral.net';
$linksclegacy = '/legacy.suttacentral.net/';
$anamesclegacy = 'SC.net Legacy';
//api-emulator
$scroottextlocation = $basedir . "/suttacentral.net/sc-data/sc_bilara_data/root/pli/ms";
$sctrntextlocation = $basedir . "/suttacentral.net/sc-data/sc_bilara_data/translation/";
//opentexts.php
$indexesfile = $basedir. '/assets/texts/text_indexes.txt';
$scriptfile = $basedir. '/scripts/ranges.sh';

$thsulocation = $basedir. '/tipitaka.theravada.su/';
$thrulocation = $basedir. '/theravada.ru/Teaching/Canon';
$bwlocation = $basedir. '/bw';

//extralinks.php

$locationru = $basedir. '/theravada.ru/Teaching/Canon/Suttanta/Texts';
$locationTocThsu = $basedir. "/assets/texts/";


$defaultla = 2;
//$latestrusmn = 38;
$iconimportant = 'fa-solid fa-circle-exclamation';
$iconimportant = 'fa-solid fa-triangle-exclamation';
$iconimportant = 'fa-solid fa-star';



$defaultsJS = '<script>
// Получаем все радиокнопки
var readerRadios = document.querySelectorAll(\'input[name="reader"]\');

// Устанавливаем обработчики событий при изменении состояния радиокнопок
readerRadios.forEach(function(radio) {
    radio.addEventListener(\'change\', function() {
        if (this.checked) {
            // Устанавливаем значение в localStorage
            localStorage.setItem("defaultReader", this.value);
        }
    });
});

// Проверяем значение в localStorage при загрузке страницы и устанавливаем состояние радиокнопок
var savedReader = localStorage.getItem("defaultReader");
if (savedReader) {
    document.querySelector(\'input[name="reader"][value="\' + savedReader + \'"]\').checked = true;
}
</script>';



?>
