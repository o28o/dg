<?php
// Включаем вывод всех ошибок для отладки
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Устанавливаем заголовки кэширования
header("Cache-Control: public, max-age=3600"); // Кэшировать на 1 час
header("Expires: " . gmdate("D, d M Y H:i:s", time() + 3600) . " GMT");
?>
<!DOCTYPE html>
<?php
error_reporting(E_ERROR | E_PARSE);
include_once('./config/config.php');
include_once('./config/translate.php');
include './scripts/opentexts.php';
//echo $readerPage;
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="/assets/css/styles.css" rel="stylesheet" />
<!-- Favicon-->
<link rel="icon" type="image/png" href="/assets/img/favico-noglass.png" />

    <!-- Style CSS -->
    <link rel="stylesheet" href="/assets/css/playerStyle.css">
    <link rel="stylesheet" href="/assets/css/paliLookup.css">
<link href="/assets/css/extrastyles.css" rel="stylesheet" />

  <!-- Загрузка иконки для iOS -->
  <link rel="apple-touch-icon" sizes="152x152" href="/assets/img/favico-noglass.png">

  <title>Bhikkhupātimokkha</title>

</head>

<body>
      <div class="container mt-3">
        <div class="align-items-center align-items-center toggle-switch input-group-append">
            <div id="" class="input-group">
                <a href="/ru/read.php" title="Sutta and Vinaya reading" rel="noreferrer" class="me-1">
                    <svg fill="#979797" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="26px" viewBox="0 0 547.596 547.596" xml:space="preserve" stroke="#979797"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="3.285576"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M540.76,254.788L294.506,38.216c-11.475-10.098-30.064-10.098-41.386,0L6.943,254.788 c-11.475,10.098-8.415,18.284,6.885,18.284h75.964v221.773c0,12.087,9.945,22.108,22.108,22.108h92.947V371.067 c0-12.087,9.945-22.108,22.109-22.108h93.865c12.239,0,22.108,9.792,22.108,22.108v145.886h92.947 c12.24,0,22.108-9.945,22.108-22.108v-221.85h75.965C549.021,272.995,552.081,264.886,540.76,254.788z"></path> </g> </g></svg>
                </a>

                <a href="/ru" title="Sutta and Vinaya search" rel="noreferrer" class="me-1">
                    <img width="24px" alt="dhamma.gift icon" src="/assets/img/gray-white.png">
                </a>
  <a class="ms-1 toggle-dict-btn">  <img src="/assets/svg/comment.svg" class="dictIcon-sitePages"></img></a>

                <div class="ms-1 form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="darkSwitch">
                </div>
       <a class="ms-1 btn-sm btn-secondary rounded-pill text-decoration-none " href="/d/?q=pli-tv-bu-pm&script=devanagari" >bu-pm</a>
      <a class="ms-1 btn-sm btn-secondary rounded-pill text-decoration-none " href="/bipm.php?expand=true" >bi-pm</a>
 
    <a class="ms-1 btn-sm btn-secondary rounded-pill text-decoration-none " href="/san/sarv.php" >sarv</a>
    <a class="ms-1 btn-sm btn-secondary rounded-pill text-decoration-none " href="/san/mg.php" >mg</a>
    <a class="ms-1 btn-sm btn-secondary rounded-pill text-decoration-none " href="/san/d/lo.php" >lo</a>
    <a class="ms-1 btn-sm btn-secondary rounded-pill text-decoration-none " href="/san/mu2.php" >mu2</a>
    <a class="ms-1 btn-sm btn-secondary rounded-pill text-decoration-none " href="/san/mu3.php" >mu3</a>
 
    <a class="ms-1 btn-sm btn-secondary rounded-pill text-decoration-none " href="https://www.digitalpalireader.online/_dprhtml/index.html?loc=v.6.0.4.0.0.0.t" >dpr</a>
    
    <a class="ms-1 btn-sm btn-secondary rounded-pill text-decoration-none " data-bs-toggle="collapse" data-bs-target="#playerCollapse" href="#" >player</a>
      <div class="collapse " id="playerCollapse">
       <!-- Start DEMO HTML (Use the following code into your project)-->
 <div class="simple-audio-player" id="simp" data-config='{"shide_top":true,"shide_btm":false,"auto_load":false,"simp-plext":true}'>
  <div class="simp-playlist">
    <ul>
  <li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-pj.m4a>1. Bu-pj</span><span class=simp-desc>Bhikkhupātimokkha</span></li>
