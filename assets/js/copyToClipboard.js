// Функция для добавления стилей и элемента уведомления
function initCopyNotification() {

  // Создаем элемент уведомления
  const bubble = document.createElement('div');
  bubble.id = 'bubbleNotification';
  bubble.className = 'bubble-notification';
  document.body.appendChild(bubble);
}


// Функция для определения языка
function getNotificationText() {
  const path = window.location.pathname;
  const language = localStorage.getItem('siteLanguage') || 
                  (path.includes('/r/') ? 'ru' : 
                   path.includes('/read/') ? 'en' : 'en');
  
  return {
    ru: "Скопировано в буфер",
    en: "Copied to clipboard"
  }[language] || "Copied to clipboard";
}

// Основная функция копирования
function copyToClipboard(text = "") {
  // Инициализация уведомления
  if (!document.getElementById('bubbleNotification')) {
    initCopyNotification();
  }

  // Обработка URL
  if (text === 127) {
    text = window.location.href.replace('localhost', '127.0.0.1');
  } else if (text === "") {
    text = window.location.href;
    text = text.includes('localhost') || text.includes('127.0.0.1')
      ? text.replace(/https?:\/\/(localhost|127\.0\.0\.1)(:\d+)?/gi, 'https://dhamma.gift')
      : text.includes('dhamma.gift')
        ? text.replace('https://dhamma.gift', 'http://127.0.0.1:8080')
        : 'https://dhamma.gift' + text.substring(text.indexOf('/', 8));
  }

  // Получаем элемент, на котором кликнули
  const clickedElement = event?.target;
  if (!clickedElement || !clickedElement.classList.contains('copyLink')) {
    navigator.clipboard.writeText(text);
    showBubbleNotification(getNotificationText());
    return;
  }

  const parentSpan = clickedElement.closest('span[id]');
  if (!parentSpan) return;

  // Определяем язык кликнутого элемента
  const clickedLang = clickedElement.closest('[lang]')?.getAttribute('lang');
  const suttaId = new URL(text).searchParams.get('q') || '';

  let textParts = [];
  
  // 1. Всегда добавляем текст пали (с видимыми вариантами)
  const piElement = parentSpan.querySelector('.pli-lang');
  if (piElement) {
    const piClone = piElement.cloneNode(true);
    // Удаляем только скрытые варианты
    piClone.querySelectorAll('.hidden-variant').forEach(el => el.remove());
    const piText = piClone.textContent
      .trim()
      .replace(/\u00A0/g, '\n')
      .replace(/\s\s+/g, '\n');
    textParts.push(piText);
  }

  // 2. Если кликнули на перевод - добавляем его текст
  if (clickedLang !== 'pi') {
    const translationElement = clickedElement.closest('[lang]:not([lang="pi"])');
    if (translationElement) {
      const translationText = translationElement.textContent.trim();
      textParts.push(translationText);
    }
  }

  // 3. Добавляем все остальные видимые переводы (кроме кликнутого)
  if (clickedLang !== 'pi') {
    const otherTranslations = Array.from(
      parentSpan.querySelectorAll('[lang]:not([lang="pi"]):not([lang="' + clickedLang + '"])')
    )
      .filter(el => !el.closest('.hidden-variant'))
      .map(el => el.textContent.trim())
      .filter(Boolean);
    
    if (otherTranslations.length > 0) {
      textParts = textParts.concat(otherTranslations);
    }
  }

  // Собираем финальный текст с правильными отступами
  let textToCopy = textParts.join('\n\n'); // Двойной перенос между блоками
  
  // 4. Добавляем ID сутты и ссылку с дополнительными отступами
  if (suttaId) textToCopy += `\n\n${suttaId}`;
    
  if (text.includes('localhost') || text.includes('127.0.0.1')) {
		text = text.replace(/http:\/\/(localhost|127\.0\.0\.1)(:\d+)?/g, 'https://dhamma.gift');
    }

  textToCopy += `\n${text}`;

  console.log('Копируемый текст:', textToCopy);
  showBubbleNotification(getNotificationText());
  
  if (navigator.clipboard) {
    navigator.clipboard.writeText(textToCopy).catch(() => fallbackCopy(textToCopy));
  } else {
    fallbackCopy(textToCopy);
  }
}

