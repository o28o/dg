for i in ` find assets/texts/sutta/ -name "*.json" | grep -iE "(ru-o.json|experiment|progres)"  | awk -F'/' '{print $NF}' | awk -F'_' '{print $1}' | sort -V`; 
do  
#grep level5 read.php | grep "$i\""  ; 
sed -i '/class="level5"/ { /href=.*?q='$i'"/ { /<?php echo \$ifRuLitTrn;?>/! s/<\/span>/<?php echo \$ifRuLitTrn;?><\/span>/; } }' read.php
done 
 

