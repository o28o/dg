<?php
// Параметры запроса
$slug = strtolower($_GET['q'] ?? '');
$type = $_GET['type'] ?? 'pali'; // 'pali' или 'trn' (translation)

// Определяем язык по URL (новая логика)
$is_ru_url = (strpos($_SERVER['REQUEST_URI'], '/ru/') !== false) || 
             (strpos($_SERVER['REQUEST_URI'], '/r/') !== false) || 
             (strpos($_SERVER['REQUEST_URI'], '/ml/') !== false);

// Совмещаем старую и новую логику определения языка
if ($type === 'pali') {
    $lang = 'pi';
    $content_type = 'pali';
    $title_lang = 'Pali';
} elseif ($type === 'trn') {
    $lang = $is_ru_url ? 'ru' : 'en';
    $content_type = $is_ru_url ? 'ru' : 'en';
    $title_lang = $is_ru_url ? 'Russian' : 'English';
} else {
    // Старая логика по умолчанию (для обратной совместимости)
    $lang = 'ru';
    $content_type = 'ru';
    $title_lang = 'Translation';
}

// Заголовок страницы (сохраняем старый формат)
$title = htmlspecialchars(
    $slug
    ? ucfirst(str_replace(['-', '_'], ' ', $slug)) . ' (' .
      ($type === 'pali' ? 'Pali' : ($title_lang)) . ')'
    : 'TTS Page'
);

// Загрузка контента по slug (обновленная версия)
function loadContent($slug, $type) {
    include_once('config/config.php');
    
$jq = 'jq -r \'to_entries[] | "<a id=\"\(.key)\"></a><span>\(.value)</span>"\' | sed "s/' . $slug . '://"';    // Старая логика (для демонстрации)
    if (!in_array($type, ['pali', 'ru', 'en'])) {
        if ($type === 'trn') {
            return "Это перевод для: $slug";
        }
        return $type === 'pali' ? "Это палийский текст для: $slug" : "Контент для: $slug";
    }

    // Новая логика загрузки из файлов
    if ($type === 'pali') {
        $script = $_GET['script'] ?? 'dev'; // по умолчанию деванагари

        if ($script === 'lat') {
            $cmd = "find $basedir/suttacentral.net/sc-data/sc_bilara_data/root/pli/ms/ -name \"{$slug}_*\" -print -quit";
        } else {
            $cmd = "find $basedir/assets/texts/devanagari/root/pli/ms/ -name \"{$slug}_*\" -print -quit";
        }
        
        $file = shell_exec($cmd);
        $file = is_string($file) ? trim($file) : '';
        $content = $file ? shell_exec("cat " . escapeshellarg($file) . " | $jq") : "Pali text not found for: $slug";
        
        // Обработка пунктуации только для палийского текста
if ($content && $type === 'pali') {
    $content = preg_replace_callback(
        '/(<a\b[^>]*>.*?<\/a>)|([-—–:;“”‘’",\'.?!])/u',
        function($matches) {
            if ($matches[1] !== '') {
                // 1. Если это <a>...</a> — оставляем без изменений
                return $matches[1];
            } else {
                // 2. Если это пунктуация вне <a> — заменяем
                if (preg_match('/[.?!]/u', $matches[2])) {
                    return ' | ';
                } elseif (preg_match('/[-—–]/u', $matches[2])) {
                    return ' ';
                } else {
                    return ''; // Удаляем :;“”‘’",
                }
            }
        },
        $content
    );
}
        return $content;
    }
    elseif ($type === 'ru') {
        $cmd = "find $basedir/assets/texts/sutta ../assets/texts/vinaya -name \"{$slug}_*\" -print -quit";
        $file = trim(shell_exec($cmd));
        return $file ? shell_exec("cat ".escapeshellarg($file)." | $jq") : "Russian translation not found for: $slug";
    }
    else { // en
        $cmd = "find $basedir/suttacentral.net/sc-data/sc_bilara_data/translation/en/ -name \"{$slug}_*\" -print -quit";
        $file = trim(shell_exec($cmd));
        return $file ? shell_exec("cat ".escapeshellarg($file)." | $jq") : "English translation not found for: $slug";
    }
}

$basename = basename($file, '.json');
$parts = explode('-', $basename);
$translator = end($parts);

// Определяем текст подписи
if ($lang === 'pi') {
    $sourceInfo = 'Mahāsaṅgīti Pāḷi';
} else {
    $sourceInfo = $lang === 'ru' ? "Перевод: $translator" : "Translator: $translator";
}


// Если передан slug, загружаем контент автоматически
$content = $slug ? loadContent($slug, $content_type) : htmlspecialchars($_POST['content'] ?? '');
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" sizes="32x32" href="https://dhamma.gift/assets/img/favico_black.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/assets/css/bootstrap.5.3.1.min.css" rel="stylesheet" />
 <link href="/assets/css/styles.css" rel="stylesheet" />

  <link href="/assets/css/extrastyles.css" rel="stylesheet" />
  <link href="/assets/css/pages.css" rel="stylesheet" />
