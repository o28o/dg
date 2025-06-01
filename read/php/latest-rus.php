<?php
include_once('../../config/config.php');

// validate all json files
$validatejson = shell_exec("bash $basedir/scripts/validatejson.sh 2>&1 && bash $basedir/scripts/updateReadPHP.sh 2>&1 && bash $basedir/scripts/updateTextInfoJS.sh 2>&1");

if ( $validatejson == "" ) {
  echo " </br><h2 style='text-align: center;'>validated successfully</h2>";
} else {
  echo "</br><p style='text-align: center;'>$validatejson</p>";
  exit(" </br><h2 style='text-align: center;'>please fix errors</h2>");
}

//apply styles for suttacentral.net 
$styleforsc = shell_exec("bash $basedir/scripts/styleforsc.sh 2>&1");
echo "<p style='text-align: center;'>$styleforsc</p>";

//mn
/*
$pathmn = 'assets/texts/sutta/mn/';
$check = shell_exec("

mnrangeInFile=`grep 'let mnranges = ' $basedir/read/js/reader-rus-translations.js | sed 's@;@@g' | sed 's@.*\[@\[@g'`
mnstring=`find $basedir/$pathmn -name \"*translation-ru*.json\" | awk -F'_' '{print $1}'  | awk -F'/' '{print \$NF}' | sort -V | xargs | sed \"s/ /', '/g\" | sed \"s/^/'/g\" | sed \"s/$/'/g\"`

mndir=\"[\${mnstring%,}]\"

if [[ \"\$mndir\" == \"\$mnrangeInFile\" ]] ; then
echo MN no updates
else
echo MN updated to \$mndir
sed -i \"s@let mnranges =.*@let mnranges = \$mndir;@g\" $basedir/read/js/reader-rus-translations.js $basedir/read/js/multilang.js $basedir/read/js/multilangrev.js $basedir/read/js/multilangfullrev.js 
fi
");
echo "<h2 style='text-align: center;'>
$check</h2>";
*/


//sn
/*
$pathsn = 'assets/texts/sutta/sn/';
$check = shell_exec("
snrangeInFile=`grep 'let snranges = ' $basedir/read/js/reader-rus-translations.js | sed 's@;@@g' | sed 's@.*\[@\[@g'`

snstring=`find $basedir/$pathsn -name \"*translation-ru*.json\" | awk -F'_' '{print $1}'  | awk -F'/' '{print \$NF}' | sort -V | xargs | sed 's/ /\", \"/g' | sed 's/^/\"/g' | sed 's/$/\"/g'`

sndir=\"[\${snstring%,}]\"

  
if [[ \"\$sndir\" == \"\$snrangeInFile\" ]] ; then


echo SN no updates
else
echo SN updated to \$sndir

sed -i 's@let snranges =.*@let snranges = '\"\$sndir\"';@g' $basedir/read/js/reader-rus-translations.js $basedir/read/js/multilang.js $basedir/read/js/multilangrev.js $basedir/read/js/multilangfullrev.js $basedir/read/js/memorize.js 

fi
");
echo "<h2 style='text-align: center;'>
$check</h2>";
*/
//dn
/*
$pathdn = 'assets/texts/sutta/dn/';
$check = shell_exec("
dnrangeInFile=`grep 'let dnranges = ' $basedir/read/js/reader-rus-translations.js | sed 's@;@@g' | sed 's@.*\[@\[@g'`

dnstring=`find $basedir/$pathdn -name \"*translation-ru*.json\" | awk -F'_' '{print $1}'  | awk -F'/' '{print \$NF}' | sort -V | xargs | sed \"s/ /', '/g\" | sed \"s/^/'/g\" | sed \"s/$/'/g\"`

dndir=\"[\${dnstring%,}]\"

if [[ \"\$dndir\" == \"\$dnrangeInFile\" ]] ; then
echo DN no updates
else
echo DN updated to \$dndir
sed -i \"s@let dnranges =.*@let dnranges = \$dndir;@g\" $basedir/read/js/reader-rus-translations.js $basedir/read/js/multilang.js $basedir/read/js/multilangrev.js $basedir/read/js/multilangfullrev.js 
fi
");
echo "<h2 style='text-align: center;'>
$check</h2>";

//an
$pathan = 'assets/texts/sutta/an/';
$check = shell_exec("
anrangeInFile=`grep 'let anranges = ' $basedir/read/js/reader-rus-translations.js | sed 's@;@@g' | sed 's@.*\[@\[@g'`

anstring=`find $basedir/$pathan -type f  -name \"*translation-ru*.json\" | awk -F'/' '{print \$NF}'| awk -F'_' '{print \$1}' | sort -V | xargs | sed \"s@ @\', \'@g\"`

andir=\"['\${anstring%,}']\"

  
if [[ \"\$andir\" == \"\$anrangeInFile\" ]] ; then


echo AN no updates
else
echo AN updated to \$andir
sed -i \"s@let anranges =.*@let anranges = \$andir;@g\" $basedir/read/js/reader-rus-translations.js $basedir/read/js/multilang.js $basedir/read/js/multilangrev.js $basedir/read/js/multilangfullrev.js
fi
");  
echo "<h2 style='text-align: center;'>
$check</h2>";*/
//   sed -i 's@latestrusmn=.*@latestrusmn='$max_mn'@g' $basedir/config/script_config.sh ;
 // sed -i 's@\$latestrusmn =.*@\$latestrusmn = '$max_mn';@g' $basedir/config/config.php ;
