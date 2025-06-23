#!/bin/bash -i
start=`date +%s`
#set -x 
#set +x
#trap read debug

#export LC_ALL=en_US
#export LC_ALL=C.utf8
##############################
# ‘Why don’t I gather grass, 
# sticks, branches, and leaves 
# and make a raft? Riding on the raft
# and paddling with my hands and feet,
# I can safely reach the far shore.
########## sn35.238 ##########
source ./config/script_config.sh --source-only
export LANG=ru_RU.utf8
#export LANG=en_US.UTF-8
args="$@"

if [[ "$@" == *"-nbg"* ]]; then
rand=`echo $@ | awk -F'-nbg-' '{print $2}' | awk '{print $1}' `
else
rand=`echo $RANDOM | md5sum | head -c 5`
fi 
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
cat $apachesitepath/assets/js/timer.js | sed '/time_in_seconds = 300;/s/300/'${timeout}'/' >> $tmphtml
echo "</script>" >> $tmphtml
echo "<script $fontawesomejs></script>" >> $tmphtml
cat $templatefolder/Footer.html | sed "s@('#pali')@('#temporary-$rand')@g"  | sed "/stateSave/s@true@false@g" | sed 's@</tbody>@@g' | sed 's@</table>@@g' | sed 's@WORDSLINKVAR@#not-ready@g' | sed 's@MAINLINKVAR@'${mainpagebase}'@g' | sed 's@READLINKVAR@'${pagelang}'/read.php@g' >> $tmphtml
#| sed 's@HISTREPLACE@'${mainpagebase}/history.php'@g'


fi
((round++))
}
#setInterval(function() {   location.reload();   }, ${timeout} * 1000);
if [[ "$@" == *"-oru"* ]]; then
pagelang="/ru"
mainpagebase="/ru"
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
	3. Скачайте необработанные данные <a class=\"outlink\" href="/esult/${basefile}">здесь</a>
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
sed 's/<p>/\n/g; s/<[^>]*>//g'  | sed  's/": "/ /g' | sed  's/"//1' | sed 's/",$//g' 
}


vin=vinaya
abhi=abhidhamma
sutta=mutta
metaphorcountfile=$textinfofolder/metphrcount_sutta.txt
fortitle="4 Nikayas"
dirlocation=sutta
translator=sujato
fileprefix=_4nikayas
hwithtitle='<h1>'
if [[ "$@" == *"-vin"* ]]; then
    vin=dummy
    sutta=sutta
	fortitle="Vinaya Vibhanga and Patimokkha"
	dirlocation=vinaya
	translator=brahmali
    fileprefix=_vinayavbpm
    metaphorcountfile=$textinfofolder/metphrcount_vinaya.txt
fi
if [[ "$@" == *"-abhi"* ]]; then
    abhi=dummy
    sutta=sutta
	fortitle=Abhidhamma
	dirlocation=abhidhamma
	translator=""
    fileprefix=_abhidhamma
    #echo search in abhidhamma
fi
 
 
 #case for am3.76 3.77 
 
 shopt -s extglob
if [[ "$pattern" == @(taṇh*|dhāt*|cetan*|patthan*|kamm*|khett*|viññāṇ*|bīj*|sneh*|phass*|majjh*|sibbin*|ant*) ]]; 
then
customtexts="|an3.7[67].*${modpattern}|${modpattern}.*dutiyo puriso|an6.61.*${modpattern}|an4.199.*${modpattern}"
fi

if [[ "$@" == *"-kn"* ]]; then
function grepbasefile {
  excludetext='{ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,vv}'
nice -$nicevalue grep -E -Ri${grepvar}${grepgenparam} -B${linesbefore} -A${linesafter} "$pattern" $suttapath/$pali_or_lang --exclude-dir={$sutta,$abhi,$vin,xplayground,name,site,patton} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,pli-tv-kd,pli-tv-pvr,vv} 
}
fileprefix=${fileprefix}-kn
fortitle="${fortitle} + 6 KN books"
elif [[ "$@" == *"-def"* ]]
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
  then
  vin=dummy
vindefpart="${modpattern}.{0,3}—|${modpattern}.{0,3}ti|${modpattern}.*nāma|"
linesafter=1
function grepbasefile {
nice -$nicevalue grep -E -Ri${grepvar}${grepgenparam} -B${linesbefore} -A${linesafter} "$pattern" $suttapath/$pali_or_lang --exclude-dir={$sutta,$abhi,$vin,xplayground,name,site} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,vv,pli-tv-kd,pli-tv-pvr,thag,thig,dhp} > $tmpdef

nice -$nicevalue grep -Ei -B${linesbefore} -A${linesafter} "${vindefpart}\bKata.{0,20} \b${modpattern}.{0,5}\?|\bKatha.{0,20} \b${modpattern}.{0,5}\?|${modpattern}.{0,20}Kat.{0,20} \bho.*\?|${modpattern}.{0,15}, ${modpattern}.{0,25}|${modpattern}.{0,25} vucca|Kiñ.*${modpattern}.{0,9} va|${modpattern}.*ariyassa vinaye|ariyassa vinaye.*${modpattern}" $tmpdef
}
else 
# definitions in Suttanta 

function grepbasefile {
nice -$nicevalue grep -E -Ri${grepvar}${grepgenparam} -B${linesbefore} -A${linesafter} "$pattern" $suttapath/$pali_or_lang --exclude-dir={$sutta,$abhi,$vin,xplayground,name,site} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,vv,pli-tv-kd,pli-tv-pvr,thag,thig,dhp} > $tmpdef

nice -$nicevalue grep -Ei -B${linesbefore} -A${linesafter} "\bKata.{0,40} ${modpattern}.{0,9}[\?,]|\bKatha.{0,40} ${modpattern}.{0,9}[\?,]|\bKo .{0,40}${modpattern}|\bayaṁ .{0,40}${modpattern}|\bKatha.{0,40} \b${modpattern}.{0,5}[\?,]|${modpattern}.{0,20}Kat.{0,20} \bho.*\?|${modpattern}.{0,15}, ${modpattern}.{0,25} vucca|${modpattern}.{0,25} vucca|Kiñ.*${modpattern}.{0,9} va|${modpattern}.*ariyassa vinaye|ariyassa vinaye.*${modpattern}${customtexts}" $tmpdef
}
fi  


function grepbasefileExtended1 {
  fortitle="Definition Extended 1 ${fortitle}"
cat $tmpdef | nice -$nicevalue grep -Ei -B${linesbefore} -A${linesafter} "\b${modpattern}[^\s]{0,3}sutta|${modpattern}.*vacanīy"
}

