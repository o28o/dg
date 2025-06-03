<?php
// Параметры запроса
$slug = $_GET['q'] ?? '';
$type = $_GET['type'] ?? ''; // 'pali' или 'trn' (translation)
$lang = ($type === 'pali') ? 'pi' : 'ru';

// Заголовок страницы
$title = htmlspecialchars(
    $slug 
    ? ucfirst(str_replace(['-', '_'], ' ', $slug)) . ' (' . ($type === 'pali' ? 'Pali' : 'Translation') . ')'
    : 'TTS Page'
);

// Загрузка контента по slug (замените на вашу логику)
function loadContent($slug, $type) {
    // Пример: загрузка из базы данных или файлов
    // Здесь должна быть ваша реализация!
    if ($type === 'pali') {
        return "Это палийский текст для: $slug";
    } else {
        return "Это перевод для: $slug";
    }
}

// Если передан slug, загружаем контент автоматически
$content = $slug ? loadContent($slug, $type) : htmlspecialchars($_POST['content'] ?? '');
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


