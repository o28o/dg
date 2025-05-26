
//установка фокуса в инпуте по нажатию / 
document.addEventListener('keydown', function(event) {
    // Проверяем именно символ / (код 191 или Slash)
    if (event.key === '/' || event.code === 'Slash') {
        // Ищем все возможные инпуты
        const inputs = document.querySelectorAll(
            '#paliauto[type="search"], #paliauto[type="text"], .dtsb-value.dtsb-input'
        );
        
        // Если нет ни одного подходящего инпута - выходим
        if (inputs.length === 0) return;
        
        // Берем первый подходящий инпут (или можно реализовать более сложную логику выбора)
        const input = inputs[0];
        
        // Предотвращаем действие по умолчанию только если нашли инпут
        event.preventDefault();
        
        // Фокусируемся и перемещаем курсор в конец
        input.focus();
        input.setSelectionRange(input.value.length, input.value.length);
    }
});

// Отключаем перехват / когда фокус уже в инпуте
const handleInputKeydown = (event) => {
    if (event.key === '/' || event.code === 'Slash') {
        event.stopPropagation();
    }
};

// Вешаем обработчики на все существующие и будущие инпуты
document.querySelectorAll('input').forEach(input => {
    input.addEventListener('keydown', handleInputKeydown);
});

// Наблюдатель для динамически добавляемых инпутов
new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        mutation.addedNodes.forEach((node) => {
            if (node.nodeName === 'INPUT') {
                node.addEventListener('keydown', handleInputKeydown);
            } else if (node.querySelectorAll) {
                node.querySelectorAll('input').forEach(input => {
                    input.addEventListener('keydown', handleInputKeydown);
                });
            }
        });
    });
}).observe(document.body, { childList: true, subtree: true });

//конец фокуса в инпуте по нажатию / 


function loadModal(modalId, modalFile) {
    fetch(modalFile)
        .then(response => response.text())
        .then(html => {
            document.getElementById("modalContainer").innerHTML = html;
            let modal = new bootstrap.Modal(document.getElementById(modalId));
           //modal.show();
        })
        .catch(error => console.error("Ошибка загрузки модального окна:", error));
}

//loadModal("paliLookupInfo", "/assets/common/modalsSC.html");