<li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-ss.m4a>2. Bu-ss</span><span class=simp-desc>Bhikkhupātimokkha</span></li>                                                  <li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-ay.m4a>3. Bu-ay</span><span class=simp-desc>Bhikkhupātimokkha</span></li>
<li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-np1vag.m4a>4. Bu-np1vag</span><span class=simp-desc>Bhikkhupātimokkha</span></li>                                          <li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-np2vag.m4a>5. Bu-np2vag</span><span class=simp-desc>Bhikkhupātimokkha</span></li>
<li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-np3vag.m4a>6. Bu-np3vag</span><span class=simp-desc>Bhikkhupātimokkha</span></li>                                          <li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-pc1vag.m4a>7. Bu-pc1vag</span><span class=simp-desc>Bhikkhupātimokkha</span></li>
<li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-pc2vag.m4a>8. Bu-pc2vag</span><span class=simp-desc>Bhikkhupātimokkha</span></li>                                          <li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-pc3vag.m4a>9. Bu-pc3vag</span><span class=simp-desc>Bhikkhupātimokkha</span></li>
<li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-pc4vag.m4a>10. Bu-pc4vag</span><span class=simp-desc>Bhikkhupātimokkha</span></li>                                         <li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-pc5vag.m4a>11. Bu-pc5vag</span><span class=simp-desc>Bhikkhupātimokkha</span></li>
<li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-pc6vag.m4a>12. Bu-pc6vag</span><span class=simp-desc>Bhikkhupātimokkha</span></li>                                         <li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-pc7vag.m4a>13. Bu-pc7vag</span><span class=simp-desc>Bhikkhupātimokkha</span></li>
<li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-pc8vag.m4a>14. Bu-pc8vag</span><span class=simp-desc>Bhikkhupātimokkha</span></li>                                         <li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-pc9vag.m4a>15. Bu-pc9vag</span><span class=simp-desc>Bhikkhupātimokkha</span></li>
<li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-pd.m4a>16. Bu-pd</span><span class=simp-desc>Bhikkhupātimokkha</span></li>                                                 <li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-sk1vag.m4a>17. Bu-sk1vag</span><span class=simp-desc>Bhikkhupātimokkha</span></li>
<li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-sk2vag.m4a>18. Bu-sk2vag</span><span class=simp-desc>Bhikkhupātimokkha</span></li>                                         <li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-sk3vag.m4a>19. Bu-sk3vag</span><span class=simp-desc>Bhikkhupātimokkha</span></li>
<li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-sk4vag.m4a>20. Bu-sk4vag</span><span class=simp-desc>Bhikkhupātimokkha</span></li>                                         <li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-sk5vag.m4a>21. Bu-sk5vag</span><span class=simp-desc>Bhikkhupātimokkha</span></li>
<li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-sk6vag.m4a>22. Bu-sk6vag</span><span class=simp-desc>Bhikkhupātimokkha</span></li>                                         <li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-sk7vag.m4a>23. Bu-sk7vag</span><span class=simp-desc>Bhikkhupātimokkha</span></li>
<li><span class=simp-source data-src=/assets/audio/bu-pm/Bu-as.m4a>24. Bu-as</span><span class=simp-desc>Bhikkhupātimokkha</span></li>    
    </ul>
  </div>
  <div class="simp-footer">Made by <a href="https://bit.ly/sekedus" target="_blank" title="Sekedus">Sekedus</a></div>
</div>    
     <!-- END EDMO HTML (Happy Coding!)  <script>
document.addEventListener("DOMContentLoaded", () => {
    // Найти заголовок страницы и извлечь его текст
    const pageTitle = document.querySelector("title")?.innerText || "Untitled";

    // Найти div для плейлиста
    const playlistDiv = document.querySelector(".simp-playlist ul");
    if (!playlistDiv) return;

    // Найти все аудиотеги на странице
    const audioTags = document.querySelectorAll("audio.lazy-audio source");
    audioTags.forEach((source, index) => {
        const src = source.getAttribute("src");
        if (src) {
            // Создаем элементы li с вложенными span
            const li = document.createElement("li");

            const spanSource = document.createElement("span");
            spanSource.classList.add("simp-source");
            spanSource.setAttribute("data-src", src);
            spanSource.textContent = index + 1;

            const spanDesc = document.createElement("span");
            spanDesc.classList.add("simp-desc");
            spanDesc.textContent = pageTitle;

            // Добавляем span-элементы в li и добавляем li в ul
            li.appendChild(spanSource);
            li.appendChild(spanDesc);
            playlistDiv.appendChild(li);
        }
    });
      simp_startScript();
});  
  
