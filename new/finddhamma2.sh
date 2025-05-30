#!/bin/bash -i
start=`date +%s`
#set -x 
#set +x
#trap read debug
#sutta ; grep -ril "<" | xargs | sed -i -e  "s@<b>@@g" -e  "s@</b>@@g"
#export LC_ALL=en_US
##############################
# ‘Why don’t I gather grass, 
# sticks, branches, and leaves 
# and make a raft? Riding on the raft
# and paddling with my hands and feet,
# I can safely reach the far shore.
########## sn35.238 ##########
source ./config/script_config.sh --source-only
export LANG=ru_RU.utf8
history="$apachesitepath/result/.history"

function cleanupTempFiles {
rm $tmpdir/${prefix}initrun* 2>/dev/null
rm $tmpdir/${prefix}afterawk 2>/dev/null
rm $tmpdir/${prefix}cmnd* 2>/dev/null
rm $tmpdir/${prefix}counts 2>/dev/null
rm $tmpdir/${prefix}finalhtml 2>/dev/null
rm $tmpdir/${prefix}finalraw 2>/dev/null
rm $tmpdir/${prefix}readyforawk 2>/dev/null
rm $tmpdir/${prefix}words 2>/dev/null
rm $tmpdir/${prefix}wordsAggregatedByTexts 2>/dev/null
}
cleanupTempFiles
args="$@"

if [[ "$@" == *"-nbg"* ]]; then
rand=`echo $@ | awk -F'-nbg-' '{print $2}' | awk '{print $1}' `
else
rand=`echo $RANDOM | md5sum | head -c 5`
fi 
prefix=tmp${rand}-
tmphtml=search-${rand}.html
excludetext='{ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,vv,thag,thig,dhp}'
mkdir $output 2>/dev/null
cd $output 
dateforhist=`date +%d-%m-%Y`

function writeToTmpHtml {
  
if [ "$linescount" -ge 200 ]; then
skiprounds=1
fi
if [ "$totaltexts" -le 50 ]; then
    timeout=$(awk "BEGIN {printf \"%.2f\", $totaltexts / $multiplier - $skiprounds }" )
  timeout=`echo $timeout | sed 's@\..*@@'`
elif [ "$totaltexts" -ge 51 ]; then
    timeout=$defaultTimeout
fi

if [ "$round" -ge $skiprounds ]; then
#cp $table $tmphtml
sed -n '/<table/q;p' $table > $tmphtml
inProgressresponse >> $tmphtml
sed -n '/<table/,$p' $table  >> $tmphtml 
echo "</tbody>
 </table>"  >> $tmphtml
 
 echo "
<script>function waitForHtml() {
    if (document.readyState !== 'complete' || !document.body.innerHTML.includes('</html>')) {
        setTimeout(waitForHtml, 1000); // Повторяем через 1 секунду
    } else {
        // Здесь можете выполнить действия, которые должны произойти после того, как слово '</html>' обнаружено
        console.log('Слово </html> обнаружено. Продолжаем загрузку страницы.');
    }
}

document.addEventListener('DOMContentLoaded', waitForHtml);
   
  document.addEventListener('DOMContentLoaded', function() {
    var refreshLink = document.getElementById('refreshLink');

    refreshLink.addEventListener('click', function(event) {
      event.preventDefault(); 
      location.reload();
    });
  });
    
</script>" >> $tmphtml
sed -i '/<table id="pali"/s@id="pali"@id="temporary-'$rand'"@g' $tmphtml
sed -i '/<button.*>Words</s@type="button">@type="button" disabled>@g' $tmphtml
sed -i 's@TitletoReplace@'$round' of '$totaltexts' done for '$pattern'. Auto-refresh '$timeout' sec @g' $tmphtml
echo "<script>" >> $tmphtml
cat $apachesitepath/assets/js/timer.js | sed '/time_in_seconds = 60;/s/60/'${timeout}'/' >> $tmphtml
echo "</script>" >> $tmphtml
echo "<script $fontawesomejs></script>" >> $tmphtml
cat $templatefolder/Footer2.html | sed "s@('#pali')@('#temporary-$rand')@g"  | sed "/stateSave/s@true@false@g" | sed 's@</tbody>@@g' | sed 's@</table>@@g' | sed 's@WORDSLINKVAR@#not-ready@g' | sed 's@MAINLINKVAR@'${mainpagebase}'@g' | sed 's@READLINKVAR@'${pagelang}'/read.php@g' | sed 's@/history.php@'${mainpagebasehistory}/history.php'@g' >> $tmphtml
fi
((round++))
}
#setInterval(function() {   location.reload();   }, ${timeout} * 1000);
if [[ "$@" == *"-oru"* ]]; then
pagelang="/ru"
mainpagebase="/ru"
mainpagebasehistory=$mainpagebase
outfnlang=-ru
langforhist="/Ru"
defaultlang='lang=pli-rus'
excluderesponse="исключая"
function bgswitch {
 # removefilenames
	echo "Найдено $linescount строк с $pattern<br> 
	Ресурсы сервера ограничены и запрос нельзя обработать.<br>
	Варианты:<br>
	1. Попробуйте опции <strong>Определения</strong> или <strong>Сравнения</strong>, чтобы сузить поиск<br>
	2. Выберите более специфическое слово из подсказок для Пали<br>
	3. Скачайте необработанные данные <a class=\"outlink\" href="/result/${basefile}">здесь</a>
	"
}
#
function reverseyoinpattern {
pattern="`echo $pattern | sed 's/\[ёе\]/е/g' | sed 's/\[ṅṁṃ\]/'$initialNorM'/g'`"
}  

function GeneralError {
  echo "Ожидайте результат в истории. <a href='./result/$tmphtml'>Следить</a>"
}

function capitalized {
echo "$pattern" | sed 's/[[:lower:]]/\U&/'
}

function emptypattern {
   echo "Что искать?"
}

function inProgressresponse {
  
  echo "
<div class='alert alert-warning alert-dismissible fade show' role='alert' id='successAlert'>

   <strong>Загружаю...</strong> $round из $totaltexts текстов с $pattern обработано. Авто-обновление через <div id='countdown'></div>
      <button class='alert-link btn btn-link' id='resume'><i class='fa-solid fa-play'></i></button>
   <button class='alert-link btn btn-link' id='pause'><i class='fa-solid fa-pause'></i></button>
   <button class='alert-link btn btn-link' id='refreshLink'><i class='fa-solid fa-arrow-rotate-right'></i></button>

<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>" 
}
#$timeout секунд.  &nbsp;
#<div class='spinner-border spinner-border-sm' role=status>
#<span class=visually-hidden>Loading...</span>
#</div>
function OKresponse {
  echo "`echo "$pattern" | sed 's/[[:lower:]]/\U&/'`${addtotitleifexclude} $textsqnty в $fortitle $language "
}

function Erresponse {
     echo "${pattern} нет в $fortitle $language<br>"
     
}

function Clarification {
     echo "в SN, DN, MN и AN. Попробуйте другие <br>
     настройки +KN, Vin и др."
}

function wordsresponse {
php -r "print(\"<a class="outlink" href="./result/${tempfilewords}">Слова</a> и \");"  
}

function quoteresponse {
	php -r "print(\"<a class="outlink" href="./result/${table}">Цитаты</a><br>\n\");"
	
}
function minlengtherror {
echo "Слишком коротко. Мин $minlength символа"
}

else #eng
pagelang=
mainpagebase="/"
mainpagebasehistory=""
defaultlang='lang=pli-eng'
langforhist="/En"
excluderesponse="excluding"
function bgswitch {
 # removefilenames
	echo "Found $linescount lines with $pattern<br> 
	Server resources are limited.<br>
	Solutions:<br>
	1. Try <strong>Definitions</strong> or <strong>Similies</strong> options, it'll narrow down results<br>
	2. Choose more specific word from Pali autocomplete<br>
	3. Download raw data <a class=\"outlink\" href="/result/${basefile}">here</a>
	"
}

function emptypattern {
   echo "Empty pattern"
}

function GeneralError {
  echo "Check result in History. <a href='./result/$tmphtml'>Watch</a>"
}
function inProgressresponse {
  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
  <strong>Loading...</strong> $round of $totaltexts records with $pattern proccessed. Auto-refresh in <div id='countdown'></div>
      <button class='alert-link btn btn-link' id='resume'><i class='fa-solid fa-play'></i></button>
   <button class='alert-link btn btn-link' id='pause'><i class='fa-solid fa-pause'></i></button>
   <button class='alert-link btn btn-link' id='refreshLink'><i class='fa-solid fa-arrow-rotate-right'></i></button> 
  
   <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
   </div>"
}

function OKresponse {
echo "`echo "$pattern" | sed 's/[[:lower:]]/\U&/'`${addtotitleifexclude} $textsqnty in $fortitle $language "
}

function Erresponse {
     echo "${pattern} not in $fortitle $language<br>"
}

function Clarification {
     echo "in SN, DN, MN & AN<br>
     Try +KN, Vin options."
}

function wordsresponse {
php -r "print(\"<a class="outlink" href="./result/${tempfilewords}">Words</a> and \");"
}

function quoteresponse {
php -r "print(\"<a class="outlink" href="./result/${table}">Quotes</a><br>\n\");"

}

function minlengtherror {
echo Too short. Min is $minlength
}

fi

function grepbrief {
	
	awk -v ptn="$pattern" -v cnt1=$wbefore -v cnt2=$wafter '
{ for (i=1;i<=NF;i++)
      if ($i ~ ptn) {
         sep=""
         for (j=i-cnt1;j<=i+cnt2;j++) {
             if (j<1 || j>NF) continue
             printf "%s%s", sep ,$j
             sep=OFS
         }
         print ""
      }
}'
}

function getSamyuttaname {
samyuttanumer=`echo $suttanumber | awk -F'.' '{print $1}'`

if [[ $samyuttanumer == "sn1" ]]; then
  samyuttaname="Devatāsaṁyuttaṁ"
elif [[ $samyuttanumer == "sn2" ]]; then
  samyuttaname="Devaputtasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn3" ]]; then
  samyuttaname="Kosalasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn4" ]]; then
  samyuttaname="Mārasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn5" ]]; then
  samyuttaname="Bhikkhunīsaṁyuttaṁ"
elif [[ $samyuttanumer == "sn6" ]]; then
  samyuttaname="Brahmasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn7" ]]; then
  samyuttaname="Brāhmaṇasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn8" ]]; then
  samyuttaname="Vaṅgīsasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn9" ]]; then
  samyuttaname="Vanasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn10" ]]; then
  samyuttaname="Yakkhasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn11" ]]; then
  samyuttaname="Sakkasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn12" ]]; then
  samyuttaname="Nidānasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn13" ]]; then
  samyuttaname="Abhisamayasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn14" ]]; then
  samyuttaname="Dhātusaṁyuttaṁ"
