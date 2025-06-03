if (typeof initCopyNotification === 'undefined') {
    // Функция НЕ объявлена — можно добавлять её
    function initCopyNotification() {
        if (!document.getElementById('bubbleNotification')) {
            const bubble = document.createElement('div');
            bubble.id = 'bubbleNotification';
            bubble.className = 'bubble-notification';
            document.body.appendChild(bubble);
        }
    }
	    initCopyNotification();
}

if (typeof showBubbleNotification === 'undefined') {
    // Функция НЕ объявлена — можно добавлять её
     function showBubbleNotification(text) {
        const bubble = document.getElementById('bubbleNotification');
        if (!bubble) return;

        bubble.textContent = text;
        bubble.classList.add('show');
        bubble.style.opacity = '1';

        setTimeout(() => {
            bubble.style.opacity = '0';
        }, 2000);
    }
}
 
// Проверяем язык в localStorage
const siteLanguage = localStorage.getItem('siteLanguage');

let savedDict = localStorage.getItem('selectedDict');


// Добавь это в начало файла, после других функций
function getSelectedText() {
    const selection = window.getSelection();
    return selection ? selection.toString().trim() : '';
}

function isSelectionWithinElement(element) {
    const selection = window.getSelection();
    if (!selection.rangeCount) return false;
    
    const range = selection.getRangeAt(0);
    return element.contains(range.commonAncestorContainer);
}


function savePopupState() {
    localStorage.setItem('popupWidth', popup.style.width);
    localStorage.setItem('popupHeight', popup.style.height);
    localStorage.setItem('popupTop', popup.style.top);
    localStorage.setItem('popupLeft', popup.style.left);
}


if (savedDict) {
    savedDict = savedDict.toLowerCase();
} else if (window.location.pathname.includes('/d/')) {
    savedDict = "dpdFull".toLowerCase();
} else if (window.location.pathname.includes('/r/') || window.location.pathname.includes('/ml/') || window.location.pathname.includes('/ru/')) {
    savedDict = "standalonebwru".toLowerCase();
} else {
    savedDict = "standalonebw".toLowerCase();
}
        
// Устанавливаем правильный URL для словаря в зависимости от языка
let dhammaGift;
let dgParams;
let dictUrl;

if (window.location.href.includes('localhost') || window.location.href.includes('127.0.0.1')) {
    dhammaGift = '';
 //  dictUrl = "http://localhost:8880";
  dictUrl = "https://dict.dhamma.gift";
//dictUrl = "https://dpdict.net";
} else if (savedDict.includes("compact")) {
    dhammaGift = 'https://dhamma.gift';
    dictUrl = "https://dict.dhamma.gift";
    //dictUrl = "https://dpdict.net";
  }
  else {
    dhammaGift = 'https://dhamma.gift';
    dictUrl = "https://dict.dhamma.gift";
}

if (window.location.href.includes('/r/') || (localStorage.siteLanguage && localStorage.siteLanguage === 'ru')) {
   dhammaGift += '/ru';
}
dhammaGift += '/?q=';

// Добавляем сюда логику для загрузки предпочтений поиска, сохраненных на главной.
dgParams = '&p=-kn';

if (savedDict.includes("dpd")) {
  if (savedDict.includes("ru")) {
    dictUrl += "/ru";
  }
  
  if (savedDict.includes("full")) {
    dictUrl += "/search_html?q=";
  } else if (savedDict.includes("compact")) {
    dictUrl += "/gd?search=";
  }
} else if (savedDict === "dicttango") {
  dictUrl = "dttp://app.dicttango/WordLookup?word=";
} else if (savedDict === "mdict") {
  dictUrl = "mdict://mdict.cn/search?text=";
}
else if (savedDict === "standalonebwru") {
  dictUrl = "standalonebwru"; // Используем standalone-словарь
} else if (savedDict === "standalonebw") {
  dictUrl = "standalonebw"; // Используем standalone-словарь
} else {
   dictUrl = "searchonly";
}

// Функция для отложенной загрузки скриптов standalone-словаря
// Cache for tracking loaded scripts
const scriptCache = new Map();

// Polyfill for requestIdleCallback
const requestIdleCallback = window.requestIdleCallback || 
    function(cb) { return setTimeout(() => { cb({ didTimeout: false }); }, 0); };