function grepbasefileExtended2 {
  fortitle="Definition Extended 2 ${fortitle}"
nice -$nicevalue grep  -B${linesbefore} -A${linesafter} -Ei "\bKata.* \b${modpattern}.*[\?,]|\bKatha.* \b${modpattern}.*[,\?]|\bKas.{0,60}${modpattern}.{0,9}[\?,]|${modpattern}[^\s]{0,3}sutta|${modpattern}[^\s]{0,3}vagg[ao]|(dn3[34]|mn4[34]).*(Dv|Ti|Tay|Tī|Cattā|Cata|Pañc|cha|Satta|Aṭṭh|Nav|das).{0,20}${modpattern}|\bKata.{0,20}${modpattern}.{0,9}[\?,]|${modpattern}.*adhivacan|${modpattern}.{0,15}, ${modpattern}.*vucca|${modpattern}.{0,9} vacan|Seyyathāpi.*${modpattern}|Katth.*${modpattern}.*daṭṭhabb|Kiñ.*${modpattern}.{0,9} vadeth|vucca.{2,5} ${modpattern}{0,7}|Yadapi.*${modpattern}.*tadapi.*${modpattern}|an1\..*yadidaṁ ${modpattern}|an1\..*${modpattern}.*yadidaṁ|An2.*Dv.*${modpattern}|An3.*(Tis|Tay|Tī).{0,50}${modpattern}|An4.*(Cattā|Cata).{0,50}${modpattern}|An5.*Pañc.{0,50}${modpattern}|An6.*cha.*${modpattern}|An7.*Satta.*${modpattern}|An8.*Aṭṭh.*${modpattern}|An9.*Nav.*${modpattern}|an1[10].*das.{0,50}${modpattern}|(an3.34|an3.111|an3.112|an6.39|an10.174|dn15|sn12.60|sn14.12).*${modpattern}|(mn135|mn136|mn137|mn138|mn139|mn140|mn141|mn142|sn12.2:|sn45.8|sn47.40|sn48.9:|sn48.10|sn48.36|sn48.37|sn48.38|sn51.20).*${modpattern}|Puna caparaṁ.*${modpattern}" $tmpdef
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
nice -$nicevalue grep -E -Ri${grepvar}${grepgenparam}  -B${linesbefore} -A${linesafter} "$pattern" $suttapath/$pali_or_lang --exclude-dir={$sutta,$abhi,$vin,xplayground,name,site} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,vv,pli-tv-kd,pli-tv-pvr,thag,thig,dhp} > $tmpsml

#for i in `grep -iE "Evamev.*${modpattern}" $tmpsml | awk -F':' '{print $1}' | sort -V | uniq`; do grep -EHi -B1 "Evamev.*${modpattern}" $i | sed 's@json-@json:@g' | grep -vi "Evamev.*${modpattern}" | sort -V | uniq | sed '/--/d'  ; done > tmpsml

if [[ "$type" == html ]]; then
for i in `cat $tmpsml`; do nice -$nicevalue grep -HEi "${vinsmlpart}seyyathāpi.*${modpattern}|${modpattern}[^ ]{0,4}etaṁ|${modpattern}.*adhivacan|Eva[mnṇṅṃṁ].*${modpattern}|${modpattern}.*(ūpam|upam|opam|opamm)|(ūpam|upam|opam|opamm).*${modpattern}|Suppose.*${modpattern}|${modpattern} is|${modpattern}.*is a designation for|is a designation for.*${modpattern}|${modpattern}.*Simile|simile.*${modpattern}|It’s like.*${modpattern}|is a term for.*${modpattern}|${modpattern}.*is a term for|similar to.*${modpattern}|${modpattern}.*similar to|Представ.*${modpattern}|обозначение.*${modpattern}|${modpattern}.*обозначение" $i | grep -vE "$nonmetaphorkeys" | grep -v "condition"| sed 's/html:.*/html/g'  ; 
done
else 
#json sources
nice -$nicevalue grep -Ei -B${linesbefore} -A${linesafter} "${vinsmlpart}seyyathāpi.*${modpattern}|${modpattern}.*adhivacan|${modpattern}.*(ūpam|upam|opam|opamm)|(ūpam|upam|opam|opamm).*${modpattern}|Eva[mnṇṅṃṁ]ev.*${modpattern}|Suppose.*${modpattern}|${modpattern} is|${modpattern}.*is a designation for|is a designation for.*${modpattern}|${modpattern}.*Simile|simile.*${modpattern}|It’s like.*${modpattern}|is a term for.*${modpattern}|${modpattern}.*is a term for|similar to.*${modpattern}|${modpattern}.*similar to|Представ.*${modpattern}|обозначение.*${modpattern}|${modpattern}.*обозначение${customtexts}" $tmpsml | grep -vE "$nonmetaphorkeys" | grep -v "condition" > ${tmpsml}_2

nice -$nicevalue grep -B2 -ERi "Eva[mnṇṅṃṁ].*${modpattern}" $suttapath/$pali_or_lang --exclude-dir={$sutta,$abhi,$vin,xplayground,name,site} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,vv,pli-tv-kd,pli-tv-pvr,thag,thig,dhp} | grep -A1 -i Seyyathāpi | sed 's@json-@json:@g' | sed '/--/d' > ${tmpsml}_3

cat ${tmpsml}_2 ${tmpsml}_3 | sort -V | uniq 
#| grep -vi "Eva[mnṇṅṃṁ].*${modpattern}"
fi
}


#sml end

elif [[ "$@" == *"-all"* ]]; then
function grepbasefile {
nice -$nicevalue grep -E -Ri${grepvar}${grepgenparam} -B${linesbefore} -A${linesafter} "$pattern" $suttapath/$pali_or_lang --exclude-dir={$sutta,$abhi,$vin,xplayground,name,site}
}
fileprefix=_suttanta
fortitle="Suttanta"
if [[ "$@" == *"-vin"* ]]; then
fileprefix=_vinaya
fortitle="Vinaya"
fi


elif [[ "$@" == *"-tru"* ]]; then
function grepbasefile {
nice -$nicevalue grep -E -B${linesbefore} -A${linesafter} -Ri${grepvar}${grepgenparam} "$pattern" $pali_or_lang --exclude-dir={$sutta,$abhi,home,js,css,image} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,pli-tv-kd,pli-tv-pvr,tha-ap,thi-ap,vv} 
}
fileprefix=${fileprefix}
fortitle="${fortitle}"
elif [[ "$@" == *"-b"* ]]; then
function grepbasefile {
nice -$nicevalue grep -E -Ri${grepvar}${grepgenparam} -B${linesbefore} -A${linesafter} "$pattern" $bwlocation
 --exclude-dir={$sutta,$abhi,home,js,css,image,fonts} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,pli-tv-kd,pli-tv-pvr,thi-ap,vv} | grep -vE "(ud|sn|an)[0-9]{0,3}.html|/bw/home"
}
fileprefix=${fileprefix}-bw
fortitle="${fortitle}"
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
nice -$nicevalue grep -Eril -m1 "$pattern" $suttapath/$pali_or_lang --exclude-dir={$sutta,$abhi,$vin,xplayground,name,site,patton} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,pli-tv-kd,pli-tv-pvr,vv}  > iter$iterationnum.$rand
 iterationnum=$((iterationnum + 1))
