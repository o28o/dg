<?php
ob_start();
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$base_path = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/';
$base_url = "$scheme://$host$base_path";

$referer = $_SERVER['HTTP_REFERER'] ?? $base_url;
$referer_path = parse_url($referer, PHP_URL_PATH) ?? '/';
$query_string = parse_url($referer, PHP_URL_QUERY) ?? '';

$is_russian = (preg_match('#^/ru(/|$)#', $referer_path));

$main_path = $is_russian ? '/ru' : '';

if (strpos($referer_path, '/read.php') !== false) {
    $start_url = $main_path . '/read.php?source=pwa';
} else {
    $start_url = $main_path . '/?source=pwa';
}

if (!empty($query_string)) {
    $start_url .= (strpos($start_url, '?') === false ? '?' : '&') . $query_string;
}

$short_name = (preg_match('/^(localhost|127\.\d+\.\d+\.\d+)$/', $host)) ? "DG Offline" : "Dhamma.Gift";
$name = $short_name;

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
    "screenshots" => [...], // как у тебя
    "categories" => ["education", "books", "spirituality"],
    "dir" => "ltr",
    "iarc_rating_id" => "e",
    "prefer_related_applications" => false,
    "related_applications" => [],
    "scope_extensions" => [...], 
    "start_url" => $start_url,
    "scope" => $main_path . "/", // корректный scope
    "display" => "browser", // ✔️ stable; standalone можно при необходимости
    "background_color" => "#2E3E50",
    "theme_color" => "#2E3E50",
    "share_target" => [
        "action" => $main_path . "/",
        "method" => "GET",
        "enctype" => "application/x-www-form-urlencoded",
        "params" => [
            "text" => "q"
        ]
    ],
    "shortcuts" => [
        [
            "name" => "DG Read",
            "url" => $main_path . "/read.php",
            "icons" => [[
                "src" => "/assets/img/maniIcon.png",
                "type" => "image/png",
                "sizes" => "192x192"
            ]]
        ],
        [
            "name" => "Dict.Dhamma.Gift",
            "url" => $main_path . "/assets/openDDG.html",
            "icons" => [[
                "src" => "/assets/svg/dpd-logo-dark.svg",
                "type" => "image/svg+xml",
                "sizes" => "192x192"
            ]]
        ],
        [
            "name" => "Bhikkhu Patimokkha",
            "url" => $main_path . "/pm.php?expand=true",
            "icons" => [[
                "src" => "/assets/img/monkIcon.png",
                "type" => "image/png",
                "sizes" => "192x192"
            ]]
        ],
        [
            "name" => "Bhikkhuni Patimokkha",
            "url" => $main_path . "/bipm.php?expand=true",
            "icons" => [[
                "src" => "/assets/img/nunIcon.png",
                "type" => "image/png",
                "sizes" => "192x192"
            ]]
        ],
        [
            "name" => "Aksharamukha.com",
            "url" => $main_path . "/assets/openDDG.html?url=https://www.aksharamukha.com/converter",
            "icons" => [[
                "src" => "/assets/img/maniIcon.png",
                "type" => "image/png",
                "sizes" => "192x192"
            ]]
        ],
        [
            "name" => "Dharmamitra.org",
            "url" => $main_path . "/assets/openDDG.html?url=https://dharmamitra.org/",
            "icons" => [[
                "src" => "/assets/img/maniIcon.png",
                "type" => "image/png",
                "sizes" => "192x192"
            ]]
        ]
    ]
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