elif [[ $samyuttanumer == "sn15" ]]; then
  samyuttaname="Anamataggasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn16" ]]; then
  samyuttaname="Kassapasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn17" ]]; then
  samyuttaname="Lābhasakkārasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn18" ]]; then
  samyuttaname="Rāhulasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn19" ]]; then
  samyuttaname="Lakkhaṇasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn20" ]]; then
  samyuttaname="Opammasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn21" ]]; then
  samyuttaname="Bhikkhusaṁyuttaṁ"
elif [[ $samyuttanumer == "sn22" ]]; then
  samyuttaname="Khandhasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn23" ]]; then
  samyuttaname="Rādhasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn24" ]]; then
  samyuttaname="Diṭṭhisaṁyuttaṁ"
elif [[ $samyuttanumer == "sn25" ]]; then
  samyuttaname="Okkantasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn26" ]]; then
  samyuttaname="Uppādasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn27" ]]; then
  samyuttaname="Kilesasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn28" ]]; then
  samyuttaname="Sāriputtasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn29" ]]; then
  samyuttaname="Nāgasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn30" ]]; then
  samyuttaname="Supaṇṇasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn31" ]]; then
  samyuttaname="Gandhabbakāyasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn32" ]]; then
  samyuttaname="Valāhakasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn33" ]]; then
  samyuttaname="Vacchagottasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn34" ]]; then
  samyuttaname="Jhānasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn35" ]]; then
  samyuttaname="Saḷāyatanasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn36" ]]; then
  samyuttaname="Vedanāsaṁyuttaṁ"
elif [[ $samyuttanumer == "sn37" ]]; then
  samyuttaname="Mātugāmasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn38" ]]; then
  samyuttaname="Jambukhādakasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn39" ]]; then
  samyuttaname="Sāmaṇḍakasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn40" ]]; then
  samyuttaname="Moggallānasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn41" ]]; then
  samyuttaname="Cittasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn42" ]]; then
  samyuttaname="Gāmaṇisaṁyuttaṁ"
elif [[ $samyuttanumer == "sn43" ]]; then
  samyuttaname="Asaṅkhatasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn44" ]]; then
  samyuttaname="Abyākatasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn45" ]]; then
  samyuttaname="Maggasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn46" ]]; then
  samyuttaname="Bojjhaṅgasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn47" ]]; then
  samyuttaname="Satipaṭṭhānasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn48" ]]; then
  samyuttaname="Indriyasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn49" ]]; then
  samyuttaname="Sammappadhānasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn50" ]]; then
  samyuttaname="Balasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn51" ]]; then
  samyuttaname="Iddhipādasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn52" ]]; then
  samyuttaname="Anuruddhasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn53" ]]; then
  samyuttaname="Jhānasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn54" ]]; then
  samyuttaname="Ānāpānasaṁyuttaṁ"
elif [[ $samyuttanumer == "sn55" ]]; then
  samyuttaname="Sotāpattisaṁyuttaṁ"
elif [[ $samyuttanumer == "sn56" ]]; then
  samyuttaname="Saccasaṁyuttaṁ"
fi
}
pattern="$@"

if [[ "$@" == *"-h"* ]]; then
    echo "
    without arguments will search in pali<br>
    materials as stored on Suttacentral.net in DN, MN, SN, AN.<br>
    <br>
    -pli - to search in Pali, same as without arguments (default option) <br>
    -def - find similes in Pali provided with standard text formulas <br>
    -sml - find similes in Pali provided with standard text formulas <br>
	-kn - include Khuddaka Nikaya selected books <br>
	-all - include all Khuddaka Nikaya books <br>
    -vin - to search in vinaya texts only <br>
    -abhi - to search in abhidhamma texts only <br>
    -laN X - search X and print N lines after match<br>
    -lbN X - search X and print N lines before match<br>    
    X -exc Y - search X exclude Y <br>
    -onl \"X|Y|...\"- find texts that contain all patterns only
    -ru - to search in Russian <br>
    -en - to search in English <br>
    -th - to search in Thai <br>
    -si - to search in Sinhala <br>
    -b - to search in tbw materials <br>
    -tru - to search in theravada.ru materials <br>
    -oru - output messages in sian<br>"
    exit 0
fi
#-nbg - no background <br>
if [[ "$@" == *"-la"* ]]; then
linesafter=`echo "$@" | sed 's@.*-la@@' | awk '{print $1}'` 
else
linesafter=0
fi

if [[ "$@" == *"-lb"* ]]; then
linesbefore=`echo "$@" | sed 's@.*-lb@@' | awk '{print $1}'` 
else 
linesbefore=0
fi

if [[ "$@" == *"-nm"* ]]; then
numbersmatches=`echo "$@" | sed 's@.*-nm@@' | awk '{print $1}'` 
#history=/dev/null
else
numbersmatches=
fi



if [[ "$pattern" =~ '/' || "$pattern" =~ '\' ]]
then
  #echo "yes"
  pattern=`echo "$pattern"| clearargs `
  else
  #echo "no /\\"
  pattern=`echo "$pattern"| awk '{print tolower($0)}' | clearargs `
fi

userpattern="$pattern"
escapedkeyword="$userpattern"
#echo escapedkeyword $escapedkeyword
patternForHighlight="`echo $pattern | sed 's@е@[её]@g' | sed 's@ṃ@[ṃṁ]@g' | sed -E 's/^[A-Za-z]{2,4}[0-9]{2,3}\.\*//g'| sed -E 's/^[A-Za-z]{2,4}[0-9]{2,3}.[0-9]{1,3}\.\*//g' | sed 's@^@(@g' | sed 's/$/)/g' | sed 's@,@@g'`"

if [[ "$pattern" == "" ]] ||  [[ "$pattern" == "-ru" ]] || [[ "$pattern" == "-en" ]] || [[ "$pattern" == "-th" ]] || [[ "$pattern" == "-si" ]] || [[ "$pattern" == "-oru" ]]  || [[ "$pattern" == "-nbg" ]] || [[ "$pattern" == "-ogr" ]] || [[ "$pattern" == "-oge" ]] || [[ "$pattern" == "-vin" ]] || [[ "$pattern" == "-all" ]] || [[ "$pattern" == "" ]] || [[ "$pattern" == "-kn" ]] || [[ "$pattern" == "-pli" ]] || [[ "$pattern" == "-def" ]] || [[ "$pattern" == "-sml" ]] || [[ "$pattern" == "-b" ]] || [[ "$pattern" == "-onl" ]] ||  [[ "$pattern" == "-tru" ]] || [[ "$pattern" == "-defall" ]] || [[ "$pattern" == "-nm5" ]] || [[ "$pattern" == "-nm10" ]] || [[ "$pattern" == "-conv" ]] 
then   
#emptypattern
   exit 3
fi
    

if   [ "${#pattern}" -lt "$minlength" ]
then
minlengtherror
exit 1 
fi

grepgenparam=E

#if you want to use this script for other languages, add blocks that are needed with your language which must be available on suttacentra.net
lookup=$suttapath/sc-data/sc_bilara_data

function clearsed {
sed 's/<p>/\n/g; s/<[^>]*>//g'  | sed  's/": "/ /g' | sed  's/"//1' | sed 's/",$//g' | sed 's/{//g' | sed 's/}//g'
}


vin=vinaya
abhi=abhidhamma
sutta=mutta
metaphorcountfile=$textinfofolder/metphrcount_sutta.txt
fortitle="4 Nikaya"
dirlocation=sutta
translator=sujato
fileprefix=_4nikaya
hwithtitle='<h1>'
searchIn="./sutta/sn ./sutta/mn ./sutta/an ./sutta/dn"
source="an,sn,mn,dn"
if [[ "$@" == *"-vin"* ]]; then
    vin=dummy
    sutta=sutta
	fortitle="Vinaya Vibhanga and Patimokkha"
	dirlocation=vinaya
	translator=brahmali
	vin="./vinaya/pli-tv-b*"
	searchIn="$vin"
    fileprefix=_vinayavbpm
    metaphorcountfile=$textinfofolder/metphrcount_vinaya.txt
	source="vn"


    
fi
if [[ "$@" == *"-abhi"* ]]; then
    abhi=dummy
    sutta=sutta
	fortitle=Abhidhamma
	dirlocation=abhidhamma
	translator=""
    fileprefix=_abhidhamma
hwithtitle='<h1>'
searchIn="./abhidhamma/sn"
source="abhi"    
    
    #echo search in abhidhamma
fi
 
 
 #case for am3.76 3.77 
 
 shopt -s extglob
if [[ "$pattern" == @(taṇh*|dhāt*|cetan*|patthan*|kamm*|khett*|viññāṇ*|bīj*|sneh*|phass*|majjh*|sibbin*|ant*) ]]; 
then
customtexts="|an3.7[67].*${modpattern}|${modpattern}.*dutiyo puriso|an6.61.*${modpattern}|an4.199.*${modpattern}"
fi

if [[ "$@" == *"-kn"* ]]; then

kn="./sutta/kn/ud ./sutta/kn/iti ./sutta/kn/dhp ./sutta/kn/thig ./sutta/kn/thag ./sutta/kn/snp"
searchIn="$searchIn $kn"
source="an,sn,mn,dn,kn"
fileprefix=_suttanta
fortitle="${fortitle} + 6 KN books"

elif [[ "$@" == *"-all"* ]]; then

knLater="./sutta/kn"
searchIn="$searchIn $knLater"
source="an,sn,mn,dn,kn,lt"
fortitle="Suttanta"
fileprefix=_suttanta
if [[ "$@" == *"-vin"* ]]; then
	vin="./vinaya/pli-tv-b*"
	vinLater="./vinaya/pli-tv-*"
	searchIn="$vin $vinLater"
	source="vn,kp"
	fortitle="Vinaya"
	fileprefix=_vinaya
fi 

elif [[ "$@" == *"-tru"* ]]; then
function grepbasefile {
nice -$nicevalue grep -E -B${linesbefore} -A${linesafter} -Ri${grepvar}${grepgenparam} "$pattern" $pali_or_lang --exclude-dir={$sutta,$abhi,home,js,css,image} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,pli-tv-kd,pli-tv-pvr,tha-ap,thi-ap,vv} | cleanuphtml
}
fileprefix=${fileprefix}
fortitle="${fortitle}"
elif [[ "$@" == *"-b"* ]]; then
function grepbasefile {
nice -$nicevalue grep -E -Ri${grepvar}${grepgenparam} -B${linesbefore} -A${linesafter} "$pattern" $bwlocation
 --exclude-dir={$sutta,$abhi,home,js,css,image,fonts} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,pli-tv-kd,pli-tv-pvr,thi-ap,vv} | grep -vE "(ud|sn|an)[0-9]{0,3}.html|/bw/home"  | cleanuphtml
}
fileprefix=${fileprefix}-bw
fortitle="${fortitle}"
fi