done
echo "$patternforfind dddd $patternforgrep" >> outgrepcomloop
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
#find $suttapath/$pali_or_lang  -type f -not -path '*/'$sutta'/*' -not -path '*/'$abhi'/*' -not -path '*/'$vin'/*' -not -path '*/xplayground/*' -not -path '*/name/*' -not -path '*/site/*' -not -path '*/ab/*' -not -path '*/bv/*' -not -path '*/cnd/*' -not -path '*/cp/*' -not -path '*/ja/*' -not -path '*/kp/*' -not -path '*/mil/*' -not -path '*/mnd/*' -not -path '*/ne/*' -not -path '*/pe/*' -not -path '*/ps/*' -not -path '*/pv/*' -not -path '*/tha-ap/*' -not -path '*/thi-ap/*' -not -path '*/vv/*' -not -path '*/thag/*' -not -path '*/thig/*' -not -path '*/snp/*' -not -path '*/dhp/*' -not -path '*/iti/*' -not -path '*/ud/*' -print0 | xargs -n$filelimit -r0P$procqnty grep -E -Ri${grepvar}${grepgenparam} "$pattern" > $tmpgb

nice -$nicevalue grep -E -Ri${grepvar}${grepgenparam}  -B${linesbefore} -A${linesafter}  "$pattern" $suttapath/$pali_or_lang --exclude-dir={$sutta,$abhi,$vin,xplayground,name,site} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,vv,thag,thig,dhp,pli-tv-kd,pli-tv-pvr} > $tmpgb
nice -$nicevalue grep -E -Ri${grepvar}${grepgenparam} "$pattern" $suttapath/sc-data/sc_bilara_data/variant/pli/ms/sutta --exclude-dir={$sutta,$abhi,$vin,xplayground,name,site} --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,pli-tv-kd,pli-tv-pvr,tha-ap,thi-ap,vv,thag,thig,dhp} >> $tmpgb
#dhp
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
elif [[ "$@" == *"-ru"* ]]; then
    fnlang=_ru
    pali_or_lang=sc-data/html_text/ru/pli
    language=Russian
    printlang=Русский
    directlink=
    type=html   
    metaphorkeys="как если бы|подоб|представь|обозначение|Точно также, как"
    nonmetaphorkeys="подобного|подоба"
    definitionkeys="что такое.*${pattern}.{0,4}\\?|${pattern}.*говорят|${pattern}.*обозначение|${pattern}.{0,4}, ${pattern}.*говорят"
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
OKresponse
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
cat $templatefolder/Header.html $templatefolder/WordTableHeader.html | sed 's/$title/TitletoReplace/g' | sed 's@HOMEVAR@'$mainpagebase'@'  > $tempfilewords 
else
cat $templatefolder/Header.html $templatefolder/WordTableHeader.html | sed '/forshellscript/d' | sed 's/$title/TitletoReplace/g' > $tempfilewords 
fi 

nice -$nicevalue cat $tempfile | pvlimit | while IFS= read -r line ; do
uniqword=`echo $line | awk '{print $1}'`
uniqwordcount=`echo $line | awk '{print $2}'`
linkscount=`nice -$nicevalue grep -i "\b$uniqword\b" $basefile | sort | awk '{print $1}' | awk -F'/' '{print $NF}' | sort | uniq | wc -l`

if(( $linkscount == 0 ))
then
continue 
fi 

linkswwords=`grep -i "\b$uniqword\b" $basefile | awk '{print $1, $2}' | sort -Vf | awk -F'/' '{print $NF}' | sed 's@_.*json@@g' | sed 's@ @@g' | sort -Vf | awk -F':' '!a[$1]++ {print}' | awk -F':' '{if ($2 ~ /-/) print "<a target=_blank href=\"'${pagelang}'/read/?s='${uniqword}'&q="$1"#"$2":"$3"\">"$2"</a>"; else print "<a target=_blank href=\"'${pagelang}'/read/?s='${uniqword}'&q="$1"#"$3"\">"$2"</a>"}' | xargs`

#&lang=pli
echo "<tr>
<td>`echo $uniqword | highlightpattern`</td>
<td><a href=\$quotesLinkToReplace?f=$uniqword>$linkscount</a></td>   
<td>$uniqwordcount</td>   
<td>$linkswwords</td>
</tr>" >>$tempfilewords

# `(( $linkscount >= 6 )) && echo \"($linkscount)\"`
echo "$uniqword: $linkswwords<br>" >> $tempfilewhistory
done
}


