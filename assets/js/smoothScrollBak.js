//smooth scroll to anchor
    window.addEventListener('DOMContentLoaded', function() {
      var hash = window.location.hash;
  const isLocalhost = window.location.hostname.match(/localhost|127\.0\.0\.1/);
const timeout = isLocalhost ? 1000 : 2500; 
//console.log(timeout);
      if (hash) {
        setTimeout(function() {
          var element = document.getElementById(hash.substring(1));
          if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
          }
        }, timeout);
      }
    });  


document.addEventListener('DOMContentLoaded', function() {



  // Создаем элемент кнопки  <img src="/assets/img/arrow-up.png" alt="To top"> <!--  <img src="/assets/svg/arrow-up.svg" alt="To top"> -->  <i class="fa-solid fa-arrow-up"></i>
  var scrollToTopBtn = document.createElement('button');
  scrollToTopBtn.id = 'scrollToTopBtn';
  scrollToTopBtn.className = 'btn btn-secondary rounded-pill hide-button';
  scrollToTopBtn.style.display = 'none';

  // Создаем элемент изображения
  var img = document.createElement('img');
  img.id = 'arrowImg';
  img.src = '/assets/svg/arrow-up.svg';
  img.alt = 'To top';
  scrollToTopBtn.appendChild(img);
  
    if (localStorage.theme === "dark") { img.src = '/assets/svg/arrow-up.svg';
  } else if (localStorage.theme === "light") { 
    img.src = '/assets/svg/arrow-up-dark.svg';
  } else{ 
    img.src = '/assets/svg/arrow-up.svg';
  }
  
  // Создаем элемент иконки
/* var icon = document.createElement('i');
  icon.className = 'fa-solid fa-arrow-up';
  scrollToTopBtn.appendChild(icon); */

  // Добавляем кнопку на страницу
  document.body.appendChild(scrollToTopBtn);

  // Функция для проверки позиции прокрутки и показа кнопки при необходимости
  function checkScrollPosition() {
    if (window.scrollY > 600) { // Измените это значение на нужное вам
      scrollToTopBtn.style.display = 'block';
    } else {
      scrollToTopBtn.style.display = 'none';
    }
  }

  // Проверяем позицию прокрутки при загрузке страницы
  checkScrollPosition();

  // Добавляем обработчик события прокрутки страницы
  window.addEventListener('scroll', checkScrollPosition);

  // Обработчик события клика для кнопки "Наверх"
  scrollToTopBtn.addEventListener('click', function(event) {
    event.preventDefault(); // Предотвращаем действие по умолчанию (перезагрузку страницы)
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
});

// Обработчик для кнопки смены темы
const themeButton = document.getElementById("theme-button");
if (themeButton) {
  themeButton.addEventListener('click', function() {
    // Ждем небольшой задержки, чтобы тема успела измениться
    setTimeout(() => {
      const arrowImg = document.getElementById('arrowImg');
      if (arrowImg) {
        // Проверяем текущую тему
        const isDark = document.documentElement.classList.contains('dark') || 
                       localStorage.theme === 'dark' ||
                       (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
        
        // Меняем изображение стрелки
        arrowImg.src = isDark ? '/assets/svg/arrow-up.svg' : '/assets/svg/arrow-up-dark.svg';
      }
    }, 50); // Небольшая задержка в 50мс
  });
}

//scroll by s params
document.addEventListener("DOMContentLoaded", function() {
 //   console.log("DOMContentLoaded event fired");
    let params = new URLSearchParams(document.location.search);
    let finder = params.get("s");
    let query = params.get("q");
    let url = document.location.href;

    if (finder && finder.trim() !== "" && query && url.indexOf("#") === -1) {
    //    console.log("Parameters 's', 'q', and no anchor found in URL");

        let regex = new RegExp(finder, 'gi');
        let match = document.body.innerText.match(regex);
    //    console.log("Match:", match);

        if (match && match.length > 0) {
            let firstMatchElement = document.querySelector(`*:contains(${match[0]})`);
      //      console.log("First match element:", firstMatchElement);

            if (firstMatchElement) {
                firstMatchElement.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
          //      console.log("Smooth scroll to first match element");
            } else {
        //        console.log("First match element not found");
            }
        } else {
    //        console.log("No match found");
        }
    } else {
   //     console.log("Conditions not met: 's' parameter empty or missing, 'q' parameter empty or missing, or anchor found in URL");
    }
});

// Функция для выделения элемента по ID
function highlightById(elementId) {
    const element = document.getElementById(elementId);
    if (!element) return;

    // Сохраняем оригинальные стили
    const originalTransition = element.style.transition;
    const originalBorderRadius = element.style.borderRadius;
    const originalBoxShadow = element.style.boxShadow;

    // Настройки анимации
    element.style.borderRadius = '10px';
    element.style.transition = 'box-shadow 0.3s ease-in-out';
    let blinkCount = 0;
    const maxBlinks = 6; // 3 мерцания (вкл/выкл)
    let isWide = false;

    // Находим все дочерние иконки
    const icons = element.querySelectorAll('.menu-icon, i.fa-solid, img');

    // Функция для мерцания
    const blinkInterval = setInterval(function() {
        // Подсветка основного элемента
        element.style.boxShadow = isWide ? '0 0 0 2px grey' : '0 0 0 4px grey';
        
        // Подсветка иконок
        icons.forEach(icon => {
            icon.style.transition = 'box-shadow 0.3s ease-in-out';
            icon.style.boxShadow = isWide ? '0 0 0 2px grey' : '0 0 0 4px grey';
        });

        isWide = !isWide;
        blinkCount++;

        // Останавливаем после 3 мерцаний (6 изменений состояния)
        if (blinkCount >= maxBlinks) {
            clearInterval(blinkInterval);
            
            // Возвращаем оригинальные стили
            setTimeout(() => {
                element.style.boxShadow = originalBoxShadow;
                element.style.transition = originalTransition;
                element.style.borderRadius = originalBorderRadius;
                
                icons.forEach(icon => {
                    icon.style.boxShadow = '';
                    icon.style.transition = '';
                });
            }, 300);
        }
    }, 500);
}

// Функция для выделения нескольких элементов по массиву ID

function highlightMultipleById(ids) {
    ids.forEach(highlightById);
}

// Пример использования:
// highlightById('tools');
// highlightMultipleById(['tools', 'materials']);




// Функция для наблюдения за появлением элементов с указанными классами
function observeAndHighlightElements(classNames) {
    // Преобразуем строку с классами в массив (если передана строка)
    const classes = Array.isArray(classNames) ? classNames : [classNames];
    
    // Настройки для IntersectionObserver
    const observerOptions = {
        root: null, // наблюдать относительно viewport
        rootMargin: '0px',
        threshold: 0.1 // срабатывает когда 10% элемента видно
    };
    
    // Создаем наблюдатель
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Если элемент стал видимым
                highlightElement(entry.target);
                // Прекращаем наблюдение после первого срабатывания
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Находим все элементы с указанными классами и начинаем наблюдение
    classes.forEach(className => {
        document.querySelectorAll(`.${className}`).forEach(element => {
            observer.observe(element);
        });
    });
}

// Оригинальная функция highlightElement с небольшими улучшениями
function highlightElement(element) {
    if (!element) return;
    
    // Прокручиваем к элементу
    element.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    
    // Сохраняем оригинальные стили для восстановления
    const originalTransition = element.style.transition;
    const originalBorderRadius = element.style.borderRadius;
    const originalBoxShadow = element.style.boxShadow;
    
    // Начальные стили
    element.style.borderRadius = '10px';
    element.style.transition = 'box-shadow 0.3s ease-in-out';
    let isWide = false;
    
    // Функция для мигания
    const blinkInterval = setInterval(() => {
        element.style.boxShadow = isWide ? '0 0 0 2px grey' : '0 0 0 4px grey';
        isWide = !isWide;
    }, 500);
    
    // Убираем выделение через 3 секунды
    setTimeout(() => {
        clearInterval(blinkInterval);
        element.style.boxShadow = '0 0 0 0 grey';
        
        // Восстанавливаем оригинальные стили
        setTimeout(() => {
            element.style.transition = originalTransition;
            element.style.borderRadius = originalBorderRadius;
            element.style.boxShadow = originalBoxShadow;
        }, 300);
    }, 3000);
}

// Использование:
// observeAndHighlightElements('my-class'); // для одного класса
// observeAndHighlightElements(['class1', 'class2']); // для нескольких классов
 

// Функция для проверки хэша и запуска выделения
function checkHashAndHighlight() {
    // Получаем хэш из URL (например, "#tools" или "#tools,materials")
    const hash = window.location.hash;

    // Если хэш присутствует
    if (hash) {
        // Убираем символ "#" из хэша и разбиваем на массив ID
        const elementIds = hash.substring(1).split(',');

        // Для каждого ID находим элемент и выделяем его
        elementIds.forEach((elementId) => {
            const element = document.getElementById(elementId);
            if (element) {
                highlightElement(element);
            }
        });
    }
}

// Вызываем функцию при загрузке страницы


// Также вызываем функцию при изменении хэша
window.addEventListener('hashchange', checkHashAndHighlight);

document.addEventListener("DOMContentLoaded", function () {
    checkHashAndHighlight(); // Вызываем функцию при загрузке страницы
});