if [[ "$@" == *"-def"* ]]
then
fileprefix=${fileprefix}-definition
fortitle="Definition ${fortitle}"

modpattern="`echo $pattern | sed -E 's/([aiīoā]|aṁ)$//g'`"
pattern="$modpattern" 
#vin=dummy ${modpattern}.*nāma|
linesafter=3
patternForHighlight="`echo $pattern | sed -E 's/^[A-Za-z]{2,4}[0-9]{2,3}\.\*//g'| sed -E 's/^[A-Za-z]{2,4}[0-9]{2,3}.[0-9]{1,3}\.\*//g' | sed 's/.\*/|/g' |  sed 's@^@(@g' | sed 's/$/)/g' | sed 's@\\.@|@g' | sed 's@ @|@g' | sed 's@,@@g'`"

tmpdef=$tmpdir/tmpdef.$rand

if [[ "$@" == *"-vin"* ]]

vin="./vinaya/pli-tv-b*"
searchIn="$vin"
	source="vn"

  then
  vin=dummy
vindefpart="${modpattern}.{0,3}—|${modpattern}.{0,3}ti|${modpattern}.*nāma|"
linesafter=1
function grepbasefile {
nice -$nicevalue grep -E -Ri${grepvar}${grepgenparam} -B${linesbefore} -A${linesafter} "$pattern" $suttapath/$pali_or_lang --exclude-dir={$sutta,$abhi,$vin,xplayground,name,site} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,vv,pli-tv-kd,pli-tv-pvr,thag,thig,dhp}  | cleanuphtml > $tmpdef

nice -$nicevalue grep -Ei -B${linesbefore} -A${linesafter} "${vindefpart}\bKata.{0,20} \b${modpattern}.{0,5}\?|${modpattern}.{0,20}Kat.{0,20} \bho.*\?|\bKatha.{0,20} \b${modpattern}.{0,5}\?|${modpattern}.{0,15}, ${modpattern}.{0,25} vucca|${modpattern}.{0,25} vucca|Kiñ.*${modpattern}.{0,9} va|${modpattern}.*ariyassa vinaye|ariyassa vinaye.*${modpattern}" $tmpdef
}
else 
# definitions in Suttanta 

function grepbasefile {
nice -$nicevalue grep -E -Ri${grepvar}${grepgenparam} -B${linesbefore} -A${linesafter} "$pattern" $suttapath/$pali_or_lang --exclude-dir={$sutta,$abhi,$vin,xplayground,name,site} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,vv,pli-tv-kd,pli-tv-pvr,thag,thig,dhp}  | cleanuphtml > $tmpdef

nice -$nicevalue grep -Ei -B${linesbefore} -A${linesafter} "\bKata.{0,40} ${modpattern}.{0,9}[\?,]|\bKo .{0,40}${modpattern}|\bayaṁ .{0,40}${modpattern}|\bKatha.{0,40} \b${modpattern}.{0,5}[\?,]|${modpattern}.{0,15}, ${modpattern}.{0,25} vucca|${modpattern}.{0,25} vucca|Kiñ.*${modpattern}.{0,9} va|${modpattern}.*ariyassa vinaye|ariyassa vinaye.*${modpattern}${customtexts}" $tmpdef
}
fi  


function grepbasefileExtended1 {
  fortitle="Definition Extended 1 ${fortitle}"
cat $tmpdef | nice -$nicevalue grep -Ei -B${linesbefore} -A${linesafter} "\b${modpattern}[^\s]{0,3}sutta|${modpattern}.*vacanīy"  | cleanuphtml
}

function grepbasefileExtended2 {
  fortitle="Definition Extended 2 ${fortitle}"
nice -$nicevalue grep  -B${linesbefore} -A${linesafter} -Ei "\bKata.* \b${modpattern}.*[\?,]|\bKatha.* \b${modpattern}.*[,\?]|\bKas.{0,60}${modpattern}.{0,9}[\?,]|${modpattern}[^\s]{0,3}sutta|${modpattern}[^\s]{0,3}vagg[ao]|(dn3[34]|mn4[34]).*(Dv|Ti|Tay|Tī|Cattā|Cata|Pañc|cha|Satta|Aṭṭh|Nav|das).{0,20}${modpattern}|\bKata.{0,20}${modpattern}.{0,9}[\?,]|${modpattern}.*adhivacan|${modpattern}.{0,15}, ${modpattern}.*vucca|${modpattern}.{0,9} vacan|Seyyathāpi.*${modpattern}|Katth.*${modpattern}.*daṭṭhabb|Kiñ.*${modpattern}.{0,9} vadeth|vucca.{2,5} ${modpattern}{0,7}|Yadapi.*${modpattern}.*tadapi.*${modpattern}|an1\..*yadidaṁ ${modpattern}|an1\..*${modpattern}.*yadidaṁ|An2.*Dv.*${modpattern}|An3.*(Tis|Tay|Tī).{0,50}${modpattern}|An4.*(Cattā|Cata).{0,50}${modpattern}|An5.*Pañc.{0,50}${modpattern}|An6.*cha.*${modpattern}|An7.*Satta.*${modpattern}|An8.*Aṭṭh.*${modpattern}|An9.*Nav.*${modpattern}|an1[10].*das.{0,50}${modpattern}|(an3.34|an3.111|an3.112|an6.39|an10.174|dn15|sn12.60|sn14.12).*${modpattern}|(mn135|mn136|mn137|mn138|mn139|mn140|mn141|mn142|sn12.2:|sn45.8|sn47.40|sn48.9:|sn48.10|sn48.36|sn48.37|sn48.38|sn51.20).*${modpattern}" $tmpdef  | cleanuphtml
}
#|an1\..*${modpattern}
#sml 

elif [[ "$@" == *"-sml"* ]]
then

fileprefix=${fileprefix}-simile
fortitle="Similes ${fortitle}"


modpattern="`echo $pattern | sed -E 's/([aiīoā]|aṁ)$//g'`"
pattern="$modpattern" 
#vin=dummy ${modpattern}.*nāma|
linesafter=1
patternForHighlight="`echo $pattern | sed -E 's/^[A-Za-z]{2,4}[0-9]{2,3}\.\*//g'| sed -E 's/^[A-Za-z]{2,4}[0-9]{2,3}.[0-9]{1,3}\.\*//g' | sed 's/.\*/|/g' |  sed 's@^@(@g' | sed 's/$/)/g' | sed 's@\\.@|@g' | sed 's@ @|@g' | sed 's@,@@g'`"

tmpsml=$tmpdir/tmpsml.$rand
nonmetaphorkeys="condition|adhivacanasamphass|adhivacanapath|\banopam|\battūpa|\bnillopa|opamaññ"
if [[ "$@" == *"-vin"* ]]
  then
  vin=dummy
#vinsmlpart="${modpattern}.{0,3}—|${modpattern}.{0,3}ti|${modpattern}.*nāma|"
fi  

function grepbasefile {
nice -$nicevalue grep -E -Ri${grepvar}${grepgenparam}  -B${linesbefore} -A${linesafter} "$pattern" $suttapath/$pali_or_lang --exclude-dir={$sutta,$abhi,$vin,xplayground,name,site} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,vv,pli-tv-kd,pli-tv-pvr,thag,thig,dhp}  | cleanuphtml > $tmpsml

#for i in `grep -iE "Evamev.*${modpattern}" $tmpsml | awk -F':' '{print $1}' | sort -V | uniq`; do grep -EHi -B1 "Evamev.*${modpattern}" $i | sed 's@json-@json:@g' | grep -vi "Evamev.*${modpattern}" | sort -V | uniq | sed '/--/d'  ; done > tmpsml

if [[ "$type" == html ]]; then
for i in `cat $tmpsml`; do nice -$nicevalue grep -HEi "${vinsmlpart}seyyathāpi.*${modpattern}|${modpattern}.*adhivacan|Eva[mnṇṅṃṁ].*${modpattern}|${modpattern}.*(ūpam|upam|opam|opamm)|(ūpam|upam|opam|opamm).*${modpattern}|Suppose.*${modpattern}|${modpattern} is|${modpattern}.*is a designation for|is a designation for.*${modpattern}|${modpattern}.*Simile|simile.*${modpattern}|It’s like.*${modpattern}|is a term for.*${modpattern}|${modpattern}.*is a term for|similar to.*${modpattern}|${modpattern}.*similar to|Представ.*${modpattern}|обозначение.*${modpattern}|${modpattern}.*обозначение" $i | grep -vE "$nonmetaphorkeys" | grep -v "condition"| sed 's/html:.*/html/g'  ; 
done
else 
#json sources
nice -$nicevalue grep -Ei -B${linesbefore} -A${linesafter} "${vinsmlpart}seyyathāpi.*${modpattern}|${modpattern}.*adhivacan|${modpattern}.*(ūpam|upam|opam|opamm)|(ūpam|upam|opam|opamm).*${modpattern}|Suppose.*${modpattern}|${modpattern} is|${modpattern}.*is a designation for|is a designation for.*${modpattern}|${modpattern}.*Simile|simile.*${modpattern}|It’s like.*${modpattern}|is a term for.*${modpattern}|${modpattern}.*is a term for|similar to.*${modpattern}|${modpattern}.*similar to|Представ.*${modpattern}|обозначение.*${modpattern}|${modpattern}.*обозначение${customtexts}" $tmpsml | grep -vE "$nonmetaphorkeys" | grep -v "condition" > $tmpdir/${tmpsml}_2

nice -$nicevalue grep -B2 -ERi "Eva[mnṇṅṃṁ].*${modpattern}" $suttapath/$pali_or_lang --exclude-dir={$sutta,$abhi,$vin,xplayground,name,site} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,vv,pli-tv-kd,pli-tv-pvr,thag,thig,dhp} | grep -A1 -i Seyyathāpi | sed 's@json-@json:@g' | sed '/--/d' > $tmpdir/${tmpsml}_3

cat $tmpdir/${tmpsml}_2 $tmpdir/${tmpsml}_3 
#| grep -vi "Eva[mnṇṅṃṁ].*${modpattern}"
fi
}


#sml end