function genbwlinks {
forbwlink=`echo $filenameblock |  awk '{print substr($1,1,2)}' `

  if [[ -s $bwlocation/$forbwlink/${filenameblock}.html  ]] ; then 
  linken=`echo $filenameblock |  awk '{print "'${urllinkbw}${forbwlink}'/"$0".html"}' `
  elif [[ -s $bwlocation/$forbwlink/${forbwranges}.html  ]] ; then 
  linken=`echo $filenameblock |  awk '{print "'${urllinkbw}$forbwlink/$forbwranges'.html"}' `
  else
  linken=`echo $filenameblock |  awk '{print "'$urllinken'"$0"'${urllinkenmid}${urllinkenend}'"}'`
  fi 
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
  if [[ "$mainpagebase" == *"/ru"* ]]; then
cat $templatefolder/Header.html $templatefolder/ResultTableHeaderRu.html | sed 's@HOMEVAR@'$mainpagebase'@' | sed 's/$title/TitletoReplace/g' | tohtml 
else
cat $templatefolder/Header.html $templatefolder/ResultTableHeaderEn.html | sed 's@HOMEVAR@'$mainpagebase'@' | sed 's/$title/TitletoReplace/g' | tohtml 
fi
textlist=`nice -$nicevalue cat $basefile | pvlimit | awk -F':' '{print $1}' | awk -F'/' '{print $NF}' |  awk -F'_' '{print $1}' | sort -Vf | uniq`

for pathAndfile in `nice -$nicevalue cat $basefile | awk -F':' '{print $1}' | sed -E 's@.*(sutta|vinaya|abhidhamma)@@g' |  awk -F'_' -v dirlocation="$dirlocation" '{print dirlocation""$1}' | sort -Vf | uniq` ; do

filenameblock=`echo $pathAndfile | awk -F'/' '{print $NF}'| sort -Vf | uniq`
pathblock=`echo $pathAndfile | awk -F'/' '{ var=NF-1 ; for (i=1;i<=var;i++) printf $i"/"}'`

#echo "flnblck=$filenameblock pathblock=$pathblock" 
#| tohtml

  #old find block
  #  roottext=`nice -$nicevalue find $lookup/root/pli/ms/$pathblock -name "*${filenameblock}_*" -not -path "*/blurb/*" -not  -path "*/name*" -not -path "*/site/*"`
 #   translation=`nice -$nicevalue find $lookup/translation/en/$translator/$pathblock -name "*${filenameblock}_*" -not -path "*/blurb/*" -not  -path "*/name*" -not -path "*/site/*" |head -n1`
 #   variant=`nice -$nicevalue find $lookup/variant/pli/ms/$pathblock -name "*${filenameblock}_*" -not -path "*/blurb/*" -not  -path "*/name*" -not -path "*/site/*"`
   roottext=`ls $lookup/root/pli/ms/$pathblock/*${filenameblock}_*`
   
   #roottext=`for f in $lookup/root/pli/ms/$pathblock/*${filenameblock}_*; do ;  [ -e "$f" ] && echo "$f" ; break ; done`

 #echo "$roottext $roottext2"
 lettersblock=`echo $filenameblock | sed 's@[0-9]*@@g'`
 numberblock=`echo $filenameblock | sed 's@[A-Za-z]*@@g'`
#echo "$filenameblock $pathblock $lettersblock $numberblock" | tohtml
checktrnfile="`ls $apachesitepath/assets/texts/$pathblock/*${filenameblock}_translation* 2>/dev/null | tail -n1`"


pathblocknotexttype=$(echo $pathblock | sed 's@sutta@@')
audiofile=$(ls "$apachesitepath/assets/audio/$pathblocknotexttype/${filenameblock}_"* 2> /dev/null | tail -n1)
Audiofileforlink=$(echo "$audiofile" | sed "s|$apachesitepath||")

svgicon='<?xml version="1.0" encoding="utf-8"?>
<svg style="fill:currentColor;" height="18px" width="18px" version="1.1" id="Listening" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
	 viewBox="0 0 128 128" xml:space="preserve">
	 <g transform="translate(-15,-15)">
<path id="_x34__1_" d="M39.6,108.1c-8.8,0-16-7.2-16-16c0-2.2,1.8-4,4-4s4,1.8,4,4c0,4.4,3.6,8,8,8c2.8,0,5.4-1.5,6.9-3.9
	c0.6-1,1.4-2.8,2.3-4.7c1.7-3.8,3.6-8.1,6-11.2c1.9-2.5,4.7-5,7.4-7.5c2.7-2.5,5.8-5.4,6.8-7.2c2-3.5,3-7.4,3-11.4
	c0-12.7-10.3-23-23-23s-23,10.3-23,23c0,2.2-1.8,4-4,4s-4-1.8-4-4c0-17.1,13.9-31,31-31c17.1,0,31,13.9,31,31
	c0,5.4-1.4,10.7-4.1,15.4c-1.6,2.9-4.9,5.9-8.4,9.1c-2.4,2.3-5,4.6-6.5,6.5c-1.8,2.3-3.6,6.3-5,9.5c-1,2.2-1.8,4.1-2.7,5.6
	C50.5,105.1,45.2,108.1,39.6,108.1z"/>
<path id="_x33__2_" d="M34,79.6c-2.2,0-4-1.8-4-4s1.8-4,4-4c2,0,3.7-1.6,3.7-3.7c0-2-1.6-3.7-3.7-3.7c-2.2,0-4-1.8-4-4v-6
	c0-10.5,8.5-19,19-19s19,8.5,19,19c0,3.3-0.8,6.5-2.4,9.3c-0.1,0.1-0.1,0.2-0.2,0.3c-0.8,1.2-2.7,3-5.9,6l-1.2,1.1
	c-1.6,1.5-4.2,1.4-5.7-0.2c-1.5-1.6-1.4-4.2,0.2-5.7L54,64c2.6-2.4,4.2-3.9,4.7-4.6c0.8-1.6,1.3-3.4,1.3-5.2c0-6.1-4.9-11-11-11
	s-11,4.9-11,11v2.7c4.5,1.6,7.7,5.9,7.7,11C45.7,74.3,40.5,79.6,34,79.6z"/>
<path id="_x32__15_" d="M85,78.7c-0.6,0-1.2-0.2-1.7-0.5c-1.7-1-2.2-3.1-1.3-4.8c3.3-5.8,5.1-12.3,5.1-19c0-6.8-1.8-13.4-5.2-19.2
	c-1-1.7-0.4-3.8,1.2-4.8c1.7-1,3.8-0.4,4.8,1.2c4.1,6.9,6.2,14.8,6.2,22.8c0,7.9-2.1,15.6-6,22.5C87.4,78.1,86.2,78.7,85,78.7z"/>
<path id="_x31__17_" d="M95.9,90.1c-0.8,0-1.5-0.2-2.2-0.7c-1.8-1.2-2.3-3.7-1.1-5.6c5.9-8.7,9-18.8,9-29.4
	c0-10.6-3.2-20.9-9.2-29.6c-1.2-1.8-0.8-4.3,1-5.6c1.8-1.2,4.3-0.8,5.6,1c6.9,10.1,10.6,21.9,10.6,34.1c0,12.1-3.6,23.8-10.3,33.8
	C98.4,89.5,97.1,90.1,95.9,90.1z"/>
	</g>
</svg>'

#matching_files=( $apachesitepath/assets/texts/$pathblock/*${filenameblock}_translation*{+o,-o}.json )
#if [[ ${#matching_files[@]} -gt 0 ]]; then
  # Найдены файлы с "+o.json" или "-o.json"
#  checktrnfile="${matching_files[0]}"
#else
  # Файлы с "+o.json" или "-o.json" не найдены
#  checktrnfile="$apachesitepath/assets/texts/$pathblock/*${filenameblock}_translation*"
#fi

if [[ "$args" == *"-oru"* ]] && [ -f "$checktrnfile" ]; then
defaultlang='lang=pli-rus'
fnlang=_ru

defaultlang='lang=pli-rus'
 translation="$checktrnfile"
 else
 defaultlang='lang=pli'
    translation=`ls $lookup/translation/en/$translator/$pathblock/*${filenameblock}_*`
fi   
    variant=`ls $lookup/variant/pli/ms/$pathblock/*${filenameblock}_* 2>/dev/null`
    
    np=`echo $filenameblock | sed 's@\.@_@g'`




if [[ "$language" == *"Pali"* ]]; then
        file=$roottext
elif [[ "$language" == "English" ]]; then
        file=$translation
fi 
   
if echo $filenameblock | grep -E "(sn|an)[0-9]{0,2}.[0-9]{0,3}-[0-9]{0,3}" >/dev/null || echo $filenameblock | grep -E "dhp[0-9]{0,3}-[0-9]{0,3}" >/dev/null
then 
suttanumber=`nice -$nicevalue grep -E -Ei $filenameblock $basefile | awk '{print $2}' | awk -F':' '{print $1}' | sort | uniq `
forbwranges=$suttanumber 
else 
suttanumber=$filenameblock
fi 
if [[ "$roottext" == *"/dhp/"* ]] ||  [[ "$roottext" == *"/iti/"* ]] ||  [[ "$roottext" == *"/ja/"* ]] 
        then 
        roottitle=`nice -$nicevalue grep -m1 ':0\.4' $roottext | clearsed | awk '{print substr($0, index($0, $2))}' | xargs `
elif [[ "$roottext" == *"/pli-tv-pvr/"* ]] 
then
roottitle=`nice -$nicevalue grep -E -m3 ':0\.[23]' $roottext | clearsed | awk '{print substr($0, index($0, $2))}' | xargs `
elif [[ "$roottext" == *"/pli-tv-bu-pm"* ]] || [[ "$roottext" == *"/pli-tv-bi-pm"* ]] 
then
roottitle=`nice -$nicevalue grep -E -m2 ':0\.2' $roottext | clearsed | awk '{print substr($0, index($0, $2))}' | xargs `
elif [[ "$roottext" == *"/pli-tv-kd/"* ]] 
then
roottitle=`nice -$nicevalue grep -E -m3 ':0\.[3-4].*khandhaka' $roottext | clearsed | awk '{print substr($0, index($0, $2))}' | xargs `
elif [[ "$roottext" == *"/pli-tv-b"* ]] 
then
  roottitle=`nice -$nicevalue grep -E -m3 ':0\.[3-5].*sikkhāpada' $roottext | clearsed | awk '{print substr($0, index($0, $2))}' | xargs `
elif ls $roottext | grep -E -q -m1 "sn[0-9]{0,2}.[0-9]*_"
then

getSamyuttaname

roottitle=`nice -$nicevalue grep -m5 ':0\.' $roottext | clearsed | awk '{print substr($0, index($0, $2))}' | xargs | grep -E -oE "[^ ]*sutta[^ ]*"`

roottitle="$roottitle $samyuttaname"
elif ls $roottext | grep -m1 -E -q "sn[0-9]{0,3}.[0-9]*-[0-9]*_"
then

getSamyuttaname

      roottitle="`nice -$nicevalue grep -Ei -m1 "$pattern" $roottext | clearsed | awk '{print $1}' | awk -F':' '{print $1}' | sort -Vf | uniq |  xargs ` $samyuttaname"

elif ls $roottext | grep -m1 -E -q "an[0-9]{0,3}.[0-9]*-[0-9]*_"
then

      roottitle="`nice -$nicevalue grep -Ei -m1 "$pattern" $roottext | clearsed | awk '{print $1}' | awk -F':' '{print $1}' | sort -Vf | uniq |  xargs `"
else 
roottitle=`nice -$nicevalue grep -m1 -oE "[^ ]*sutta[^ ]*" $roottext | clearsed `
fi 
#echo -e "Content-Type: text/html\n\n"
#echo $@

if [[ "$translation" == *"/dn/"* ]] || [[ "$translation" == *"/mn/"* ]] || [[ "$translation" == *"/ud/"* ]] 
        then 
        trntitle=`nice -$nicevalue grep -m1 ':0\.2' $translation | clearsed | awk '{print substr($0, index($0, $2))}' | xargs `
elif [[ "$translation" == *"/dhp/"* ]] ||  [[ "$translation" == *"/iti/"* ]] 
        then 
        trntitle=`nice -$nicevalue grep -m1':0\.4' $translation | clearsed | awk '{print substr($0, index($0, $2))}' | xargs `
elif [[ "$translation" == *"/pli-tv-b"* ]] 
then
trntitle=`nice -$nicevalue grep -E -m3 ':0\.[3-5].*rule' $translation | clearsed | awk '{print substr($0, index($0, $2))}' | xargs `
        else
        trntitle=`nice -$nicevalue grep -m1 ':0\.3' $translation | clearsed | awk '{print substr($0, index($0, $2))}' | sort -Vf | uniq | xargs `
        fi 
translatorsname=`echo $translation | awk -F'/en/' '{print $2}' | awk -F'/' '{print $1}'`

if [[ "$fortitle" == *"4 Nikayas"* ]]
then
linkthai=`echo $filenameblock |  awk -v lkth="$linkforthai" -v ext="$linkforthaiext" '{print lkth$0''ext}' `
linksi=`echo $filenameblock |  awk -v lksi="$linkforsi" -v ext="$linkforsiext" '{print lksi$0''ext}' `
link=`echo $filenameblock |  awk -v lkru="$linkforru" -v ext="$linkforruext" '{print lkru$0''ext}' `

htmlpattern=$(echo "$pattern" | sed 's/\\.//g' | sed 's/ /%20/g')

linkgeneral=`echo $filenameblock | awk '{print "'${pagelang}'/read/?s='${htmlpattern}'&q="$0}' ` 
elif  [[ "$fortitle" == *"Abhidhamma"* ]] 
then 
linkgeneral=`echo $filenameblock |  awk '{print "https://suttacentral.net/"$0}' ` 
else
linkgeneral=`echo $filenameblock |  awk '{print "'${pagelang}'/read/?q="$0}' ` 
fi




#"&'$defaultlang'

linkpli=`echo $filenameblock |  awk '{print "'$urllinkpli${pagelang}'/read/?q="$0}' `
#"&'$defaultlang'"
#echo "root=$roottext trn=$translation" 

genbwlinks

count=`nice -$nicevalue grep -E -oi$grepgenparam "$pattern" $file $variant | wc -l ` 
echo $count >> $tempfile

word=`getwords | grepexclude | removeindex | clearsed | sedexpr | awk '{print tolower($0)}' | highlightpattern | xargs` 

if [[ "$suttanumber" != *"pli-tv-bi-vb-pd2-8"* ]] && [[ "$suttanumber" != *"pli-tv-bi-vb-pj1-4"* ]] && [[ "$suttanumber" != *"pli-tv-bi-vb-pc91-93"* ]] && [[ "$suttanumber" != *"pli-tv-bu-vb-as1-7"* ]] && [[ "$suttanumber" != *"pli-tv-bi-vb-as1-7"* ]] 
then
indexlist=`nice -$nicevalue grep -E -i "${suttanumber}:" $basefile | awk '{print $2}' | sort -Vf | uniq`
else 
indexlist=`nice -$nicevalue grep -E -i "pli-tv-b[ui]-vb" $basefile | awk '{print $2}' | sort -Vf | uniq`
fi

firstIndex=$(echo $indexlist | tr ' ' '\n' | head -n1 | awk -F':' '{print $2}'  )

if [[ $filenameblock == *"-"* ]] && [[ $fortitle == *"4 Nikayas"* ]]
then
firstIndex=$(echo $indexlist | tr ' ' '\n' | head -n1  )
fi

linkgeneralwithindex="$linkgeneral#$firstIndex"
#echo "ind=$indexlist ls=`ls $basefile` stn=$suttanumber fnb=$filenameblock"

metaphorcount=`nice -$nicevalue grep -m1 ${filenameblock}_ $metaphorcountfile | awk '{print $2}'`
if [[ $metaphorcount == "" ]]
then

metaphorcount=`nice -$nicevalue cat $file | pvlimit | clearsed | nice -$nicevalue grep -iE "$metaphorkeys" | nice -$nicevalue grep -vE "$nonmetaphorkeys" | tr -s ' '  '\n' | nice -$nicevalue grep -iE "$metaphorkeys" | wc -l` 
sankhamEvamcount=`cat $file | tr '\n' '\a' | grep -ioc 'saṅkhaṁ gacchati.*Evame'`
metaphorcount=$(( $metaphorcount + $sankhamEvamcount ))
fi
#<a target=\"_blank\" href="$linken">En</a> 
echo "<tr>
<td><a class=\"freebutton\" target=\"_blank\" href="$linkgeneralwithindex">$filenameblock</a></td>
<td><input type='checkbox' data-index="$filenameblock"></td>
<td><strong class=\"pli-lang inputscript-ISOPali\">`echo $roottitle | highlightpattern` </strong>`echo ${trntitle}  | highlightpattern ` </td>
<td class=\"pli-lang inputscript-ISOPali\">${word}</td>
<td>$count</td>   
<td>$metaphorcount</td>
<td>
`[ "$suttanumber" != "" ] && [[ "$fortitle" == *"4 Nikayas"* ]] && echo "<a  href='' onclick=openDpr('$suttanumber') >Pi</a>"` 

<a class='bwLink' href='' data-slug='$suttanumber'>En</a>
<a class='ruLink' href='' data-slug='$suttanumber'>Ru</a>



`[[ $linkthai != "" ]] && [[ "$@" == *"-th"* ]] && echo "<a target=\"_blank\" href="$linkthai">ไทย</a>"`
$([[ $linkthai != "" ]] && [[ "$args" == *"-conv"* ]] && echo "<a target=\"_blank\" href=\"$linkthai\">ไทย</a>")
`[[ $linksi != "" ]] && [[ "$@" == *"-si"* ]] && echo "<a target=\"_blank\" href="$linksi">සිං</a>"`
$([[ $linksi != "" ]] && [[ "$args" == *"-conv"* ]] && echo "<a target=\"_blank\" href=\"$linksi\">සිං</a>")

</td>" | tohtml
#`if [ -n "$audiofile" ]; then echo "<a  href=\"$Audiofileforlink\">$svgicon</a>"; fi`  
echo "<td><p>" | tohtml 
for i in $indexlist
do

indexForAnchor=` echo $i` 
 fileForAnchor=`echo $roottext | awk -F'/' '{print $NF}' | awk -F'_' '{print $1}'` 
 
 if [[ "$fileForAnchor" == *"-"* ]] && [[ $fortitle == *"4 Nikayas"* ]]
 then
 anchor="$indexForAnchor"
 else 
 anchor=`echo $indexForAnchor | awk -F':' '{print $2}'`
 fi
 
 if [ "$linesafter" -eq 0 ] && [ "$linesbefore" -eq 0 ]; then
   quote_pi=`nice -$nicevalue grep -iE -m1 "${i}(:|[^0-9]|$)" $roottext | grep -v "^--$" | removeindex | clearsed | awk '{print substr($0, index($0, $2))}'  | highlightpattern | grep -viE "(^}$|^{$})" | grep -viE "^$" | sed 's/[[:space:]]*$//' `
  quote_ln=`nice -$nicevalue grep -iE -m1 "${i}(:|[^0-9]|$)" $translation | grep -v "^--$" | removeindex | clearsed | awk '{print substr($0, index($0, $2))}'  | highlightpattern | grep -viE "(^}$|^{$})" | grep -viE "^$" | sed 's/[[:space:]]*$//' ` 
 quote_var=`nice -$nicevalue grep -iE -m1 "${i}(:|[^0-9]|$)" $variant | grep -v "^--$" | removeindex | clearsed | awk '{print substr($0, index($0, $2))}'  | highlightpattern | grep -viE "(^}$|^{$})" | grep -viE "^$" | sed 's/[[:space:]]*$//' `  
    else
    quote_pi=`nice -$nicevalue grep -iE -m1 "${i}(:|[^0-9]|$)" $roottext | removeindex | clearsed | awk '{print substr($0, index($0, $2))}'  | highlightpattern | sed '$!G; $!G' | sed '/^$/s/$/<br>\n/' | grep -viE "(^}$|^{$})" | sed 's/[[:space:]]*$//' `
    
    quote_ln=`nice -$nicevalue grep -iE -m1 "${i}(:|[^0-9]|$)" $translation | removeindex | clearsed | awk '{print substr($0, index($0, $2))}'  | highlightpattern | sed '$!G; $!G' | sed '/^$/s/$/<br>\n/' | grep -viE "(^}$|^{$})" | sed 's/[[:space:]]*$//' `
    
    quote_var=`nice -$nicevalue grep -iE -m1 "${i}(:|[^0-9]|$)" $variant | removeindex | clearsed | awk '{print substr($0, index($0, $2))}'  | highlightpattern | sed '$!G; $!G' | sed '/^$/s/$/<br>\n/' | grep -viE "(^}$|^{$})" | sed 's/[[:space:]]*$//' `
fi

echo "<span class=\"pli-lang inputscript-ISOPali\" lang=\"pi\">$quote_pi<a target=_blank class=\"text-white text-decoration-none\" href=\"$linkgeneral#$anchor\">&#8202;</a></span><br class=\"btwntrn\">" 
[[ "$quote_ln" != "" ]] && 
echo "<span class=\"eng-lang text-muted font-weight-light\" lang=\"en\">$quote_ln</span>" 
[[ "$quote_var" != "" ]] && 
echo "<span class=\"eng-lang text-muted font-weight-light\" lang=\"en\">$quote_var</span>" 
echo '<br class="styled">' 
done | tohtml 

echo "</p></td>
</tr>" | tohtml
writeToTmpHtml
done
matchqnty=`awk '{sum+=$1;} END{print sum;}' $tempfile`

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
cat $templatefolder/Header.html $templatefolder/ResultTableHeader.html | sed 's/$title/TitletoReplace/g' | sed 's@HOMEVAR@'$mainpagebase'@' | tohtml 
else
cat $templatefolder/Header.html $templatefolder/ResultTableHeader.html | sed 's/$title/TitletoReplace/g' |sed '/forshellscript/d'  | sed 's@HOMEVAR@'$mainpagebase'@' | tohtml 

fi 

uniquelist=`cat $basefile |grep -vE "(ud|sn|an)[0-9]{0,3}.html|/bw/home" | grep -Ev "palisearch|engsearch|standalone.js" | pvlimit | awk '{print $1}' | awk -F'/' '{print $NF}' | sort -Vf | uniq`


textlist=$uniquelist
    for i in $uniquelist
do

if [[ "$args" == *"-tru"* ]]; then
filenameblock=`echo $i |  sed 's/-.*//g' | sed 's@_@.@g' | sort -Vf | uniq `
else 
filenameblock=`echo $i |  sed 's/.html//g' | sort -Vf | uniq `
fi 

file=`grep -m1 "${i}" $basefile `

tr=$file

    suttanumber="$filenameblock"

linkgeneral=`echo $filenameblock |  awk '{print "'${pagelang}'/read/?q="$0}' `
#"&'$defaultlang'"
linklang="$linkgeneral"


if [[ "$@" == *"-b"* ]]; then
roottext=`nice -$nicevalue find $bwlocation -name "*${filenameblock}_*" -not -path "*/home/*" -not  -path "*/css/*" -not -path "*/js/*" -not -path "*/engsesrch/*"`
else
#pathblock=`echo $pathAndfile | awk -F'/' '{ var=NF-1 ; for (i=1;i<=var;i++) printf $i"/"}'`
#roottext=`ls $lookup/root/pli/ms/$pathblock/*${filenameblock}_*`

roottext=`nice -$nicevalue find $lookup/root -name "*${filenameblock}_*" -not -path "*/blurb/*" -not  -path "*/name*" -not -path "*/site/*"`
fi
        if [[ "$language" == *"Pali"* ]]; then
        file=$roottext
   # elif [[ "$language" == "Russian" ]]; then
   else
        file=$tr
        remtitle=`echo $filenameblock | sed 's/[A-Za-z]//g'`
suttatitle=`grep -m1 $hwithtitle $file | clearsed | xargs | sed 's@'$remtitle'@@g'`

	   np=`echo $filenameblock | sed 's@\.@_@g'`
   # tr=`find $searchdir -name "*${np}-*"`
tr=`ls $searchdir/*${np}-* 2>/dev/null`
     thrulink=`echo $tr | sed 's@.*theravada.ru@'$linkforthru'@g'`

linklang="$thrulink"	
fi

roottitle=`nice -$nicevalue grep -m5 ':0\.' $roottext | clearsed | awk '{print substr($0, index($0, $2))}' | xargs | grep -E -oE "[^ ]*sutta[^ ]*"`

if ls $roottext | grep -m1 -E -q "sn[0-9]{0,2}.[0-9]*_"
then
roottitle=`nice -$nicevalue grep -m1 "${suttanumber}," $sntoccsv | awk -F',' '{print $8" "$4}' | sort -Vf | uniq`
fi
  
 if [[ $filenameblock == *"dn"* ]]
then 
if [[ $mode == "offline" ]]
then 
dnnumber=`echo $filenameblock | sed 's/dn//g'`
linklang="`ls -R $thsulocation/dn/ | grep -m1 \"dn${dnnumber}.html\" | awk -v lths="$linkforthsu" '{print lths\"/dn/\"$0}'`"
else 
linklang=` grep "ДН $dnnumber" $thsucurldn | sed 's#href=\"/toc/translations/#href=\"https://tipitaka.theravada.su/node/table/#' |awk -F'"' '{print $2}'`
fi
  fi    
  
genbwlinks
  

linkthai=`echo $filenameblock |  awk -v lkth="$linkforthai" -v ext="$linkforthaiext" '{print lkth$0''ext}' `
linksi=`echo $filenameblock |  awk -v lksi="$linkforsi" -v ext="$linkforsiext" '{print lksi$0''ext}' `

count=`nice -$nicevalue grep -E -oi$grepgenparam "$pattern" $file $variant | wc -l ` 
echo $count >> $tempfile

word=`getwords | grepexclude | xargs | clearsed | sedexpr | highlightpattern`
indexlist=`nice -$nicevalue grep -E -i $filenameblock $basefile | awk '{print $2}'`

metaphorcount=`nice -$nicevalue grep -m1 ${filenameblock}_ $metaphorcountfile | awk '{print $2}'`
if [[ $metaphorcount == "" ]]
then

metaphorcount=`nice -$nicevalue cat $file | pvlimit | clearsed | nice -$nicevalue grep -iE "$metaphorkeys" | nice -$nicevalue grep -vE "$nonmetaphorkeys" | tr -s ' '  '\n' | nice -$nicevalue grep -iE "$metaphorkeys" | wc -l` 
sankhamEvamcount=`cat $file | tr '\n' '\a' | grep -ioc 'saṅkhaṁ gacchati.*Evamev'`
metaphorcount=$(( $metaphorcount + $sankhamEvamcount ))
fi

echo "<tr>
<td><a target=\"_blank\" href="$linkgeneral">$suttanumber</a></td>
<td><input type='checkbox'></td>
<td><strong class=\"pli-lang inputscript-ISOPali\">`echo $roottitle | highlightpattern`</strong>`echo "${suttatitle}" | highlightpattern ` </td>
<td class=\"pli-lang inputscript-ISOPali\">$word</td>
<td>$count</td>   
<td>$metaphorcount</td>
<td><a target=\"_blank\" href="$linken">Eng</a>&nbsp;
`[[ $linkthai != "" ]] && echo "<a target=\"_blank\" href="$linkthai">ไทย</a>&nbsp;"`
`[[ $linksi != "" ]] && echo "<a target=\"_blank\" href="$linksi">සිං</a>&nbsp;"`
<a target=\"_blank\" href="$linklang">Рус</a>`[[ "$thrulink" != "" ]] && [[ "$thrulink" != "$linklang" ]] && echo "&nbsp;<a target=\"_blank\" href="$thrulink">Вар. 2</a>"` 
</td>
<td>" | tohtml

nice -$nicevalue grep -E -B${linesbefore} -A${linesafter} -ih "${pattern}" $file | grep -v "^--$" | clearsed | highlightpattern  | while IFS= read -r line ; do
echo "$line"
echo '<br class="styled">'
done | tohtml

echo "</td>
</tr>" | tohtml
writeToTmpHtml
done

matchqnty=`awk '{sum+=$1;} END{print sum;}' $tempfile`
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
echo grepbase > time_output.txt
{ time grepbasefile | grep -v "^--$" | grepexclude | clearsed | sort -Vf ;} 2>> time_output.txt > $basefile
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
linescount=`wc -l $basefile | awk '{print $1}'`
if [ ! -s $basefile ]
then

pattern="`echo $pattern | sed 's/\[ёе\]/е/g'`"
	Erresponse
	#Clarification
     rm $basefile
     exit 1
elif [ $linescount -ge $maxmatchesbg ] && [[ "$@" != *"-nbg"* ]];  then 
bgswitch
exit 3
#	echo "$@" | sed 's/-oru //g' | sed 's/-oge //g' | sed 's/-ogr //g'   | sed 's/-nbg //g' >> ../input/input.txt     
elif [ $totaltexts -ge $minmatchesforonline ]  && [[ "$@" != *"-onl"* ]] && [[ "$@" != *"-nbg"* ]];  then  
rm $tmphtml
cd ..
nohup bash scripts/finddhamma.sh -nbg-$rand $@ >/dev/null 2>&1 & disown

counter=0
while [ $counter -lt 60 ]; do
if [ -f "./result/$tmphtml" ] && grep -q "</html>" ./result/$tmphtml; then
        echo "<script>window.location.href=\"./result/$tmphtml\";</script>"
        break
    else
        if [ $counter -eq 59 ]; then
            GeneralError
            break
        else
            sleep 1
            ((counter++))
        fi
    fi
done
exit 0     
fi

}

rm $basefile > /dev/null 2>&1
getbasefile "$@"
cp $basefile bfl
#cleanup in case the same search was launched before
rm ${table} $tempfile $tempfilewords $tempfilewhistory > /dev/null 2>&1
###
###  basefile operations end
###

#add links to each file
echo linklist function part >> time_output.txt
round=1
{ time linklist ;} 2>> time_output.txt
echo end of linklist function part >> time_output.txt
if [[ "$language" == *"Pali"* ]] ||  [[ "$language" == *"English"* ]]; 
then
echo genwordsfile >> time_output.txt
{ time genwordsfile ;} 2>> time_output.txt
fi 
textsqnty=`echo $textlist | wc -w`

pattern="`echo $pattern | sed 's/\[ёе\]/е/g'`"
pattern=$userpattern
title="`echo "$pattern" | sed 's/^[[:lower:]]/\U&/'`${addtotitleifexclude} $textsqnty texts and $matchqnty matches in $fortitle $language"

if [[ "$@" == *"-nm"* ]]; then
title="`echo "$pattern" | sed 's/^[[:lower:]]/\U&/'`${addtotitleifexclude} $textsqnty texts and $matchqnty matches in $fortitle $language Top-$numbersmatches"
fi


titlewords="`echo "$pattern" | sed 's/^[[:lower:]]/\U&/'`${addtotitleifexclude} $uniqwordtotal related words in $textsqnty texts and $matchqnty matches in $fortitle $language"

sed -i 's/TitletoReplace/'"$title"'/g' ${table}
sed -i 's/TitletoReplace/'"$titlewords"'/g' ${tempfilewords}

OKresponse

#finalize words file 
oldname=$tempfilewords
removerand=`echo $tempfilewords| sed 's@\.'$rand'@@'`
if [[ "$language" == *"Pali"* ]] ||  [[ "$language" == *"English"* ]]; 
then
tempfilewords=${removerand}_${textsqnty}-${matchqnty}-${uniqwordtotal}.html
else
tempfilewords=${removerand}_${textsqnty}-${matchqnty}.html
fi 

# echo "</tbody>
# </table>
# <br><br><hr>
# <a href='/' id='back'>Main</a>&nbsp;
# <a href='${pagelang}/sc'>Read</a>&nbsp;
# <a href='/assets/diff'>SuttaDiff</a>&nbsp;
# <a href='/history.php'>History</a>&nbsp;"  | tohtml

if [[ "$language" == *"Pali"* ]] || [[ "$language" == *"English"* ]]; 
	then
#echo "<a href=\"/result/${tempfilewords}\">Words</a>" | tohtml
#replace button href in qoute file

#echo "<script $fontawesomejs></script>" | tohtml
		cat $templatefolder/Footer.html | sed 's@WORDSLINKVAR@'${pagelang}'/result/'${tempfilewords}'@g' | sed 's@MAINLINKVAR@'${mainpagebase}'@g' | sed 's@READLINKVAR@'${pagelang}'/read.php@g' | tohtml
	else
#| sed 's@HISTREPLACE@'${mainpagebase}/history.php'@g'
#echo "<script $fontawesomejs></script>" | tohtml
		cat $templatefolder/Footer.html | sed '/WORDSLINKVAR/d' | sed 's@MAINLINKVAR@'${mainpagebase}'@g' | sed 's@READLINKVAR@'${pagelang}'/read.php@g' | tohtml
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
<a href='${pagelang}/history.php'>History</a>&nbsp;
<a href=\"${pagelang}/result/${table}\">Quotes</a>
" >> $tempfilewords
#replace button href in word file
#echo "<script $fontawesomejs></script>"  >> $tempfilewords
cat $templatefolder/WordsFooter.html >> $tempfilewords
mv ./$oldname ./$table

if [[ "$language" == *"Pali"* ]] ||  [[ "$language" == *"English"* ]]; 
then
sed -i 's@$quotesLinkToReplace@'./$table'@' ./$tempfilewords
sed -i 's@$wordLinkToReplace@'./$tempfilewords'@' ./$table
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
<tr><td><a class=\"outlink\" href=\"./result/${table}\">${userpattern}</a></td><td><label class='star-checkbox'><input type='checkbox' data-index=\"${table}\"/><i class='fa-regular fa-star'></i></label></td><td>$textsqnty</td><td>$matchqnty</td><td><a class=\"outlink\" href=\"./result/${tempfilewords}\">$uniqwordtotal</a></td><td>${fortitle^}$langforhist</td><td>$language</td><td class=\"daterow\">$dateforhist</td><td>`ls -lh ${table} | awk '{print  $5}'`</td><td>" >> $history
#}'`</td><td><label  class='custom-checkbox'><input type='checkbox' class='star-checkbox' data-index='1'/><i class='fa-solid fa-star glyphicon glyphicon-star-empty'></i><i class='fa-solid fa-star glyphicon glyphicon-star'></i></label></td><td>"
if [[ "$type" == json ]]; then
  if (( $textsqnty <= 40 ))
  then
  echo -n "<br>`cat $tempfilewhistory | grep href | sed -E "s@$patternForHighlight@<b>&</b>@I" | xargs`" >> $history
  else 
  echo -n "<br>" >> $history
  fi
elif  [[ "$language" == Thai ]] && [[ "$fortitle" == *"4 Nikayas"* ]]
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
echo "<script>
window.location.href=\"$pagelang/result/${table}\";
</script>"

end=`date +%s`
runtime=$((end-start))
echo total execution time $runtime >> time_output.txt
find . -type f -name 'search-*.html' -mmin +60 -exec rm {} \;
exit 0
