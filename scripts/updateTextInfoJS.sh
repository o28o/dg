# Полная команда для создания массива
mapfile -t keys_array < <(
  find assets/texts/sutta/ -name "*.json" \
    | grep -iE "(ru-o.json|experiment|progres)" \
    | awk -F'/' '{print $NF}' \
    | awk -F'_' '{print $1}' \
    | sort -V
)

# Вывод в формате Bash массива
declare -p keys_array

# ИЛИ вывод в формате JavaScript массива
printf "[\n"
printf "  \"%s\"\n" "${keys_array[@]}"
printf "]\n"