elif [[ "$@" == *"-onl"* ]]; then
patternForHighlight="`echo $pattern | sed -E 's/^[A-Za-z]{2,4}[0-9]{2,3}\.\*//g'| sed -E 's/^[A-Za-z]{2,4}[0-9]{2,3}.[0-9]{1,3}\.\*//g' | sed 's/.\*/|/g' |  sed 's@^@(@g' | sed 's/$/)/g' | sed 's@\\.@|@g' | sed 's@ @|@g' | sed 's@,@@g'`"
function grepbasefile {
tmponl=$tmpdir/tmponl.$rand

patternforfind=`echo $pattern | sed 's@|@ @g' |sed 's@^(@@g' | sed 's@)$@@g' `
patternforgrep=`echo $patternforfind | sed 's@ @|@g' |sed 's@^@(@g' | sed 's@$@)@g' `

onlwc=`echo $patternforfind| wc -w`
iterationnum=1
rm outgrepcomloop
for pattern in $patternforfind
do 
echo nice -$nicevalue grep -Eril -m1 "$pattern" $suttapath/$pali_or_lang --exclude-dir={$sutta,$abhi,$vin,xplayground,name,site,patton} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,pli-tv-kd,pli-tv-pvr,vv} >> outgrepcomloop
echo >> outgrepcomloop
nice -$nicevalue grep -Eril -m1 "$pattern" $suttapath/$pali_or_lang --exclude-dir={$sutta,$abhi,$vin,xplayground,name,site,patton} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,pli-tv-kd,pli-tv-pvr,vv}  | cleanuphtml > iter$iterationnum.$rand
 iterationnum=$((iterationnum + 1))
done
#echo "$patternforfind dddd $patternforgrep" >> outgrepcomloop
cat iter*.$rand | sort -V | uniq -c | awk '{print $1, $2}' | grep "^$onlwc" |  awk '{print $2}' > onllist.$rand 

for i in `cat onllist* `
do
nice -$nicevalue grep -HEi -B${linesbefore} -A${linesafter}  "$patternforgrep" "$i"
done > $tmponl

### var 1 ###

#revertlater=$pattern
#splitarraylen=`echo $pattern | tr -s "|" "\n" | wc -l`

#nice -$nicevalue grep -E -Ri${grepvar}${grepgenparam} "$pattern" $suttapath/$pali_or_lang --exclude-dir={$sutta,$abhi,$vin,xplayground,name,site} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,vv,thag,thig,snp,dhp,iti,ud} > $tmponl


### var 2 find ###
#command="find $suttapath/$pali_or_lang  -type f -not -path '*/'$sutta'/*' -not -path '*/'$abhi'/*' -not -path '*/'$vin'/*' -not -path '*/xplayground/*' -not -path '*/name/*' -not -path '*/site/*' -not -path '*/ab/*' -not -path '*/bv/*' -not -path '*/cnd/*' -not -path '*/cp/*' -not -path '*/ja/*' -not -path '*/kp/*' -not -path '*/mil/*' -not -path '*/mnd/*' -not -path '*/ne/*' -not -path '*/pe/*' -not -path '*/ps/*' -not -path '*/pv/*' -not -path '*/tha-ap/*' -not -path '*/thi-ap/*' -not -path '*/vv/*' -not -path '*/thag/*' -not -path '*/thig/*' -not -path '*/snp/*' -not -path '*/dhp/*' -not -path '*/iti/*' -not -path '*/ud/*' -not -path '*/pli-tv-kd/*' -not -path '*/pli-tv-pvr/*' "
#for i in $patternforfind
#do
##command+=`echo -n '-exec grep -qE "'$i'" {} \; '`
#command+=`echo -n '| xargs grep -il "'$i'"'` 
#done
#command+=' -print'
#echo  "$command" >> command
#eval "$command" > $tmponl 

# Чтение содержимого файла в массив с помощью mapfile (readarray)
#mapfile -t onl_array < $tmponl

# Вывод содержимого массива для проверки
#for line in "${onl_array[@]}"; do
#grep -iHE "$pattern" $line
#done > $tmponl

#cp $basefile bfl
if [[ "$type" == html ]]; then
cat $tmponl | sed 's/html:.*/html/g'  
else 
cat $tmponl
fi
#onltextindex=`for i in $splitpattern
#do
#grep -Eir "$i" $tmponl | awk '{print $2}'| awk -F':' '{print $1}' | sort -Vf | uniq 
#done | sort -Vf | uniq -c | sort | awk '{print $1, $2}'| grep "^$splitarraylen" | awk -F'"' '{print $2}' | xargs | sed 's@ @:|@g' | sed 's@$@:@g'`
#pattern=$revertlater
}
fileprefix=${fileprefix}-onl
fortitle="${fortitle} Matching Mode"
maxmatchesbg=100000000
#echo $pattern $splitpattern $splitarraylen | tohtml
else 

function grepbasefile {
tmpgb=$tmpdir/tmpgrepbase.$rand

keyword="$pattern"

if [[ "$language" == *"Pali"* ]]; then

cd $suttapath/sc-data/sc_bilara_data/variant/pli/ms/
grep -riE "$pattern" $searchIn | sed 's/{//g' | sed 's/}//g' | cleanuphtml > $tmpdir/${prefix}initrun-var
cd $apachesitepath/assets/texts/variant/
grep -riE "$pattern" $searchIn | sed 's/{//g' | sed 's/}//g'  | cleanuphtml >> $tmpdir/${prefix}initrun-var

cd $suttapath/sc-data/sc_bilara_data/root/pli/ms/

if [ -s "$tmpdir/${prefix}initrun-var" ]; then
cat $tmpdir/${prefix}initrun-var | awk '{ print $2 }' | sed 's@\"@\\"@g' | awk 'BEGIN {OFS=""; printf "grep -Eir \"("} { printf $1"|"}' |  sed '$ s@|$@)"  '"$searchIn"' \n@' > $tmpdir/${prefix}cmndFromVar
bash $tmpdir/${prefix}cmndFromVar | sed 's/<[^>]*>//g'> $tmpdir/${prefix}initrun-pi
fi
grep -riE -B${linesbefore} -A${linesafter} "$pattern" $searchIn  | cleanuphtml | grep '": "'| sed 's/json./json:/g' |  grep -v "^--$" >> $tmpdir/${prefix}initrun-pi
cp $tmpdir/${prefix}initrun-pi $tmpdir/pli

cd $suttapath/sc-data/sc_bilara_data/translation/en/$translator
cat $tmpdir/${prefix}initrun-pi | awk '{ print $2 }' | sort -V  | uniq | sed 's@\"@\\"@g' | awk 'BEGIN {OFS=""; printf "grep -Eir \"("} { printf $1"|"}' |  sed '$ s@|$@)" '"$searchIn"' \n@' > $tmpdir/${prefix}cmnd
bash $tmpdir/${prefix}cmnd | sed 's/<[^>]*>//g' > $tmpdir/${prefix}initrun-en

cat $tmpdir/${prefix}initrun-pi $tmpdir/${prefix}initrun-en $tmpdir/${prefix}initrun-var > $tmpgb

elif [[ "$language" == "English" ]]; then

cd $suttapath/sc-data/sc_bilara_data/translation/en/$translator
grep -riE -B${linesbefore} -A${linesafter} "$pattern" $searchIn | grep '": "'| sed 's/json./json:/g'  | cleanuphtml|  grep -v "^--$"  >> $tmpdir/${prefix}initrun-en

cd $suttapath/sc-data/sc_bilara_data/root/pli/ms/
cat $tmpdir/${prefix}initrun-en | awk '{ print $2 }' | sed 's@\"@\\"@g' | awk 'BEGIN {OFS=""; printf "grep -Eir \"("} { printf $1"|"}' |  sed '$ s@|$@)"  '"$searchIn"' \n@' > $tmpdir/${prefix}cmndFromEn
bash $tmpdir/${prefix}cmndFromEn > $tmpdir/${prefix}initrun-pi

cd $suttapath/sc-data/sc_bilara_data/variant/pli/ms/
cat $tmpdir/${prefix}initrun-en | awk '{ print $2 }' | sed 's@\"@\\"@g' | awk 'BEGIN {OFS=""; printf "grep -Eir \"("} { printf $1"|"}' |  sed '$ s@|$@)"  '"$searchIn"' \n@' > $tmpdir/${prefix}cmndFromEn
bash $tmpdir/${prefix}cmndFromEn > $tmpdir/${prefix}initrun-var

cat $tmpdir/${prefix}initrun-pi $tmpdir/${prefix}initrun-en $tmpdir/${prefix}initrun-var > $tmpgb
else
nice -$nicevalue grep -E -Ri${grepvar}${grepgenparam}  -B${linesbefore} -A${linesafter}  "$pattern" $suttapath/$pali_or_lang --exclude-dir={$sutta,$abhi,$vin,xplayground,name,site} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,vv,thag,thig,dhp,pli-tv-kd,pli-tv-pvr}  | cleanuphtml > $tmpgb
nice -$nicevalue grep -E -Ri${grepvar}${grepgenparam} "$pattern" $suttapath/sc-data/sc_bilara_data/variant/pli/ms/sutta --exclude-dir={$sutta,$abhi,$vin,xplayground,name,site} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,pli-tv-kd,pli-tv-pvr,tha-ap,thi-ap,vv,thag,thig,dhp}  | cleanuphtml >> $tmpgb

fi 


if [ -s $tmpgb ]; then
cat $tmpgb 
fi
}
fi

if [[ "$@" == *"-th"* ]]; then
    fnlang=_th
    pali_or_lang=sc-data/html_text/th/pli 
    language=Thai
    langforhist="/Th"
	printlang=ไทย
    directlink=
    type=html   
    metaphorkeys="как если бы|подоб|представь|обозначение|Точно также, как"
    nonmetaphorkeys="подобного|подоба"
elif [[ "$@" == *"-si"* ]]; then
    fnlang=_si
    pali_or_lang=sc-data/html_text/si/pli 
    language=Sinhala
    langforhist="/Si"
	printlang=සිංහල
    directlink=
    type=html   
    metaphorkeys="как если бы|подоб|представь|обозначение|Точно также, как"
    nonmetaphorkeys="подобного|подоба"
elif [[ "$@" == *"-tru"* ]]; then
    fnlang=_thru
    suttapath=
    pali_or_lang=$apachesitepath/theravada.ru
    language=Russian-thru
    printlang=Русский
    directlink=
    type=html   
    metaphorkeys="как если бы|подоб|представь|обозначение|Точно также, как"
    nonmetaphorkeys="подобного|подоба"
    definitionkeys="что такое.*${pattern}.{0,4}\\?|${pattern}.*говорят|${pattern}.*обозначение|${pattern}.{0,4}, ${pattern}.*говорят"  
    
         function grepbasefile {
cd $apachesitepath/theravada.ru/Teaching/Canon/Suttanta/
grep -riE -B${linesbefore} -A${linesafter} "$pattern" $searchIn | cleanuphtml
cd - > /dev/null
}   
    