function lazyLoadStandaloneScripts(lang = 'en') {
    return new Promise((resolve, reject) => {
        const loadScripts = () => {
            const commonScripts = [
                '/assets/js/standalone-dpd/dpd_i2h.js',
                '/assets/js/standalone-dpd/dpd_deconstructor.js'
            ];

            const langSpecific = lang === 'ru' 
                ? '/assets/js/standalone-dpd/ru/dpd_ebts.js'
                : '/assets/js/standalone-dpd/dpd_ebts.js';

            const scripts = [...commonScripts, langSpecific];
            const scriptsToLoad = scripts.filter(src => {
                return !document.querySelector(`script[src="${src}"]`) && !scriptCache.has(src);
            });

            if (scriptsToLoad.length === 0) {
                resolve();
                return;
            }

            // Show loading indicator - more robust version
            const loadingId = 'dict-loading-' + Date.now();
            const loadingEl = document.createElement('div');
            loadingEl.id = loadingId;
            Object.assign(loadingEl.style, {
                position: 'fixed',
                bottom: '20px',
                left: '20px',
                padding: '10px',
                background: 'rgba(0,0,0,0.7)',
                color: 'grey',
                borderRadius: '12px',
                zIndex: '10000',
                fontSize: '14px',
                boxShadow: '0 2px 5px rgba(0,0,0,0.3)'
            });
            loadingEl.textContent = 'Loading dictionary...';
            
            // Ensure loading message is visible in Safari
            document.body.appendChild(loadingEl);
            setTimeout(() => loadingEl.style.opacity = '1', 10);

            // Load all scripts with better Safari support
            const loadPromises = scriptsToLoad.map(src => {
                return new Promise((scriptResolve) => {
                    if (scriptCache.has(src)) {
                        return scriptResolve();
                    }

                    const script = document.createElement('script');
                    script.src = src;
                    script.defer = true;
                    
                    // More reliable loading for Safari
                    script.onload = script.onreadystatechange = function() {
                        if (!this.readyState || this.readyState === 'loaded' || this.readyState === 'complete') {
                            scriptCache.set(src, true);
                            scriptResolve();
                        }
                    };
                    
                    script.onerror = () => {
                        console.warn(`Failed to load script: ${src}`);
                        scriptResolve(); // Resolve even if failed to prevent blocking
                    };

                    // Safari sometimes needs this
                    script.crossOrigin = 'anonymous';
                    document.head.appendChild(script);
                });
            });

            // Set timeout for all loads
            const timeoutPromise = new Promise((_, timeoutReject) => {
                setTimeout(() => timeoutReject(new Error('Script loading timeout')), 10000); // Longer timeout for Safari
            });

            Promise.race([
                Promise.all(loadPromises),
                timeoutPromise
            ])
            .then(() => {
                const el = document.getElementById(loadingId);
                if (el) {
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 300);
                }
                resolve();
            })
            .catch(err => {
                console.warn('Dictionary loading warning:', err);
                const el = document.getElementById(loadingId);
                if (el) {
                    el.textContent = 'Dictionary load failed';
                    el.style.background = 'rgba(255,0,0,0.7)';
                    setTimeout(() => el.remove(), 2000);
                }
                resolve(); // Still resolve to allow fallback behavior
            });
        };

        // Use requestIdleCallback with fallback
        requestIdleCallback(loadScripts, { timeout: 1000 });
    });
}

// Инициализация после загрузки страницы
document.addEventListener('DOMContentLoaded', function() {
    // Минимальная задержка перед началом загрузки
    setTimeout(() => {
        if (savedDict === "standalonebw") {
            requestIdleCallback(() => {
                lazyLoadStandaloneScripts()
                    .then(() => console.log('Standalone eng scripts lazy-loaded'))
                    .catch(err => console.warn('Lazy loading eng scripts warning:', err));
            }, { timeout: 2000 });
        } 
        else if (savedDict === "standalonebwru") {
            requestIdleCallback(() => {
                lazyLoadStandaloneScripts("ru")
                    .then(() => console.log('Standalone rus scripts lazy-loaded'))
                    .catch(err => console.warn('Lazy loading rus scripts warning:', err));
            }, { timeout: 2000 });
        }
    }, 1000); // Небольшая задержка для гарантированного рендеринга
});

