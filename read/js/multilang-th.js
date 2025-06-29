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
const pathLang = "th";

citation.focus();
let language = "pli-rus";

homeButton.addEventListener("click", () => {
  document.location.search = "";
});

// pressing enter will "submit" the citation and load
form.addEventListener("submit", e => {
  e.preventDefault();
  if (citation.value) {
    buildSutta(citation.value.replace(/\s+/g, " "));
  history.pushState({ page: citation.value.replace(/\s+/g, " ") }, "", `?q=${citation.value.replace(/\s+/g, " ")}`);
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
    slug = slug.replace(/bi([psan])/, "bi-$1");
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
    slug = slug.replace(/bi([psn])/, "bi-$1");
    if (!slug.match("pli-tv-")) {
      slug = "pli-tv-" + slug;
    }
  }
  let html = `<div class="button-area"><button id="language-button" class="hide-button">Pāḷi ไทย</button></div>`;
  
  const slugReady = parseSlug(slug);
  console.log("slugReady is " + slugReady + " slug is " + slug); 



$.ajax({
       url: "/read/php/translator-lookup.php?fromjs=" +texttype +"/" +slugReady
    }).done(function(data) {
      const trnsResp = data.split(" ");
     // let translator = trnsResp[0];
      let translator = "siamrath";
  if (slug.match(/bu-pm|bi-pm/)) {
   translator = "jayasaro";
 } 

//if (slug.match(/^mn([1-9]|1[0-9]|2[0-1])$/)) {
 
const onlynumber = slug.replace(/[a-zA-Z]/g, '');

let snranges = ['sn12.2', 'sn15.3', 'sn22.59', 'sn35.28', 'sn56.11'];
let dnranges = ['dn22'];
let anranges = ['an3.107', 'an10.46'];

var rootpath = `/assets/texts/${pathLang}/root/pli/ms/${texttype}/${slugReady}_root${pathLang}-pli-ms.json`;
console.log('thai rootpath ' + rootpath);
//var rootpath = `${Sccopy}/sc-data/sc_bilara_data/root/pli/ms/${texttype}/${slugReady}_root-pli-ms.json`;

var thtrnpath = `/assets/texts/${pathLang}/translation/${texttype}/${slugReady}_translation-${pathLang}-${translator}.json`;

var theditedtrnpath = `/assets/texts/${pathLang}/translation/${texttype}/${slugReady}_translation-${pathLang}-${translator}+edited+o.json`;
if ( texttype === "vinaya")
{
  var engtrnpath = `${Sccopy}/sc-data/sc_bilara_data/translation/en/brahmali/vinaya/${slugReady}_translation-en-brahmali.json`;
} else {
//var engtrnpath = `${Sccopy}/sc-data/sc_bilara_data/translation/${pathLang}/${translator}/${texttype}/${slugReady}_translation-${pathLang}-${translator}.json`;
  var engtrnpath = `${Sccopy}/sc-data/sc_bilara_data/translation/en/sujato/${texttype}/${slugReady}_translation-en-sujato.json`;
}

var htmlpath = `${Sccopy}/sc-data/sc_bilara_data/html/pli/ms/${texttype}/${slugReady}_html.json`;

const mlUrl  = window.location.href;

const ruUrl = mlUrl.replace("/mlth/", "/r/");
const thUrl = mlUrl.replace("/mlth/", "/th/read/");
const enUrl = mlUrl.replace("/mlth/", "/read/");
//let ifRus = `<a target="" href="${ruUrl}">Ru</a> <a target="" href="${enUrl}">En</a> `;

let scLink = `<p class="sc-link"><a target="" href="${ruUrl}">Ru</a> <a target="" href="${thUrl}">Th</a> <a target="" href="${enUrl}">En</a> `;

const currentURL = window.location.href;
const anchorURL = new URL(currentURL).hash; // Убираем символ "#"




/*if (slug.includes("mn"))  {
 var trnpath = thtrnpath; 
 let language = "pli-rus";
// scLink += ifRus; 
} else if (slug.includes("sn")) { 
  var trnpath = thtrnpath; 
//  scLink += ifRus; 
} else if (slug.includes("an")) { 
  var trnpath = thtrnpath; 
//  scLink += ifRus; 
} else if (slug.includes("dn")) { 
  var trnpath = thtrnpath; 
 // scLink += ifRus; 
}*/

 if (snranges.indexOf(slug) !== -1) { 
  var trnpath = thtrnpath; 
} else if (anranges.indexOf(slug) !== -1) { 
  var trnpath = thtrnpath; 
} else if (dnranges.indexOf(slug) !== -1) { 
  var trnpath = thtrnpath; 
}
else if (slug.match(/ja/)) {
  let language = "pli";
  let slugNumber = parseInt(slug.replace(/\D/g, ''), 10); // Извлекаем число из slug

  if (slugNumber >= 1 && slugNumber <= 75) {
    var trnpath = `${Sccopy}/sc-data/sc_bilara_data/translation/en/sujato/sutta/${slugReady}_translation-en-sujato.json`;
  } else if (slugNumber > 70) {
    var trnpath = `${Sccopy}/sc-data/sc_bilara_data/root/pli/ms/${texttype}/${slugReady}_root-pli-ms.json`;
  }
} else if ( texttype === "sutta" ) {
  let translator = "sujato";
  const pathLang = "en";
  var trnpath = `${Sccopy}/sc-data/sc_bilara_data/translation/${pathLang}/${translator}/${texttype}/${slugReady}_translation-${pathLang}-${translator}.json`;
} else if (slug.match(/bu-pm|bi-pm/)) {
  
  
      let translator = "jayasaro";
let params = new URLSearchParams(document.location.search);
 let script = params.get("script");
 
   const savedScript = localStorage.getItem('selectedScript');
   const siteLanguage = localStorage.getItem('siteLanguage');

 if (( script === "devanagari" ) || ( savedScript === "Devanagari" ) ) {
var rootpath = `/assets/texts/devanagari/root/pli/ms/${texttype}/${slug}_rootd-pli-ms.json`
 } 
 else if (( script === "thai" ) || ( savedScript === "Thai" ) || (siteLanguage === "th")) {
var  rootpath = `/assets/texts/th/root/pli/ms/${texttype}/${slug}_rootth-pli-ms.json`

 } 
else {
var rootpath = `${Sccopy}/sc-data/sc_bilara_data/root/pli/ms/${texttype}/${slug}_root-pli-ms.json`
 }

    var trnpath = `${Sccopy}/sc-data/sc_bilara_data/translation/${pathLang}/${translator}/${texttype}/${slug}_translation-${pathLang}-${translator}.json`;
    var engtrnpath = `${Sccopy}/sc-data/sc_bilara_data/translation/en/brahmali/${texttype}/${slug}_translation-en-brahmali.json`;

    var htmlpath = `/assets/html/${texttype}/${slug}_html.json`;
    //console.log(rootpath, trnpath, htmlpath);
} else if ( texttype === "vinaya" ) {
	
  let translator = "brahmali";

  const pathLang = "en";
  var trnpath = `${Sccopy}/sc-data/sc_bilara_data/translation/${pathLang}/${translator}/${texttype}/${slugReady}_translation-${pathLang}-${translator}.json`;

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

/*rootResponse.then(data => {
});

const translationResponse = fetch(thtrnpath)
  .then(response => {
    if (!response.ok) {
      throw new Error('note:no translation found');
    }
    return response.json();
  })
  .catch(error => {
    console.log('note: no translation found, trying alternative path');
    // Переключаем на второй путь
    // Делаем новый запрос по второму пути
    return fetch(trnpath)
      .then(response => {
        if (!response.ok) {
          throw new Error('Alternative translation file not found');
        }
        return response.json();
      })
      .catch(error => {
        console.log('note: no alternative translation found either');
        return {}; // Возвращаем пустой объект, если оба пути недоступны
      });
  });

async function fetchTranslation() {
  const paths = [theditedtrnpath, thtrnpath, trnpath];

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
*/
const attemptFetch = (path) => 
  fetch(path)
    .then(response => 
      response.ok 
        ? response.json() 
        : Promise.reject('HTTP error')
    );

const translationResponse = [thtrnpath, theditedtrnpath, trnpath]
  .reduce((chain, path) => chain.catch(() => attemptFetch(path)), 
    Promise.reject())
  .catch(() => {
    console.log('All translation paths failed');
    return {};
  });


  const engtranslationResponse = fetch(engtrnpath).then(response => response.json());
  const htmlResponse = fetch(htmlpath).then(response => response.json());
/*
const varResponse = fetch(varpath).then(response => response.json())    .
  catch(error => {
 console.log('note:no var found');   
// console.log(varpath);   
return {};
  } 
    );
*/    
async function fetchVariant() {
  const paths = [varpath, varpathLocal];

  for (const path of paths) {
    try {
      const response = await fetch(path);
      if (response.ok) {
        return await response.json();
      }
      console.log(`note: no var found at ${path}`);
    } catch (error) {
      console.log(`note: error fetching var ${path}`);
    }
  }

  console.log('note: no var found in any path');
  return {}; // Если все пути недоступны
}

const varResponse = fetchVariant();        
    
    
    
  Promise.all([rootResponse, translationResponse, engtranslationResponse, htmlResponse, varResponse]).then(responses => {
    const [paliData, transData, engTransData, htmlData, varData] = responses;

    Object.keys(htmlData).forEach(segment => {
      if (transData[segment] === undefined) {
        transData[segment] = "&nbsp;";
      }
      if (transData[segment] === "") {
        transData[segment] = "&nbsp;";
      }    
      let [openHtml, closeHtml] = htmlData[segment].split(/{}/);
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

var fullUrlWithAnchor = window.location.href.split('#')[0] + '#' + anchor;

let params = new URLSearchParams(document.location.search);
 let script = params.get("script");
 
   const savedScript = localStorage.getItem('selectedScript');
   const siteLanguage = localStorage.getItem('siteLanguage');

 if (( script === "devanagari" ) || ( savedScript === "Devanagari" ) ) {
var rootpath = `/assets/texts/devanagari/root/pli/ms/${texttype}/${slugReady}_rootd-pli-ms.json`;
 } 
 else if (( script === "thai" ) || ( savedScript === "Thai" ) || (siteLanguage === "th")) {
var  rootpath = `/assets/texts/th/root/pli/ms/${texttype}/${slugReady}_rootth-pli-ms.json`
 } 
else {
var  rootpath = `/assets/texts/th/root/pli/ms/${texttype}/${slugReady}_rootth-pli-ms.json`;
 }

  let finder = params.get("s");
 //  finder = finder.replace(/\\b/g, '');
//  finder = finder.replace(/%08/g, '\\b');
 // console.log(finder);
   // let finder = decodeURIComponent(params.get("s"));

if (finder && finder.trim() !== "") {
  let regex = new RegExp(finder, 'gi'); // 'gi' - игнорировать регистр

  try {
    paliData[segment] = paliData[segment]?.replace(regex, match => `<b class='match finder'>${match}</b>`);
  } catch (error) {
    console.error("Ошибка при выделении совпадений в paliData:", error);
  }

  try {
    transData[segment] = transData[segment]?.replace(regex, match => `<b class="match finder">${match}</b>`);
  } catch (error) {
    console.error("Ошибка при выделении совпадений в transData:", error);
  }

  if (varData[segment] !== undefined) {  
    try {
      varData[segment] = varData[segment].replace(regex, match => `<b class="match finder">${match}</b>`);
    } catch (error) {
      console.error("Ошибка при выделении совпадений в varData:", error);
    }
  }
}

if (paliData[segment] === undefined) {
  paliData[segment] = "&nbsp;";
}
if (transData[segment] === undefined) {
  transData[segment] = "&nbsp;";
}
if (engTransData[segment] === undefined) {
  engTransData[segment] = "&nbsp;";
}

if (localStorage.getItem("removePunct") === "true" && paliData[segment] !== undefined) {
  
    paliData[segment] = paliData[segment].replace(/[-—–]/g, ' ');  
    paliData[segment] = paliData[segment].replace(/[:;“”‘’,"']/g, '');  
    paliData[segment] = paliData[segment].replace(/[.?!]/g, ' | '); 
    
    //।   ॥  
}
if (paliData[segment] !== undefined) {
paliData[segment] = paliData[segment].replace(/[—–—]/, ' — ');
}

let linkToCopy = `<a class="text-decoration-none copyLink" style="cursor: pointer;" onclick="copyToClipboard('${fullUrlWithAnchor}')">&nbsp;</a>`
let linkWithDataSet = `<a class="text-decoration-none copyLink" style="cursor: pointer;" data-copy-text="${fullUrlWithAnchor}">&nbsp;</a>`


//   console.log(`transData[${segment}]: ${transData[segment]}`);
  //  console.log(`engTransData[${segment}]: ${engTransData[segment]}`);
    if (engTransData[segment] !== transData[segment] && varData[segment] !== undefined) {
        html += `${openHtml}<span id="${anchor}">
	<span class="pli-lang inputscript-ISOPali" lang="pi">${paliData[segment].trim()}${linkToCopy}<br>
<font class="variant">
${varData[segment].trim()}${linkToCopy}   
</font>   
	  </span>
	  <span class="right-column">

      <span class="rus-lang" lang="ru">${transData[segment].trim()}${linkToCopy}<br>
	  	  <font class="eng-lang">${engTransData[segment].trim()}${linkToCopy}</font><br>
		  </span>
		  </span>
      </span>${closeHtml}\n\n`;
	  
	  //	  </span>   --dark-gray2: #9E9E9E;  --light-gray2: #616161;
//      <span class="eng-lang" lang="en">

    } else if (engTransData[segment] !== transData[segment]) {
        html += `${openHtml}<span id="${anchor}">
      <span class="pli-lang inputscript-ISOPali" lang="pi">${paliData[segment].trim()}${linkToCopy}
	  </span>
      <span class="rus-lang" lang="ru">${transData[segment].trim()}${linkToCopy}<br>
	  	  <font class="eng-lang">${engTransData[segment].trim()}${linkToCopy}</font><br>
		  </span>
      </span>${closeHtml}\n\n`;
	  
	  //	  </span>   --dark-gray2: #9E9E9E;  --light-gray2: #616161;
//      <span class="eng-lang" lang="en">

    } else if (varData[segment] !== undefined) {
        html += `${openHtml}<span id="${anchor}">
      <span class="pli-lang inputscript-ISOPali" lang="pi">${paliData[segment].trim().trim()}${linkToCopy}<br>
<font class="variant">
${varData[segment].trim()}${linkToCopy}
</font></span>      
      <span class="rus-lang" lang="en">${engTransData[segment].trim()}${linkToCopy}</span>
      </span>${closeHtml}\n\n`;
    }  else {
        html += `${openHtml}<span id="${anchor}">
      <span class="pli-lang inputscript-ISOPali" lang="pi">${paliData[segment].trim()}${linkToCopy}</span>
      <span class="rus-lang" lang="en">${engTransData[segment].trim()}${linkToCopy}</span>
      </span>${closeHtml}\n\n`;
    }

    });

if (translator === "o") {
  translatorforuser = '<a href=/assets/common/o.html>o</a> с Пали';
} else if (translator === "sv") {
  translatorforuser = 'SV theravada.ru с Англ';
}
else if  (translator === "jayasaro" ) {
  translatorforuser = 'Bhikkhu Brahmali or Jayasaro';
} 
else if (translator === "siamrath" ) {
  translatorforuser = 'ไทย: Siam Rath, eng: Bhikkhu Sujato';
}

else if ((translator === "" && texttype === "sutta" ) || (translator === "sujato" )) {
  translatorforuser = 'ไทย: Siam Rath, eng: Bhikkhu Sujato';
}

else if ((translator === "" && texttype === "sutta" ) || (translator === "sujato" )) {
  translatorforuser = 'ไทย: Siam Rath, eng: Bhikkhu Sujato';
}
else if ((translator === "" && texttype === "vinaya") || (translator === "brahmali" ))  {
    translatorforuser = 'All by Bh Brahmali, patimokkha by A Jayasaro';
} else if (translator === "syrkin" ) {
  translatorforuser = 'А.Я. Сыркин с Пали';
} else if (translator === "syrkin+edited+o" ) {
  translatorforuser = 'А.Я. Сыркин с Пали, ред. <a href=/assets/common/o.html>o</a>';
} else if (translator === "sv+edited+o" ) {
  translatorforuser = 'SV theravada.ru с Англ, ред. <a href=/assets/common/o.html>o</a>';
} else if (translator === "o+in+progress" ) {
  translatorforuser = '<a href=/assets/common/o.html>o</a>, в процессе';
} else {
	translatorforuser = translator ;
}


//const translatorCapitalized = translator.charAt(0).toUpperCase() + translator.slice(1);

     const translatorByline = `<div class="byline">
     <p>
    <span class="pli-lang" lang="pi">Pāḷi <a class="text-decoration-none text-reset" href="/assets/texts/abbr.html?s=ms" title="Mahāsaṅgīti Pāḷi">MS</a> </span> <span class="rus-lang" lang="ru">Trans. by ${translatorforuser}</span>
     </p>
     </div>`;
     
      const scButton = `<a href="https://suttacentral.net/${slug}/th/${translator}">Читать на SC</a>`;
      
      $.ajax({
      url: "/read/php/extralinks.php?fromjs=" +slug
    }).done(function(data) {
      const linksArray = data.split(",");

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
scLink += `<a target="" href="${textUrl}">DPR</a> `;
}
}
//dpr end

if ((translator === 'sujato') || (translator === 'brahmali')) {
  scLink += `<a target="" href="https://suttacentral.net/${slug}/en/${translator}">SC</a> `;  
} else {
  scLink += `<a target="" href="https://suttacentral.net/${slug}/th/siam_rath">SC</a> `;
}
 //     scLink += `<a target="" href="https://suttacentral.net/${slug}/en/${translator}">SC</a> `; 

//<a href="/legacy.suttacentral.net/read/pi/${slug}.html">legacy.SC</a>  <a target="" href="https://voice.suttacentral.net/scv/index.html?#/sutta?search=${slug}">Voice.SC</a>
      if (linksArray[0].length >= 4) {
        scLink += linksArray[0];
            //console.log("extralinks " + linksArray[0]);
      } 
      scLink += "</p>"; 

const origUrl = window.location.href;
let rvUrl = origUrl.replace("/th/read/", "/read/");
rvUrl = origUrl.replace("/th/read/", "/read/");
dUrl = origUrl.replace("/mlth/", "/d/");
rvUrl = rvUrl.replace("/mlth/", "/read/");
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
  <div style="max-width: 600px; margin: 0 auto; text-align: center;" class="warning-container">
    <p class='warning'>
    <strong>Note:</strong><a style='cursor: pointer;' class='text-decoration-none' target='' href='${dUrl}'>&nbsp;</a>Translations, dictionaries and commentaries were not made by the Blessed One.<a style='cursor: pointer;' class='text-decoration-none' target='' href='${dUrl}'>&nbsp;</a>Cross-check with Pali in 4 main nikayas.<a class='text-decoration-none' target='' href='${rvUrl}'>&nbsp;</a>
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

  let params = new URLSearchParams(document.location.search);


      
      $.ajax({
      url: "/read/php/api.php?fromjs=" +texttype +"/" +slugReady +"&type=A"
    }).done(function(data) {
      const nextArray = data.split(" ");
      let nextSlug = nextArray[0];
let nextSlugPrint = nextSlug.replace(/pli-tv-|b[ui]-vb-/g, "");

let nextName = nextArray.slice(1).join(" ");
nextName = nextName.replace(/[0-9.]/g, '');

      if (nextName === undefined) {
      var nextPrint = nextSlugPrint;
      } else {
     var nextPrint = nextSlugPrint +' ' +nextName;
     }     

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

	next2.innerHTML = next.innerHTML;
    }
    );
  
  $.ajax({
      url: "/read/php/api.php?fromjs=" +texttype +"/" +slugReady +"&type=B"
    }).done(function(data) {
      const prevArray = data.split(" ");
      let prevSlug = prevArray[0];
      let prevSlugPrint = prevSlug.replace(/pli-tv-|b[ui]-vb-/g, "");
let prevName = prevArray.slice(1).join(" ");
prevName = prevName.replace(/[0-9.]/g, '');

        if (prevName === undefined) {
    var prevPrint = prevSlugPrint;
      } else {
        var prevPrint = prevSlugPrint +' ' +prevName;
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

	previous2.innerHTML = previous.innerHTML;
      }
      );

    }
    );
     
    })
.catch(error => {
  console.log('error:not found');
  console.log(rootpath);
  console.log('eng ', engtrnpath);
  console.log('rus', thtrnpath);
  console.log(htmlpath);

// Отправка запроса по адресу http://localhost:8080/ru/?q= с использованием значения slug
var xhr = new XMLHttpRequest();
var targetUrl = "/?s=" + encodeURIComponent(sGetparam) + "&q=" + encodeURIComponent(slug) + "#" + anchorURL;

// Проверяем, не пытаемся ли мы загрузить тот же URL, на котором уже находимся
if (window.location.href.split('#')[0] !== targetUrl.split('#')[0]) {
    xhr.open("GET", targetUrl, true);
    xhr.send();

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                // Проверяем, что ответ не пустой и не является страницей ошибки
                if (xhr.responseText && !xhr.responseText.includes("404") && !xhr.responseText.includes("error")) {
                    console.log("Response received, redirecting...");
                    window.location.href = targetUrl;
                } else {
                    console.log("Server returned an error page");
                }
            } else {
                console.log("Error: Request failed with status", xhr.status);
            }
        }
    };
} else {
    console.log("Already on the target URL, skipping request");
}

  // Обновление сообщения об ошибке на странице
  
  suttaArea.innerHTML = `<p>Идёт Поиск "${decodeURIComponent(slug)}". Пожалуйста, Ожидайте.</p>
  
                      <div class="spinner-border" role="status">
                <span class="visually-hidden">Загрузка...</span>
                  </div>
<p>    Подсказка: <br>
    С главной страницы доступно больше настроек поиска.
<br></p>`;
});
    }

    );

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
    console.log("in the initializing " + lang);
    setLanguage(lang);
  } else if  (localStorage.paliToggleML) {
    	language = localStorage.paliToggleML; 
		  console.log('read from ls ' + language);
setLanguage(language);
  }
} else {
suttaArea.innerHTML = `<div class="instructions">
  <p>Use text indexes for navigation.<br>E.g.: <span class="abbr">sn35.28</span> <span class="abbr">an1.1-10</span> <span class="abbr">bu-as1-7</span> or <span class="abbr">bu-pj1</span>.<br>
  Dn, mn, sn, an, some kn books, both patimokkhas and vinaya vibhanga are available. </p>
  <div class="lists">

  <div class="suttas">
  <h2>Main Suttas</h2>
  <ul>
      <li><span class="abbr">dn</span> Dīgha-nikāya</li>
      <li><span class="abbr">mn</span> Majjhima-nikāya</li>
      <li><span class="abbr">sn</span> Saṁyutta-nikāya</li>
      <li><span class="abbr">an</span> Aṅguttara-nikāya</li>

  </ul>
  </div>
    <h2>Other Texts</h2><br>
  <ul>
      <li><span class="abbr">snp</span> Sutta-nipāta</li>  
      <li><span class="abbr">ud</span> Udāna</li>
      <li><span class="abbr">iti</span> Itivuttaka (1–112)</li>
      <li><span class="abbr">dhp</span> Dhammapada</li>
      <li><span class="abbr">thag</span> Theragāthā</li>
      <li><span class="abbr">thig</span> Therīgāthā</li>
	  <li><span class="abbr">kp</span> Khuddakapāṭha</li>
  </ul>
  </div>
  
  
  <div>
  <!-- <h2>Vinaya</h2> -->
  <div class="vinaya">
  <div>
  <h3>Bhikkhu Vinaya</h3>
<ul>
<li><span class="abbr">bu-pm</span> <a href="/assets/texts/pm.php"> Bhikkhunīpātimokkha</a></li>
<li><span class="abbr">bu-pj</span> Pārājikā</li>
<li><span class="abbr">bu-ss</span> Saṅghādisesā</li>
<li><span class="abbr">bu-ay</span> Aniyatā</li>
<li><span class="abbr">bu-np</span> Nissaggiyā-pācittiyā</li>
<li><span class="abbr">bu-pc</span> Pācittiyā</li>
<li><span class="abbr">bu-pd</span> Pāṭidesanīyā</li>
<li><span class="abbr">bu-sk</span> Sekhiyā</li>
<li><span class="abbr">bu-as</span> Adhikarana-samatha</li>
</ul>
</div><div>
<h3>Bhikkhuni Vinaya</h3>
<ul>
<li><span class="abbr">bi-pm</span> <a href="/assets/texts/bipm.php"> Bhikkhunīpātimokkha</a></li>
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
<li><span class=abbr>kd1</span> <a href=/read/?q=pli-tv-kd1>Mahākhandhaka</a></li>
<li><span class=abbr>kd2</span> <a href=/read/?q=pli-tv-kd2>Uposathakkhandhaka</a></li>                                 
<li><span class=abbr>kd3</span> <a href=/read/?q=pli-tv-kd3>Vassūpanāyikakkhandhaka</a></li>
<li><span class=abbr>kd4</span> <a href=/read/?q=pli-tv-kd4>Pavāraṇākkhandhaka</a></li>
<li><span class=abbr>kd5</span> <a href=/read/?q=pli-tv-kd5>Cammakkhandhaka</a></li>
<li><span class=abbr>kd6</span> <a href=/read/?q=pli-tv-kd6>Bhesajjakkhandhaka</a></li>
<li><span class=abbr>kd7</span> <a href=/read/?q=pli-tv-kd7>Kathinakkhandhaka</a></li>
<li><span class=abbr>kd8</span> <a href=/read/?q=pli-tv-kd8>Cīvarakkhandhaka</a></li>                                    
<li><span class=abbr>kd9</span> <a href=/read/?q=pli-tv-kd9>Campeyyakkhandhaka</a></li>
<li><span class=abbr>kd10</span> <a href=/read/?q=pli-tv-kd10>Kosambakakkhandhaka</a></li>
</ul>
<h3>Cūḷavagga</h3><br>
<ul>
<li><span class=abbr>kd11</span> <a href=/read/?q=pli-tv-kd11>Kammakkhandhaka</a></li>
<li><span class=abbr>kd12</span> <a href=/read/?q=pli-tv-kd12>Pārivāsikakkhandhaka</a></li>
<li><span class=abbr>kd13</span> <a href=/read/?q=pli-tv-kd13>Samuccayakkhandhaka</a></li>
<li><span class=abbr>kd14</span> <a href=/read/?q=pli-tv-kd14>Samathakkhandhaka</a></li>
<li><span class=abbr>kd15</span> <a href=/read/?q=pli-tv-kd15>Khuddakavatthukkhandhaka</a></li>
<li><span class=abbr>kd16</span> <a href=/read/?q=pli-tv-kd16>Senāsanakkhandhaka</a></li>
<li><span class=abbr>kd17</span> <a href=/read/?q=pli-tv-kd17>Saṅghabhedakakkhandhaka</a></li>
<li><span class=abbr>kd18</span> <a href=/read/?q=pli-tv-kd18>Vattakkhandhaka</a></li>
<li><span class=abbr>kd19</span> <a href=/read/?q=pli-tv-kd19>Pātimokkhaṭṭhapanakkhandhaka</a></li>
<li><span class=abbr>kd20</span> <a href=/read/?q=pli-tv-kd20>Bhikkhunikkhandhaka</a></li>
<li><span class=abbr>kd21</span> <a href=/read/?q=pli-tv-kd21>Pañcasatikakkhandhaka</a></li>
<li><span class=abbr>kd22</span> <a href=/read/?q=pli-tv-kd22>Sattasatikakkhandhaka</a></li>
</ul>
</div>
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
  } else if (language === "rus") {
    showEnglish();
  } else if (language === "pli") {
    showPali();
  }
}

function showPaliAll() {
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
function showPaliRussian() {
  suttaArea.classList.remove("hide-pali");
  suttaArea.classList.add("hide-english");
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
  suttaArea.classList.add("hide-russian");
  suttaArea.classList.remove("hide-english");
  suttaArea.classList.remove('column-view'); // Отключаем двухколоночный режим
}
function showRussian() {
  suttaArea.classList.add("hide-pali");
  suttaArea.classList.add("hide-english");
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
 if (!localStorage.paliToggleML) {
    localStorage.paliToggleRu = "pli-rus";
  }   

  languageButton.addEventListener("click", () => {
    if (language === "pli") {
      showPaliAll();
      language = "pli-rus";    
      localStorage.paliToggleML = "pli-rus";
    } else if (language === "pli-rus") {
     showPali();
           language = "pli";
      localStorage.paliToggleML = "pli";

 /*   } else if (language === "rus") {
     showPaliRussian();
      language = "rus";
      localStorage.paliToggleML = "rus"; */
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
} else if (
  slug.match(/bu-pm|bi-pm/)) {
  return `${slug}`;
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