elif [[ "$@" == *"-ru"* ]]; then
    fnlang=_ru
    pali_or_lang=sc-data/html_text/ru/pli/
    language=Russian
    printlang=Русский
    directlink=
    type=html  
    searchIn="./sutta/"
    metaphorkeys="как если бы|подоб|представь|обозначение|Точно также, как"
    nonmetaphorkeys="подобного|подоба"
    definitionkeys="что такое.*${pattern}.{0,4}\\?|${pattern}.*говорят|${pattern}.*обозначение|${pattern}.{0,4}, ${pattern}.*говорят"
      function grepbasefile {
cd $suttapath/$pali_or_lang
grep -riE -B${linesbefore} -A${linesafter} "$pattern" $searchIn | cleanuphtml | sed 's@/ему/@ему@g'
cd - > /dev/null
}  

elif [[ "$@" == *"-b"* ]]; then
    fnlang=_tbw
    pali_or_lang=/bw/
    directlink=/bw
    language="TBW"
    type=html
    hwithtitle='<h00002>'
    metaphorkeys="is a designation for|suppose"
    nonmetaphorkeys="adhivacanasamphass|adhivacanapath|ekarūp|tathārūpa|āmarūpa|\brūpa|evarūpa|\banopam|\battūpa|\bnillopa|opamaññ"
    definitionkeys="Kata.*${pattern}.{0,4}\\?|${pattern}.*vucati|${pattern}.*adhivacan|${pattern}.{0,4}, ${pattern}.*vucca"
   #modify pattern as legacy uses different letters
elif [[ "$@" == *"-pli"* ]]; then
    fnlang=_pali
    pali_or_lang=sc-data/sc_bilara_data/root/pli/ms
    directlink=/pli/ms
    #directlink=/en/?layout=linebyline
    language=Pali
    type=json
    metaphorkeys="seyyathāpi|adhivacan|ūpama|opama|opamma"
    nonmetaphorkeys="adhivacanasamphass|adhivacanapath|ekarūp|tathārūpa|āmarūpa|\brūpa|evarūpa|\banopam|\battūpa|\bnillopa|opamaññ"
    definitionkeys="Kata.*${pattern}.{0,4}\\?|${pattern}.*vucati|${pattern}.*adhivacan|${pattern}.{0,4}, ${pattern}.*vucca"
   #modify pattern as legacy uses different letters
elif [[ "$@" == *"-en"* ]]; then
    fnlang=_en
	printlang=English
    pali_or_lang=sc-data/sc_bilara_data/translation/en/$translator
    language=English
    type=json
    metaphorkeys="It’s like a |suppose|is a term for|similar to |simile|Suppose|is a designation for"
    nonmetaphorkeys="adhivacanasamphass|adhivacanapath" 
    definitionkeys="what is.*${pattern}.{0,4}\\?|speak of this.*${pattern}|${pattern}.*term|${pattern}.{0,4}, ${pattern}.*говорят"
    if [[ "$@" == *"-vin"* ]]
  then 
nice -$nicevalue grep -E -Ri${grepvar}${grepgenparam} "$pattern" $suttapath/sc-data/sc_bilara_data/translation/en/$translator/$dirlocation --exclude-dir={$sutta,$abhi,$vin,xplayground,name,site} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,vv,pli-tv-kd,pli-tv-pvr,thig,dhp} >> $tmpgb
#dhp,iti,ud
fi
else
    fnlang=_pali
    pali_or_lang=sc-data/sc_bilara_data/root/pli/ms
    directlink=/pli/ms
    #directlink=/en/?layout=linebyline
    language=Pali
    type=json
    metaphorkeys="seyyathāpi|adhivacan|ūpama|opama|opamma"
    nonmetaphorkeys="adhivacanasamphass|adhivacanapath|ekarūp|tathārūpa|āmarūpa|\brūpa|evarūpa|\banopam|\battūpa|\bnillopa|opamaññ"
fi

if [[ "$@" == *"-exc"* ]]
then

fortitle="${fortitle}"
excludepattern="`echo $@ | sed 's/.*-exc //g'`"
addtotitleifexclude=" exc. $excludepattern"
addtoresponseexclude=" $excluderesponse $excludepattern"

# Проверяем, есть ли пробелы в excludepattern
if [[ $excludepattern == *" "* ]]; then
    # Если есть, преобразовываем в соответствующий формат
    excludepatterngrepv="$(echo "$excludepattern" | sed 's/ /|/g')"
    excludepatterngrepv="($excludepatterngrepv)"
elif [[ $excludepattern == *"("* ]] &&  [[ $excludepattern == *")"* ]] ; then
    excludepatterngrepv="$excludepattern"    
else
    # Если нет пробелов, используем исходный паттерн
    excludepatterngrepv="$excludepattern"
fi

function grepexclude {
grep -iE -v "$excludepatterngrepv"
}
#echo arg="$@"
excfn="` echo -exc-${excludepattern} | sed 's/ /-/g' | sed 's@\\\@@g' `"

else
function grepexclude {
pvlimit 
}
fi

function diact2normal {
sed "s/ā/aa/g" |
sed "s/ī/ii/g" |
sed "s/ū/uu/g" |
sed "s/ḍ/.d/g" |
sed "s/ṁ/.m/g" |
sed "s/ṅ/.n/g" |
sed "s/ṇ/.n/g" |
sed "s/ṭ/.t/g" |
sed "s/ḷ/.l/g" |
sed "s/ñ/~n/g"
}

function cyr2lat {
sed "s/а/a/g" |
sed "s/б/b/g" |
sed "s/в/v/g" |
sed "s/г/g/g" |
sed "s/д/d/g" |
sed "s/е/e/g" |
sed "s/ё/yo/g" |
sed "s/ж/zh/g" |
sed "s/з/z/g" |
sed "s/и/i/g" |
sed "s/й/i/g" |
sed "s/к/k/g" |
sed "s/л/l/g" |
sed "s/м/m/g" |
sed "s/н/n/g" |
sed "s/о/o/g" |
sed "s/п/p/g" |
sed "s/р/r/g" |
sed "s/с/s/g" |
sed "s/т/t/g" |
sed "s/у/u/g" |
sed "s/ф/f/g" |
sed "s/х/h/g" |
sed "s/ц/ts/g" |
sed "s/ч/ch/g" |
sed "s/ш/sh/g" |
sed "s/щ/sh/g" |
sed "s/ъ//g" |
sed "s/ы/y/g" |
sed "s/ь//g" |
sed "s/э/e/g" |
sed "s/ю/yu/g" |
sed "s/я/ya/g" 
}

#link and filename
fn=`echo $pattern | sed 's/\*//g' | sed 's/[|-]/-/g' | sed 's/[][]//g' | sed 's/ /-/g' | sed 's/\\\//g' | sed 's@?@-question@g'|  awk '{print tolower($0)}'`
fn=${fn}${excfn}${fileprefix}${fnlang}${outfnlang}

modifiedfn=`echo $fn | diact2normal | cyr2lat`

extention=$rand.tmp
basefile=${fn}_fn.$extention

#filelist
#metaphors=${fn}_metaphors.$extention
table=${modifiedfn}.$rand
tempfile=$tmpdir/${modifiedfn}.$extention
tempfilewhistory=$tmpdir/${modifiedfn}_hist.$extention
tempfilewords=${modifiedfn}_words.$rand
tempdeffile=$tmpdir/${modifiedfn}.def.$extention
deffile=$tmpdir/${modifiedfn}_definitions.$rand

if [[ "$@" == *"-nm"* ]] 
then
filesizenooverwrite=1900000000000
fi
function checkifalreadydone {
checkfile=`ls $modifiedfn*_[0-9]*-[0-9]*.html 2>/dev/null| grep -v word ` 

if [[ -s "${checkfile}" ]] ; then 
function md5checkwrite {
var="$(cat)"
functionname=`echo $var | awk '{print $1}'`
functionfile=~/.shortcuts/${functionname}.sh 
content=`echo "$var" | awk 'NR!=1'`
#echo $functionfile $functionname
md5_stdin=$(echo "$content" | md5sum | cut -d" " -f 1)
md5_file=$(md5sum ${functionfile} | cut -d" " -f1)
[[ "$md5_stdin" != "$md5_file" ]] && echo "$content"  > $functionfile
}

filesize=$(stat -c%s "${checkfile}")

if (( $filesize >= $filesizenooverwrite )) && [[ "`tail -n1 ${checkfile}`" == "</html>" ]] 
then
	echo Already 
	cat -n $history | grep -E "$table" | grep daterow | grep -i "${fortitle^}" | grep ">$language<" | tac > updatehistorytmp 
	linenumbers=`cat updatehistorytmp | awk '{print $1}'`

for i in $linenumbers
do 
sed -i "${i}d" $history 
done 

sed -i 's@[0-9][0-9]-[0-9][0-9]-[0-9][0-9][0-9][0-9]@'$dateforhist'@g' updatehistorytmp
cat updatehistorytmp | tac | head -1 | awk '{print substr($0, index($0, $2))}' >> $history
rm updatehistorytmp
#OKresponse
echo "<script>window.location.href=\"./result/${checkfile}\";</script>"
	exit 0
fi 
fi
}

function genwordsfile {
cat $tempfilewords | pvlimit | sedexpr | awk '{print tolower($0)}' | tr -s ' '  '\n' | sort | uniq -c | awk '{print $2, $1}' > $tempfile
uniqwordtotal=`cat $tempfile | pvlimit | sort | uniq | wc -l `

if [[ "$language" == *"Pali"* ]] ||  [[ "$language" == *"English"* ]]; 
then
cat $templatefolder/Header2.html $templatefolder/WordTableHeader2.html | sed 's/$title/TitletoReplace/g' | sed 's@HOMEVAR@'$mainpagebase'@'  > $tempfilewords 
else
cat $templatefolder/Header2.html $templatefolder/WordTableHeader2.html | sed '/forshellscript/d' | sed 's/$title/TitletoReplace/g' > $tempfilewords 
fi

#bash $apachesitepath/new/words.sh -f ${table} "$pattern"
cat $tmpdir/${prefix}wordsfinalhtml >> $tempfilewords

}


if [[ "$type" == json ]]; then
filelist=`echo "
${words}
${links}
${links_and_words}
${quotes}
${brief}
${metaphors}
${top}"`

grepvar=

