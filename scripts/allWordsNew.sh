#!/bin/bash -i

#core
cd /data/data/com.termux/files/usr/share/apache2/default-site/htdocs/suttacentral.net/sc-data/sc_bilara_data/root/pli/ms/

find sutta/mn sutta/sn sutta/dn sutta/an sutta/kn/thig sutta/kn/thag sutta/kn/dhp sutta/kn/ud sutta/kn/snp sutta/kn/iti vinaya/pli-tv-bu-vb/ vinaya/pli-tv-bi-vb/ -type f -name "*.json" | xargs cat | cj | tr " " "\n" | sed -E 's/^[[:punct:]]+//; s/[[:punct:]]+$//' | grep -v "^$" | sed 's/’”/”/g' | sort | uniq -c > ~/fdg/Sutta4NpartKNVinayaVibhangaAllWords.txt

#sutta only (without vinaya)
find sutta/mn sutta/sn sutta/dn sutta/an sutta/kn/thig sutta/kn/thag sutta/kn/dhp sutta/kn/ud sutta/kn/snp sutta/kn/iti -type f -name "*.json" | xargs cat | cj | tr " " "\n" | sed -E 's/^[[:punct:]]+//; s/[[:punct:]]+$//' | grep -v "^$" | sed 's/’”/”/g' | sort | uniq -c > ~/fdg/Sutta4NpartKNAllWords.txt

#variants
cd /data/data/com.termux/files/usr/share/apache2/default-site/htdocs/suttacentral.net/sc-data/sc_bilara_data/variant/pli/ms

find sutta/mn sutta/sn sutta/dn sutta/an sutta/kn/thig sutta/kn/thag sutta/kn/dhp sutta/kn/ud sutta/kn/snp sutta/kn/iti vinaya/pli-tv-bu-vb/ vinaya/pli-tv-bi-vb/ -type f -name "*.json" | xargs cat | cj | tr " " "\n" | sed -E 's/^[[:punct:]]+//; s/[[:punct:]]+$//' | grep -v "^$" | sed 's/’”/”/g' | sort | uniq -c > ~/fdg/Sutta4NpartKNVinayaVibhangaVars.txt

#sutta only (without vinaya)
find sutta/mn sutta/sn sutta/dn sutta/an sutta/kn/thig sutta/kn/thag sutta/kn/dhp sutta/kn/ud sutta/kn/snp sutta/kn/iti -type f -name "*.json" | xargs cat | cj | tr " " "\n" | sed -E 's/^[[:punct:]]+//; s/[[:punct:]]+$//' | grep -v "^$" | sed 's/’”/”/g' | sort | uniq -c > ~/fdg/Sutta4NpartKNVars.txt

exit 0

find thig thag dhp ud snp iti  -type f -name "*.json" | xargs cat | cj | tr " " "\n" | sed -E 's/^[[:punct:]]+//; s/[[:punct:]]+$//' | grep -v "^$" | sed 's/’”/”/g' | sort | uniq -c > ~/fdg/allWordsKNPartUdItiSnpThigThagDhp.txt

#fresh 19 05 2025
cd /data/data/com.termux/files/usr/share/apache2/default-site/htdocs/suttacentral.net/sc-data/sc_bilara_data/root/pli/ms
find sutta/mn sutta/sn sutta/dn sutta/an sutta/kn/dhp sutta/kn/ud sutta/kn/snp sutta/kn/iti vinaya/ -type f -name "*.json" | xargs cat | cj | python3 -c "import sys; print(sys.stdin.read().lower())" | sed 's@—@ @g' | tr " " "\n" |  sed -E 's/^[[:punct:]]+//; s/[[:punct:]]+$//' | grep -v "^$" | sed "s/[‘’“”]/”/g" | sed 's@””@”@g' | sed 's@””@”@g' | sort | uniq > ~/fdg/assets/texts/tmp.txt
cd  ~/fdg/assets/texts

file=cuttedWordsForBot.txt
output=sutta_words2.txt
sed -e 's/ā/a`/g' -e 's/ī/i`/g' -e 's/ū/u`/g' -e 's/ṁ/m`/g' -e 's/ñ/n`/g' -e 's/ṅ/n^/g' -e 's/ṇ/n_/g' -e 's/ṭ/t`/g' -e 's/ḍ/d`/g' -e 's/ḷ/l`/g' $file | sort | sed -e 's/a`/ā/g' -e 's/i`/ī/g' -e 's/u`/ū/g' -e 's/m`/ṁ/g' -e 's/n`/ñ/g' -e 's/n\^/ṅ/g' -e 's/n_/ṇ/g' -e 's/t`/ṭ/g' -e 's/d`/ḍ/g' -e 's/l`/ḷ/g' > $output

cat headForSuttaWords.txt sutta_words2.txt indexesforac.txt > sutta_words.txt



rm tmp.txt




#-c | awk '{ print $2, $1}' 

ababo 3
ababā 3
abaddho 3