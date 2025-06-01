#!/bin/bash

# Файл, от которого сравниваем время изменения
REFERENCE_FILE="assets/texts/lastupdate_state_file"

# Проверяем, существует ли он
if [ ! -f "$REFERENCE_FILE" ]; then
newer=""
else
echo "newer case"
newer="-newer $REFERENCE_FILE"
fi

for i in ` find assets/texts/sutta/ -name "*.json" $newer | grep -iE "(ru-o.json|experiment|progres)"  | awk -F'/' '{print $NF}' | awk -F'_' '{print $1}' | sort -V`; 
do  
echo $i
#grep level5 read.php | grep "$i\""  ; 
sed -i '/class="level5"/ { /href=.*?q='$i'"/ { /<?php echo \$ifRuLitTrn;?>/! s/<\/span>/ <?php echo \$ifRuLitTrn;?><\/span>/; } }' read.php
done 
 