function linklist {
if [[ "$args" == *"-oru"* ]] ; then

cat $templatefolder/Header2.html $templatefolder/ResultTableHeader2Ru.html | sed 's@HOMEVAR@'$mainpagebase'@' | sed 's/$title/TitletoReplace/g' | tohtml 
else
cat $templatefolder/Header2.html $templatefolder/ResultTableHeader2En.html | sed 's@HOMEVAR@'$mainpagebase'@' | sed 's/$title/TitletoReplace/g' | tohtml 

fi
textlist=`nice -$nicevalue cat $basefile | pvlimit | awk -F':' '{print $1}' | awk -F'/' '{print $NF}' |  awk -F'_' '{print $1}' | sort -Vf | uniq`

keyword="$pattern"



if [[ "$args" == *"-oru"* ]] ; then
cd $apachesitepath/assets/texts/
bash $tmpdir/${prefix}cmnd  | cleanuphtml > $tmpdir/${prefix}initrun-ru
cat $tmpdir/${prefix}initrun-ru >> $tmpdir/$basefile
fi   
    
cd $output > /dev/null
#Samaṇasukhasutta An Ascetic’s Happiness an5.128 var
sed -i 's/_root-pli-ms.json/":1"/g' $tmpdir/${prefix}initrun-pi $tmpdir/$basefile
sed -i 's/_translation-ru-.*.json/":2"/g' $tmpdir/${prefix}initrun-ru $tmpdir/$basefile
sed -i 's/_translation-en-.*.json/":3"/g' $tmpdir/${prefix}initrun-en $tmpdir/$basefile
sed -i 's/_variant-pli-ms.json/":4"/g' $tmpdir/${prefix}initrun-var $tmpdir/$basefile
sed -i 's/":/@/g'  $tmpdir/${prefix}initrun* $tmpdir/$basefile
sed -i -e 's@.*sutta/kn@khudakka\@/@g' -e 's@.*sutta/@dhamma\@/@g' -e 's@.*vinaya/@vinaya\@/@g' $tmpdir/${prefix}initrun* $tmpdir/$basefile
sed -i -e 's@.*/sutta/kn@khudakka\@/@g' -e 's@.*/sutta/@dhamma\@/@g' -e 's@.*/vinaya/@vinaya\@/@g' $tmpdir/$basefile
   
cat $tmpdir/${prefix}initrun* | sed 's/<[^>]*>//g'  | sed 's/@ *"/@/g' | sed 's/",$//g' | sed 's/ "$//g' | sed 's@/.*/@@g' | sed 's^@/^@^g' |  sort -t'@' -k2V,2 -k4V,4 -k2n,3 | uniq > $tmpdir/${prefix}readyforawk



# |  для доп колонки |  awk -F/ '{print $NF}' | sed 's@\@/.*/@\@@g' |
########## count keywords in texts

if [[ "$language" == *"Pali"* ]]; then

cd $suttapath/sc-data/sc_bilara_data/root/pli/ms/
grep -rioE "\w*$keyword[^ ]*" $searchIn | awk -F: '$2 > 0 {print $0}' > $tmpdir/${prefix}words

cd $suttapath/sc-data/sc_bilara_data/variant/pli/ms/
grep -rioE "\w*$keyword[^ ]*" $searchIn | sed 's/<[^>]*>//g' |sed 's/[[:punct:]]*$//'| awk -F: '$2 > 0 {print $0}' >> $tmpdir/${prefix}words


elif [[ "$language" == "English" ]]; then
cd $suttapath/sc-data/sc_bilara_data/translation/en/$translator
grep -rioE "\w*$keyword[^ ]*" $searchIn | sed 's/<[^>]*>//g' |sed 's/[[:punct:]]*$//'| awk -F: '$2 > 0 {print $0}' >> $tmpdir/${prefix}words
fi 

cat $tmpdir/${prefix}words   | awk -F/ '{print $NF}' | awk -F_ '{print $1}' | sort -V | uniq -c | awk 'BEGIN { OFS = "@" }{ print $2,$2,$1}' > $tmpdir/${prefix}counts

cat $tmpdir/${prefix}words | cleanupwords | awk -F/ '{print $NF}' | sed 's/_.*:/ /g'| awk '{print $1, $2}' | sort -V | uniq | awk '{
    if ($1 in data) {
        data[$1] = data[$1] " " $2
    } else {
        data[$1] = $1 "@" $2
    }
}
END {
    for (item in data) {
        print data[item]
    }
}' | sort -V > $tmpdir/${prefix}wordsAggregatedByTexts

cd $output > /dev/null
########## end count keywords in texts

#rm $tmpdir/${prefix}afterawk  
bash $apachesitepath/new/awknewfdg.sh $tmpdir/${prefix}readyforawk "$keyword" > $tmpdir/${prefix}afterawk  

counts_file="$tmpdir/${prefix}counts" 
afterawk_file="$tmpdir/${prefix}afterawk"
aggregated_file="$tmpdir/${prefix}wordsAggregatedByTexts"
wordsAggregatedByTexts=$(wc -l < "$aggregated_file")
counts=$(wc -l < "$counts_file")
afterawk=$(wc -l < "$afterawk_file")

if [ "$counts" -eq "$afterawk" ] && [ "$afterawk" -eq "$wordsAggregatedByTexts" ]; then
   # echo "Все три переменные равны $counts"
   echo
else
    echo "$counts в файле $counts_file не равно количеству строк 
    $afterawk в файле $afterawk_file и 
    $wordsAggregatedByTexts в $aggregated_file"
   paste -d"@" $tmpdir/${prefix}counts $tmpdir/${prefix}afterawk $tmpdir/${prefix}wordsAggregatedByTexts | awk -F@ '{OFS == "@"} BEGIN {print "counts after wordsAggr" } {OFS == "\t"} {print $1,$6, $9}' > $tmpdir/fordebug
  #  cd result
  #  exit 0
fi

paste -d"@" $tmpdir/${prefix}counts $tmpdir/${prefix}afterawk $tmpdir/${prefix}wordsAggregatedByTexts > $tmpdir/${prefix}finalraw
bash $apachesitepath/new/awk-step2fornew.sh $tmpdir/${prefix}finalraw "$keyword" > $tmpdir/${prefix}finalhtml
#cp $tmpdir/${prefix}_finalraw $tmpdir/${keyword}_finalrawForAI.txt
#cp $tmpdir/${prefix}_finalhtml $tmpdir/${keyword}_finalhtmlForAI.txt

headerinfo="${keyword^} $(awk -F@ '{ sum += $3 }; END { print NR " texts and "  sum " matches" }' $tmpdir/${prefix}counts)"
escapedKeyword="$(echo "$patternforhist" | sed 's/\\/\\\\/g')"

if [[ "$@" == *"-oru"* ]]
then
wordLinkToReplace="/ru/w.php?s=${escapedKeyword}\&d=$source\&p=-oru"
else
wordLinkToReplace="/w.php?s=${escapedKeyword}\&d=$source"
fi
WORDREPLACELINK="$wordLinkToReplace"

params=$(tail -n1 $apachesitepath/result/params.txt)


echo '<div class="keyword" style="display: none;" >'"$escapedkeyword"'</div>' | tohtml
echo '<div class="searchIn" style="display: none;" >'"$source"'</div>' | tohtml
echo '<div class="searchlang" style="display: none;" >'"$searchlang"'</div>' | tohtml

echo '<div class="params" style="display: none;" >'"$params"'</div>' | tohtml

echo '<div class="args" style="display: none;" >'"$args"'</div>' | tohtml
cat $tmpdir/${prefix}finalhtml | tohtml

#echo -e "Content-Type: text/html\n\n"
#echo $@



headerinfo="${keyword^} $(awk -F@ '{ sum += $3 }; END { print NR " texts and "  sum " matches" }' $tmpdir/${prefix}counts)"
matchqnty=`awk -F@ '{sum+=$3;} END{print sum;}' $tmpdir/${prefix}counts`

}
#e g for Russian language
elif [[ "$type" == html ]]; then

filelist=`echo "
${words}
${links}
${links_and_words}
${quotes}
${tempfile}
${table}"`

#${texts}

grepvar=l


function linklist {
if [[ "$language" == *"Pali"* ]] ||  [[ "$language" == *"English"* ]]; 
then
cat $templatefolder/Header2.html $templatefolder/ResultTableHeader2.html | sed 's/$title/TitletoReplace/g' | sed 's@HOMEVAR@'$mainpagebase'@' | tohtml 
else
cat $templatefolder/Header2.html $templatefolder/ResultTableHeader2.html | sed 's/$title/TitletoReplace/g' |sed '/forshellscript/d'  | sed 's@HOMEVAR@'$mainpagebase'@' | tohtml 

fi 

keyword="$pattern"

    
cd $output > /dev/null
#Samaṇasukhasutta An Ascetic’s Happiness an5.128 var

#if ru
sed -i 's/.html/":1"/g'  $tmpdir/$basefile
sed -i 's/":/@/g'  $tmpdir/$basefile

sed -i -e 's@.*sutta/kn@khudakka\@/@g' -e 's@.*sutta/@dhamma\@/@g' -e 's@.*vinaya/@vinaya\@/@g' $tmpdir/$basefile
sed -i -e 's@.*/sutta/kn@khudakka\@/@g' -e 's@.*/sutta/@dhamma\@/@g' -e 's@.*/vinaya/@vinaya\@/@g' $tmpdir/$basefile
   
#cat $tmpdir/$basefile | sed 's/<[^>]*>//g' | sed 's^@/^@^g' | sed 's/@ *"/@/g' | sed 's/",$//g' | sed 's/ "$//g' | sed 's@/.*/@@g'| awk -F@ '{OFS = "@"} {print $1, $2, $3, "", $4}' | sort -t'@' -k2V,2 -k4V,4 -k2n,3 | uniq > $tmpdir/${prefix}readyforawk

cat $tmpdir/$basefile | sed 's/<[^>]*>//g' | sed 's/@ *"/@/g' | sed 's/",$//g' | sed 's/ "$//g' | sed 's@/.*/@@g'| awk -F@ '{OFS = "@"} {print $1, $2, $3, "", $4}' | sed 's^@/^@^g' |  sort -t'@' -k2V,2 -k4V,4 -k2n,3 | uniq > $tmpdir/${prefix}readyforawk


# |  для доп колонки |  awk -F/ '{print $NF}' | sed 's@\@/.*/@\@@g' |
########## count keywords in texts

cd $suttapath/$pali_or_lang
grep -rioE "\w*$keyword[^ ]*" $searchIn | sed 's/<[^>]*>//g' | awk -F: '$2 > 0 {print $0}' > $tmpdir/${prefix}words



cat $tmpdir/${prefix}words   | awk -F/ '{print $NF}' | awk -F: '{print $1}' | sort -V | uniq -c | sed 's/.html//g'| awk 'BEGIN { OFS = "@" }{ print $2,$2,$1}' > $tmpdir/${prefix}counts

cat $tmpdir/${prefix}words | cleanupwords | awk -F/ '{print $NF}' | sed 's/.html:/ /g'| awk '{print $1, $2}' | sort -V | uniq | awk '{
    if ($1 in data) {
        data[$1] = data[$1] " " $2
    } else {
        data[$1] = $1 "@" $2
    }
}
END {
    for (item in data) {
        print data[item]
    }
}' | sort -V > $tmpdir/${prefix}wordsAggregatedByTexts

