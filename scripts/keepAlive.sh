#!/bin/bash

# Текущая дата и время
timestamp=$(date "+%Y-%m-%d %H:%M:%S")

# Попытка взять слово из файла, если он существует и не пустой
cd /var/www/html/  > /dev/null 2>&1
cd /data/data/com.termux/files/usr/share/apache2/default-site/htdocs > /dev/null 2>&1

words_file="./assets/texts/sutta_words_forbot.txt"
if [[ -s "$words_file" ]]; then
    mapfile -t file_terms < "$words_file"
    term="$(echo "${file_terms[RANDOM % ${#file_terms[@]}]}" | tr -d '\r' | xargs)"
else
    # Массив терминов по умолчанию
    terms=("bhagavato" "dhamma" "dukkha" "adhivacanasamphasso" "kho" "kacchapo")
    term="${terms[RANDOM % ${#terms[@]}]}"
fi

# Функция URL-кодирования
urlencode() {
       jq -nr --arg input "$1" '$input|@uri'
   }

# Функция проверки endpoint
check_endpoint() {
    local lang=$1
    local path=$2
    local base_url=$3
    local encoded_term=$(urlencode "$term")
    local url="${base_url}${path}?q=${encoded_term}"

    local start_time=$(date +%s%3N)
    local content=$(curl --max-time 30 -s "$url")
    local end_time=$(date +%s%3N)

    local response_time_ms=$((end_time - start_time))
    local response_time_s=$(echo "scale=3; $response_time_ms / 1000" | bc)

    local size_bytes=$(echo "$content" | wc -c)
    local size_kb=$(echo "scale=2; $size_bytes / 1024" | bc)

    if echo "$content" | grep -q "</body>"; then
        status="OK"
    else
        status="FAIL"
    fi

    echo "$timestamp $lang $status ${response_time_s}s ${size_kb}kb $term $url" | tee -a /tmp/keepalive.log 2>/dev/null
}

# Определение базового URL
if uname -a | grep -qi "android"; then
  BASE_URL="https://dict.dhamma.gift"
elif grep -qi "ubuntu" /proc/version; then
  BASE_URL="http://localhost:8880"
else
  BASE_URL="https://dict.dhamma.gift"
fi

# Проверка русского endpoint
check_endpoint "RU" "/ru/search_html" "$BASE_URL"
#check_endpoint "RU" "/ru/search_html" "https://dpdict.net"

# Проверка английского endpoint
check_endpoint "EN" "/search_html" "$BASE_URL"
#check_endpoint "EN" "/search_html" "https://dpdict.net"


cd -  > /dev/null 2>&1
