#!/bin/bash

# Файл, от которого сравниваем время изменения
REFERENCE_FILE="assets/texts/lastupdate_readPHP_file"

# Проверяем, существует ли он
if [ ! -f "$REFERENCE_FILE" ]; then
newer=""
else
#echo "newer case"
newer="-newer $REFERENCE_FILE"
fi

for i in ` find assets/texts/sutta/ -name "*.json" $newer | grep -iE "(ru-o.json|experiment|progres)"  | awk -F'/' '{print $NF}' | awk -F'_' '{print $1}' | sort -V`; 
do  
echo $i

find "assets/texts/sutta" -type f \
  -name "${i}_*" | \
  grep -v "${i}_.*\(ru-o\.json\|experiment\|progres\)" | \
  xargs -r mv -t "assets/texts/svEtc/automatic/"
  
#grep level5 read.php | grep "$i\""  ; 
sed -i '/class="level5"/ { /href=.*?q='$i'"/ { /<?php echo \$ifRuLitTrn;?>/! s/<\/span>/ <?php echo \$ifRuLitTrn;?><\/span>/; } }' read.php



 if [[ $? != 0 ]]; then
    echo "</br>error in $i"
    error_found=1  # Устанавливаем флаг ошибки
  fi
done

echo -n "new texts added to read.php" 
find assets/texts/sutta/ -name "*.json" $newer | grep -iE "(ru-o.json|experiment|progres)"  | awk -F'/' '{print $NF}' | awk -F'_' '{print $1}' | sort -V
echo 

# Если не было ошибок, создаем/обновляем state_file
if [[ $error_found -eq 0 ]]; then
  touch $REFERENCE_FILE
fi