cd $output > /dev/null
########## end count keywords in texts

#rm $tmpdir/${prefix}afterawk  
bash $apachesitepath/new/awknewfdg.sh $tmpdir/${prefix}readyforawk "$keyword" > $tmpdir/${prefix}afterawk  

counts_file="$tmpdir/${prefix}counts" 
afterawk_file="$tmpdir/${prefix}afterawk"
aggregated_file="$tmpdir/${prefix}wordsAggregatedByTexts"
wordsAggregatedByTexts=$(wc -l < "$aggregated_file")
counts=$(wc -l < "$counts_file")
afterawk=$(wc -l < "$afterawk_file")

if [ "$counts" -eq "$afterawk" ] && [ "$afterawk" -eq "$wordsAggregatedByTexts" ]; then
   # echo "Все три переменные равны $counts"
   echo
else
    echo "$counts в файле $counts_file не равно количеству строк 
    $afterawk в файле $afterawk_file и 
    $wordsAggregatedByTexts в $aggregated_file"
   paste -d"@" $tmpdir/${prefix}counts $tmpdir/${prefix}afterawk $tmpdir/${prefix}wordsAggregatedByTexts | awk -F@ '{OFS == "@"} BEGIN {print "counts after wordsAggr" } {OFS == "\t"} {print $1,$6, $9}' > $tmpdir/fordebug
  #  cd result
  #  exit 0
fi

paste -d"@" $tmpdir/${prefix}counts $tmpdir/${prefix}afterawk $tmpdir/${prefix}wordsAggregatedByTexts > $tmpdir/${prefix}finalraw
bash $apachesitepath/new/awk-step2fornew.sh $tmpdir/${prefix}finalraw "$keyword" > $tmpdir/${prefix}finalhtml
#cp $tmpdir/${prefix}_finalraw $tmpdir/${keyword}_finalrawForAI.txt
#cp $tmpdir/${prefix}_finalhtml $tmpdir/${keyword}_finalhtmlForAI.txt

headerinfo="${keyword^} $(awk -F@ '{ sum += $3 }; END { print NR " texts and "  sum " matches" }' $tmpdir/${prefix}counts)"
escapedKeyword="$(echo "$patternforhist" | sed 's/\\/\\\\/g')"

if [[ "$@" == *"-oru"* ]]
then
wordLinkToReplace="/ru/w.php?s=${escapedKeyword}\&d=$source\&p=-oru"
else
wordLinkToReplace="/w.php?s=${escapedKeyword}\&d=$source"
fi
WORDREPLACELINK="$wordLinkToReplace"

echo '<div class="keyword" style="display: none;" >'"$keyword"'</div>' | tohtml
echo '<div class="searchIn" style="display: none;" >'"$searchIn"'</div>' | tohtml


#echo $keyword in the end

cat $tmpdir/${prefix}finalhtml | tohtml

#echo -e "Content-Type: text/html\n\n"
#echo $@



headerinfo="${keyword^} $(awk -F@ '{ sum += $3 }; END { print NR " texts and "  sum " matches" }' $tmpdir/${prefix}counts)"
matchqnty=`awk -F@ '{sum+=$3;} END{print sum;}' $tmpdir/${prefix}counts`

}

fi

###
###  basefile operations
###
function getbasefile {

if [[ "$pattern" == *"ṅ"* ]]; then
initialNorM="ṅ"
elif [[ "$pattern" == *"ṃ"* ]];  then
initialNorM="ṃ"
fi
patternforhist=$pattern
if [[ "$pattern" != *"["* ]] &&  [[ "$pattern" != *"]"* ]];  then
pattern=`echo $pattern | sed 's/е/[ёе]/g' | sed 's/[ṅṃ]/[ṅṁṃ]/g'`
fi

if [[ "$@" == *"-onl"* ]]
then
 if [[ $pattern == *"("* ]] && [[ $pattern == *")"* ]] 
 then
 pattern=`echo $pattern | sed 's@ @|@g'`
 else
 pattern=`echo $pattern | sed 's@ @|@g' |sed 's@^@(@g' | sed 's@$@)@g' `
 fi
fi

checkifalreadydone
echo grepbase > new_time_output.txt
{ time grepbasefile | grep -v "^--$" | grepexclude | sort -Vf ;} 2>> new_time_output.txt > $basefile
cp $basefile bfc
#echo path is $suttapath/$pali_or_lang and searchin is $searchIn
#echo grep -riE -B${linesbefore} -A${linesafter} "$pattern" $searchIn


#grepbasefile | grep -v "^--$" | grepexclude | clearsed | sort -Vf > $basefile

if [[ "$@" == *"-nm"* ]] 
then
topmatchesintexts=`cat $basefile | awk '{print $1}' | uniq -c | LC_ALL=C sort -r | head -n$numbersmatches | awk '{print $2}'`
for i in $topmatchesintexts
do
grep $i $basefile
done > tmp
cp tmp $basefile
fi


if [[ "$@" == *"-defall"* ]] 
then
mintexts=1000
else 
mintexts=1
fi
#echo $mintexts
texts=`awk -F"$type" '{print $1}' $basefile | sort | uniq | wc -l`

if [[ "$@" == *"-def"* ]] && (( $texts <= $mintexts )) && [[ "$@" != *"-vin"* ]]
then 
#echo mintxt=$mintexts txt=$texts
#echo "$tmpdef bf $texts"
grepbasefileExtended1 | grep -v "^--$" | grepexclude | clearsed | sort -Vf >> $basefile
texts=`awk -F"$type" '{print $1}' $basefile | sort | uniq | wc -l`
#echo "$tmpdef bf+1 $texts"
fi

if [[ "$@" == *"-def"* ]] && (( $texts <= $mintexts )) && [[ "$@" != *"-vin"* ]]
then 
grepbasefileExtended2 | grep -v "^--$" | grepexclude | clearsed | sort -Vf >> $basefile

texts=`awk -F"$type" '{print $1}' $basefile | sort | uniq | wc -l`
#echo "bf+12 $texts"
fi

texts=`awk -F"$type" '{print $1}' $basefile | sort | uniq | wc -l`
if [[ "$@" == *"-def"* ]] && (( $texts <= $mintexts )) && [[ "$@" != *"-vin"* ]]
then 
nice -$nicevalue grep -E -A1 -Eir "${modpattern}.{0,50}saṅkhaṁ gacchati" $suttapath/$pali_or_lang --exclude-dir={$sutta,$abhi,$vin,xplayground,name,site} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,vv,pli-tv-kd,pli-tv-pvr} | grep -E -B1 Evamev | grep -v "^--$" >> $basefile

texts=`awk -F"$type" '{print $1}' $basefile | sort | uniq | wc -l`
#echo "bf+12sk $texts"
fi

textlist=`nice -$nicevalue cat $basefile | pvlimit | awk -F':' '{print $1}' | awk -F'/' '{print $NF}' |  awk -F'_' '{print $1}' | sort -Vf | uniq`
totaltexts=` echo $textlist | wc -w`
linescount=$(wc -l < "$basefile")

if (( linescount == 0 )); then
pattern="`echo $pattern | sed 's/\[ёе\]/е/g'`"
	Erresponse

	#Clarification
     rm $basefile
     exit 1
elif [ $linescount -ge $maxmatchesbg ] && [[ "$@" != *"-nbg"* ]];  then 
bgswitch
exit 3
#	echo "$@" | sed 's/-oru //g' | sed 's/-oge //g' | sed 's/-ogr //g'   | sed 's/-nbg //g' >> ../input/input.txt     
fi

}

rm $basefile > /dev/null 2>&1
getbasefile "$@"
#cleanup in case the same search was launched before
rm ${table} $tempfile $tempfilewords $tempfilewhistory > /dev/null 2>&1
###
###  basefile operations end
###

#add links to each file
echo linklist function part >> new_time_output.txt
round=1
{ time linklist ;} 2>> new_time_output.txt
echo end of linklist function part >> new_time_output.txt
if [[ "$language" == *"Pali"* ]] ||  [[ "$language" == *"English"* ]]; 
then
echo genwordsfile >> new_time_output.txt
{ time genwordsfile ;} 2>> new_time_output.txt
fi 
textsqnty=`echo $textlist | wc -w`

pattern="`echo $pattern | sed 's/\[ёе\]/е/g'`"
pattern=$userpattern
if [[ "$@" == *"-oru"* ]]
then
title="`echo "$pattern" | sed 's/^[[:lower:]]/\U&/'`${addtotitleifexclude} $textsqnty текстов и $matchqnty совпадений в $fortitle $language"
else 
title="`echo "$pattern" | sed 's/^[[:lower:]]/\U&/'`${addtotitleifexclude} $textsqnty texts and $matchqnty matches in $fortitle $language"
fi
if [[ "$@" == *"-nm"* ]]; then
title="`echo "$pattern" | sed 's/^[[:lower:]]/\U&/'`${addtotitleifexclude} $textsqnty texts and $matchqnty matches in $fortitle $language Top-$numbersmatches"
fi


titlewords="`echo "$pattern" | sed 's/^[[:lower:]]/\U&/'`${addtotitleifexclude} $uniqwordtotal related words in $textsqnty texts and $matchqnty matches in $fortitle $language"

sed -i 's/TitletoReplace/'"$title"'/g' ${table}
sed -i 's/TitletoReplace/'"$titlewords"'/g' ${tempfilewords}

#OKresponse

#finalize words file 
oldname=$tempfilewords
removerand=`echo $tempfilewords| sed 's@\.'$rand'@@'`
if [[ "$language" == *"Pali"* ]] ||  [[ "$language" == *"English"* ]]; 
then
tempfilewords=${removerand}_${textsqnty}-${matchqnty}-${uniqwordtotal}.html
else
tempfilewords=${removerand}_${textsqnty}-${matchqnty}.html
fi 


if [[ "$language" == *"Pali"* ]] || [[ "$language" == *"English"* ]]; 
	then
#echo "<a href=\"/result/${tempfilewords}\">Words</a>" | tohtml
#replace button href in qoute file
#ping for all variants of the pali word

# use this one if will decide that should show variants from searchIn only
#    if [ -s "$tmpdir/${prefix}initrun-var" ]; then

