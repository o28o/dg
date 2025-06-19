source ./config/script_config.sh --source-only

#downloaddir=/media/c/Users/o28o/Downloads
#trndir=/media/c/soft/dg/assets/texts/sutta/
thtrndir=/data/data/com.termux/files/usr/share/apache2/default-site/htdocs/assets/texts/th/translation/sutta/

cd $downloaddir
for file in `find . -maxdepth 1 -type f -size +0 -name "*root-pli-ms.json" 2>/dev/null`
do
newname=$(echo $file | sed 's@root-pli-ms@translation-ru-o@g')
echo renamed $file $newname
mv $file $newname
done

cd - 2>&1 >/dev/null

#find "$downloaddir" -maxdepth 1 -type f -size 0 -name "*translation*.json" | xargs rm

#ru trn 
for file in `find "$downloaddir" "$downloaddir/Telegram" -maxdepth 1 -type f -size +0 -name "*translation-ru-*.json" 2>/dev/null`
do 
suttaname=$(echo $file | sed -E 's/_translation.*//' | awk -F'/' '{print $NF}')

if [[ $suttaname =~ snp|iti|thig|thag|ud ]]; then
nikaya=kn/$(echo "$suttaname" | sed -E 's/[0-9]+.*//')
booknumber=vagga$(echo $suttaname | sed -E 's/\..*//' | sed 's/[a-z]*//g')
elif [[ $suttaname =~ dhp ]]; 
then
nikaya=kn/$(echo "$suttaname" | sed -E 's/[0-9]+.*//')
booknumber=''
elif [[ $suttaname =~ mn|dn ]]; 
then
booknumber=
    nikaya=$(echo "$suttaname" | sed -E 's/[0-9]+.*//')


else
booknumber=$(echo $suttaname | sed -E 's/\..*//')
    nikaya=$(echo "$suttaname" | sed -E 's/[0-9]+.*//')
fi

mv $file $trndir/$nikaya/$booknumber/
echo "moved $suttaname to ./$nikaya/$booknumber" 
done

#thai trn
for file in `find "$downloaddir" "$downloaddir/Telegram" -maxdepth 1 -type f -size +0 -name "*translation-th-*.json" 2>/dev/null`
do 
suttaname=$(echo $file | sed -E 's/_translation.*//' | awk -F'/' '{print $NF}')

if [[ $suttaname =~ snp|iti|thig|thag|ud ]]; then
nikaya=kn/$(echo "$suttaname" | sed -E 's/[0-9]+.*//')
booknumber=vagga$(echo $suttaname | sed -E 's/\..*//' | sed 's/[a-z]*//g')
elif [[ $suttaname =~ dhp ]]; 
then
nikaya=kn/$(echo "$suttaname" | sed -E 's/[0-9]+.*//')
booknumber=''

elif [[ $suttaname =~ mn|dn ]]; 
then
booknumber=
    nikaya=$(echo "$suttaname" | sed -E 's/[0-9]+.*//')

else
echo elsecase
booknumber=$(echo $suttaname | sed -E 's/\..*//')
    nikaya=$(echo "$suttaname" | sed -E 's/[0-9]+.*//')
fi
mkdir $thtrndir/$nikaya/$booknumber/ 2>/dev/null
mv $file $thtrndir/$nikaya/$booknumber/
echo "moved $suttaname to thai ./$nikaya/$booknumber" 
done



if [[ "`uname -a`" != *"Android"* ]]; then 
exit 0
fi

audioSrcdir=/storage/emulated/0/Music/VoiceChangerWithEffects
audioSrcdir2='/storage/emulated/0/Recordings/Voice\ Recorder'
audioDestdir=/data/data/com.termux/files/usr/share/apache2/default-site/htdocs/assets/audio


# Проверяем существование папок и присваиваем переменные
[ -d "$audioSrcdir" ] || audioSrcdir=""
[ -d "$audioSrcdir2" ] || audioSrcdir2=""

# Если обе переменные пусты, выходим
if [[ -z "$audioSrcdir" && -z "$audioSrcdir2" ]]; then
   # echo "Обе папки отсутствуют. Выход."
    exit 1
fi


dirs="$audioSrcdir $audioSrcdir2"
find "$dirs" -maxdepth 1 -size +0 -type f -name "*_*" 2>/dev/null | while IFS= read -r file 
do
suttaname=$(echo "$file" | sed -E 's/_.*//' | awk -F'/' '{print $NF}')

if [[ $suttaname =~ snp|iti|thig|thag|ud ]]; then
    nikaya=kn/$(echo "$suttaname" | sed -E 's/[0-9]+.*//')
booknumber=vagga$(echo $suttaname | sed -E 's/\..*//' | sed 's/[a-z]*//g')
elif [[ $suttaname =~ mn|dn ]]; then
    nikaya=$(echo "$suttaname" | sed -E 's/[0-9]+.*//')
booknumber=
else
booknumber=$(echo $suttaname | sed -E 's/\..*//')
    nikaya=$(echo "$suttaname" | sed -E 's/[0-9]+.*//')
fi

if [[ "$file" =~ "Recorder" ]]; then
newfn=$(echo "$file" | sed 's/_.*/_pi_puriso_jiv.m4a/g')
else
newfn=$(echo "$file" | sed 's/_.*/_pi_puriso_mod.mp3/g')
fi 
mv "$file" "$newfn" >/dev/null 2>&1
mv "$newfn" $audioDestdir/$nikaya/$booknumber/
echo "moved $suttaname to audio/$nikaya/$booknumber" 
done


cd $apachesitepath/assets/texts/sutta
 for i in `find . -type f  | awk -F'_' '{print $1}' | sort -V| uniq -c | sort -V | awk '{print $1, $2}' | grep -v "^1" | awk '{print $2}'` 
 do 
 ls ${i}_*  
mv ${i}_*sv.json ../svEtc/automatic/
 done


exit 0