<link rel="stylesheet" href="/assets/css/jquery-ui.min.css">
<!-- -->
<link href="/assets/css/paliLookup.css" rel="stylesheet" />

<script src="/assets/js/jquery-3.7.0.min.js"></script>
<script src="/assets/js/jquery-ui.min.js"></script>
  <title><?= $title ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
      line-height: 1.6;
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      color: #333;
    }
    .text-content {
      white-space: pre-line;
      text-align: justify;
    }
  </style>
</head>
<body>
    <script>
function updateUrl(lang) {
    const currentUrl = new URL(window.location.href);
    const pathParts = currentUrl.pathname.split('/');
    const slug = currentUrl.searchParams.get('q') || '';
    
    // Очищаем путь от языковых префиксов
    let newPath = pathParts.filter(part => !['ru', 'r', 'ml', 'en'].includes(part)).join('/');
    
    // Добавляем нужный языковой префикс
    if (lang === 'ru') {
        newPath = newPath.replace(/^\//, '/ru/');
    } else if (lang === 'en') {
        newPath = newPath.replace(/^\/(ru|r|ml)\//, '/');
    }
    // Для pi не меняем путь
    
    // Обновляем параметры type
    currentUrl.searchParams.delete('type');
    if (lang === 'pi') {
        //currentUrl.searchParams.set('type', 'pali');
    } else {
        currentUrl.searchParams.set('type', 'trn');
    }
    
    // Собираем новый URL
    currentUrl.pathname = newPath;
    return currentUrl.toString();
}

function setLanguage(lang) {
    history.pushState({}, '', updateUrl(lang));
    location.reload(); // теперь безопасно
}

function togglePaliScript() {
    const current = localStorage.getItem('paliScript') || 'dev';
    const next = current === 'dev' ? 'lat' : 'dev';
    localStorage.setItem('paliScript', next);

    const url = new URL(window.location.href);
    if (next === 'dev') {
        url.searchParams.delete('script');
    } else {
        url.searchParams.set('script', 'lat');
    }

    window.location.href = url.toString();
}

function updateLanguageSwitcher(lang) {
    const switcher = document.querySelector('.lang-switcher');

    if (lang === 'ru') {
        switcher.innerHTML = `
             <a class="btn btn-sm btn-outline-secondary rounded-pill text-decoration-none " href="#" title="Devanagari / Roman Script" onclick="setLanguage('pi'); return false;">pi</a>
            <a class="btn btn-sm btn-outline-secondary rounded-pill text-decoration-none ms-1" title="English" href="#" onclick="setLanguage('en'); return false;">en</a>
            <a class="btn btn-sm btn-primary rounded-pill btn-outline-secondary active ms-1" title="Russian">ru</a>
        `;
    } 
    
    else if (lang === 'pi') {
        switcher.innerHTML = `
       <!-- <span class="btn btn-sm btn-primary rounded-pill ms-1">pi</span> -->
            <a class="btn btn-sm btn-primary rounded-pill btn-outline-secondary active" href="#" onclick="togglePaliScript(); return false;" title="Devanagari / Roman Script">pi</a>
            <a class="btn btn-sm btn-outline-secondary rounded-pill text-decoration-none ms-1" href="#" onclick="setLanguage('en'); return false;" title="English">en</a>
            <a class="btn btn-sm btn-outline-secondary rounded-pill text-decoration-none ms-1" href="#" onclick="setLanguage('ru'); return false;" title="Russian">ru</a>
        `;
    }
    else {
        switcher.innerHTML = `
            <a class="btn btn-sm btn-outline-secondary rounded-pill text-decoration-none " href="#" onclick="setLanguage('pi'); return false;" title="Devanagari / Roman Script">pi</a> 
            <span class="btn btn-sm btn-primary rounded-pill btn-outline-secondary active ms-1" title="English">en</span>
            <a class="btn btn-sm btn-outline-secondary rounded-pill text-decoration-none ms-1" href="#" onclick="setLanguage('ru'); return false;" title="Russian">ru</a>
        `;
    }
}

function detectLanguage() {
    const urlParams = new URLSearchParams(window.location.search);
    const type = urlParams.get('type');

    if (type === 'pali' || type === null) return 'pi'; // ← ключевой момент

    const currentUrl = window.location.pathname.toLowerCase();
    if (currentUrl.includes('/ru/') || currentUrl.includes('/r/') || currentUrl.includes('/ml/')) return 'ru';
    if (currentUrl.includes('/en/')) return 'en';

    return 'en';
}

const lang = '<?= $lang ?>'; // ← передаём PHP переменную

function updateLinks(lang) {
    const readLink = document.getElementById('readLink');
    const homeLink = document.getElementById('homeLink');

    if (lang === 'ru') {
        readLink.href = '/ru/read.php';
        homeLink.href = '/ru';
    } else if (lang === 'en') {
        readLink.href = '/read.php';
        homeLink.href = '/';
    }
    // Если pi — не менять ссылки
}

document.addEventListener('DOMContentLoaded', function() {
    updateLanguageSwitcher(detectLanguage());
    updateLinks(lang); // ← теперь lang определён

    document.getElementById('darkSwitch').addEventListener('change', function() {
        document.body.classList.toggle('dark-mode');
    });
});

</script>
<div class="container mt-3">
  <div class="d-flex flex-wrap align-items-center justify-content-between">

    <!-- Nav (order 1 всегда) -->
    <div class="d-flex align-items-center order-1 mb-2 mb-sm-0">
      <a id="readLink" href="/ru/read.php" title="Sutta and Vinaya reading" rel="noreferrer" class="me-1">
        <svg fill="#979797" xmlns="http://www.w3.org/2000/svg" height="26px" viewBox="0 0 547.596 547.596" stroke="#979797">
          <g><path d="M540.76,254.788L294.506,38.216c-11.475-10.098-30.064-10.098-41.386,0L6.943,254.788 c-11.475,10.098-8.415,18.284,6.885,18.284h75.964v221.773c0,12.087,9.945,22.108,22.108,22.108h92.947V371.067 c0-12.087,9.945-22.108,22.109-22.108h93.865c12.239,0,22.108,9.792,22.108,22.108v145.886h92.947 c12.24,0,22.108-9.945,22.108-22.108v-221.85h75.965C549.021,272.995,552.081,264.886,540.76,254.788z"></path></g>
        </svg>
      </a>

      <a id="homeLink" href="/ru" title="Sutta and Vinaya search" rel="noreferrer" class="me-1">
        <img width="24px" alt="dhamma.gift icon" class="me-1" src="/assets/img/gray-white.png">
      </a>

    <!-- Dictionary OnClick Popup -->
    <a alt="Onclick popup dictionary" title="Onclick popup dictionary (Alt+A)" class="toggle-dict-btn text-decoration-none text-black me-1">
      <img src="/assets/svg/comment.svg" class="dictIcon">
    </a>

      <div class="ms-1 form-check form-switch">
        <input type="checkbox" class="form-check-input" id="darkSwitch">
      </div>
      <a href="/assets/common/ttsHelp.html" class="text-decoration-none text-muted ms-2">?</a>
    </div>

    <!-- Lang (order 2 на моб, order 3 на десктопе) -->
    <div class="d-inline-flex align-items-center lang-switcher order-2 order-sm-3 mb-2 mb-sm-0">
              <a class="btn btn-sm btn-outline-secondary rounded-pill text-decoration-none" href="#" onclick="setLanguage('pi'); return false;">pi</a>
      <span class="btn btn-sm btn-primary rounded-pill ms-1">en</span>
      <a class="btn btn-sm btn-outline-secondary rounded-pill text-decoration-none ms-1" href="#" onclick="setLanguage('ru'); return false;">ru</a>

    </div>

    <!-- Form (order 3 на моб, order 2 на десктопе) -->
<form id="slugForm" class="d-flex align-items-center flex-nowrap order-3 order-sm-2 mx-auto flex-grow-0" onsubmit="return goToSlug();" style="min-width: 140px; max-width: 250px;">
  <input type="search" class="form-control form-control-sm rounded-pill me-1 flex-grow-1" 
         id="paliauto" name="q" value="<?= htmlspecialchars($slug) ?>" 
         placeholder="e.g. an3.76" style="min-width: 100px;" autofocus>
  <button type="submit" class="btn btn-sm btn-outline-secondary rounded-circle p-1 flex-shrink-0">
    Go
  </button>
</form>


  </div>
</div>

<div class="text-end text-muted small mt-2">
  <?= $sourceInfo ?>
</div>
<!-- htmlspecialchars($content) -->


      <div class="text-content mt-3 pli-lang" id="voiceTextContent" lang="pi"><?= $content ?></div>

  <script src="/assets/js/dark-mode-switch/dark-mode-switch.js"></script>

  <script>
    function goToSlug() {
    const slug = document.getElementById('paliauto').value.trim();
    if (!slug) return false;

    const lang = detectLanguage();
    const url = new URL(window.location.href);

    // Обновляем параметры запроса
    url.searchParams.set('q', slug);

    if (lang === 'pi') {
        url.searchParams.set('type', 'pali');
    } else {
        url.searchParams.set('type', 'trn');
    }

    // Обновляем URL
    window.location.href = url.toString();
    return false; // не отправлять форму
}

  </script>
  <script src="/assets/js/autopali.js" defer></script>
	  <script src="/assets/js/smoothScroll.js" defer></script>
      <script src="/assets/js/paliLookup.js"></script>
      <script src="/assets/js/settings.js"></script>
<!--      <script src="https://code.responsivevoice.org/responsivevoice.js?key=X8U4dR8x"></script> -->

</body>
</html>
