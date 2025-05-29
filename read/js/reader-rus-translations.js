
const Sccopy = "/suttacentral.net";
const suttaArea = document.getElementById("sutta");
const homeButton = document.getElementById("home-button");
const fdgButton = document.getElementById("fdg-button");

const bodyTag = document.querySelector("body");
const previous = document.getElementById("previous");
const next = document.getElementById("next");
const previous2 = document.getElementById("previous2");
const next2 = document.getElementById("next2");
const form = document.getElementById("form");
const citation = document.getElementById("paliauto");
const pathLang = "ru";

citation.focus();
let language = "pli-rus";

homeButton.addEventListener("click", () => {
  document.location.search = "";
});

form.addEventListener("submit", e => {
  e.preventDefault();
  if (citation.value) {
    const query = citation.value.replace(/\s+/g, " ");
    
    // Получаем текущий параметр s, если он есть
    const currentParams = new URLSearchParams(window.location.search);
    const sParam = currentParams.get("s");

    // Строим новый URL с учётом параметра s
    let newUrl = `?q=${encodeURIComponent(query)}`;
    if (sParam) {
      newUrl += `&s=${encodeURIComponent(sParam)}`;
    }

    buildSutta(query);
    history.pushState({ page: query }, "", newUrl);
  }
});


function buildSutta(slug) {
  
  let translator = "";
  let texttype = "sutta";
  let slugArray = slug.split("&");
  slug = slugArray[0];
  if (slugArray[1]) {
    translator = slugArray[1];
  } 
  /*else {
    translator = "sv";
  }*/
  slug = slug.toLowerCase();

  if ((!slug.match("bu-pm")) && (!slug.match("bi-pm")) && (slug.match(/bu-|bi-|kd|pvr/))) {
    translator = "brahmali";
    texttype = "vinaya";
    slug = slug.replace(/bu([psan])/, "bu-$1");
    slug = slug.replace(/bi([psn])/, "bi-$1");
    if (!slug.match("pli-tv-")) {
      slug = "pli-tv-" + slug;
    }
    if (!slug.match("vb-")) {
      slug = slug.replace("bu-", "bu-vb-");
    }
    if (!slug.match("vb-")) {
      slug = slug.replace("bi-", "bi-vb-");
    }
  }

  if (slug.match(/bu-pm|bi-pm/)) {
    texttype = "vinaya";
    slug = slug.replace(/bu([psan])/, "bu-$1");
    slug = slug.replace(/bi([psan])/, "bi-$1");
    if (!slug.match("pli-tv-")) {
      slug = "pli-tv-" + slug;
    }
  }
  let html = `<div class="button-area"><button title="Переключить язык (Atl+Z или Alt+Space)" id="language-button" class="hide-button">Pāḷi Рус</button></div>`;
  
  const slugReady = parseSlug(slug);
 // console.log("slugReady is " + slugReady + " slug is " + slug); 



$.ajax({
       url: "/read/php/translator-lookup.php?fromjs=" +texttype +"/" +slugReady
    }).done(function(data) {
      const trnsResp = data.split(" ");
      let translator = trnsResp[0];

//if (slug.match(/^mn([1-9]|1[0-9]|2[0-1])$/)) {
 
const onlynumber = slug.replace(/[a-zA-Z]/g, '');

//let anranges = ['an1.1-10', 'an1.11-20', 'an10.141', 'an10.142', 'an10.143', 'an10.144', 'an10.145', 'an10.146', 'an10.147', 'an10.148', 'an10.149', 'an10.150', 'an10.151', 'an11.992-1151'];

let vinayaranges = ["pli-tv-bu-vb-as1-7", "pli-tv-bu-vb-ay1", "pli-tv-bu-vb-ay2", "pli-tv-bu-vb-np1", "pli-tv-bu-vb-pc1", "pli-tv-bu-vb-pc2", "pli-tv-bu-vb-pd1", "pli-tv-bu-vb-pd2", "pli-tv-bu-vb-pd3", "pli-tv-bu-vb-pd4", "pli-tv-bu-vb-pj1", "pli-tv-bu-vb-pj2", "pli-tv-bu-vb-pj3", "pli-tv-bu-vb-pj4", "pli-tv-bu-vb-sk1", "pli-tv-bu-vb-sk2", "pli-tv-bu-vb-sk3", "pli-tv-bu-vb-sk4", "pli-tv-bu-vb-sk5", "pli-tv-bu-vb-sk7", "pli-tv-bu-vb-sk8", "pli-tv-bu-vb-sk74", "pli-tv-bu-vb-ss1", "pli-tv-bu-vb-ss2", "pli-tv-bu-vb-ss3", "pli-tv-bu-vb-ss4", "pli-tv-bu-vb-ss5", "pli-tv-bu-vb-ss6", "pli-tv-bu-vb-ss7", "pli-tv-bu-vb-ss8", "pli-tv-bu-vb-ss9", "pli-tv-bu-vb-ss10", "pli-tv-bu-vb-ss11", "pli-tv-bu-vb-ss12", "pli-tv-bu-vb-ss13"];

let knranges = ['dhp1-20', 'dhp21-32', 'dhp33-43', 'dhp44-59', 'dhp60-75', 'dhp76-89', 'dhp90-99', 'dhp100-115', 'dhp116-128', 'dhp129-145', 'dhp146-156', 'dhp157-166', 'dhp167-178', 'dhp179-196', 'dhp197-208', 'dhp209-220', 'dhp221-234', 'dhp235-255', 'dhp256-272', 'dhp273-289', 'dhp290-305', 'dhp306-319', 'dhp320-333', 'dhp334-359', 'dhp360-382', 'dhp383-423', 'iti1', 'iti2', 'iti3', 'iti4', 'iti5', 'iti6', 'iti7', 'iti8', 'iti9', 'iti10', 'iti11', 'iti12', 'iti13', 'iti14', 'iti15', 'iti16', 'iti17', 'iti18', 'iti19', 'iti20', 'iti21', 'iti22', 'iti23', 'iti24', 'iti25', 'iti26', 'iti27', 'iti28', 'iti29', 'iti30', 'iti31', 'iti32', 'iti33', 'iti34', 'iti35', 'iti36', 'iti37', 'iti38', 'iti39', 'iti40', 'iti41', 'iti42', 'iti43', 'iti44', 'iti45', 'iti46', 'iti47', 'iti48', 'iti49', 'iti50', 'iti51', 'iti52', 'iti53', 'iti54', 'iti55', 'iti56', 'iti57', 'iti58', 'iti59', 'iti60', 'iti61', 'iti62', 'iti63', 'iti64', 'iti65', 'iti66', 'iti67', 'iti68', 'iti69', 'iti70', 'iti71', 'iti72', 'iti73', 'iti74', 'iti75', 'iti76', 'iti77', 'iti78', 'iti79', 'iti80', 'iti81', 'iti82', 'iti83', 'iti84', 'iti85', 'iti86', 'iti87', 'iti88', 'iti89', 'iti90', 'iti91', 'iti92', 'iti93', 'iti94', 'iti95', 'iti96', 'iti97', 'iti98', 'iti99', 'iti100', 'iti101', 'iti102', 'iti103', 'iti104', 'iti105', 'iti106', 'iti107', 'iti108', 'iti109', 'iti110', 'iti111', 'iti112', 'snp1.1', 'snp1.2', 'snp1.3', 'snp1.4', 'snp1.5', 'snp1.6', 'snp1.7', 'snp1.8', 'snp1.8', 'snp1.9', 'snp1.10', 'snp1.11', 'snp1.12', 'snp2.1', 'snp2.2', 'snp2.3', 'snp2.4', 'snp2.5', 'snp2.6', 'snp2.7', 'snp2.8', 'snp2.9', 'snp2.10', 'snp2.11', 'snp2.12', 'snp2.13', 'snp2.14', 'snp3.1', 'snp3.2', 'snp3.3', 'snp3.4', 'snp3.5', 'snp3.6', 'snp3.7', 'snp3.8', 'snp3.9', 'snp3.10', 'snp3.11', 'snp3.12', 'snp4.1', 'snp4.2', 'snp4.3', 'snp4.4', 'snp4.5', 'snp4.6', 'snp4.7', 'snp4.8', 'snp4.9', 'snp4.10', 'snp4.11', 'snp4.12', 'snp4.13', 'snp4.14', 'snp4.15', 'snp4.16', 'snp5.1', 'snp5.2', 'snp5.3', 'snp5.4', 'snp5.5', 'snp5.6', 'snp5.7', 'snp5.8', 'snp5.9', 'snp5.10', 'snp5.11', 'snp5.12', 'snp5.13', 'snp5.14', 'snp5.15', 'snp5.16', 'snp5.17', 'snp5.18', 'snp5.19', 'thag1.1', 'thag1.2', 'thag1.3', 'thag1.4', 'thag1.5', 'thag1.6', 'thag1.7', 'thag1.8', 'thag1.9', 'thag1.10', 'thag1.11', 'thag1.12', 'thag1.13', 'thag1.14', 'thag1.15', 'thag1.16', 'thag1.17', 'thag1.18', 'thag1.19', 'thag1.20', 'thag1.21', 'thag1.22', 'thag1.23', 'thag1.24', 'thag1.25', 'thag1.26', 'thag1.27', 'thag1.28', 'thag1.29', 'thag1.30', 'thag1.31', 'thag1.32', 'thag1.33', 'thag1.34', 'thag1.35', 'thag1.36', 'thag1.37', 'thag1.38', 'thag1.39', 'thag1.40', 'thag1.41', 'thag1.42', 'thag1.43', 'thag1.44', 'thag1.45', 'thag1.46', 'thag1.47', 'thag1.48', 'thag1.49', 'thag1.50', 'thag1.51', 'thag1.52', 'thag1.53', 'thag1.54', 'thag1.55', 'thag1.56', 'thag1.57', 'thag1.58', 'thag1.59', 'thag1.60', 'thag1.61', 'thag1.62', 'thag1.63', 'thag1.64', 'thag1.65', 'thag1.66', 'thag1.67', 'thag1.68', 'thag1.69', 'thag1.70', 'thag1.71', 'thag1.72', 'thag1.73', 'thag1.74', 'thag1.75', 'thag1.76', 'thag1.77', 'thag1.78', 'thag1.79', 'thag1.80', 'thag1.81', 'thag1.82', 'thag1.83', 'thag1.84', 'thag1.85', 'thag1.86', 'thag1.87', 'thag1.88', 'thag1.89', 'thag1.90', 'thag1.91', 'thag1.92', 'thag1.93', 'thag1.94', 'thag1.95', 'thag1.96', 'thag1.97', 'thag1.98', 'thag1.99', 'thag1.100', 'thag1.101', 'thag1.102', 'thag1.103', 'thag1.104', 'thag1.105', 'thag1.106', 'thag1.107', 'thag1.108', 'thag1.109', 'thag1.110', 'thag1.111', 'thag1.112', 'thag1.113', 'thag1.114', 'thag1.115', 'thag1.116', 'thag1.117', 'thag1.118', 'thag1.119', 'thag1.120', 'thag2.1', 'thag2.2', 'thag2.3', 'thag2.4', 'thag2.5', 'thag2.6', 'thag2.7', 'thag2.8', 'thag2.9', 'thag2.10', 'thag2.11', 'thag2.12', 'thag2.13', 'thag2.14', 'thag2.15', 'thag2.16', 'thag2.17', 'thag2.18', 'thag2.19', 'thag2.20', 'thag2.21', 'thag2.22', 'thag2.23', 'thag2.24', 'thag2.25', 'thag2.26', 'thag2.27', 'thag2.28', 'thag2.29', 'thag2.30', 'thag2.31', 'thag2.32', 'thag2.33', 'thag2.34', 'thag2.35', 'thag2.36', 'thag2.37', 'thag2.38', 'thag2.39', 'thag2.40', 'thag2.41', 'thag2.42', 'thag2.43', 'thag2.44', 'thag2.45', 'thag2.46', 'thag2.47', 'thag2.48', 'thag2.49', 'thag3.1', 'thag3.2', 'thag3.3', 'thag3.4', 'thag3.5', 'thag3.6', 'thag3.7', 'thag3.8', 'thag3.9', 'thag3.10', 'thag3.11', 'thag3.12', 'thag3.13', 'thag3.14', 'thag3.15', 'thag3.16', 'thag4.1', 'thag4.2', 'thag4.3', 'thag4.4', 'thag4.5', 'thag4.6', 'thag4.7', 'thag4.8', 'thag4.9', 'thag4.10', 'thag4.11', 'thag4.12', 'thag5.1', 'thag5.2', 'thag5.3', 'thag5.4', 'thag5.5', 'thag5.6', 'thag5.7', 'thag5.8', 'thag5.9', 'thag5.10', 'thag5.11', 'thag5.12', 'thag6.1', 'thag6.2', 'thag6.3', 'thag6.4', 'thag6.5', 'thag6.6', 'thag6.7', 'thag6.8', 'thag6.9', 'thag6.10', 'thag6.11', 'thag6.12', 'thag6.13', 'thag6.14', 'thag7.1', 'thag7.2', 'thag7.3', 'thag7.4', 'thag7.5', 'thag8.1', 'thag8.2', 'thag8.3', 'thag9.1', 'thag10.1', 'thag10.2', 'thag10.3', 'thag10.4', 'thag10.5', 'thag10.6', 'thag10.7', 'thag11.1', 'thag12.1', 'thag12.2', 'thag13.1', 'thag14.1', 'thag14.2', 'thag15.1', 'thag15.2', 'thag16.1', 'thag16.2', 'thag16.3', 'thag16.4', 'thag16.5', 'thag16.6', 'thag16.7', 'thag16.8', 'thag16.9', 'thag16.10', 'thag17.1', 'thag17.2', 'thag17.3', 'thag18.1', 'thag19.1', 'thag20.1', 'thag21.1', 'thig1.1', 'thig1.2', 'thig1.3', 'thig1.4', 'thig1.5', 'thig1.6', 'thig1.7', 'thig1.8', 'thig1.9', 'thig1.10', 'thig1.11', 'thig1.12', 'thig1.13', 'thig1.14', 'thig1.15', 'thig1.16', 'thig1.17', 'thig1.18', 'thig2.1', 'thig2.2', 'thig2.3', 'thig2.4', 'thig2.5', 'thig2.6', 'thig2.7', 'thig2.8', 'thig2.9', 'thig2.10', 'thig3.1', 'thig3.2', 'thig3.3', 'thig3.4', 'thig3.5', 'thig3.6', 'thig3.7', 'thig3.8', 'thig4.1', 'thig5.1', 'thig5.2', 'thig5.3', 'thig5.4', 'thig5.5', 'thig5.6', 'thig5.7', 'thig5.8', 'thig5.9', 'thig5.10', 'thig5.11', 'thig5.12', 'thig6.1', 'thig6.2', 'thig6.3', 'thig6.4', 'thig6.5', 'thig6.6', 'thig6.7', 'thig6.8', 'thig7.1', 'thig7.2', 'thig7.3', 'thig8.1', 'thig9.1', 'thig10.1', 'thig11.1', 'thig12.1', 'thig13.1', 'thig13.2', 'thig13.3', 'thig13.4', 'thig13.5', 'thig14.1', 'thig15.1', 'thig16.1', 'ud1.1', 'ud1.2', 'ud1.3', 'ud1.4', 'ud1.5', 'ud1.6', 'ud1.7', 'ud1.8', 'ud1.9', 'ud1.10', 'ud2.1', 'ud2.2', 'ud2.3', 'ud2.4', 'ud2.5', 'ud2.6', 'ud2.7', 'ud2.8', 'ud2.9', 'ud2.10', 'ud3.1', 'ud3.2', 'ud3.3', 'ud3.4', 'ud3.5', 'ud3.6', 'ud3.7', 'ud3.8', 'ud3.9', 'ud3.10', 'ud4.1', 'ud4.2', 'ud4.3', 'ud4.4', 'ud4.5', 'ud4.6', 'ud4.7', 'ud4.8', 'ud4.9', 'ud4.10', 'ud5.1', 'ud5.2', 'ud5.3', 'ud5.4', 'ud5.5', 'ud5.6', 'ud5.7', 'ud5.8', 'ud5.9', 'ud5.10', 'ud6.1', 'ud6.2', 'ud6.3', 'ud6.4', 'ud6.5', 'ud6.6', 'ud6.7', 'ud6.8', 'ud6.9', 'ud6.10', 'ud7.1', 'ud7.2', 'ud7.3', 'ud7.4', 'ud7.5', 'ud7.6', 'ud7.7', 'ud7.8', 'ud7.9', 'ud7.10', 'ud8.1', 'ud8.2', 'ud8.3', 'ud8.4', 'ud8.5', 'ud8.6', 'ud8.7', 'ud8.8', 'ud8.9', 'ud8.10'];

let params = new URLSearchParams(document.location.search);
 let script = params.get("script");
 
   const savedScript = localStorage.getItem('selectedScript');

 if (( script === "devanagari" ) || ( savedScript === "Devanagari" ) ) {
var rootpath = `/assets/texts/devanagari/root/pli/ms/${texttype}/${slugReady}_rootd-pli-ms.json`
 } 
else if (( script === "thai" ) || ( savedScript === "Thai" ) ) {
var rootpath = `/assets/texts/th/root/pli/ms/${texttype}/${slugReady}_rootth-pli-ms.json`
 } 
else {
var rootpath = `${Sccopy}/sc-data/sc_bilara_data/root/pli/ms/${texttype}/${slugReady}_root-pli-ms.json`
 }


var rustrnpath = `/assets/texts/${texttype}/${slugReady}_translation-${pathLang}-${translator}.json`;

var htmlpath = `${Sccopy}/sc-data/sc_bilara_data/html/pli/ms/${texttype}/${slugReady}_html.json`;

const ruUrl  = window.location.href;

const mlUrl = ruUrl.replace("/r/", "/ml/");
 let scLink = `<p class="sc-link"><a target="" title='Pali + Русский + Английский (Alt+2)' href="${mlUrl}">R+E</a>&nbsp;`;
 //<a class='ruLink' href='' onclick=openRu('${slug}') data-slug='${slug}'>tst</a>&nbsp;
const currentURL = window.location.href;
const anchorURL = new URL(currentURL).hash; // Убираем символ "#"



// let ifRus = `<a target="" href="${mlUrl}">R+E</a>&nbsp;`;
 
if (slug.includes("mn"))  {
 var trnpath = rustrnpath; 
 let language = "pli-rus";
// scLink += ifRus; 
} else if (slug.includes("sn")) { 
  var trnpath = rustrnpath; 
//  scLink += ifRus; 
} else if (slug.includes("an")) { 
  var trnpath = rustrnpath; 
//  scLink += ifRus; 
} else if (slug.includes("dn")) { 
  var trnpath = rustrnpath; 
//  scLink += ifRus; 
} else if (knranges.indexOf(slug) !== -1) { 
  var trnpath = rustrnpath; 
 // scLink += ifRus; 
} else if (slug.match(/ja/)) {
  let language = "pli";
  let slugNumber = parseInt(slug.replace(/\D/g, ''), 10); // Извлекаем число из slug

  if (slugNumber >= 1 && slugNumber <= 75) {
    var trnpath = `${Sccopy}/sc-data/sc_bilara_data/translation/en/sujato/sutta/${slugReady}_translation-en-sujato.json`;
  } else if (slugNumber > 70) {
    var trnpath = `${Sccopy}/sc-data/sc_bilara_data/root/pli/ms/${texttype}/${slugReady}_root-pli-ms.json`;
  }
  // console.log('ja case ', rootpath, trnpath, htmlpath);
} else if ( texttype === "sutta" ) {
  let translator = "sujato";
  const pathLang = "en";
  // console.log(`${Sccopy}/sc-data/sc_bilara_data/translation/${pathLang}/${translator}/${texttype}/${slugReady}_translation-${pathLang}-${translator}.json`);
  var trnpath = `${Sccopy}/sc-data/sc_bilara_data/translation/${pathLang}/${translator}/${texttype}/${slugReady}_translation-${pathLang}-${translator}.json`;
} else if (slug.match(/bu-pm|bi-pm/)) {
    //let translator = "thanissaro+o";
    let translator = "o";
//  console.log(trnpath);
	
	
 if (( script === "devanagari" ) || ( savedScript === "Devanagari" ) ) {
//	     var rootpath = `/assets/texts/${texttype}/${slug}_root-pli-ms.json`;
var rootpath = `/assets/texts/devanagari/root/pli/ms/${texttype}/${slug}_rootd-pli-ms.json`
 } 
else if (( script === "thai" ) || ( savedScript === "Thai" ) ) {
var rootpath = `/assets/texts/th/root/pli/ms/${texttype}/${slug}_rootth-pli-ms.json`
 } 
else {
var rootpath = `${Sccopy}/sc-data/sc_bilara_data/root/pli/ms/${texttype}/${slug}_root-pli-ms.json`
 }
 	
    var trnpath = `/assets/texts/${texttype}/${slug}_translation-${pathLang}-${translator}.json`;
    var htmlpath = `/assets/html/${texttype}/${slug}_html.json`;
  //  console.log(rootpath, trnpath, htmlpath);
} else if ( texttype === "vinaya" ) {
	
if (vinayaranges.indexOf(slug) !== -1) { 
  var trnpath = rustrnpath; 
 // scLink += ifRus; 
} else {
  let translator = "brahmali";

  const pathLang = "en";
  var trnpath = `${Sccopy}/sc-data/sc_bilara_data/translation/${pathLang}/${translator}/${texttype}/${slugReady}_translation-${pathLang}-${translator}.json`;
}
  console.log('vinaya case');
}  

var varpath = `${Sccopy}/sc-data/sc_bilara_data/variant/pli/ms/${texttype}/${slugReady}_variant-pli-ms.json`
var varpathLocal = `/assets/texts/variant/${texttype}/${slugReady}_variant-pli-ms.json`

const rootResponse = fetch(rootpath)
  .then(response => {
    if (!response.ok) {
      throw new Error('Root file not found');
    }
    return response.json();
  })
  .catch(error => {
    console.log('note: no root found, trying alternative path');
    // Переключаем на второй путь
    rootpath = `${Sccopy}/sc-data/sc_bilara_data/root/pli/ms/${texttype}/${slugReady}_root-pli-ms.json`;
    // Делаем новый запрос по второму пути
    return fetch(rootpath)
      .then(response => {
        if (!response.ok) {
          throw new Error('Alternative root file not found');
        }
        return response.json();
      })
      .catch(error => {
        console.log('note: no alternative root found either');
        return {}; // Возвращаем пустой объект, если оба пути недоступны
      });
  });

    
   async function fetchTranslation() {
  const paths = [rustrnpath, trnpath];

  for (const path of paths) {
    try {
      const response = await fetch(path);
      if (response.ok) {
        return await response.json();
      }
      console.log(`note: no translation found at ${path}`);
    } catch (error) {
      console.log(`note: error fetching ${path}`);
    }
  }

  console.log('note: no translation found in any path');
  return {}; // Если все пути недоступны
}

const translationResponse = fetchTranslation(); 
    
    
  const htmlResponse = fetch(htmlpath).then(response => response.json())    .
  catch(error => {
 console.log('note:no html found');   
// console.log(varpath); 
return {};
  } 
    );
    
async function fetchVariant() {
  const paths = [varpath, varpathLocal];
  let combinedData = {}; // Объект для объединения данных

  for (const path of paths) {
    try {
      const response = await fetch(path);
      if (response.ok) {
        const data = await response.json();
        combinedData = { ...combinedData, ...data }; // Объединяем данные
      } else {
    //    console.log(`note: no var found at ${path}`);
      }
    } catch (error) {
    //  console.log(`note: error fetching var ${path}`);
    }
  }

  if (Object.keys(combinedData).length === 0) {
  //  console.log('note: no var found in any path');
  }

  return combinedData; // Возвращаем объединенные данные
}

// Использование
const varResponse = fetchVariant();
    
//  console.log(trnpath);
//  console.log(rustrnpath);
Promise.all([rootResponse, translationResponse, htmlResponse, varResponse]).then(responses => {
    const [paliData, transData, htmlData, varData] = responses;
    Object.keys(htmlData).forEach(segment => {
      if (transData[segment] === undefined) {
        transData[segment] = "";
      }
      if (transData[segment] === "") {
        transData[segment] = "";
      }      
      
let [openHtml, closeHtml] = htmlData[segment].split(/{}/);
   openHtml = openHtml || ''; // Запасное значение
   closeHtml = closeHtml || ''; // Запасное значение 
 
      /* openHtml = openHtml.replace(/^<span class='verse-line'>/, "<br><span class='verse-line'>"); inputscript-IASTPali 
      Roman (IAST)     	IAST
Roman (IAST: Pāḷi)     	IASTPali
Roman (IPA)            	IPA
Roman (ISO 15919)      	ISO
Roman (ISO 15919: Pāḷi)	ISOPali */
// ISOPali ISO IASTPali IAST

let startIndex = segment.indexOf(':') + 1;
let anchor = segment.substring(startIndex);

if (slug.includes('-') && (slug.includes('an') || slug.includes('sn') || slug.includes('dhp'))) {
anchor = segment;
}

// Получите полный URL с якорем

var fullUrlWithAnchor = window.location.href.split('#')[0] + '#' + anchor;

  let finder = params.get("s");
 //  finder = finder.replace(/\\b/g, '');
//  finder = finder.replace(/%08/g, '\\b');
 // console.log(finder);
   // let finder = decodeURIComponent(params.get("s"));


if (localStorage.getItem("removePunct") === "true" && paliData[segment] !== undefined) {    
  paliData[segment] = paliData[segment].replace(/[-—–]/g, ' ');  
    paliData[segment] = paliData[segment].replace(/[:;“”‘’,"']/g, '');  
    paliData[segment] = paliData[segment].replace(/[.?!]/g, ' | '); 
    
    //।   ॥  
}

if (finder && finder.trim() !== "") {
  let regex = new RegExp(finder, 'gi'); // 'gi' - игнорировать регистр

  try {
    paliData[segment] = paliData[segment]?.replace(regex, match => `<b class='match finder'>${match}</b>`);
  } catch (error) {
  //  console.log("Ошибка при выделении совпадений в paliData:", info);
  }

  try {
    transData[segment] = transData[segment]?.replace(regex, match => `<b class="match finder">${match}</b>`);
  } catch (error) {
 //   console.log("Ошибка при выделении совпадений в transData:", info);
  }

  if (varData[segment] !== undefined) {  
    try {
      varData[segment] = varData[segment].replace(regex, match => `<b class="match finder">${match}</b>`);
    } catch (error) {
    //  console.log("Ошибка при выделении совпадений в varData:", info);
    }
  }
}

let linkToCopy = `<a class="text-decoration-none copyLink" style="cursor: pointer;" onclick="copyToClipboard('${fullUrlWithAnchor}')">&nbsp;</a>`
let linkWithDataSet = `<a class="text-decoration-none copyLink" style="cursor: pointer;" data-copy-text="${fullUrlWithAnchor}">&nbsp;</a>`

//// inputscript-ISOPali add for aksharamukha data-copy-text="${fullUrlWithAnchor}"


if (paliData[segment] !== undefined && transData[segment] !== undefined && varData[segment] !== undefined) {
        html += `${openHtml}<span id="${anchor}">
      <span class="pli-lang inputscript-ISOPali" lang="pi">${paliData[segment].trim()}${linkToCopy}<br>
<font class="variant">
${varData[segment].trim()}${linkToCopy}   
</font>     
      </span>
      <span class="rus-lang" lang="ru">${transData[segment].trim()}${linkToCopy}
<br></span>
      </span>${closeHtml}\n\n`;
} else if (paliData[segment] !== undefined && transData[segment] !== undefined) {
html += `${openHtml}<span id="${anchor}"><span class="pli-lang inputscript-ISOPali" lang="pi">${paliData[segment].trim()}${linkToCopy}</span><span class="rus-lang" lang="ru">${transData[segment].trim()}${linkToCopy}<br></span></span>${closeHtml}\n\n`;
} else if (paliData[segment] !== undefined) {
  html += openHtml + '<span id="' + anchor + '"><span class="pli-lang inputscript-ISOPali" lang="pi">' + paliData[segment].trim() + linkToCopy + '</span></span>' + closeHtml + '\n\n';
} else if (transData[segment] !== undefined) {
  html += openHtml + '<span id="' + anchor + '"><span class="rus-lang" lang="ru">' + transData[segment].trim() + linkToCopy + '</span></span>' + closeHtml + '\n\n';
}
    });

//console.log('before ' + translator) ;

if (translator === "o") {
  translatorforuser = '<a href=/assets/texts/o.html>o</a> с Пали';
} else if (translator === "sv") {
  translatorforuser = 'SV theravada.ru с Англ';
} else if ((translator === "" && texttype === "sutta" ) || (translator === "sujato" )) {
  translatorforuser = 'Bhikkhu Sujato';
} else if ((translator === "" && texttype === "vinaya") || (translator === "brahmali" ))  {
  translatorforuser = 'Bhikkhu Brahmali';
} else if (translator === "syrkin" ) {
  translatorforuser = '<a href=/assets/texts/syrkin.html>А.Я. Сыркин</a> с Пали';
} else if (translator === "syrkin+edited+o" ) {
  translatorforuser = '<a href=/assets/texts/syrkin.html>А.Я. Сыркин</a> с Пали, ред. <a href=/assets/texts/o.html>o</a>';
} else if (translator === "sv+edited+o" ) {
  translatorforuser = 'SV theravada.ru с Англ, ред. <a href=/assets/texts/o.html>o</a>';
} else if (translator === "myagkih+edited+tr" ) {
  translatorforuser = 'К. Мягких с Англ, ред. ТР';
}
else if (translator === "o+in+progress" ) {
  translatorforuser = '<a href=/assets/texts/o.html>o</a>, в процессе';
} else {
	translatorforuser = translator ;
}

//const translatorCapitalized = translator.charAt(0).toUpperCase() + translator.slice(1);

     const translatorByline = `<div class="byline">
     <p>
    <span class="pli-lang" lang="pi">Pāḷi <a class="text-decoration-none text-reset" href="/assets/texts/abbr.html?s=ms">MS</a></span> <span class="rus-lang" lang="ru"> Пер. ${translatorforuser}</span>
     </p>
     </div>`;
  
  const ruUrl  = window.location.href;

const enUrl = ruUrl.replace("/r/", "/read/");

scLink += `<a title='Английский (Alt+1)' href="${enUrl}">En</a>&nbsp;`;
 
  
//dpr
if (texttype !== "vinaya") {
function getTextUrl(slug) {
  let nikaya = slug.match(/[a-zA-Z]+/)[0]; // Получаем название никаи из строки
  let textnum;

  if (slug.includes(".")) {
    let match = slug.match(/([a-zA-Z]+)(\d+)\.(\d+)/);
    if (match) {
      let [, nikaya, subdivision, textnum] = match;
      let textUrl = findTextUrl(nikaya, parseInt(subdivision), parseInt(textnum));
      if (textUrl) {
        return textUrl;
      }
    }
  } else {
    textnum = parseInt(slug.match(/[a-zA-Z](\d+)/)[1]); // Получаем цифры после букв
    let textUrl = findTextUrl(nikaya, null, textnum);
    if (textUrl) {
      return textUrl;
    }
  }
  
  return "Запись не найдена";
}

function findTextUrl(nikaya, subdivision, textnum) {
  if (subdivision !== null) {
    if (digitalPaliReader[nikaya].available[subdivision]) {
      let item = digitalPaliReader[nikaya].available[subdivision].find(item => {
        if (Array.isArray(item)) {
          if (item.length === 3) {
            return textnum >= item[0] && textnum <= item[1];
          } else if (item.length === 2) {
            return textnum === item[0];
          }
        }
        return false;
      });
      
      if (item) {
        return digitalPaliReader.constants.rootUrl + item[item.length - 1];
      }
    }
  } else {
    let item = digitalPaliReader[nikaya].available.find(item => Array.isArray(item) ? item[0] === textnum : item === textnum);
    if (item) {
      return digitalPaliReader.constants.rootUrl + item[1];
    }
  }
  
  return null;
}

let textUrl = getTextUrl(slug);
//console.log("Ссылка на", slug + ":", textUrl);
if (textUrl) {
scLink += `<a target="" title='Digital Pali Reader' href="${textUrl}">DPR</a>&nbsp;`;
}

}
//dpr end
if ((translator === 'sujato') || (translator === 'brahmali')) {
  scLink += `<a target="" title='SuttaCentral.net' href="https://suttacentral.net/${slug}/en/${translator}">SC</a>&nbsp;`;  
} else {
  scLink += `<a target="" title='SuttaCentral.net' href="https://suttacentral.net/${slug}">SC</a>&nbsp;`;
}

      $.ajax({
      url: "/read/php/extralinks.php?fromjs=" +slug
    }).done(function(data) {
      const linksArray = data.split(",");
  
   //   scLink += `<a target="" href="https://suttacentral.net/${slug}">SC</a>&nbsp;`; 

//<a href="/legacy.suttacentral.net/read/pi/${slug}.html">legacy.SC</a>&nbsp; <a target="" href="https://voice.suttacentral.net/scv/index.html?#/sutta?search=${slug}">Voice.SC</a>
      if (linksArray[0].length >= 4) {
        scLink += linksArray[0];
          //  console.log("extralinks " + linksArray[0]);
      } 
      scLink = scLink;
      
      scLink += "</p>"; 

const origUrl = window.location.href;
let rvUrl = origUrl.replace("/r/", "/read/");
thUrl = origUrl.replace("/r/", "/th/read/");
dUrl = origUrl.replace("/r/", "/d/");
rvUrl = rvUrl.replace("/ml/", "/r/");
rvUrl = rvUrl.replace("/read/", "/memorize/");

// Настройки
const SHOW_CLOSE_AFTER = 10;  // Показывать кнопку закрытия после 10 просмотров

// Получаем или инициализируем счетчик просмотров
let viewCount = parseInt(localStorage.getItem('warningViewCount')) || 0;
viewCount++;
localStorage.setItem('warningViewCount', viewCount);

// Проверяем, можно ли показывать кнопку закрытия
const canShowClose = viewCount >= SHOW_CLOSE_AFTER;

// Проверяем, был ли warning уже закрыт
const isWarningClosed = localStorage.getItem('warningClosed');

const warning = `
  <div style="max-width: 550px; margin: 0 auto; text-align: center;" class="warning-container">
    <p class='warning'>
      <strong>Заметка:</strong><a style='cursor: pointer;' class='text-decoration-none' target='' href='${dUrl}'>&nbsp;</a>Переводы, словари и комментарии сделаны не Благословенным.<a style='cursor: pointer;' class='text-decoration-none' target='' href='${thUrl}'>&nbsp;</a>Сверяйтесь с Пали в 4 основных никаях.<a style='cursor: pointer;' class='text-decoration-none' target='' href='${rvUrl}'>&nbsp;</a>
           ${canShowClose && !isWarningClosed ? `<span class="close-warning">×</span>` : ''} 
    </p>
  </div>
`;

// Добавляем HTML
suttaArea.innerHTML = scLink + '<br>' + (!isWarningClosed ? warning : '') + translatorByline + html + translatorByline + warning + scLink;

// Добавляем обработчик события для кнопки закрытия (если она есть)
if (canShowClose && !isWarningClosed) {
  document.querySelector('.close-warning')?.addEventListener('click', function() {
    localStorage.setItem('warningClosed', 'true');
    document.querySelector('.warning-container')?.remove();
  });
}

//конец вывода информации

const pageTitleElement = document.querySelector("h1");
let pageTitleText = pageTitleElement.textContent;
pageTitle = pageTitleText.replace(/[0-9.]/g, '');

slug = slug.replace(/pli-tv-|vb-/g, '');
document.title = `${slug} ${pageTitle}`;
    
var metaDescription = document.createElement('meta');
metaDescription.name = 'description';
metaDescription.content = document.title;
document.head.appendChild(metaDescription);

var ogDescriptionMeta = document.createElement('meta');
ogDescriptionMeta.property = 'og:description';
ogDescriptionMeta.content = document.title;
document.head.appendChild(ogDescriptionMeta);


      toggleThePali();
      
      $.ajax({
      url: "/read/php/api.php?fromjs=" +texttype +"/" +slugReady +"&type=A"
    }).done(function(data) {
      const nextArray = data.split(" ");
      let nextSlug = nextArray[0];
let nextSlugPrint = nextSlug.replace(/pli-tv-|b[ui]-vb-/g, "");

   //   let nextName = nextArray[1];
let nextName = nextArray.slice(1).join(" ");
nextName = nextName.replace(/[0-9.]/g, '');

      if (nextName === undefined) {
      var nextPrint = nextSlugPrint;
      } else {
        var nextPrint = `
      ${nextSlugPrint}
      <span class="sutta-name"> ${nextName.trim()}</span>
      `;
     
     
     }
   //  console.log(nextPrint);

    let finder = params.get("s");
         next.innerHTML = nextSlug
          ? `<a href="?q=${nextSlug}${params.has("s") ? `&s=${finder}` : ""}">${nextPrint.trim()}
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="body_1" width="15" height="11">

      <g transform="matrix(0.021484375 0 0 0.021484375 2 -0)">
        <g>
              <path d="M202.1 450C 196.03278 449.9987 190.56381 446.34256 188.24348 440.73654C 185.92316 435.13055 187.20845 428.67883 191.5 424.39L191.5 424.39L365.79 250.1L191.5 75.81C 185.81535 69.92433 185.89662 60.568687 191.68266 54.782654C 197.46869 48.996624 206.82434 48.91536 212.71 54.6L212.71 54.6L397.61 239.5C 403.4657 245.3575 403.4657 254.8525 397.61 260.71L397.61 260.71L212.70999 445.61C 209.89557 448.4226 206.07895 450.0018 202.1 450z" stroke="none" fill="#8f8f8f" fill-rule="nonzero" />
        </g>
      </g>
      </svg></a>`
        : "";
// Копируем HTML и сразу удаляем класс через replace()
next2.innerHTML = next.innerHTML.replace(/class="sutta-name"/g, '');
    }
    );
  
  $.ajax({
      url: "/read/php/api.php?fromjs=" +texttype +"/" +slugReady +"&type=B"
    }).done(function(data) {
      const prevArray = data.split(" ");
      let prevSlug = prevArray[0];
      let prevSlugPrint = prevSlug.replace(/pli-tv-|b[ui]-vb-/g, "");

//      let prevName = prevArray[1];
let prevName = prevArray.slice(1).join(" ");
prevName = prevName.replace(/[0-9.]/g, '');

        if (prevName === undefined) {
    var prevPrint = prevSlugPrint;
      } else {
      var prevPrint = `
      ${prevSlugPrint}
      <span class="sutta-name"> ${prevName}</span>
      `;
     }
     let finder = params.get("s");

    previous.innerHTML = prevSlug
  ? `<a href="?q=${prevSlug}${params.has("s") ? `&s=${finder}` : ""}">
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="body_1" width="15" height="11">
      <g transform="matrix(0.021484375 0 0 0.021484375 2 -0)">
        <g>
          <path d="M353 450C 349.02106 450.0018 345.20444 448.4226 342.39 445.61L342.39 445.61L157.5 260.71C 151.64429 254.8525 151.64429 245.3575 157.5 239.5L157.5 239.5L342.39 54.6C 346.1788 50.809414 351.70206 49.328068 356.8792 50.713974C 362.05634 52.099876 366.10086 56.14248 367.4892 61.318974C 368.87753 66.49547 367.3988 72.01941 363.61002 75.81L363.61002 75.81L189.32 250.1L363.61 424.39C 367.90283 428.6801 369.18747 435.13425 366.8646 440.74118C 364.5417 446.34808 359.06903 450.00275 353 450z" stroke="none" fill="#8f8f8f" fill-rule="nonzero" />
        </g>
      </g>
      </svg>${prevPrint.trim()}</a>`
  : "";
        previous2.innerHTML = previous.innerHTML.replace(/class="sutta-name"/g, '');

      }
      );

    }
    );
    })
.catch(error => {
  console.log('error:not found');
  
  console.log('rootResponse', translationResponse);
  console.log('rootpath', rootpath);
  console.log('trnpath', trnpath);
  console.log('rustrnpath', rustrnpath);
  console.log('htmlpath', htmlpath);
  console.log('varpath', varpath);
  console.log('varpathLocal', varpath);
  
  const currentURL = window.location.href;
const anchorURL = new URL(currentURL).hash; // Убираем символ "#"
console.log('anchorURL', anchorURL);


  let params = new URLSearchParams(document.location.search);
  let sGetparam = params.get("s");
  
console.log('sGetparam', sGetparam);  
console.log('slug', slug);  

/*
  // Отправка запроса по адресу http://localhost:8080/ru/?q= с использованием значения slug
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "/ru/?s=" + encodeURIComponent(sGetparam) + "&q=" + encodeURIComponent(slug) + "#" + encodeURIComponent(anchorURL) , true);
  xhr.send();

  // Обработка ответа
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        // Обработка успешного ответа
        console.log(xhr.responseText);
     window.location.href = "/ru/?s=" + encodeURIComponent(sGetparam) + "&q=" + encodeURIComponent(slug) + "#" + anchorURL;

      } else {
        // Обработка ошибки
        console.log('Error sending request to /ru/?q=');
      }
    }
  };
  
  // Обновление сообщения об ошибке на странице
  */
  
// Отправка запроса по адресу http://localhost:8080/ru/?q= с использованием значения slug
var xhr = new XMLHttpRequest();
xhr.open("GET", "/ru/?p=-kn&q=" + encodeURIComponent(slug), true);
xhr.send();

xhr.onreadystatechange = function() {
  if (xhr.readyState == 4) {
    if (xhr.status == 200) {
      // Проверяем, что ответ не является страницей 404 или другой ошибкой
      // Например, можно проверить наличие определенного текста или структуры ответа
      if (!xhr.responseText.includes("Page not found") && 
          !xhr.responseText.includes("404") &&
          xhr.responseText.trim().length > 0) {
        console.log(xhr.responseText);

/*	
let currentParams = new URLSearchParams(window.location.search);
let sParam = currentParams.get("s");
let newUrl = `/ru/?p=-kn&q=${encodeURIComponent(slug)}`;
if (sParam) newUrl += `&s=${encodeURIComponent(sParam)}`;
window.location.href = newUrl;
	*/
		
    window.location.href = "/ru/?p=-kn&q=" + encodeURIComponent(slug);
      } else {
        console.log('Page not found or empty response');
      }
    } else if (xhr.status == 404) {
      console.log('Error 404: Page not found');
    } else {
      console.log('Error sending request. Status:', xhr.status);
    }
  }
};

  // Обновление сообщения об ошибке на странице  
  
  suttaArea.innerHTML = `<p>Идёт Поиск "${decodeURIComponent(slug)}". Пожалуйста, Ожидайте.</p>
    
                  <div class="spinner-border" role="status">
                <span class="visually-hidden">Загрузка...</span>
                  </div>
  <p>  Подсказка: <br>
    С главной страницы доступно больше настроек поиска.
<br></p>`;
return false;
});

    }

    );
	
// в конец функции можно добавить скролл

}

// initialize the whole app
if (document.location.search) {
  let params = new URLSearchParams(document.location.search);
  let slug = params.get("q");
  let lang = params.get("lang");

  citation.value = slug;

  buildSutta(slug);
  
  if (lang) {
    language = lang;
    setLanguage(lang);
  } else if  (localStorage.paliToggleRu) {
    	language = localStorage.paliToggleRu; 
setLanguage(language);
  } 
} else {
  suttaArea.innerHTML = `<div class="instructions">
<p>Для перехода тексты должны быть указаны с номерами. Пример: <span class="abbr">sn35.28</span> <span class="abbr">an1.1-10</span> <span class="abbr">bu-as1-7</span> или <span class="abbr">bi-pj1</span>.<br>
 Доступны dn, mn, sn, an, некоторые книги kn, обе патимоккхи и виная вибханги.<br>
  </p>
  <div class="lists">

  <div class="suttas">
  <a href="/ru/read.php"> <h2>Основные Сутты</h2></a> <br>
  <ul>
     <li><span class="abbr">dn</span> <a href="/ru/assets/texts/dn.php"> Dīgha-nikāya</a></li></li>
     <li><span class="abbr">mn</span> <a href="/ru/assets/texts/mn.php"> Majjhima-nikāya</a></li></li>
      <li><span class="abbr">sn</span> <a href="/ru/assets/texts/sn.php"> Saṁyutta-nikāya</a></li>
      <li><span class="abbr">an</span> <a href="/ru/assets/texts/an.php"> Aṅguttara-nikāya</a></li>

  </ul>
  </div>

  <div>
  <h2>Часть KN</h2><br>
  <ul>
       <li><span class="abbr">snp</span> Sutta-nipāta</li> 
      <li><span class="abbr">ud</span> Udāna</li>
      <li><span class="abbr">iti</span> Itivuttaka (1–112)</li>
      <li><span class="abbr">dhp</span> Dhammapada</li>
      <li><span class="abbr">thag</span> Theragāthā</li>
      <li><span class="abbr">thig</span> Therīgāthā</li>
   <!--	     <li><span class="abbr">snp</span> Sutta-nipāta</li>
 <li><span class="abbr">kp</span> Khuddakapāṭha</li>-->
  </ul>
  </div>  
  
  <div>
 <!-- <h2>Виная</h2> -->
  <div class="vinaya">
  <div>
  <h3>Бхиккху Виная</h3><br>
<ul>
<li><span class="abbr">bu-pm</span> <a href="/ru/assets/texts/pm.php"> Bhikkhupātimokkha</a></li>
<li><span class="abbr">bu-pj</span> <a href="/r/?q=bu-pm#8.0"> Pārājikā</a></li></li>
<li><span class="abbr">bu-ss</span> <a href="/r/?q=bu-pm#14.0"> Saṅghādisesā</a></li></li>
<li><span class="abbr">bu-ay</span> <a href="/r/?q=bu-pm#29.0"> Aniyatā</a></li>
<li><span class="abbr">bu-np</span> <a href="/r/?q=bu-pm#33.0"> Nissaggiyā-pācittiyā</a></li>
<li><span class="abbr">bu-pc</span> <a href="/r/?q=bu-pm#65.0"> Pācittiyā</a></li>
<li><span class="abbr">bu-pd</span> <a href="/r/?q=bu-pm#159.0"> Pāṭidesanīyā</a></li></li>
<li><span class="abbr">bu-sk</span> <a href="/r/?q=bu-pm#165.0"> Sekhiyā</a></li></li>
<li><span class="abbr">bu-as</span> <a href="/r/?q=bu-pm#245.0"> Adhikarana-samatha</a></li></li>
</ul>
</div><div>
<h3>Бхиккхуни Виная</h3><br>
<ul>
<li><span class="abbr">bi-pm</span> <a href="/ru/assets/texts/bipm.php"> Bhikkhunīpātimokkha</a></li>
<li><span class="abbr">bi-pj</span> Pārājikā</li>
<li><span class="abbr">bi-ss</span> Saṅghādisesā</li>
<li><span class="abbr">bi-np</span> Nissaggiyā-pācittiyā</li>
<li><span class="abbr">bi-pc</span> Pācittiyā</li>
<li><span class="abbr">bi-pd</span> Pāṭidesanīyā</li>
<li><span class="abbr">bi-sk</span> Sekhiyā</li>
<li><span class="abbr">bi-as</span> Adhikarana-samatha</li>
</ul>
</div>
<div>
<h3>Khandhaka</h3>
<h3>Mahāvagga</h3><br>
<ul>
<li><span class=abbr>kd1</span> <a href=/r/?q=pli-tv-kd1>Mahākhandhaka</a></li>
<li><span class=abbr>kd2</span> <a href=/r/?q=pli-tv-kd2>Uposathakkhandhaka</a></li>                                 
<li><span class=abbr>kd3</span> <a href=/r/?q=pli-tv-kd3>Vassūpanāyikakkhandhaka</a></li>
<li><span class=abbr>kd4</span> <a href=/r/?q=pli-tv-kd4>Pavāraṇākkhandhaka</a></li>
<li><span class=abbr>kd5</span> <a href=/r/?q=pli-tv-kd5>Cammakkhandhaka</a></li>
<li><span class=abbr>kd6</span> <a href=/r/?q=pli-tv-kd6>Bhesajjakkhandhaka</a></li>
<li><span class=abbr>kd7</span> <a href=/r/?q=pli-tv-kd7>Kathinakkhandhaka</a></li>
<li><span class=abbr>kd8</span> <a href=/r/?q=pli-tv-kd8>Cīvarakkhandhaka</a></li>                                    
<li><span class=abbr>kd9</span> <a href=/r/?q=pli-tv-kd9>Campeyyakkhandhaka</a></li>
<li><span class=abbr>kd10</span> <a href=/r/?q=pli-tv-kd10>Kosambakakkhandhaka</a></li>
</ul>
<h3>Cūḷavagga</h3><br>
<ul>
<li><span class=abbr>kd11</span> <a href=/r/?q=pli-tv-kd11>Kammakkhandhaka</a></li>
<li><span class=abbr>kd12</span> <a href=/r/?q=pli-tv-kd12>Pārivāsikakkhandhaka</a></li>
<li><span class=abbr>kd13</span> <a href=/r/?q=pli-tv-kd13>Samuccayakkhandhaka</a></li>
<li><span class=abbr>kd14</span> <a href=/r/?q=pli-tv-kd14>Samathakkhandhaka</a></li>
<li><span class=abbr>kd15</span> <a href=/r/?q=pli-tv-kd15>Khuddakavatthukkhandhaka</a></li>
<li><span class=abbr>kd16</span> <a href=/r/?q=pli-tv-kd16>Senāsanakkhandhaka</a></li>
<li><span class=abbr>kd17</span> <a href=/r/?q=pli-tv-kd17>Saṅghabhedakakkhandhaka</a></li>
<li><span class=abbr>kd18</span> <a href=/r/?q=pli-tv-kd18>Vattakkhandhaka</a></li>
<li><span class=abbr>kd19</span> <a href=/r/?q=pli-tv-kd19>Pātimokkhaṭṭhapanakkhandhaka</a></li>
<li><span class=abbr>kd20</span> <a href=/r/?q=pli-tv-kd20>Bhikkhunikkhandhaka</a></li>
<li><span class=abbr>kd21</span> <a href=/r/?q=pli-tv-kd21>Pañcasatikakkhandhaka</a></li>
<li><span class=abbr>kd22</span> <a href=/r/?q=pli-tv-kd22>Sattasatikakkhandhaka</a></li>
</ul>
</div>
<div>
<ul>
<li><span class="abbr">pvr</span> Parivāra</li>
</ul>
</div>
  </div></div>
`;
}

function setLanguage(language) {
  if (language === "pli-rus") {
    showPaliEnglish();
  } else if (language === "pli") {
    showPali();
  } else if (language === "rus") {
    showEnglish();
  }
}

function showPaliEnglish() {
  suttaArea.classList.remove("hide-pali");
  suttaArea.classList.remove("hide-english");
  suttaArea.classList.remove("hide-russian");
  
  const savedMode = localStorage.getItem('viewMode') || 'alternate'; // Получаем сохранённое значение или 'alternate' по умолчанию
  const isColumnView = (savedMode === 'columns');

  // Применяем сохранённый режим
  if (isColumnView) {
    suttaArea.classList.add('column-view');
  }
  
}
function showEnglish() {
  suttaArea.classList.add("hide-pali");
  suttaArea.classList.remove("hide-english");
  suttaArea.classList.remove("hide-russian");
  suttaArea.classList.remove('column-view'); // Отключаем двухколоночный режим
}
function showPali() {
  suttaArea.classList.remove("hide-pali");
  suttaArea.classList.add("hide-english");
  suttaArea.classList.add("hide-russian");
  suttaArea.classList.remove('column-view'); // Отключаем двухколоночный режим
}

function toggleThePali() {
  const languageButton = document.getElementById("language-button");

 
	 // initial state
 if (!localStorage.paliToggleRu) {
    localStorage.paliToggleRu = "pli-rus";
  }   

  languageButton.addEventListener("click", () => {
    if (language === "pli-rus") {
     showPali();
      language = "pli";
      localStorage.paliToggleRu = "pli";
    } else if (language === "rus") {
      showPaliEnglish();
      language = "pli-rus";    
      localStorage.paliToggleRu = "pli-rus";
    } else if (language === "pli") {
	  showEnglish();
      language = "rus";
      localStorage.paliToggleRu = "rus";  
    }
  });
  
}


function parseSlug(slug) {
if (
  slug === 'bu-as' ||
  slug === 'bu-vb-as1-7' ||
  slug === 'pli-tv-bu-vb-as1-7' ||
  slug === 'bi-as' ||
  slug === 'bi-vb-as1-7' ||
  slug === 'pli-tv-bi-vb-as1-7'
) {
  const slugParts = slug.match(/^([a-z]+)-([a-z]+)-([a-z]+)-([a-z]+)-([a-z]+)*(\d*)/);
  const fixforbivb = slug.replace(/(\d+)-(\d+)/g, '');
  const bookWithoutNumber = fixforbivb.replace(/(\d+)/g, '');
  const fixforbivb2 = slug.replace(/-([a-z]+)\d+/g, '');
  const bookWithoutNumberAndRule = fixforbivb2.replace(/-\d+$/g, '');
  const firstNum = slugParts[6];
  
  return `${bookWithoutNumberAndRule}/${bookWithoutNumber}1-7`;
} else if ( slug.match(/^([a-z]+)-([a-z]+)-([a-z]+)-([a-z]+)-([a-z]+)*(\d*)/)) {
    const slugParts = slug.match(/^([a-z]+)-([a-z]+)-([a-z]+)-([a-z]+)-([a-z]+)*(\d*)/);
  const fixforbivb = slug.replace(/(\d+)-(\d+)/g, '');
  const bookWithoutNumber = fixforbivb.replace(/(\d+)/g, '');
  const fixforbivb2 = slug.replace(/-([a-z]+)\d+/g, '');
  const bookWithoutNumberAndRule = fixforbivb2.replace(/-\d+$/g, '');
  const firstNum = slugParts[6];
  return `${bookWithoutNumberAndRule}/${bookWithoutNumber}/${slug}`;
}
else if  (slug.match(/^([a-z]+)-([a-z]+)-([a-z]+)*(\d*)/)){
  const bookWithoutNumber = slug.replace(/(\d+|\.)/g, '');
  return `${bookWithoutNumber}/${slug}`;
}

const slugParts = slug.match(/^([a-z]+)(\d*)\.*(\d*)/);
const book = slugParts ? slugParts[1] : slug;
const firstNum = slugParts ? slugParts[2] : '';

// Далее ваш существующий код...
  if (book === "dn" || book === "mn") {
    return `${book}/${slug}`;
  } else if (book === "sn" || book === "an") {
    return `${book}/${book}${firstNum}/${slug}`;
  } else if (book === "kp") {
    return `kn/kp/${slug}`;
  } else if (book === "dhp") {
    return `kn/dhp/${slug}`;
  } else if (book === "ud") {
    return `kn/ud/vagga${firstNum}/${slug}`;
  } else if (book === "iti") {
    return `kn/iti/vagga${findItiVagga(firstNum)}/${slug}`;
  } else if (book === "snp") {
    return `kn/snp/vagga${firstNum}/${slug}`;
  } else if (book === "thag" || book === "thig") {
    return `kn/${book}/${slug}`;
  } else if (book === "ja") {
    return `kn/ja/${slug}`;
  }
}

function findItiVagga(suttaNumber) {
  if (suttaNumber >= 1 && suttaNumber <= 10) {
    return "1";
  } else if (suttaNumber >= 11 && suttaNumber <= 20) {
    return "2";
  } else if (suttaNumber >= 21 && suttaNumber <= 27) {
    return "3";
  } else if (suttaNumber >= 28 && suttaNumber <= 37) {
    return "4";
  } else if (suttaNumber >= 38 && suttaNumber <= 49) {
    return "5";
  } else if (suttaNumber >= 50 && suttaNumber <= 59) {
    return "6";
  } else if (suttaNumber >= 60 && suttaNumber <= 69) {
    return "7";
  } else if (suttaNumber >= 70 && suttaNumber <= 79) {
    return "8";
  } else if (suttaNumber >= 80 && suttaNumber <= 89) {
    return "9";
  } else if (suttaNumber >= 90 && suttaNumber <= 99) {
    return "10";
  } else if (suttaNumber >= 100 && suttaNumber <= 112) {
    return "11";
  }
}


// clicking an abbreviation on the home page will replace the input field with that abbreviation
const abbreviations = document.querySelectorAll("span.abbr");
abbreviations.forEach(book => {
  book.addEventListener("click", e => {
    citation.value = e.target.innerHTML;
    // form.input.setSelectionRange(10, 10);
    citation.focus();
  });
});

function handleVariantVisibility() {
  const toggleButton = document.getElementById("toggle-variants");
  const variantElements = document.querySelectorAll(".variant");

  if (!toggleButton || variantElements.length === 0) return;

  const storedState = localStorage.getItem("variantVisibility");

  // Применяем сохраненное состояние при загрузке
  if (storedState === "hidden") {
    variantElements.forEach((el) => el.classList.add("hidden-variant"));
  }

  // Добавляем обработчик клика для переключения видимости
  toggleButton.addEventListener("click", function () {
    const isHidden = variantElements[0].classList.contains("hidden-variant");
    variantElements.forEach((el) => el.classList.toggle("hidden-variant"));
    localStorage.setItem("variantVisibility", isHidden ? "visible" : "hidden");
  });

  
}