//

//kn
/*
$pathkn = 'assets/texts/sutta/kn/';
$check = shell_exec("
knrangeInFile=`grep 'let knranges = ' $basedir/read/js/reader-rus-translations.js | sed 's@;@@g' | sed 's@.*\[@\[@g'`

knstring=`find $basedir/$pathkn -name \"*translation-ru*.json\" | awk -F'_' '{print $1}'  | awk -F'/' '{print \$NF}' | sort -V | xargs | sed \"s/ /', '/g\" | sed \"s/^/'/g\" | sed \"s/$/'/g\"`

kndir=\"[\${knstring%,}]\"

if [[ \"\$kndir\" == \"\$knrangeInFile\" ]] ; then
echo KN no updates
else
echo KN updated to \$kndir
sed -i \"s@let knranges =.*@let knranges = \$kndir;@g\" $basedir/read/js/reader-rus-translations.js $basedir/read/js/multilang.js $basedir/read/js/multilangrev.js $basedir/read/js/multilangfullrev.js  $basedir/read/js/memorize.js 
fi
");
*/
echo "<h2 style='text-align: center;'>
$check</h2>";
echo "<h2 style='text-align: center;'>
AN complete</h2>";
echo "<h2 style='text-align: center;'>
DN complete</h2>";
echo "<h2 style='text-align: center;'>
MN complete</h2>";

//vinaya
/*
$pathvinaya = 'assets/texts/vinaya/pli-tv-b[ui]-vb/';
$check = shell_exec("
vinayarangeInFile=`grep 'let vinayaranges = ' $basedir/read/js/reader-rus-translations.js | sed 's@;@@g' | sed 's@.*\[@\[@g'`

vinayastring=`find $basedir/$pathvinaya -name \"*translation-ru*.json\" | awk -F'_' '{print $1}'  | awk -F'/' '{print \$NF}' | sort -V | xargs | sed 's/ /\", \"/g' | sed 's/^/\"/g' | sed 's/$/\"/g'`

vinayadir=\"[\${vinayastring%,}]\"

  
if [[ \"\$vinayadir\" == \"\$vinayarangeInFile\" ]] ; then


echo Vinaya no updates
else
echo Vinaya updated to \$vinayadir

sed -i 's@let vinayaranges =.*@let vinayaranges = '\"\$vinayadir\"';@g' $basedir/read/js/reader-rus-translations.js $basedir/read/js/multilang.js $basedir/read/js/multilangrev.js $basedir/read/js/multilangfullrev.js $basedir/read/js/memorize.js 

fi
");

*/
echo "<h2 style='text-align: center;'>
$check</h2>";



?>