// Fallback для старых браузеров
function fallbackCopy(text) {
  const textarea = document.createElement('textarea');
  textarea.value = text;
  document.body.appendChild(textarea);
  textarea.select();
  document.execCommand('copy');
  document.body.removeChild(textarea);
}

// Показать уведомление
function showBubbleNotification(text) {
  const bubble = document.getElementById('bubbleNotification');
  if (!bubble) return;
  
  bubble.textContent = text;
  bubble.classList.add('show');
  
  setTimeout(() => {
    bubble.classList.remove('show');
  }, 2000);
}

// Скрыть share icon на production
document.addEventListener('DOMContentLoaded', function() {
  const shareOnlineElement = document.getElementById('shareOnline');
  if (shareOnlineElement && window.location.href.includes('dhamma.gift')) {
    shareOnlineElement.style.display = 'none';
  }

// Инициализируем уведомление при загрузке
initCopyNotification();


	
// Event delegation для копирования
document.addEventListener('click', function(e) {
  const copyLink = e.target.closest('.copyLink');
  if (!copyLink) return;

  e.preventDefault();

 let url = copyLink.dataset.copyText || '';
  
  if (url.includes('localhost') || url.includes('127.0.0.1')) {
		url = url.replace(/http:\/\/(localhost|127\.0\.0\.1)(:\d+)?/g, 'https://dhamma.gift');
    }
	

  const contentBlock = copyLink.closest('span[id]');
  if (!contentBlock) return;

  // Функция для обработки текста
  const processText = (text) => {
    if (!text) return '';
    return text
      .replace(/\u00A0/g, '\n')
      .replace(/\s\s+/g, '\n')
      .trim();
  };

  let textToCopy = '';

  // 1. Текст на пали (исключаем только hidden-variant)
  const piTextElements = contentBlock.querySelectorAll('[lang="pi"]:not(.hidden-variant)');
  let piText = '';
  
  piTextElements.forEach(el => {
    const text = processText(el.textContent);
    if (text) {
      if (piText) piText += '\n';
      piText += text;
    }
  });
  
  if (piText) textToCopy += piText;

  // 2. Собираем переводы (исключаем только hidden-variant)
 // Ищем только УНИКАЛЬНЫЕ языки, игнорируем вложенные дубликаты
const langSet = new Set();
const translations = [];

for (const el of contentBlock.querySelectorAll('[lang]:not([lang="pi"]):not(.hidden-variant)')) {
  const lang = el.getAttribute('lang');
  const text = processText(el.textContent);

  if (!text || text === piText || langSet.has(lang)) continue;

  langSet.add(lang);
  translations.push({ lang, text });
}

  // Добавляем переводы с разделением
  if (translations.length > 0) {
    textToCopy += '\n\n';
    
    let currentLang = null;
    translations.forEach((t, i) => {
      // Пустая строка между разными языками
      if (currentLang && currentLang !== t.lang) {
        textToCopy += '\n';
      }
      textToCopy += t.text;
      if (i < translations.length - 1) {
        textToCopy += '\n';
      }
      currentLang = t.lang;
    });
  }

  // 3. Номер сутты и URL
  const suttaId = new URL(url).searchParams.get('q') || '';
  if (suttaId) textToCopy += `\n\n${suttaId}`;
  textToCopy += `\n${url}`;

  navigator.clipboard.writeText(textToCopy)
    .then(() => showBubbleNotification(getNotificationText()))
    .catch(() => fallbackCopy(textToCopy));
});


	});