function lookupWordInStandaloneDict(word) {
    let out = "";
   // console.log("---");
 //   console.log("before: ", word);
    word = word.replace(/[’”'"]/g, "").replace(/ṁ/g, "ṃ");
   // console.log("after: ", word);

// Создаем URL для поиска слова в словаре
const dictSearchUrl = `https://dict.dhamma.gift/${savedDict.includes("ru") ? "ru/" : ""}search_html?q=${encodeURIComponent(word)}`;

if (word in dpd_i2h) {
    out += `<a href="${dictSearchUrl}" target="_blank" rel="noopener noreferrer" style="text-decoration: none; color: inherit;"><strong>${word}</strong></a><br><ul style="line-height: 1em; padding-left: 15px;">`;
    for (const headword of dpd_i2h[word]) {
        if (headword in dpd_ebts) {
            out += '<li>' + headword + '. ' + dpd_ebts[headword] + '</li>';
        }
    }
    out += "</ul>";
}

if (word in dpd_deconstructor) {
    out += `<a href="${dictSearchUrl}" target="_blank" rel="noopener noreferrer" style="text-decoration: none; color: inherit;"><strong>${word}</strong></a><br><ul style="line-height: 1em; padding-left: 15px;">`;
    out += "<li>" + dpd_deconstructor[word] + "</li>";
    out += "</ul>";
}

    return out.replace(/ṃ/g, "ṁ");
}


function clearParams() {
    const keys = ['popupWidth', 'popupHeight', 'popupTop', 'popupLeft', 'windowWidth', 'windowHeight', 'isFirstDrag'];
    keys.forEach(key => localStorage.removeItem(key));
}

// Создание элементов для Popup с возможностью изменения размера и перемещения
function createPopup() {
    const overlay = document.createElement('div');
    overlay.classList.add('overlay');

    const popup = document.createElement('div');
    popup.classList.add('popup');
    popup.style.position = 'fixed';
    popup.style.maxWidth = '100%';
    popup.style.maxHeight = '1200px';
    popup.style.overflow = 'hidden';

    // Проверка параметров окна браузера
    const currentWindowWidth = window.innerWidth;
    const currentWindowHeight = window.innerHeight;

    const savedWindowWidth = localStorage.getItem('windowWidth');
    const savedWindowHeight = localStorage.getItem('windowHeight');

    if (
        savedWindowWidth &&
        savedWindowHeight &&
        (parseInt(savedWindowWidth, 10) !== currentWindowWidth ||
            parseInt(savedWindowHeight, 10) !== currentWindowHeight)
    ) {
        clearParams();
    }

    localStorage.setItem('windowWidth', currentWindowWidth);
    localStorage.setItem('windowHeight', currentWindowHeight);

    // Установка сохранённых размеров и позиции
    const savedWidth = localStorage.getItem('popupWidth');
    const savedHeight = localStorage.getItem('popupHeight');
    const savedTop = localStorage.getItem('popupTop');
    const savedLeft = localStorage.getItem('popupLeft');

    if (savedWidth) popup.style.width = savedWidth;
    if (savedHeight) popup.style.height = savedHeight;
    if (savedTop) popup.style.top = savedTop;
    if (savedLeft) popup.style.left = savedLeft;

    const closeBtn = document.createElement('button');
    closeBtn.classList.add('close-btn');
    closeBtn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="17" height="17" fill="currentColor">
            <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>
        </svg>
    `;

    const openBtn = document.createElement('a');
    openBtn.classList.add('open-btn');
    openBtn.style.position = 'absolute';
    openBtn.style.top = '10px';
    openBtn.style.right = '45px';
    openBtn.style.background = 'rgba(45, 62, 80, 0.6)';
    openBtn.style.color = 'rgba(255, 255, 255, 0.8)';
    openBtn.style.cursor = 'pointer';
    openBtn.style.width = '30px';
    openBtn.style.height = '30px';
    openBtn.style.borderRadius = '50%';
    openBtn.style.display = 'flex';
    openBtn.style.alignItems = 'center';
    openBtn.style.justifyContent = 'center';
    openBtn.style.textDecoration = 'none';
    openBtn.target = '_blank';
    openBtn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" fill="white" style="transform: scaleX(-1);">
            <path d="M505 442.7l-99.7-99.7c28.4-35.3 45.7-79.8 45.7-128C451 98.8 352.2 0 224 0S-3 98.8-3 224s98.8 224 224 224c48.2 0 92.7-17.3 128-45.7l99.7 99.7c6.2 6.2 14.4 9.4 22.6 9.4s16.4-3.1 22.6-9.4c12.5-12.5 12.5-32.8 0-45.3zM224 384c-88.4 0-160-71.6-160-160S135.6 64 224 64s160 71.6 160 160-71.6 160-160 160z"/>
        </svg>
    `;

    const dictBtn = document.createElement('a');
    dictBtn.classList.add('dict-btn');
    dictBtn.style.position = 'absolute';
    dictBtn.style.top = '10px';
    dictBtn.style.right = '80px';
    dictBtn.style.background = 'rgba(45, 62, 80, 0.6)';
    dictBtn.style.color = 'rgba(255, 255, 255, 0.8)';
    dictBtn.style.cursor = 'pointer';
    dictBtn.style.width = '30px';
    dictBtn.style.height = '30px';
    dictBtn.style.borderRadius = '50%';
    dictBtn.style.display = 'flex';
    dictBtn.style.alignItems = 'center';
    dictBtn.style.justifyContent = 'center';
    dictBtn.style.textDecoration = 'none';
    dictBtn.target = '_blank';
    dictBtn.title = 'Open in dict.dhamma.gift';
    dictBtn.innerHTML = `<img src="/assets/svg/dpd-logo-dark.svg" width="18" height="18">`;

    const iframe = document.createElement('iframe');
    iframe.src = '';
    iframe.style.width = '100%';
    iframe.style.height = 'calc(100% - 16px)';
    iframe.style.overflow = 'hidden';

    const header = document.createElement('div');
    header.classList.add('popup-header');
    header.style.cursor = 'move';
    header.style.height = '10px';
    header.style.display = 'flex';
    header.style.alignItems = 'center';
    header.style.padding = '0 10px';
    header.textContent = '';

    const resizeHandle = document.createElement('div');
    resizeHandle.classList.add('resize-handle');
    resizeHandle.style.position = 'absolute';
    resizeHandle.style.right = '0';
    resizeHandle.style.bottom = '0';
    resizeHandle.style.width = '20px';
    resizeHandle.style.height = '20px';
    resizeHandle.style.cursor = 'nwse-resize';
    resizeHandle.style.zIndex = '10';
    resizeHandle.innerHTML = `
        <style>
            .resize-handle::after {
                content: "";
                position: absolute;
                right: 3px;
                bottom: 3px;
                width: 0;
                height: 0;
                border-style: solid;
                border-width: 0 0 12px 12px;
                border-color: transparent transparent #666 transparent;
            }
        </style>
    `;

    popup.appendChild(header);
    popup.appendChild(dictBtn);
    popup.appendChild(openBtn);
    popup.appendChild(closeBtn);
    popup.appendChild(iframe);
    popup.appendChild(resizeHandle);

    document.body.appendChild(overlay);
    document.body.appendChild(popup);

    // Состояния для управления событиями
    let isDragging = false;
    let isResizing = false;

    // Перетаскивание окна
    let startX, startY, initialLeft, initialTop;
    let isFirstDrag = localStorage.getItem('isFirstDrag') === 'false' ? false : true;

    if (isFirstDrag) {
        popup.style.top = '50%';
        popup.style.left = '50%';
        popup.style.width = '749px';
        popup.style.height = '600px';
        popup.style.transform = 'translate(-50%, -50%)';
    }

    function startDrag(e) {
        isDragging = true;
        iframe.style.pointerEvents = 'none';
        popup.classList.add('dragging');
        
        if (isFirstDrag) {
            const rect = popup.getBoundingClientRect();
            popup.style.transform = 'none';
            popup.style.top = rect.top + 'px';
            popup.style.left = rect.left + 'px';
            isFirstDrag = false;
            localStorage.setItem('isFirstDrag', isFirstDrag);
        }  
        
        startX = e.clientX || e.touches[0].clientX;
        startY = e.clientY || e.touches[0].clientY;
        initialLeft = parseInt(popup.style.left || 0, 10);
        initialTop = parseInt(popup.style.top || 0, 10);
        e.preventDefault();
    }

    function moveDrag(e) {
        if (isDragging) {
            const deltaX = (e.clientX || e.touches[0].clientX) - startX;
            const deltaY = (e.clientY || e.touches[0].clientY) - startY;
            popup.style.left = `${initialLeft + deltaX}px`;
            popup.style.top = `${initialTop + deltaY}px`;
        }
    }

    function stopDrag() {
        if (isDragging) {
            isDragging = false;
            iframe.style.pointerEvents = 'auto';
            popup.classList.remove('dragging');
            savePopupState();
        }
    }

    // Изменение размера окна
    let startWidth, startHeight, startResizeX, startResizeY;

    function startResize(e) {
        isResizing = true;
        iframe.style.pointerEvents = 'none';
        popup.classList.add('resizing');
        
        startWidth = parseInt(document.defaultView.getComputedStyle(popup).width, 10);
        startHeight = parseInt(document.defaultView.getComputedStyle(popup).height, 10);
        startResizeX = e.clientX || e.touches[0].clientX;
        startResizeY = e.clientY || e.touches[0].clientY;
        
        e.preventDefault();
        e.stopPropagation();
    }

    function doResize(e) {
        if (!isResizing) return;
        
        const currentX = e.clientX || e.touches[0].clientX;
        const currentY = e.clientY || e.touches[0].clientY;
        
        const newWidth = startWidth + (currentX - startResizeX);
        const newHeight = startHeight + (currentY - startResizeY);
        
        const minWidth = 200;
        const minHeight = 150;
        const maxWidth = window.innerWidth * 0.9;
        const maxHeight = window.innerHeight * 0.9;
        
        popup.style.width = Math.max(minWidth, Math.min(newWidth, maxWidth)) + 'px';
        popup.style.height = Math.max(minHeight, Math.min(newHeight, maxHeight)) + 'px';
        
        e.preventDefault();
        e.stopPropagation();
    }

    function stopResize() {
        if (isResizing) {
            isResizing = false;
            iframe.style.pointerEvents = 'auto';
            popup.classList.remove('resizing');
           savePopupState();
        }
    }

    // Обработчики событий
    header.addEventListener('mousedown', startDrag);
    document.addEventListener('mousemove', moveDrag);
    document.addEventListener('mouseup', stopDrag);
    header.addEventListener('touchstart', startDrag);
    document.addEventListener('touchmove', moveDrag);
    document.addEventListener('touchend', stopDrag);

    resizeHandle.addEventListener('mousedown', startResize);
    resizeHandle.addEventListener('touchstart', startResize);
    document.addEventListener('mousemove', doResize);
    document.addEventListener('touchmove', doResize);
    document.addEventListener('mouseup', stopResize);
    document.addEventListener('touchend', stopResize);

    // Отмена действий при выходе курсора за пределы окна
    document.addEventListener('mouseleave', () => {
        if (isDragging) stopDrag();
        if (isResizing) stopResize();
    });

    return { overlay, popup, closeBtn, iframe };
}
// Вставка popup на страницу
const { overlay, popup, closeBtn, iframe } = createPopup();

// Закрытие popup при нажатии на кнопку или на overlay
closeBtn.addEventListener('click', () => {
      event.stopPropagation(); // Останавливаем всплытие события

  popup.style.display = 'none';
  overlay.style.display = 'none';
  iframe.src = ''; // Очищаем iframe
//  resizeObserver.disconnect();
});

overlay.addEventListener('click', () => {
      event.stopPropagation(); // Останавливаем всплытие события

  popup.style.display = 'none';
  overlay.style.display = 'none';
  iframe.src = ''; // Очищаем iframe
});

// console.log('lookup dict ', dictUrl, ' siteLanguage ', siteLanguage);

// Проверяем состояние в localStorage при загрузке страницы
let dictionaryVisible = localStorage.getItem('dictionaryVisible') === null ? true : localStorage.getItem('dictionaryVisible') === 'true';

const toggleBtn = document.querySelector('.toggle-dict-btn img');
if (dictionaryVisible) {
  toggleBtn.src = "/assets/svg/comment.svg";
} else {
  toggleBtn.src = "/assets/svg/comment-slash.svg";
  clearParams();
}

// Обработчик кнопки для включения/выключения отображения словаря
toggleBtn.addEventListener('click', () => {
  dictionaryVisible = !dictionaryVisible;

  // Сохраняем состояние в localStorage
  localStorage.setItem('dictionaryVisible', dictionaryVisible);

  if (dictionaryVisible) {
  toggleBtn.src = "/assets/svg/comment.svg";
        showBubbleNotification("Dictionary On");

} else {
  toggleBtn.src = "/assets/svg/comment-slash.svg";
        showBubbleNotification("Dictionary Off");

}
});

    // Добавляем обработчик сочетания клавиш Alt + A (физическая клавиша)
  document.addEventListener("keydown", (event) => {
    if (event.altKey && event.code === "KeyA") {
      // Имитируем клик по кнопке
      toggleBtn.click();
    }
  });  

// Перехватчик кликов по слову
// Перехватчик кликов по слову и выделенного текста
document.addEventListener('click', function(event) {
    // Проверяем, есть ли выделенный текст внутри элемента с пали
    const pliElement = event.target.closest('.pli-lang, [lang="pi"]');
    const selectedText = getSelectedText();
    
    if (pliElement && selectedText && isSelectionWithinElement(pliElement)) {
        // Обрабатываем выделенный текст
        if (event.target.closest('a, button, input, textarea, select')) {
            return;
        }

        let cleanedText = cleanWord(selectedText);
        console.log('Выделенный текст:', cleanedText);

        if (dictionaryVisible) {
            let translation = "";
            
            if (dictUrl === "standalonebw" || dictUrl === "standalonebwru") {
                translation = lookupWordInStandaloneDict(cleanedText);
            } 
            else if (dictUrl.includes('dicttango') || dictUrl.includes('mdict')) {
                const tempLink = document.createElement('a');
                tempLink.href = 'javascript:void(0)';
                tempLink.onclick = function() {
                    window.location.href = `${dictUrl}${encodeURIComponent(cleanedText)}`;
                    return false;
                };
                tempLink.click();
                translation = "";
                popup.style.display = 'none';
                overlay.style.display = 'none';
            }
            else {
                const url = `${dictUrl}${encodeURIComponent(cleanedText)}`;
                iframe.src = url;
            }

            if (translation) {
                const isDarkMode = document.body.classList.contains('dark') || document.documentElement.getAttribute('data-theme') === 'dark';
                const themeClass = isDarkMode ? 'dark' : '';
                
                const tempDiv = document.createElement('div');
                tempDiv.style.position = 'absolute';
                tempDiv.style.visibility = 'hidden';
                tempDiv.style.width = 'calc(100% - 20px)';
                tempDiv.innerHTML = translation;
                document.body.appendChild(tempDiv);
                
                const contentHeight = tempDiv.offsetHeight;
                document.body.removeChild(tempDiv);
                
                let minHeight = 100;
                const maxHeight = window.innerHeight * 0.95; 
                
                if (dictUrl === "standalonebw" || dictUrl === "standalonebwru") {
                    minHeight = 100;
                } else {
                    const screenHeight = window.innerHeight;
                    minHeight = (screenHeight * 0.8 < 600) ? screenHeight * 0.8 : 600;
                }

                let finalHeight = Math.min(Math.max(contentHeight + 20, minHeight), maxHeight);
                
                iframe.srcdoc = `  
                    <!DOCTYPE html>  
                    <html lang="en" class="${themeClass}">  
                    <head>  
                        <meta charset="UTF-8">  
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <style>  
                            body {  
                                font-family: Arial, sans-serif;  
                                padding: 10px;  
                                margin: 0;
                                overflow: hidden;
                            }  
                            body.dark {  
                                background: #07021D !important;  
                                color: #E1EAED !important;  
                            }  
                            strong {  
                                font-size: 1.2em;  
                            }  
                            ul {  
                                list-style-type: none;  
                                padding-left: 0;  
                            }  
                            li {  
                                margin-bottom: 10px;  
                            }  
                        </style>  
                    </head>  
                    <body class="${themeClass}">  
                        ${translation}  
                    </body>  
                    </html>  
                `;
                
                popup.style.height = `${finalHeight}px`;
                popup.style.display = 'block';  
                overlay.style.display = 'block';
                
                iframe.onload = function() {
                    try {
                        const iframeBody = iframe.contentDocument.body;
                        const scrollHeight = iframeBody.scrollHeight;
                        const adjustedHeight = Math.min(Math.max(scrollHeight + 20, minHeight), maxHeight);
                        popup.style.height = `${adjustedHeight}px`;
                    } catch(e) {
                        console.error('Error adjusting iframe height:', e);
                    }
                };
            }
            
            const openBtn = document.querySelector('.open-btn');
            const textForSearch = cleanedText.replace(/'ti/, '');
            openBtn.href = `${dhammaGift}${encodeURIComponent(textForSearch)}${dgParams}`;

            const dictBtn = document.querySelector('.dict-btn');
            const dictSearchUrl = `https://dict.dhamma.gift/${savedDict.includes("ru") ? "ru/" : ""}search_html?q=${encodeURIComponent(textForSearch)}`;
            dictBtn.href = dictSearchUrl;

            function showSearchButton() {
                const textForSearch = cleanedText.replace(/'ti/, '');
                const searchBtn = document.createElement('a');
                searchBtn.href = `${dhammaGift}${encodeURIComponent(textForSearch)}${dgParams}`;
                searchBtn.classList.add('open-btn');
                searchBtn.style.position = 'fixed';
                searchBtn.style.border = 'none';
                searchBtn.style.background = '#2D3E50';
                searchBtn.style.color = 'white';
                searchBtn.style.cursor = 'pointer';
                searchBtn.style.width = '30px';
                searchBtn.style.height = '30px';
                searchBtn.style.borderRadius = '50%';
                searchBtn.style.display = 'flex';
                searchBtn.style.alignItems = 'center';
                searchBtn.style.justifyContent = 'center';
                searchBtn.style.textDecoration = 'none';
                searchBtn.target = '_blank';
                searchBtn.style.top = `${event.clientY - 10}px`;
                searchBtn.style.left = `${event.clientX - 10}px`;
                searchBtn.style.zIndex = '10000';
                searchBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" fill="white" style="transform: scaleX(-1);">
                        <path d="M505 442.7l-99.7-99.7c28.4-35.3 45.7-79.8 45.7-128C451 98.8 352.2 0 224 0S-3 98.8-3 224s98.8 224 224 224c48.2 0 92.7-17.3 128-45.7l99.7 99.7c6.2 6.2 14.4 9.4 22.6 9.4s16.4-3.1 22.6-9.4c12.5-12.5 12.5-32.8 0-45.3zM224 384c-88.4 0-160-71.6-160-160S135.6 64 224 64s160 71.6 160 160-71.6 160-160 160z"/>
                    </svg>
                `;
                document.body.appendChild(searchBtn);
                searchBtn.addEventListener('click', () => {
                    searchBtn.remove();
                });
                setTimeout(() => {
                    searchBtn.remove();
                }, 1500);
            }

            if (dictUrl.includes('dicttango') || dictUrl.includes('mdict')) {
                popup.style.display = 'none';
                overlay.style.display = 'none';
                showSearchButton();
            } else if (dictUrl.includes('searchonly')) {
                popup.style.display = 'none';
                overlay.style.display = 'none';
                showSearchButton();
            } else {
                popup.style.display = 'block';
                overlay.style.display = 'block';
            }
        }
    } else if (event.target.closest('.pli-lang, [lang="pi"]')) {
        // Обработка клика по одному слову (оригинальная логика)
        const clickedWord = getClickedWordWithHTML(event.target, event.clientX, event.clientY);

        if (event.target.closest('a, button, input, textarea, select')) {
            return;
        }

        if (clickedWord) {
            let cleanedWord = cleanWord(clickedWord);
            console.log('Клик по слову:', cleanedWord);

            if (dictionaryVisible) {
                let translation = "";
                
                if (dictUrl === "standalonebw" || dictUrl === "standalonebwru") {
                    translation = lookupWordInStandaloneDict(cleanedWord);
                } 
                else if (dictUrl.includes('dicttango') || dictUrl.includes('mdict')) {
                    const tempLink = document.createElement('a');
                    tempLink.href = 'javascript:void(0)';
                    tempLink.onclick = function() {
                        window.location.href = `${dictUrl}${encodeURIComponent(cleanedWord)}`;
                        return false;
                    };
                    tempLink.click();
                    translation = "";
                    popup.style.display = 'none';
                    overlay.style.display = 'none';
                }
                else {
                    const url = `${dictUrl}${encodeURIComponent(cleanedWord)}`;
                    iframe.src = url;
                }

                if (translation) {
                    const isDarkMode = document.body.classList.contains('dark') || document.documentElement.getAttribute('data-theme') === 'dark';
                    const themeClass = isDarkMode ? 'dark' : '';
                    
                    const tempDiv = document.createElement('div');
                    tempDiv.style.position = 'absolute';
                    tempDiv.style.visibility = 'hidden';
                    tempDiv.style.width = 'calc(100% - 20px)';
                    tempDiv.innerHTML = translation;
                    document.body.appendChild(tempDiv);
                    
                    const contentHeight = tempDiv.offsetHeight;
                    document.body.removeChild(tempDiv);
                    
                    let minHeight = 100;
                    const maxHeight = window.innerHeight * 0.95; 
                    
                    if (dictUrl === "standalonebw" || dictUrl === "standalonebwru") {
                        minHeight = 100;
                    } else {
                        const screenHeight = window.innerHeight;
                        minHeight = (screenHeight * 0.8 < 600) ? screenHeight * 0.8 : 600;
                    }

                    let finalHeight = Math.min(Math.max(contentHeight + 20, minHeight), maxHeight);
                    
                    iframe.srcdoc = `  
                        <!DOCTYPE html>  
                        <html lang="en" class="${themeClass}">  
                        <head>  
                            <meta charset="UTF-8">  
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <style>  
                                body {  
                                    font-family: Arial, sans-serif;  
                                    padding: 10px;  
                                    margin: 0;
                                    overflow: hidden;
                                }  
                                body.dark {  
                                    background: #07021D !important;  
                                    color: #E1EAED !important;  
                                }  
                                strong {  
                                    font-size: 1.2em;  
                                }  
                                ul {  
                                    list-style-type: none;  
                                    padding-left: 0;  
                                }  
                                li {  
                                    margin-bottom: 10px;  
                                }  
                            </style>  
                        </head>  
                        <body class="${themeClass}">  
                            ${translation}  
                        </body>  
                        </html>  
                    `;
                    
                    popup.style.height = `${finalHeight}px`;
                    popup.style.display = 'block';  
                    overlay.style.display = 'block';
                    
                    iframe.onload = function() {
                        try {
                            const iframeBody = iframe.contentDocument.body;
                            const scrollHeight = iframeBody.scrollHeight;
                            const adjustedHeight = Math.min(Math.max(scrollHeight + 20, minHeight), maxHeight);
                            popup.style.height = `${adjustedHeight}px`;
                        } catch(e) {
                            console.error('Error adjusting iframe height:', e);
                        }
                    };
                }
                
                const openBtn = document.querySelector('.open-btn');
                const wordForSearch = cleanedWord.replace(/'ti/, '');
                openBtn.href = `${dhammaGift}${encodeURIComponent(wordForSearch)}${dgParams}`;

                const dictBtn = document.querySelector('.dict-btn');
                const dictSearchUrl = `https://dict.dhamma.gift/${savedDict.includes("ru") ? "ru/" : ""}search_html?q=${encodeURIComponent(wordForSearch)}`;
                dictBtn.href = dictSearchUrl;

                function showSearchButton() {
                    const wordForSearch = cleanedWord.replace(/'ti/, '');
                    const searchBtn = document.createElement('a');
                    searchBtn.href = `${dhammaGift}${encodeURIComponent(wordForSearch)}${dgParams}`;
                    searchBtn.classList.add('open-btn');
                    searchBtn.style.position = 'fixed';
                    searchBtn.style.border = 'none';
                    searchBtn.style.background = '#2D3E50';
                    searchBtn.style.color = 'white';
                    searchBtn.style.cursor = 'pointer';
                    searchBtn.style.width = '30px';
                    searchBtn.style.height = '30px';
                    searchBtn.style.borderRadius = '50%';
                    searchBtn.style.display = 'flex';
                    searchBtn.style.alignItems = 'center';
                    searchBtn.style.justifyContent = 'center';
                    searchBtn.style.textDecoration = 'none';
                    searchBtn.target = '_blank';
                    searchBtn.style.top = `${event.clientY - 10}px`;
                    searchBtn.style.left = `${event.clientX - 10}px`;
                    searchBtn.style.zIndex = '10000';
                    searchBtn.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" fill="white" style="transform: scaleX(-1);">
                            <path d="M505 442.7l-99.7-99.7c28.4-35.3 45.7-79.8 45.7-128C451 98.8 352.2 0 224 0S-3 98.8-3 224s98.8 224 224 224c48.2 0 92.7-17.3 128-45.7l99.7 99.7c6.2 6.2 14.4 9.4 22.6 9.4s16.4-3.1 22.6-9.4c12.5-12.5 12.5-32.8 0-45.3zM224 384c-88.4 0-160-71.6-160-160S135.6 64 224 64s160 71.6 160 160-71.6 160-160 160z"/>
                        </svg>
                    `;
                    document.body.appendChild(searchBtn);
                    searchBtn.addEventListener('click', () => {
                        searchBtn.remove();
                    });
                    setTimeout(() => {
                        searchBtn.remove();
                    }, 1500);
                }

                if (dictUrl.includes('dicttango') || dictUrl.includes('mdict')) {
                    popup.style.display = 'none';
                    overlay.style.display = 'none';
                    showSearchButton();
                } else if (dictUrl.includes('searchonly')) {
                    popup.style.display = 'none';
                    overlay.style.display = 'none';
                    showSearchButton();
                } else {
                    popup.style.display = 'block';
                    overlay.style.display = 'block';
                }
            }
        }
    }
});

function getClickedWordWithHTML(element, x, y) {
    let range;
    
    if (document.caretRangeFromPoint) {
        range = document.caretRangeFromPoint(x, y); // Для Chrome, Edge
    } else if (document.caretPositionFromPoint) {
        const position = document.caretPositionFromPoint(x, y); // Для Firefox
        if (position && position.offsetNode) {
            range = document.createRange();
            range.setStart(position.offsetNode, position.offset);
            range.setEnd(position.offsetNode, position.offset); // Добавляем setEnd
        }
    }

    if (!range) return null;

    const parentElement = element.closest('.pli-lang, .rus-lang, .eng-lang, [lang="pi"], [lang="en"], [lang="ru"]');
    if (!parentElement) {
     //   console.log('Родительский элемент с классом pli-lang не найден.');
        return null;
    }

    // Получаем текст без HTML-тегов
    const fullText = parentElement.textContent;

    // Вычисляем смещение в тексте без учета HTML-тегов
    const globalOffset = calculateOffsetWithHTML(parentElement, range.startContainer, range.startOffset);
    if (globalOffset === -1) {
      //  console.error('Не удалось вычислить глобальное смещение.');
        return null;
    }

   // console.log('Смещение в полном тексте:', globalOffset);

    // Используем обновленное регулярное выражение для поиска слова
    const regex = /[^\s,;.–—!?()]+/g; // Регулярное выражение, игнорирующее пробелы и знаки препинания
    let match;
    while ((match = regex.exec(fullText)) !== null) {
        if (match.index <= globalOffset && regex.lastIndex >= globalOffset) {
        //    console.log('Найденное слово:', match[0]);
            return match[0];
        }
    }

    console.log('Слово не найдено');
    return null;
}

// Функция для вычисления глобального смещения клика в полном тексте
function calculateOffsetWithHTML(element, targetNode, targetOffset) {
    let offset = 0;
    const walker = document.createTreeWalker(element, NodeFilter.SHOW_TEXT, null, false);

    let node;
    while ((node = walker.nextNode())) {
        if (node === targetNode) {
            return offset + targetOffset;
        }
        offset += node.textContent.length;
    }

  //  console.log('Целевой узел не найден.');
    return -1; // Возвращаем ошибку, если узел не найден
}

// Функция для получения полного текста из элемента, включая все текстовые узлы
function getFullTextFromElement(element) {
    const textNodes = [];
    const walker = document.createTreeWalker(element, NodeFilter.SHOW_TEXT, null, false);

    let node;
    while ((node = walker.nextNode())) {
        textNodes.push(node.textContent);
    }

    return textNodes.join(' ').replace(/\s+/g, ' ').trim(); // Удаляем лишние пробелы
}

// Пример обработки клика на элемент
document.addEventListener('click', (event) => {
    const clickedWord = getClickedWordWithHTML(event.target, event.clientX, event.clientY);
    if (clickedWord) {
      //  console.log('Слово по клику:', clickedWord);
    } else {
     //   console.log('Слово не определено');
    }
});

// Функция для очистки слова от лишних символов
function cleanWord(word) {
    return word
        .replace(/^[\s'‘—.–।|…"“”]+/, ' ') // Убираем символы в начале, включая пробелы и тире
        .replace(/^[0-9]+/, ' ') // 
        .replace(/[\s'‘,—.—–।|"“…:;”]+$/, ' ') // Убираем символы в конце, включая пробелы и тире
        .replace(/[‘'’‘"“””]+/g, "'") // заменяем в середине
        .trim()
        .toLowerCase();
}

// Функция для транслитерации слова
/*
function transliterateWord(word) {
    return new Promise((resolve, reject) => {
        // Подготавливаем текст для передачи в URL (инкодируем пробелы и спецсимволы)
        const encodedText = encodeURIComponent(word);

        // Формируем URL для вызова PHP-скрипта
        const url = `/scripts/api/transliterate.php?text=${encodedText}&source=autodetect&target=ISOPali`;

        // Отправляем GET-запрос на сервер
        fetch(url)
            .then(response => response.json())  // Ожидаем, что сервер вернёт JSON
            .then(data => {
                // Извлекаем значение из поля 'converted' и возвращаем его
                const transliteratedText = data.converted;
                resolve(transliteratedText);
            })
            .catch(error => {
                reject(error);
            });
    });
}
*/


