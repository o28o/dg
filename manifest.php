<?php
// Включим буферизацию вывода, чтобы избежать ошибок с заголовками     "orientation" => "any",
ob_start();
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$base_path = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/';
$base_url = "$scheme://$host$base_path";

// Получаем URL, с которого устанавливается PWA (с проверкой на существование)
$referer = $_SERVER['HTTP_REFERER'] ?? $base_url;
$referer_path = parse_url($referer, PHP_URL_PATH) ?? '/';
$query_string = parse_url($referer, PHP_URL_QUERY) ?? '';

// Определяем язык (русский если есть /ru/ в пути или путь точно /ru)
$is_russian = (strpos($referer_path, '/ru/') !== false) || ($referer_path === '/ru');

// Устанавливаем $mainpagenoslash в зависимости от языка
$mainpagenoslash = $is_russian ? '/ru' : '';

// Формируем start_url в зависимости от пути установки
if (strpos($referer_path, '/read.php') !== false) {
    // Для read.php сохраняем полный путь
    $start_url = $is_russian 
        ? "/ru/read.php?source=pwa" 
        : "/read.php?source=pwa";
} elseif ($is_russian) {
    // Для русского раздела
    $start_url = "/ru/?source=pwa";
} else {
    // Для всех остальных случаев (английский)
    $start_url = "/?source=pwa";
}

// Добавляем оригинальные query параметры (если есть)
if (!empty($query_string)) {
    $start_url .= (strpos($start_url, '?') === false ? '?' : '&') . $query_string;
}

// Устанавливаем короткое имя и имя в зависимости от хоста
if (preg_match('/^(localhost|127\.\d+\.\d+\.\d+)$/', parse_url($base_url, PHP_URL_HOST))) {
    $short_name = "DG Offline";
    $name = "DG Offline";
} else {
    $short_name = "Dhamma.Gift";
    $name = "Dhamma.Gift";
}

// Очищаем буфер и устанавливаем заголовок
ob_end_clean();
header('Content-Type: application/json');

echo json_encode([
    "name" => $name,
    "short_name" => $short_name,
    "description" => "Sutta & Vinaya Search. Read. Multi-Tool.",
    "id" => "DG",
    "lang" => $is_russian ? "ru" : "en",
    "handle_links" => "auto",
    "launch_handler" => [
        "client_mode" => "focus-existing"
    ],
    "icons" => [
        [
            "src" => "/assets/img/pwa-bold-monocolor-192.png",
            "type" => "image/png",
            "sizes" => "192x192"
        ],
        [
            "src" => "/assets/img/pwa-bold-monocolor-512.png",
            "type" => "image/png",
            "sizes" => "512x512"
        ]
    ],
    "screenshots" => [
        [
            "src" => "/assets/img/android/1.jpg",
            "type" => "image/jpeg",
            "sizes" => "1080x1920",
            "label" => "Main"
        ],
        [
            "src" => "/assets/img/android/2.jpg",
            "type" => "image/jpeg",
            "sizes" => "1080x1920",
            "label" => "Flexible Tables"
        ],
        [
            "src" => "/assets/img/android/3.jpg",
            "type" => "image/jpeg",
            "sizes" => "1080x1920",
            "label" => "Autocomplete"
        ],
        [
            "src" => "/assets/img/android/4.jpg",
            "type" => "image/jpeg",
            "sizes" => "1080x1920",
            "label" => "Share to Search"
        ],
        [
            "src" => "/assets/img/android/5.jpg",
            "type" => "image/jpeg",
            "sizes" => "1080x1920",
            "label" => "Dhamma.Gift Read"
        ],    
        [
            "src" => "/assets/img/android/6.jpg",
            "type" => "image/jpeg",
            "sizes" => "1080x1920",
            "label" => "shortcuts"
        ],  
        [
            "src" => "/assets/img/android/7.jpg",
            "type" => "image/jpeg",
            "sizes" => "1080x1920",
            "label" => "Build-in Pali Dictionary"
        ],
        [
            "src" => "/assets/img/android/8.jpg",
            "type" => "image/jpeg",
            "sizes" => "1080x1920",
            "label" => "Dhamma Multi-Tool"
        ]
    ],
    "categories" => [
        "education",
        "books",
        "spirituality"
    ],
    "dir" => "ltr", 
    "iarc_rating_id" => "e",
    "prefer_related_applications" => false,
    "related_applications" => [],
    "scope_extensions" => [
        ["origin" => "*.dhamma.gift.com"],
        ["origin" => "dict.dhamma.gift"],
        ["origin" => "*.dict.dhamma.gift"]
    ],
    "start_url" => $start_url,
    "scope" => "/",
    "display" => "minimal-ui",
    "background_color" => "#2E3E50",
    "theme_color" => "#000000",
    "share_target" => [
        "action" => $mainpagenoslash . "/",
        "method" => "GET",
         "enctype" => "application/x-www-form-urlencoded",
        "params" => [
            "text" => "q"
        ]
    ],
    "shortcuts" => [
        [
            "name" => "DG Read",
            "url" => $mainpagenoslash . "/read.php",
            "icons" => [
                [
                    "src" => "/assets/img/maniIcon.png",
                    "type" => "image/png",
                    "sizes" => "192x192"
                ]
            ]
        ],    
        [
            "name" => "Dict.Dhamma.Gift",
            "url" => $mainpagenoslash . "/assets/openDDG.html",
            "icons" => [
                [
                    "src" => "/assets/svg/dpd-logo-dark.svg",
                    "type" => "image/svg+xml",
                    "sizes" => "192x192"
                ]
            ]
        ],
        [
            "name" => "Bhikkhu Patimokkha",
            "url" => $mainpagenoslash . "/pm.php?expand=true",
            "icons" => [
                [
                    "src" => "/assets/img/monkIcon.png",
                    "type" => "image/png",
                    "sizes" => "192x192"
                ]
            ]
        ],
        [
            "name" => "Bhikkhuni Patimokkha",
            "url" => $mainpagenoslash . "/bipm.php?expand=true",
            "icons" => [
                [
                    "src" => "/assets/img/nunIcon.png",
                    "type" => "image/png",
                    "sizes" => "192x192"
                ]
            ]
        ],
        [
            "name" => "Aksharamukha.com",
            "url" => $mainpagenoslash . "/assets/openDDG.html?url=https://www.aksharamukha.com/converter",
            "icons" => [
                [
                    "src" => "/assets/img/maniIcon.png",
                    "type" => "image/png",
                    "sizes" => "192x192"
                ]
            ]
        ],
                [
            "name" => "Dharmamitra.org",
            "url" => $mainpagenoslash . "/assets/openDDG.html?url=https://dharmamitra.org/",
            "icons" => [
                [
                    "src" => "/assets/img/maniIcon.png",
                    "type" => "image/png",
                    "sizes" => "192x192"
                ]
            ]
        ]
    ]
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