</script>     -->              
              </div>	  
                
                
            </div>
        </div>
    </div>
 <div class="container">
   <!-- <div class="mt-3">
      <button class="btn btn-primary btn-sm" type="button" id="collapseAll">+</button>
    </div> -->
    <div class="mt-3">
   
<div class="level1 d-flex align-items-center ">
  <span class="toggle-button btn btn-primary btn-sm form-check-inline btn-fixed-width btn-rotate"
    data-bs-toggle="collapse" data-bs-target="#bupmCollapse">-</span>
  <h2><a href="#" data-bs-toggle="collapse" data-bs-target="#bupmCollapse">Bhikkhupātimokkha</a></h2>
</div>

      <div class="collapse " id="bupmCollapse">
        
<?php
include $basedir . "/assets/texts/bupm.php";
?>

  </div>
</div>
<div class="mb-5"></div>
<script src="/assets/js/jquery-3.7.0.min.js"></script>
<script src="/assets/js/bootstrap.bundle.5.3.1.min.js"></script>
<script src="/assets/js/pmjs.js"></script>
<script src="/assets/js/openFdg.js"></script>
<script src="/assets/js/dark-mode-switch/dark-mode-switch.js"></script>
<script>
 // save collapsed state
$(document).ready(function () {
    var isLocal = window.location.href.includes("localhost");

    $(".collapse").on("shown.bs.collapse", function () {
        if (this.id !== "navbarResponsive" && this.id !== "collapseSettings") {
            var keyPrefix = isLocal ? "lcl_" : "fdg_";
            localStorage.setItem(keyPrefix + "coll_" + this.id, true);
            console.log("Saved state for " + this.id + " as true");
        }
    });

    $(".collapse").on("hidden.bs.collapse", function () {
        if (this.id !== "navbarResponsive" && this.id !== "collapseSettings") {
            var keyPrefix = isLocal ? "lcl_" : "fdg_";
            localStorage.removeItem(keyPrefix + "coll_" + this.id);
      //      console.log("Removed state for " + this.id);
        }
    });

    $(".collapse").each(function () {
        var keyPrefix = isLocal ? "lcl_" : "fdg_";
        if (localStorage.getItem(keyPrefix + "coll_" + this.id) === "true") {
            $(this).collapse("show");
       //     console.log("Loaded state for " + this.id + " as true");
        } else {
            $(this).collapse("hide");
         //   console.log("Loaded state for " + this.id + " as false");
        }
    });
});


</script>
 <script type="text/javascript"> // restore scroll position
$(document).ready(function () {

    if (localStorage.getItem("fdg-quote-scroll") != null) {
        $(window).scrollTop(localStorage.getItem("fdg-quote-scroll"));
    }

    $(window).on("scroll", function() {
        localStorage.setItem("fdg-quote-scroll", $(window).scrollTop());
    });

  });
</script>
<script src="/assets/js/paliLookup.js"></script>
<script src="/assets/js/settings.js"></script>
<script src="/assets/js/standalone-dpd/pali-lookup-standalone.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            enablePaliLookup();
        });

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const shouldExpand = urlParams.get('expand') === 'true';

    if (shouldExpand) {
        const collapseElement = document.getElementById('bupmCollapse');
        if (collapseElement) {
            const collapseInstance = bootstrap.Collapse.getInstance(collapseElement) || 
                                   new bootstrap.Collapse(collapseElement);
            
            collapseInstance.show();
            
            const toggleButton = document.querySelector('[data-bs-target="#bupmCollapse"]');
            if (toggleButton) {
                toggleButton.classList.remove('collapsed');
                toggleButton.setAttribute('aria-expanded', 'true');
            }
        }
    }
});
    </script>
<!-- Audio Player JS -->
<script  src="/assets/js/jsPlayer.js"></script>  
          <script src="/assets/js/smoothScroll.js" defer></script>

</body>

</html>