//sett8ngs management
document.addEventListener('DOMContentLoaded', function() {
  
  const scriptSelect = document.getElementById('script-select');
  const dictSelect = document.getElementById('dict-select');

  const applyButton = document.getElementById('apply-button');
  const resetButton = document.getElementById('reset-button');
  const settingsButton = document.getElementById('settingsButton');
  const helpButton = document.getElementById('helpMessage');
  const goButton = document.querySelector('.go-button'); // Кнопка "Go"

    // Добавляем обработчик сочетания клавиш Alt + Space (физическая клавиша)
  document.addEventListener("keydown", (event) => {
    if ((event.altKey && event.code === "Space") || (event.altKey && event.code === "KeyZ")) {
        const languageButton = document.getElementById("language-button");
      if (languageButton) {
       event.preventDefault();
       // Имитируем клик по кнопке
      languageButton.click();
      }
    }
  });

document.addEventListener("keydown", (event) => {
  if (event.ctrlKey && event.code === "ArrowRight") {
    const nextDiv = document.getElementById("next");
    if (nextDiv) {
      const link = nextDiv.querySelector("a");
      if (link) {
        history.pushState(null, "", link.href); // Добавляем запись в историю
        location.href = link.href; // Принудительно переходим
      }
    }
  }
});

document.addEventListener("keydown", (event) => {
  if (event.ctrlKey && event.code === "ArrowLeft") {
    const prevDiv = document.getElementById("previous");
    if (prevDiv) {
      const link = prevDiv.querySelector("a");
      if (link) {
        history.pushState(null, "", link.href); // Добавляем запись в историю
        location.href = link.href; // Принудительно переходим
      }
    }
  }
});


document.addEventListener("keydown", (event) => {
  if (event.altKey && event.code === "KeyH") {
    // Имитируем клик по кнопке
    helpButton.click();
  }
});
    document.addEventListener("keydown", (event) => {
    if (event.altKey && event.code === "KeyS") {
      // Имитируем клик по кнопке
      settingsButton.click();
    }
  });
  
  //setup dictionary 
  
// Загрузка сохраненного значения из localStorage
const savedDict = localStorage.getItem('selectedDict');

if (savedDict && [...dictSelect.options].some(opt => opt.value === savedDict)) {
  dictSelect.value = savedDict; // Устанавливаем только если значение есть в списке
} else {
  
if (window.location.href.includes('/r/') || window.location.href.includes('/ml/') || window.location.href.includes('/ru/')) {
dictSelect.value = 'standalonebwru'; // Значение по умолчанию standalonebwru
//  localStorage.setItem('selectedDict', 'dpdCompactRu');
} else if (window.location.href.includes('/d/')) {
dictSelect.value = 'dpdFull'; // Значение по умолчанию standalonebwru
//  localStorage.setItem('selectedDict', 'dpdCompactRu');
} else {
  dictSelect.value = 'standalonebw'; // Значение по умолчанию
//  localStorage.setItem('selectedDict', 'standalonebw');
}
}

  
    // Загрузка сохраненного значения из localStorage
  const savedScript = localStorage.getItem('selectedScript');

    // Установка сохраненного значения в select при загрузке страницы
if (savedScript) {
  scriptSelect.value = savedScript;
} else {
  scriptSelect.value = 'ISOPali'; // Значение по умолчанию, если ничего не сохранено
localStorage.setItem('selectedScript', 'ISOPali');
}



if (applyButton) {
  applyButton.addEventListener('click', function() {
    // Сохраняем все выбранные настройки
    localStorage.setItem('selectedScript', scriptSelect.value);
    localStorage.setItem('selectedDict', dictSelect.value);
    
    // Сохраняем состояние чекбокса removePunct (если он есть на странице)
    const removePunctCheckbox = document.querySelector('.setting-checkbox[data-key="removePunct"]');
    if (removePunctCheckbox) {
      localStorage.setItem('removePunct', removePunctCheckbox.checked);
    }
    
    localStorage.setItem("firstVisitShowSettingsClosed", "true");
    
    // Перезагружаем страницу для применения всех изменений
    location.reload();
  });
}

  // Функция для применения сохраненного значения
function applySavedDict(dict) {
  localStorage.setItem('selectedDict', dict);
    localStorage.setItem('dictionaryVisible', 'true');
      location.reload();  // Перезагрузка, если изменился словарь
}

  // Функция для применения сохраненного значения
  function applySavedScript(script) {
    const url = new URL(window.location.href);

    if (script === 'ISOPali') {
      localStorage.setItem('selectedScript', 'ISOPali');
      url.searchParams.delete('script');
    } else {
      url.searchParams.set('script', script.toLowerCase());
    }

    // Перезагрузка страницы с новым URL
    if (window.location.href !== url.toString()) {
      window.location.href = url.toString();
    }
  }
 
 if (resetButton) { 
  resetButton.addEventListener('click', function() {
  // Удаляем значения из localStorage для всех чекбоксов
  document.querySelectorAll(".setting-checkbox").forEach(checkbox => {
    const key = checkbox.dataset.key; // Берём ключ из data-key
    localStorage.removeItem(key); // Удаляем сохранённое состояние чекбокса
  });

  // Дополнительные параметры, которые нужно очистить
  localStorage.removeItem('selectedScript');
  localStorage.removeItem('selectedDict');
  localStorage.removeItem("defaultReader");
  localStorage.removeItem('paliToggleRu');
  localStorage.removeItem('viewMode');
  localStorage.setItem("variantVisibility", "hidden");


  const keysToRemove = [
    'lightMode',
    'dark',
    'paliToggleRu',
    'pli-rus',
    'popupHeight',
    'popupLeft',
    'popupTop',
    'popupWidth',
    'removePunct',
    'selectedDict',
    'selectedScript',
    'theme',
    'themeButtonAction',
    'visitCount',
    'windowHeight',
    'windowWidth',
    'isFirstDrag'
  ];

  keysToRemove.forEach(key => {
    localStorage.removeItem(key);
  });


  // Очищаем параметр 'script' из URL
  const url = new URL(window.location.href);
  url.searchParams.delete('script');

  // Перезагружаем страницу с обновленным URL
  window.location.href = url.toString();
});
}

//Default readers
/* dropdown variant
// Получаем выпадающий список
var readerSelect = document.getElementById('reader-select');

// Устанавливаем обработчик события при изменении выбранного значения
readerSelect.addEventListener('change', function() {
    // Устанавливаем значение в localStorage
    localStorage.setItem("defaultReader", this.value);
    // Обновляем URL
  //  updateUrl();
});

// Проверяем значение в localStorage при загрузке страницы и устанавливаем выбранное значение
var savedReader = localStorage.getItem("defaultReader");
if (savedReader) {
    readerSelect.value = savedReader;
}

// Сохраняем текущие значения параметров
const initialBaseUrl = getBaseUrl();
const initialDefaultReader = localStorage.defaultReader;

// Функция для получения текущего baseUrl
function getBaseUrl() {
    let baseUrl;
    if (window.location.href.includes('/ru') || (localStorage.siteLanguage && localStorage.siteLanguage === 'ru')) {
        baseUrl = window.location.origin + "/r/";
    } else {
        baseUrl = window.location.origin + "/read/";
    }

    if (localStorage.defaultReader === 'ml') {
        baseUrl = window.location.origin + "/ml/";
    } else if (localStorage.defaultReader === 'rv') {
        baseUrl = window.location.origin + "/rev/";
    } else if (localStorage.defaultReader === 'd') {
        baseUrl = window.location.origin + "/d/";
    } else if (localStorage.defaultReader === 'mem') {
        baseUrl = window.location.origin + "/memorize/";
    } else if (localStorage.defaultReader === 'fr') {
        baseUrl = window.location.origin + "/frev/";
    }

    return baseUrl;
}

// Функция для обновления URL
function updateUrl() {
    const currentBaseUrl = getBaseUrl();
    const url = new URL(window.location.href);

    // Извлекаем путь из currentBaseUrl
    const newPath = new URL(currentBaseUrl).pathname;

    // Обновляем путь в текущем URL
    url.pathname = newPath;

    // Сохраняем новый URL
    window.location.href = url.toString();
}

// Функция для проверки изменений и обновления URL
function checkAndUpdateUrl() {
    const currentBaseUrl = getBaseUrl();
    const currentDefaultReader = localStorage.defaultReader;

    // Если параметры изменились, обновляем URL
    if (currentBaseUrl !== initialBaseUrl || currentDefaultReader !== initialDefaultReader) {
        updateUrl();
    }
}
*/
// end of default reader part

// radio button varians

// Получаем все радиокнопки
var readerRadios = document.querySelectorAll('input[name="reader"]');

// Устанавливаем обработчики событий при изменении состояния радиокнопок
readerRadios.forEach(function(radio) {
    radio.addEventListener('change', function() {
        if (this.checked) {
            // Устанавливаем значение в localStorage
            localStorage.setItem("defaultReader", this.value);
        }
    });
});

// Проверяем значение в localStorage при загрузке страницы и устанавливаем состояние радиокнопок
var savedReader = localStorage.getItem("defaultReader");
if (savedReader) {
    document.querySelector('input[name="reader"][value="' + savedReader + '"]').checked = true;
}

// Сохраняем текущие значения параметров
const initialBaseUrl = getBaseUrl();
const initialDefaultReader = localStorage.defaultReader;

// Функция для получения текущего baseUrl
function getBaseUrl() {
    let baseUrl;
    if (window.location.href.includes('/ru') || (localStorage.siteLanguage && localStorage.siteLanguage === 'ru')) {
        baseUrl = window.location.origin + "/r/";
    } else {
        baseUrl = window.location.origin + "/read/";
    }

    if (localStorage.defaultReader === 'ml') {
        baseUrl = window.location.origin + "/ml/";
    } else if (localStorage.defaultReader === 'rv') {
        baseUrl = window.location.origin + "/rev/";
    } else if (localStorage.defaultReader === 'd') {
        baseUrl = window.location.origin + "/d/";
    } else if (localStorage.defaultReader === 'mem') {
        baseUrl = window.location.origin + "/memorize/";
    } else if (localStorage.defaultReader === 'fr') {
        baseUrl = window.location.origin + "/frev/";
    }

    return baseUrl;
}

// Функция для обновления URL
function updateUrl() {
    const currentBaseUrl = getBaseUrl();
    const url = new URL(window.location.href);

    // Извлекаем путь из currentBaseUrl
    const newPath = new URL(currentBaseUrl).pathname;

    // Обновляем путь в текущем URL
    url.pathname = newPath;

    // Сохраняем новый URL
    window.location.href = url.toString();
}
const initialRemovePunct = localStorage.getItem("removePunct");
// Функция для проверки изменений и обновления URL
function checkAndUpdateUrl() {
    const currentBaseUrl = getBaseUrl();
    const currentDefaultReader = localStorage.defaultReader;
    const currentRemovePunct = localStorage.getItem("removePunct"); // Новая проверка

    // Если параметры изменились, обновляем URL
    if (currentBaseUrl !== initialBaseUrl || 
        currentDefaultReader !== initialDefaultReader || 
        currentRemovePunct !== initialRemovePunct) { // Добавлено
        updateUrl();
    }
}

// end of default reader part

// open current url in demo mode

// Функция для извлечения параметров из URL
function getQueryParams() {
  const params = {};
  const queryString = window.location.search.substring(1);
  const pairs = queryString.split('&');
  pairs.forEach(pair => {
    const [key, value] = pair.split('=');
    if (key && value) {
      params[key] = value;
    }
  });
  return params;
}

// Функция для обновления ссылок
function updateDemoLinks() {
  const params = getQueryParams();
  const queryString = Object.keys(params).map(key => `${key}=${params[key]}`).join('&');
  const hash = window.location.hash;

  // Проверяем, есть ли цифры в параметре q
const hasNumbersInQ = params.q && (/\d/.test(params.q) || /(bupm|bu-pm|bipm|bi-pm)/.test(params.q));

if (!hasNumbersInQ && !window.location.pathname.match(/\/(ml|d|memorize|rev|frev)\//)) {
  return;
}

  // Определяем базовый URL в зависимости от языка
  let baseUrl;
  if (window.location.href.includes('/ru/') || window.location.href.includes('/r/') || (localStorage.siteLanguage && localStorage.siteLanguage === 'ru')) {
    baseUrl = window.location.origin + "/r/"; // Для русского языка
  } else if (window.location.href.includes('/th') || (localStorage.siteLanguage && localStorage.siteLanguage === 'th')) {
    baseUrl = window.location.origin + "/th/read/"; // Для тайского языка
  } else {
    baseUrl = window.location.origin + "/read/"; // Для других языков
  }

  // Ссылки для демо-режимов
  const demoLinks = {
    stDemo: baseUrl, // Используем baseUrl для stDemo
    mlDemo: window.location.origin + "/ml/",
    dDemo: window.location.origin + "/d/",
    memDemo: window.location.origin + "/memorize/",
    rvDemo: window.location.origin + "/rev/",
    frDemo: window.location.origin + "/frev/"
  };

  // Обновляем ссылки
  Object.keys(demoLinks).forEach(id => {
    const linkElement = document.getElementById(id);
    if (linkElement) {
      const baseUrl = demoLinks[id];
      const newUrl = `${baseUrl}?${queryString}${hash}`;
      linkElement.href = newUrl; // Обновляем атрибут href
    }
  });
}

// Вызываем функцию обновления ссылок при загрузке страницы
window.onload = updateDemoLinks;
  //end 


//remove punctuation checkbox
    document.querySelectorAll(".setting-checkbox").forEach(checkbox => {
        const key = checkbox.dataset.key; // Берём ключ из data-key
        checkbox.checked = localStorage.getItem(key) === "true";

        checkbox.addEventListener("change", () => {
            localStorage.setItem(key, checkbox.checked);
        });
    });



//end of DOMContentLoaded

});


//Горячие кнопки от 1 до Х

document.addEventListener("keydown", (event) => {
  if (event.altKey && event.code === "Digit1") { // Проверяем, что нажаты Alt и 7
    event.preventDefault();

    let currentUrl = window.location.href; // Получаем текущий URL
    let urlWithoutParams = currentUrl.split('?')[0]; // Удаляем всё после ?

    let newUrl;
    let defaultLanguage = localStorage.getItem('siteLanguage') || "en"; // Получаем язык из localStorage или используем "en" по умолчанию

	let defaultLanguageLinkPart;
		if (defaultLanguage === "ru") {
		  defaultLanguageLinkPart = "/r/";
		} else if (defaultLanguage === "th") {
		  defaultLanguageLinkPart = "/th/read/";
		} else {
		  defaultLanguageLinkPart = "/read/";
		}


    // Проверяем, содержит ли URL /r/
    if (urlWithoutParams.endsWith("/r/")) {
      newUrl = urlWithoutParams.replace("/r/", "/read/"); // Меняем на /read/
    } else if (urlWithoutParams.endsWith("/th/read/")) {
      newUrl = urlWithoutParams.replace("/th/read/", defaultLanguageLinkPart); // Меняем на /read/
    } else if (urlWithoutParams.endsWith("/read/")) {
      newUrl = urlWithoutParams.replace("/read/", "/r/"); // Меняем на /r/
    } 
	else {
      // Если URL не содержит ни /r/, ни /read/, выбираем начальный вариант
      if (localStorage.siteLanguage && localStorage.siteLanguage === 'ru') {
        newUrl = window.location.origin + "/r/";
      } else {
        newUrl = window.location.origin + "/read/";
      }
    }


    // Добавляем параметры обратно, если они были
let params = currentUrl.split('?')[1] || '';
newUrl = params ? `${newUrl}?${params}` : `${newUrl}?q=sn56.11`;

    if (newUrl !== currentUrl) { // Проверяем, изменился ли URL
      history.pushState(null, "", newUrl); // Добавляем запись в историю
      location.href = newUrl; // Принудительно переходим по новому URL
      location.reload();
    }
  }
  

});


// Объект, связывающий цифры от 1 до 6 с id ссылок
const demoLinks = {
 // 1: "stDemo", // Alt + 1
  2: "mlDemo", // Alt + 2
  3: "dDemo",  // Alt + 3
  4: "memDemo", // Alt + 4
  5: "rvDemo", // Alt + 5
  6: "frDemo"  // Alt + 6
};

// Обработчик события нажатия клавиш
document.addEventListener("keydown", (event) => {
  // Проверяем, что нажата клавиша Alt и одна из цифр от 1 до 6
  if (event.altKey && event.code.startsWith("Digit")) {
              event.preventDefault();
    // Извлекаем цифру из event.code (например, "Digit1" -> 1)
    const digit = parseInt(event.code.replace("Digit", ""), 10);
    // Проверяем, что цифра находится в диапазоне от 1 до 6
    if (digit >= 2 && digit <= 6) {
      // Получаем id ссылки из объекта demoLinks
      const linkId = demoLinks[digit];

      // Находим ссылку по id
      const linkElement = document.getElementById(linkId);

      // Если ссылка найдена, имитируем клик
      if (linkElement) {
        linkElement.click(); // Программный клик по ссылке
      } else {
        console.error(`Ссылка с id "${linkId}" не найдена!`);
      }
    }
  }
});





document.addEventListener("keydown", (event) => {
  if (event.altKey && event.code === "Digit7") { // Проверяем, что нажаты Alt и 7
          event.preventDefault();
    let currentUrl = window.location.href; // Получаем текущий URL

    // Шаг 1: Удаляем всё после первого / (оставляем базовую часть)
    let base = currentUrl.split('/')[0] + '//' + currentUrl.split('/')[2];

    // Шаг 2: Удаляем всё перед ? (оставляем параметры, если они есть)
    let params = currentUrl.split('?')[1] || '';

    // Шаг 3: Собираем новый URL
    let newUrl = `${base}/th/read/${params ? `?${params}` : ''}`;

    if (newUrl !== currentUrl) { // Проверяем, изменился ли URL
      history.pushState(null, "", newUrl); // Добавляем запись в историю
      location.href = newUrl; // Принудительно переходим по новому URL
    }
  }
});

document.addEventListener("keydown", (event) => {
  if (event.altKey && event.code === "Digit8") { // Проверяем, что нажаты Alt и 7
            event.preventDefault();
    let currentUrl = window.location.href; // Получаем текущий URL

    // Шаг 1: Удаляем всё после первого / (оставляем базовую часть)
    let base = currentUrl.split('/')[0] + '//' + currentUrl.split('/')[2];

    // Шаг 2: Удаляем всё перед ? (оставляем параметры, если они есть)
    let params = currentUrl.split('?')[1] || '';

    // Шаг 3: Собираем новый URL
    let newUrl = `${base}/mlth/${params ? `?${params}` : ''}`;

    if (newUrl !== currentUrl) { // Проверяем, изменился ли URL
      history.pushState(null, "", newUrl); // Добавляем запись в историю
      location.href = newUrl; // Принудительно переходим по новому URL
    }
  }
});



document.addEventListener('keydown', (event) => {
  if (event.altKey && event.code === "KeyL") {
    event.preventDefault(); // Предотвращаем стандартное поведение

    const scriptOptions = ['ISOPali', 'devanagari', 'thai']; // Доступные скрипты
    const url = new URL(window.location.href);
    let currentScript = url.searchParams.get('script') || 'ISOPali';

    // Получаем следующий скрипт в списке
    let nextIndex = (scriptOptions.indexOf(currentScript) + 1) % scriptOptions.length;
    let nextScript = scriptOptions[nextIndex];

    // Обновляем URL
    if (nextScript === 'ISOPali') {
      url.searchParams.delete('script'); // Удаляем параметр для ISOPali
    } else {
      url.searchParams.set('script', nextScript);
    }

    window.location.href = url.toString(); // Перезагружаем страницу
  }
});



document.addEventListener('keydown', (event) => {
  // Для отладки: смотри, что нажимается
//  console.log('Pressed:', event.code);

  if (event.altKey && (event.code === 'Period' || event.code === 'KeyM')) {
    event.preventDefault();

    const currentValue = localStorage.getItem("removePunct") === "true";
    localStorage.setItem("removePunct", currentValue ? "false" : "true");

    location.reload();
  }
});



document.addEventListener("keydown", function (event) {
  const isCtrlPressed = event.ctrlKey || event.metaKey;
  const currentPath = window.location.pathname;
  const baseUrl = window.location.origin;

  const key = "preferredLanguage";
  const savedLang = localStorage.getItem(key);
  const isRuCurrent = currentPath.includes("/ru/") || currentPath.includes("/r/");

  // Функция: получить URL для заданного языка и страницы
  function makeUrl(lang, isHomepage) {
    if (isHomepage) {
      return lang === "ru" ? `${baseUrl}/ru/` : `${baseUrl}/`;
    } else {
      return lang === "ru" ? `${baseUrl}/ru/read.php` : `${baseUrl}/read.php`;
    }
  }

  // Функция: определить, нужно ли переключать язык или использовать сохранённый
  function determineTargetUrl(isHomepage) {
    const isCurrentTarget =
      (isHomepage && (currentPath === "/" || currentPath === "/ru/")) ||
      (!isHomepage && (currentPath === "/read.php" || currentPath === "/ru/read.php"));

    let nextLang;

    if (isCurrentTarget) {
      // Уже на целевой странице — делаем toggle
      nextLang = isRuCurrent ? "en" : "ru";
      localStorage.setItem(key, nextLang);
    } else {
      // С других страниц — просто используем сохранённое предпочтение
      nextLang = savedLang || (isRuCurrent ? "ru" : "en");
      if (!savedLang) localStorage.setItem(key, nextLang); // сохранить при первом запуске
    }

    return makeUrl(nextLang, isHomepage);
  }

  // === Ctrl + 1: Переход на домашнюю страницу ===
  if (isCtrlPressed && event.key === "1") {
    event.preventDefault();
    const targetUrl = determineTargetUrl(true);
    window.location.href = targetUrl;
  }

  // === Ctrl + 2: Переход на read.php ===
  if (isCtrlPressed && event.key === "2") {
    event.preventDefault();
    const targetUrl = determineTargetUrl(false);
    window.location.href = targetUrl;
  }
});




let quickModalIsOpen = false;
let quickOverlay = null;
let quickModal = null;
let escHandler = null;

function createQuickModal() {
  let currentUrl = window.location.href;
  let urlWithoutParams = currentUrl.split('?')[0];
  let queryBase = urlWithoutParams.endsWith("/ru/") || urlWithoutParams.endsWith("/r/") 
    ? "/r/?q=" 
    : "/read/?q=";

  const isDark = document.body.classList.contains("dark");
  const bgColor = isDark ? "#1a252f" : "#ffffff";
  const textColor = isDark ? "#ffffff" : "#212529";
  const linkColorPrimary = "#859900";
  const linkColorSuccess = "#2aa198";
  const linkColorWarning = "#cb4b16";
  const linkColorDanger = "#dc322f";

  // Оверлей 2c3e50
  quickOverlay = document.createElement("div");
  quickOverlay.className = "quick-overlay-element";
  quickOverlay.style.cssText = `
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background-color: rgba(0, 0, 0, 0.7);
    opacity: 0;
    transition: opacity 0.4s ease;
  `;

  // Модалка
  
  
  

  quickModal = document.createElement("div");
quickModal.className = "quick-modal-container";
quickModal.style.cssText = `
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%) scale(0.95);
  z-index: 10000;
  opacity: 0;
  transition: opacity 0.4s ease, transform 0.4s ease;
  width: 95%;
  max-width: 600px;
`;

// После добавляем элемент в DOM, вставляем медиаквери
const styleTag = document.createElement("style");
styleTag.textContent = `
  @media (max-width: 768px) {
    .quick-modal-container {
      top: 0 !important;
      left: 0 !important;
      transform: none !important;
      width: 100% !important;
      height: 100% !important;
      display: flex !important;
      align-items: flex-start !important;
      justify-content: center;
      padding: 1rem;
    }
    .quick-modal-content-wrapper {
      width: 100% !important;
      max-width: none !important;
      height: auto;
      margin-top: 1.5rem;
      border-radius: 0.75rem;
    }
  }
`;
document.head.appendChild(styleTag);

quickModal.innerHTML = `
  <div class="quick-modal-content-wrapper" style="
    background-color: ${bgColor};
    color: ${textColor};
    padding: 1.5rem;
    max-width: 600px;
    width: 100%;
    border-radius: 1rem;
    box-shadow: 0 8px 24px rgba(0,0,0,0.3);
    font-family: sans-serif;
    position: relative;
  ">

    <button id="quickCloseModalBtn" class="quick-close-button" style="
      position: absolute;
      top: 12px;
      right: 12px;
      background-color: #9e1c19;
      color: #fff;
      border: none;
      width: 28px;
      height: 28px;
      border-radius: 50%;
      font-size: 1.1rem;
      font-weight: bold;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s ease;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
      z-index: 10;
    " title="Закрыть">×</button>

    <h5 class="quick-modal-title" style="
      text-align:center;
      margin-bottom: 1.2rem;
      color: #93a1a1;
      font-size: 1.2rem;
      font-weight: 600;
    ">Cattāri Ariyasaccāni</h5>

    <div class="quick-links-container" style="display: flex; gap: 1.2rem; flex-wrap: wrap; justify-content: space-between;">
      <!-- Block 1 -->
      <div class="quick-links-column" style="flex: 1 1 45%; min-width: 200px;">
        <p><strong>1st priority:</strong></p>
        <ul style="padding-left: 1rem; font-size: 0.9rem;">
          <li><a href="${queryBase}sn56.11" target="_blank" style="color: ${linkColorPrimary}; text-decoration: none;">SN 56.11</a></li>
          <li><a href="${queryBase}dn22" target="_blank" style="color: ${linkColorPrimary}; text-decoration: none;">DN 22</a></li>
          <li><a href="${queryBase}sn12.2" target="_blank" style="color: ${linkColorPrimary}; text-decoration: none;">SN 12.2</a></li>
        </ul>
      </div>

      <!-- Block 2 -->
      <div class="quick-links-column" style="flex: 1 1 45%; min-width: 200px;">
        <p><strong>Clarify 5 khandha:</strong></p>
        <ul style="padding-left: 1rem; font-size: 0.9rem;">
          <li><a href="${queryBase}sn22.56" target="_blank" style="color: ${linkColorSuccess}; text-decoration: none;">SN 22.56</a></li>
          <li><a href="${queryBase}sn22.79" target="_blank" style="color: ${linkColorSuccess}; text-decoration: none;">SN 22.79</a></li>
          <li><a href="${queryBase}sn22.85" target="_blank" style="color: ${linkColorSuccess}; text-decoration: none;">SN 22.85</a></li>
        </ul>
      </div>

      <!-- Block 3 -->
      <div class="quick-links-column" style="flex: 1 1 45%; min-width: 200px;">
        <p><strong>Clarify 6 ajjhattāyatana:</strong></p>
        <ul style="padding-left: 1rem; font-size: 0.9rem;">
          <li><a href="${queryBase}sn35.228" target="_blank" style="color: ${linkColorWarning}; text-decoration: none;">SN 35.228</a></li>
          <li><a href="${queryBase}sn35.229" target="_blank" style="color: ${linkColorWarning}; text-decoration: none;">SN 35.229</a></li>
          <li><a href="${queryBase}sn35.236" target="_blank" style="color: ${linkColorWarning}; text-decoration: none;">SN 35.236</a></li>
          <li><a href="${queryBase}sn35.238" target="_blank" style="color: ${linkColorWarning}; text-decoration: none;">SN 35.238</a></li>
        </ul>
      </div>

      <!-- Block 4 -->
      <div class="quick-links-column" style="flex: 1 1 45%; min-width: 200px;">
        <p><strong>Clarify 4-6-X Dhātu:</strong></p>
        <ul style="padding-left: 1rem; font-size: 0.9rem;">
          <li><a href="${queryBase}sn14" target="_blank" style="color: ${linkColorDanger}; text-decoration: none;">SN 14</a></li>
          <li><a href="${queryBase}mn28" target="_blank" style="color: ${linkColorDanger}; text-decoration: none;">MN 28</a></li>
          <li><a href="${queryBase}mn115" target="_blank" style="color: ${linkColorDanger}; text-decoration: none;">MN 115</a></li>
          <li><a href="${queryBase}mn140" target="_blank" style="color: ${linkColorDanger}; text-decoration: none;">MN 140</a></li>
        </ul>
      </div>

      <!-- Block 5 -->
      <div class="quick-links-column" style="flex: 1 1 45%; min-width: 200px;">
        <p><strong>Dukkaṁ so abhinandati:</strong></p>
        <ul style="padding-left: 1rem; font-size: 0.9rem;">
          <li><a href="${queryBase}sn14.35" target="_blank" style="color: ${linkColorPrimary}; text-decoration: none;">SN 14.35</a></li>
          <li><a href="${queryBase}sn22.29" target="_blank" style="color: ${linkColorPrimary}; text-decoration: none;">SN 22.29</a></li>
          <li><a href="${queryBase}sn35.19" target="_blank" style="color: ${linkColorPrimary}; text-decoration: none;">SN 35.19</a></li>
          <li><a href="${queryBase}sn35.20" target="_blank" style="color: ${linkColorPrimary}; text-decoration: none;">SN 35.20</a></li>
        </ul>
      </div>

      <!-- Block 6 -->
      <div class="quick-links-column" style="flex: 1 1 45%; min-width: 200px;">
        <p><strong>Extra</strong></p>
        <ul style="padding-left: 1rem; font-size: 0.9rem;">
          <li><a href="${queryBase}an3.70" target="_blank" style="color: ${linkColorDanger}; text-decoration: none;">AN 3.70</a></li>
          <li><a href="${queryBase}an3.80" target="_blank" style="color: ${linkColorDanger}; text-decoration: none;">AN 3.80</a></li>
          <li><a href="${queryBase}an8.9" target="_blank" style="color: ${linkColorDanger}; text-decoration: none;">AN 8.9</a></li>
          <li><a href="${queryBase}an10.46" target="_blank" style="color: ${linkColorPrimary}; text-decoration: none;">AN 10.46</a></li>
          <li><a href="${queryBase}snp3.2" target="_blank" style="color: ${linkColorPrimary}; text-decoration: none;">Snp 3.2</a></li>
          <li><a href="${queryBase}iti61" target="_blank" style="color: ${linkColorPrimary}; text-decoration: none;">Iti 61</a></li>
        </ul>
      </div>
    </div>
  </div>
`;




  document.body.appendChild(quickOverlay);
  document.body.appendChild(quickModal);

  // Плавное появление
  requestAnimationFrame(() => {
    quickOverlay.style.opacity = "1";
    quickModal.style.opacity = "1";
    quickModal.style.transform = "translate(-50%, -50%) scale(1)";
  });

  // Закрытие
const closeQuickModal = () => {
  quickOverlay?.style && (quickOverlay.style.opacity = "0");
  quickModal?.style && (quickModal.style.opacity = "0");
  quickModal?.style && (quickModal.style.transform = "translate(-50%, -50%) scale(0.95)");

  setTimeout(() => {
    quickOverlay?.remove();
    quickModal?.remove();
    quickOverlay = null;
    quickModal = null;
    quickModalIsOpen = false; // перемещено сюда
  }, 300);

  if (escHandler) {
    document.removeEventListener("keydown", escHandler);
    escHandler = null;
  }
};


  quickOverlay.addEventListener("click", (e) => e.target === quickOverlay && closeQuickModal());
  quickModal.querySelector("#quickCloseModalBtn").addEventListener("click", closeQuickModal);

  escHandler = (e) => e.key === "Escape" && closeQuickModal();
  document.addEventListener("keydown", escHandler);
}

function toggleQuickModal() {
  if (quickModalIsOpen) {
    const closeEvent = new Event('click');
    quickOverlay.dispatchEvent(closeEvent);
  } else {
    createQuickModal();
    quickModalIsOpen = true;
  }
}

document.addEventListener("keydown", (event) => {
  if (event.altKey && event.code === "KeyP") {
    event.preventDefault();
    toggleQuickModal();
  }
});



/*

const openQuickModalBtn = document.createElement("button");
openQuickModalBtn.innerText = "≡"; // или иконку по желанию
openQuickModalBtn.setAttribute("aria-label", "Открыть окно Cattāri Ariyasaccāni");
openQuickModalBtn.style.cssText = `
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 10001;
  background-color: #859900;
  color: #fff;
  border: none;
  border-radius: 50%;
  width: 48px;
  height: 48px;
  font-size: 1.5rem;
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
  cursor: pointer;
`;

openQuickModalBtn.addEventListener("click", toggleQuickModal);
document.body.appendChild(openQuickModalBtn);




if (!document.getElementById("openQuickModalBtn")) {
  const openQuickModalBtn = document.createElement("button");

  openQuickModalBtn.addEventListener("click", toggleQuickModal);

}


<button onclick="toggleQuickModal()" aria-label="Открыть Cattāri Ariyasaccāni" style="
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 10001;
  background-color: #859900;
  color: #fff;
  border: none;
  border-radius: 50%;
  width: 48px;
  height: 48px;
  font-size: 1.5rem;
  font-weight: bold;
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
  cursor: pointer;
">
  ≡
</button>


*/

