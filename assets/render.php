<?php
// Параметры запроса
$slug = $_GET['q'] ?? '';
$type = $_GET['type'] ?? 'pali'; // 'pali' или 'trn' (translation)

// Определяем язык по URL (новая логика)
$is_ru_url = strpos($_SERVER['REQUEST_URI'], '/ru/') !== false;

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
    // Старая логика (для демонстрации)
    if (!in_array($type, ['pali', 'ru', 'en'])) {
        if ($type === 'trn') {
            return "Это перевод для: $slug";
        }
        return $type === 'pali' ? "Это палийский текст для: $slug" : "Контент для: $slug";
    }

    // Новая логика загрузки из файлов
    if ($type === 'pali') {
        //$cmd = "find ../suttacentral.net/sc-data/sc_bilara_data/root/pli/ms/ -name \"${slug}_*\" -print -quit";
        $cmd = "find ../assets/texts/devanagari/root/pli/ms/ -name \"${slug}_*\" -print -quit";
        $file = trim(shell_exec($cmd));
        return $file ? shell_exec("cat ".escapeshellarg($file)." | jq -r '.[]'") : "Pali text not found for: $slug";
    }
    elseif ($type === 'ru') {
        $cmd = "find ../assets/texts/sutta ../assets/texts/vinaya -name \"${slug}_*\" -print -quit";
        $file = trim(shell_exec($cmd));
        return $file ? shell_exec("cat ".escapeshellarg($file)." | jq -r '.[]'") : "Russian translation not found for: $slug";
    }
    else { // en
        $cmd = "find ../suttacentral.net/sc-data/sc_bilara_data/translation/en/ -name \"${slug}_*\" -print -quit";
        $file = trim(shell_exec($cmd));
        return $file ? shell_exec("cat ".escapeshellarg($file)." | jq -r '.[]'") : "English translation not found for: $slug";
    }
}

// Если передан slug, загружаем контент автоматически
$content = $slug ? loadContent($slug, $content_type) : htmlspecialchars($_POST['content'] ?? '');
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
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
  <div class="text-content"><?= htmlspecialchars($content) ?></div>
</body>
</html>