if grep -qrEi -m1 "$keyword" $suttapath/sc-data/sc_bilara_data/variant/pli/ms/sutta/ $suttapath/sc-data/sc_bilara_data/variant/pli/ms/vinaya/ 2>/dev/null
then
echo '<script>
document.addEventListener("DOMContentLoaded", function() {
  var keywordDiv = document.querySelector(".keyword");
  var variantsDivs = document.querySelectorAll(".variants");

  if (keywordDiv) {
    var keywordText = keywordDiv.innerText.trim();
    var keywordCapitalized = keywordText.charAt(0).toUpperCase() + keywordText.slice(1);
    
    variantsDivs.forEach(function(variantsDiv) {
      if (variantsDiv.id === "variants") {
variantsDiv.style.display = "block";
variantsDiv.innerHTML = `<img style="margin-top: -2px; height: 15px; " src="/assets/svg/circle-info.svg"> ${keywordCapitalized} has${variantsDiv.innerHTML.substring(variantsDiv.innerHTML.indexOf("has") + 3)}`;
      } else {
        variantsDiv.style.display = "block";
      }
    });
  }
});
</script>' | tohtml
fi 
#echo "<script $fontawesomejs></script>" | tohtml
		cat $templatefolder/Footer2.html | sed 's@WORDSLINKVAR@'${pagelang}'/result/'${tempfilewords}'@g' | sed 's@MAINLINKVAR@'${mainpagebase}'@g' | sed 's@READLINKVAR@'${pagelang}'/read.php@g' | sed 's@/history.php@'${mainpagebasehistory}/history.php'@g' | tohtml
	else

#echo "<script $fontawesomejs></script>" | tohtml
		cat $templatefolder/Footer2.html | sed '/WORDSLINKVAR/d' | sed 's@MAINLINKVAR@'${mainpagebase}'@g' | sed 's@READLINKVAR@'${pagelang}'/read.php@g' | sed 's@/history.php@'${mainpagebasehistory}/history.php'@g' | tohtml
fi 

if [[ "$@" == *"-nm"* ]]; then
sed -i "/'orderMulti': true,/a \    'order': [[4, 'desc'], [5, 'desc']],"  ${table} 
fi

mv ./$oldname ./$tempfilewords

#finalize quotes file 
oldname=$table
removerand=`echo $table| sed 's@\.'$rand'@@'`
table=${removerand}_${textsqnty}-${matchqnty}.html

echo "</tbody>
</table>
<br><br><hr>
<a href='${mainpagebase}' id='back'>Main</a>&nbsp;
<a href='${pagelang}/read.php'>Read</a>&nbsp;
<a href='/assets/diff'>SuttaDiff</a>&nbsp;
<a href='${mainpagebasehistory}/history.php'>History</a>&nbsp;
<a href=\"${pagelang}/result/${table}\">Quotes</a>
" >> $tempfilewords
#replace button href in word file
#echo "<script $fontawesomejs></script>"  >> $tempfilewords
cat $templatefolder/WordsFooter.html >> $tempfilewords
mv ./$oldname ./$table

if [[ "$language" == *"Pali"* ]]; 
then
sed -i 's@$quotesLinkToReplace@'./$table'@' ./$tempfilewords
escapedKeyword=$(echo "$patternforhist" | sed 's/\\/\\\\/g')

if [[ "$@" == *"-oru"* ]]
then

sed -i 's@$wordLinkToReplace@/ru/w.php?s='"$escapedKeyword"'\&d='$source'\&p=-oru@' ./$table
else
sed -i 's@$wordLinkToReplace@/w.php?s='"$escapedKeyword"'\&d='$source'@' ./$table
fi


elif [[ "$language" == *"English"* ]]
then
sed -i '/<button.*>Words</s@type="button">@type="button" style="display: none;">@g' $table
fi 

linenumbers=`cat -n $history | grep -E "$table" | grep daterow | grep "${fortitle^}" | grep ">$language<" | awk '{print $1}' | tac`

for i in $linenumbers
do 
sed -i "${i}d" $history 
done 

if [[ $excludepattern != "" ]]
then
userpattern="$pattern exc. ${excludepattern,,}"
fi 

if [[ "$@" == *"-nm"* ]]; then
fortitle="Top-$numbersmatches ${fortitle^}"
fi


#<img src='/assets/svg/regular-star.svg' class='starsvg'></img>
echo -n "<!-- begin $userpattern --> 
<tr><td><a class=\"outlink wordwrap\" data-local=\"./result/${table}\" href=\"${params}\">${userpattern}</a></td><td><label class='star-checkbox'><input type='checkbox' data-index=\"${table}\"/><i class='fa-regular fa-star'></i></label></td><td>$textsqnty</td><td>$matchqnty</td><td><a class=\"outlink\" href=\"./result/${tempfilewords}\">$uniqwordtotal</a></td><td>${fortitle^}$langforhist</td><td>$language</td><td class=\"daterow\">$dateforhist</td><td>`ls -lh ${table} | awk '{print  $5}'`</td><td>" >> $history
#}'`</td><td><label  class='custom-checkbox'><input type='checkbox' class='star-checkbox' data-index='1'/><i class='fa-solid fa-star glyphicon glyphicon-star-empty'></i><i class='fa-solid fa-star glyphicon glyphicon-star'></i></label></td><td>"
if [[ "$type" == json ]]; then
  if (( $textsqnty <= 40 ))
  then
  echo > /dev/null
#  echo -n "<br>`cat $tempfilewhistory | grep href | sed -E "s@$patternForHighlight@<b>&</b>@I" | xargs`" >> $history
  else 
  echo -n "<br>" >> $history
  fi
elif  [[ "$language" == Thai ]] && [[ "$fortitle" == *"4 Nikaya"* ]]
then
  if (( $textsqnty <= 40 ))
  then
  echo -n "`cat $basefile | awk -F':' '{print $1}' | awk -F'/' '{print $NF}' | sed 's/.html//g' | awk -F'_' -v lkth="$linkforthai" -v ext="$linkforthaiext"  '{print \"<a target=_blank href="lkth$1''ext">"$1"</a>\"}' | sort -u | sort -Vf | xargs`" >> $history
  else 
  echo -n "<br>" >> $history
  fi
else
  if (( $textsqnty <= 40 ))
  then
 # cat $basefile > checkitout
echo -n "`cat $basefile | awk -F':' '{print $1}' | awk -F'/' '{print $NF}' | sed 's/.html//g' | awk -F'_' '{print \"<a target=_blank href=/read/?q="$1">"$1"</a>\"}' | sort -u | sort -Vf | xargs`" >> $history
#&lang=pli
  else 
  echo -n "<br>" >> $history
  fi
fi

echo "</td></tr>
" >> $history

rm $basefile $tempfile $tempfilewhistory *grepbase* tmp* *tmp *$rand $rand* > /dev/null 2>&1
echo "<meta charset='utf-8'>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var refreshLink = document.getElementById('refreshLink');

    refreshLink.addEventListener('click', function(event) {
      event.preventDefault(); 
      location.reload();
    });
  });

window.location.href=\"$pagelang/result/${table}\";
</script>" > $tmphtml

cleanupTempFiles
end=`date +%s`
runtime=$((end-start))
echo total execution time $runtime >> new_time_output.txt
rm -- *.tmp tmpgrepbase.* tmp* 2>/dev/null
find . -type f -mtime +2 -exec rm {} \;
find . -type f -name 'search*.html' -mmin +6 -exec rm {} \;

echo "<script>
window.location.href=\"$pagelang/result/${table}\";
</script>"

exit 0


echo "<script>
  fetch(\"$pagelang/result/${table}\")
    .then(response => response.text())
    .then(html => {
        document.open(); 
        document.write(html); 
        document.close(); 
        history.pushState(null, \"\", window.location.href);
    });
</script>"

#history.pushState({ previousPage: window.location.href }, '');

#<a target=\"_blank\" href="$linken">En</a> 
echo "<tr>
<td><a class=\"freebutton\" target=\"_blank\" href="$linkgeneralwithindex">$filenameblock</a></td>
<td><input type='checkbox' data-index="$filenameblock"></td>
<td><strong class=\"pli-lang inputscript-ISOPali\">`echo $roottitle | highlightpattern` </strong>`echo ${trntitle}  | highlightpattern ` </td>
<td>${word}</td>
<td>$count</td>   
<td>$metaphorcount</td>
<td>
`[ "$suttanumber" != "" ] && [[ "$fortitle" == *"4 Nikaya"* ]] && echo "<a  href='' onclick=openDpr('$suttanumber') >Pi</a>"` 

<a class='bwLink' href='' data-slug='$suttanumber'>En</a>
<a class='ruLink' href='' data-slug='$suttanumber'>Ru</a>



`[[ $linkthai != "" ]] && [[ "$@" == *"-th"* ]] && echo "<a target=\"_blank\" href="$linkthai">ไทย</a>"`
$([[ $linkthai != "" ]] && [[ "$args" == *"-conv"* ]] && echo "<a target=\"_blank\" href=\"$linkthai\">ไทย</a>")
`[[ $linksi != "" ]] && [[ "$@" == *"-si"* ]] && echo "<a target=\"_blank\" href="$linksi">සිං</a>"`
$([[ $linksi != "" ]] && [[ "$args" == *"-conv"* ]] && echo "<a target=\"_blank\" href=\"$linksi\">සිං</a>")

</td>" 
#`if [ -n "$audiofile" ]; then echo "<a  href=\"$Audiofileforlink\">$svgicon</a>"; fi`  
echo "<td><p class='sutta'>"

echo "<span class=\"pli-lang inputscript-ISOPali\" lang=\"pi\">$quote_pi<a target=_blank class=\"text-white text-decoration-none\" href=\"$linkgeneral#$anchor\">&nbsp;</a></span><br class=\"btwntrn\">" 
[[ "$quote_ln" != "" ]] && 
echo "<span class=\"eng-lang text-muted font-weight-light\" lang=\"en\">$quote_ln</span>" 
[[ "$quote_var" != "" ]] && 
echo "<span class=\"eng-lang text-muted font-weight-light\" lang=\"en\">$quote_var</span>" 
echo '<br class="styled">' 

echo "</p></td>
</tr>" 
#&#8200

cat $tmpdir/$basefile | sed 's/<[^>]*>//g' | awk -F: 'BEGIN {OFS = ":"} {$2 = gensub("/", "", "g", $2); print $1, $2}' | sed 's/@ *"/@/g' | sed 's/",$//g' | sed 's/ "$//g' | sed 's@/.*/@@g' | awk -F@ '{OFS = "@"} {quote=$4 ; gsub("/", "", quote); print $1, $2, $3, $2, quote}' | sort -t'@' -k2V,2 -k4V,4 -k2n,3 | uniq > $tmpdir/${prefix}readyforawk
