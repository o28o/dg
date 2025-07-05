<?php
if (strpos($_SERVER['REQUEST_URI'], "/ru") !== false){
$lang = "ru";
$canonicalPage = "https://Dhamma.Gift/ru/";
$installpwa = "Установить DG";
$installpwalong = "Установить DG";
$htmllang = "ru";
$mainpage = '/ru';
$mainpagenoslash = '/ru';
$readerPage = '/r';
$mainreadlink = '/ru/read.php';
$searchcaption = 'Поиск';
$clearaption = 'Очистить';
$btnsave = 'Сохр. по умолч.';
$btnreset = 'Сбросить';

$ifRuLitTrn = '(<a href="/assets/common/o.html" class="translation-link">o</a>)';

$gearbutton = 'дополнительные настройки';
$linksothermat = 'https://drive.google.com/drive/u/1/folders/1UU-y5idRNpfcVTripRUtyTVcOgdwjMGN';
$linktextbook = "$linktextbookru";

$siteAnnounce = '<div style="max-width: 450px; " class="alert alert-primary alert-dismissible fade show mt-3" role=alert id=infoUpdate><strong>Отличная новость.</strong> Поиск на пали и англ стал намного быстрее. В процессе поиск на русском. Пока, поиск доступен только по всем совпадениям. Если вы обнаружите ошибки в работе, пожалуйста <a class="alert-link" href="#contacts">сообщите <i class="fa-regular fa-comment"></i></a><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';


$ctaButtons =' <div class="d-flex flex-wrap flex-column flex-sm-row justify-content-center align-items-center my-3 mb-2">
    
    <button class="ms-2 mb-2 p-0 border-0 bg-transparent" id="installPWA" style="cursor:pointer;">
        <img src="/assets/img/buttons/pwa-cta.png" class="img-fluid" style="max-width: 200px;" title="Установить Dhamma.gift как Прогрессивное Веб-Приложение (PWA)">
    </button>

    <a class="ms-2 mb-2" href="https://t.me/dgift_bot">
        <img src="/assets/img/buttons/telegram-cta.png" class="img-fluid" style="max-width: 200px;" title="Открыть DGift_bot. Или наберите @DGift_bot в любом Телеграм чате или группе">
    </a>

    <a class="ms-2 mb-2" href="https://play.google.com/store/apps/details?id=gift.dhamma.twa">
        <img src="/assets/img/buttons/google-play-cta.png" class="img-fluid" style="max-width: 200px;" title="Скачать с Google Play">
    </a>
    
    <a class="ms-2 mb-2" href="/assets/apk/dhamma.gift.ru-latest.apk">
        <img src="/assets/img/buttons/apk-cta.png" class="img-fluid" style="max-width: 200px;" title="Скачать APK. В нем будет встроенный поиск и опция поделиться, как в браузере. По неизвесным причинам Google скрывает их в версии на Play Market">
    </a>

    <a class="ms-2 mb-2" href="https://chromewebstore.google.com/detail/dhammagift-search-and-wor/dnnogjdcmhbiobpnkhdbfnfjnjlikabd">
        <img src="/assets/img/buttons/chrome-cta.png" class="img-fluid" style="max-width: 200px;" title="Скачать из Chrome Web Store. Поддерживается в Chrome, Edge, Opera, Brave, Vivaldi и Yandex Browser.">
    </a>

    <a class="ms-2 mb-2" href="https://addons.mozilla.org/en-US/firefox/addon/dhamma-gift/">
        <img src="/assets/img/buttons/firefox-cta.png" class="img-fluid" style="max-width: 200px;" title="Скачать из Firefox Add-ons">
    </a>

    <a class="ms-2 mb-2" href="https://microsoftedge.microsoft.com/addons/detail/dhammagift-search-and-wo/aokegkhdaijkikbdocanadeghllhfmhj">
        <img src="/assets/img/buttons/edge-cta.png" class="img-fluid" style="max-width: 200px;" title="Скачать из Microsoft Edge Store">
    </a>
    
</div>


<script>
let deferredPrompt;

window.addEventListener(\'beforeinstallprompt\', (e) => {
// Prevent automatic banner display
e.preventDefault();
deferredPrompt = e;

// Show the button
const installBtn = document.getElementById(\'installPWA\');
installBtn.style.display = \'inline-block\';

installBtn.addEventListener(\'click\', () => {
if (deferredPrompt) {
deferredPrompt.prompt();
deferredPrompt.userChoice.then((choiceResult) => {
if (choiceResult.outcome === \'accepted\') {
console.log(\'Installation accepted\');
} else {
console.log(\'Installation declined\');
}
deferredPrompt = null;
});
}
});
});
</script>';



$maintitle = 'Точный поиск в Пали Суттах и Винае';
$metadesc = 'Точный поиск в Учении Будды, в Пали Суттах и Винае. Поисковый Сайт Освобождения. Полезные Дхамма Ресурсы. Материалы для изучения Сутт, Дхаммы, Пали, Санскрита';
$metakeywords = 'Будда, Buddha, Дхамма, Дхарма, Виная, поиск, Сутта, Сутты, Суттапитака, Винаяпитака, suttapitaka, vinayapitaka Пали, Палийский канон, буддизм, dhamma, sutta, Buddhism, pali Canon, патимоккха, пратимокша, patimokkha, pratimoksasutra, ';
$titletwit = 'Точный поиск в Учении Будды, в Пали Суттах и Винае. ';
$ogdesc = 'Поисковая Система Освобождения. Учение Будды. Поиск в Суттах и Винае на Пали, Русском, Английском и Тайском. Дхамма Будды.';
$oglocale = 'ru_RU';
$ogshare = 'https://Dhamma.Gift/assets/img/social_sharing_gift_rus.jpg';
$menu = 'Меню';
$menumain = 'Главная';
$menuread = 'Читать';
$menuhist = 'История';
$menuhowto = 'Помощь';
$menuabout = 'О Проекте';
$menulinks = 'Полезное';
$menucontact = 'Контакты';
$copyrightnote = 'Материалы сайта распространяются по модели <a class="text-white text-decoration-none me-0" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Attribution-NonCommercial-ShareAlike 4.0 International">CC BY-NC-SA 4.0</a>, но Пали тексты и Английские переводы SuttaCentra.net и работы А. Я. Сыркина и TheBuddhasWords.net подчиняются другим условиям. Для их использования уточняйте условия у правообладателей.';
$poweredby = 'Powered by NI';
$tooltippoweredby = 'Natural Intelligence, Естественный Интеллект, Dhamma Интеллект';

$tooltiptitle = 'На Pāḷi, Русском, Английском, ไทย и සිංහල ';
$title = 'Найдите Истину';
$tooltippli = 'Поиск на Пали по-умолчанию. По Суттам an, sn, dn, mn. Ангутара Никаи, Саньютта Никаи, Маджжхима Никаи, Дигха Никаи';
$radiopli = '4 Никаи';
$tooltipdef = 'Поиск определений понятия на Пали в 4 Никаях. Что это, какие виды бывают, какими метафорами описывается. Если в Суттах не будет результатов, то поиск автоматически проведется в определениях из Винаи. Работает только для определений данных стандартными фразами. См. в "для Продвинутых"';
$radiodef = 'Опр';

$tooltipsml = 'Поиск сравнений, метафор, символов понятия на Пали в 4 Никаях. Работает только для определений данных стандартными фразами.';
$radiosml = 'Пдб';

$tooltipsearchbar = '
<strong>Автоподсказки</strong>: введите от 3 символов — будут появляться подсказки из пали слов Четырёх Никай (DN, MN, SN, AN), а также части KN (Dhp, Iti, Ud, Snp) и всех разделов Винаи. Из редиацкции Mahasangiti, варианты из других редакций не выводятся.
<br><br>
<strong>Количество совпадений</strong> (например, mettā 27) показывает, сколько раз слово встречается в текстах указанных выше. Для более широких результатов ищите без приставок и/или окончаний.
<br><br>
<strong>Переход к текстам</strong>: введите например, sn56.11, DN 22, Sn 12 2, an10.46 или даже фн10ю46, mn141.—В подсказке будет название текста на пали, и можно открыть текст напрямую.
<br><br>
<strong>История поиска и чтения</strong> - открывается при клике по пустому полю поиска или по пробелу. Эта история хранится только на данном устройстве.
<br><br>
<strong>Поиск по истории</strong>: при вводе до 2 символов будет отображаться отфильтрованная локальная история поиска и чтения.
<br><br>
<strong>Горячие клавиши:</strong><br>
<strong>Нажмите /</strong>, чтобы активировать поле поиска.
<br>
<strong>Ctrl + 1</strong> Главная Поиска Рус / Англ (переключатель).
<br>
<strong>Ctrl + 2</strong> Главная Чтения Оглавление Рус / Англ.
<br>
<strong>Ctrl + 3</strong> Открыть Dict.Dhamma.Gift.
<br>
<strong>Alt + 1</strong> Интерфейс для чтения Рус / Англ.
';

//<br><br> <strong>Даже \'фвршссфыфьгзз\'</strong> преобразуется в правильное adhiccasamuppann.


$tooltiptextype = '<strong>Pāḷi*</strong> - 4 Никаи + 6 книг КН Удана (Ud), Дхаммапада (Dhp), Итивутака (Iti), Суттанипата (Snp), Тхерагатха (Thag), Тхеригатха (Thig)<br><br>
<strong>4 Никаи</strong> - 4 Основные Никаи: Ангутара Никаи (АН), Саньютта Никаи (СН), Маджжхима Никаи (МН), Дигха Никаи (ДН). В коренных текстах (Мула). <br><br>
<strong>Виная*</strong> - Поиск в Вибхангах Винаи и Патимоккхах на Пали и Английском. <br><br>
<strong>+ вся КН</strong> - 4 Никаи + поиск на Пали во всех книгах Кхуддака Никаи.<br><br>
<strong>+ Kd, Pvr</strong> - Виная + Кхандхаки и Паривара<br><br>
<strong>TBW</strong> - поиск в материалах theBuddhasWords.net<br><br>
<strong>SC.net</strong> - поиск в англ переводах 4 никай SuttaCentral.net
<br><br>
<strong>Theravada.ru</strong> - поиск в русских переводах сайта theravada.ru';
$tooltipknread = 'Часть KN';
$tooltipsearchtype = '<strong>По умолчанию</strong> - все совпадения сгруппированные по текстам<br><br>
<strong>Словарь</strong> - искать слово в Dict.Dhamma.Gift<br><br>
<strong>Слова</strong> - результаты сгруппированы по словам (работает только для Пали и 4 Никай)<br><br>
    <strong>Определения</strong> - Поиск нескольких главных определений понятия на Пали в 4 Никаях. Что это, какие виды бывают, какими метафорами описывается. Работает только для определений данных стандартными фразами. <br><br>
    <strong>Сравнения</strong> - Поиск сравнений, метафор, символов понятия на Пали в 4 Никаях. Работает только для определений данных стандартными фразами.<br><br>
    <strong>Все определения</strong> - Поиск всех определений понятия. Логика описана в разделе помощи для Продвинутых.<br><br>
        <strong>Топ-5 или 10</strong> - Быстрый поиск X текстов, где больше всего совпадений. Если не нужны все результаты.
    ';
$listdefall  = "Все определения";
$listnm10 = "Топ-10";
$listnm = "Топ-5";
$listdef = "Определения";
$listwords = "Слова";
$dictLookup = "Словарь";
$listsml = "Сравнения";
$liststd = "Все совпадения";
$tooltipvin = 'Поиск в Винае на Пали';
$radiovin = 'Виная*';
$tooltipkn = 'Поиск на Пали в 4 никаях + поиск в 6 книгах Кхуддака Никаи: ud, iti, snp, dhp, thag, thig. Удана, Итивутака, Суттанипата, Дхаммапада, Тхерагатха, Тхеригатха';
$radiokn = 'Pāḷi*';
//+ 6 книг КН
$tooltiponl = 'X Y ... могут быть на любом расстоянии в рамках одного текста. Без этой опции (по умолчанию) поиск идёт только по рядомстоящим словам. ';
$checkboxonl = 'Любое расстояние';
$tooltipnonl = 'С этой опцией будут собраны тексты, которые содержат только рядомстоящие X и Y (в одной строке). По умолчанию, без этой опции поиск будет производиться на любом расстоянии в пределах одного текста.';
$checkboxnonl = 'А Б';
$tooltipltr= "+ поиск на Пали во всех книгах Кхуддака Никаи";
$radioltr = "+ вся КН";
$radiovinall = "+ Kd, Pvr";
$tooltipen = 'Поиск по англ. переводам АН, СН, МН, ДН с SuttaCentral.net дост. Суджато. Без этой опции сначала поиск будет произведен в Пали, затем в переводах sc.net и затем в переводах thebuddhaswords.net ';
$radioen = 'SC.net';
$radiotru = 'Theravada.ru';
$tooltipth = "Опционально. Поиск в 4 основных Никаях в Тайских переводах Suttacentral.net. Без этой опции сначала поиск будет произведен в Пали текстах, потом в переводах";
$radioth = "ไทย";
$tooltipru = "Опционально. Поиск по русским переводам АН, СН, МН, ДН с SuttaCentral.net";
$radioru = "Рус";
$tooltiptbw = "Искать во всем содержимом TheBuddhasWords.net";
$radiotbw = "TBW";


$monktype = array("монахом" => "imassa ca bhikkhuno",
"тхерой" => "tassa ca therassa",
"сообществом монахов" => "tassa ca saṅghassa"
);

$randomKey = array_rand($monktype);
$randomValue = $monktype[$randomKey];

$howtosearchquotetooltip = '';
$howtosearchquote = '<p class="pli-lang">Tāni ce sutte osāriyamānāni vinaye sandassiyamānāni na ceva sutte osaranti, na ca vinaye sandissanti, niṭṭhamettha gantabbaṃ: "addhā, idaṃ na ceva tassa bhagavato vacanaṃ; ' . $randomValue . ' duggahita"nti. Iti hetaṁ, bhikkhave, chaḍḍeyyātha.</p>
<p>Если при поиске в Суттах и сверке с Винаей они (учения, практики, методы, цитаты, истории, что-либо приписываемое Будде) не находятся в Суттах и не проходят сверку с Винаей, следует сделать заключение: "Определенно, это не слово Благословенного, оно ошибочно понято тем ' . $randomKey . '". Таким образом, монахи, вам следует это отвергнуть. 
</p>
<p class="text-end"><a target=_blank href=/r/?q=dn16&s=Tāni&lang=pli-eng#4.8.6>dn16</a> <a target=_blank href=/r/?q=an4.180&s=Tāni&lang=pli-eng#2.7>an4.180</a></p>';
$tooltipvindef = 'Поиск определений понятия на Пали в Винае. Работает только для определений данных стандартными фразами. См в разделе для Продвинутых';
$radiovindef = "ОпрВ";

$tooltipla = "Добавить $defaultla строки до и после совпадения";
//$checkboxla = "+" . $defaultla * 2 . " строки";
$checkboxla = "+" . $defaultla . " строки";
$regexMemoh5 = '<h5>Памятка по RegEx</h5>';

$lax = "искать X и добавить в результаты $defaultla (значение можно менять) следующие строки после строки с X";
$lbx = "искать X и добавить в результаты $defaultla предыдущие строки перед строкой с X";
$exc = "искать X, исключить Y и Z";
$excfew = 'искать X, исключить Y с окончаниями на "ti" и "nti"';
$begin = 'начало или';
$end = 'конец слова';
$anynumber = 'любое количество символов между X и Y';
$fewsymbols = 'от 0 до 10 символов';
$nextwords = 'рядом стоящие слова X и Y, если окончание слова X неизвестно или может быть различным';
$fewwords = 'расстояние в 0 или 2 слова между X и Y с любым окончанием X';
$variants = 'искать несколько вариантов';
$optionalletter = 'буква в [ ]? опционально';
$variantsexc = 'искать tatt исключив tatth';
$metaphorssmlletter = 'искать все сравнения, метафоры в Самьютте 56';
$searchfewwords = 'искать несколько отдельных слов одновременно';
$inallnikaya = 'искать X во всей Мадджхимма Никае';
$inonesutta = 'искать Y в одной Сутте ДН22';
$regexlink = 'ИИ может сгенерировать регулярное выражение для grep -Ei, к примеру <a class="text-white" href="https://chat.openai.com/" target=_blank>ChatGPT</a>, <a class="text-white" href="https://chat.deepseek.com/" target=_blank>DeepSeek</a>, <a class="text-white" href=" https://claude.ai/" target=_blank>Claude AI</a>, <a class="text-white" href="https://codepal.ai/regex-generator" target=_blank>Codepal.ai</a>
<br>';

$regexMemo = '<p style="text-align: left;">
  <!--   <strong>-onl "(X|Y|...)"</strong> - найти тексты содержащие только все совпадения X, Y ... и т.д.<br> -->
        </p>     ';
$titlehowtovideo = 'Как пользоваться?';  
$linkhowtovideo = 'https://youtu.be/XXa-K2fQ0Is?si=DDkT-2ZJo6B9bOAA';
$titledeschowtovideo = 'How to search in Pali Suttas and Vinaya with Dhamma.Gift'; 

$randomNumber = rand(1, 2); // Генерируем случайное число, например, 1 или 2
// Логика выбора пары
if ($randomNumber % 2 == 1) {
$fntmessage = '<p class="font-italic text-center pli-lang">
“Evamevaṁ kho, devānaminda, yaṁ kiñci subhāsitaṁ sabbaṁ taṁ tassa bhagavato vacanaṁ arahato sammāsambuddhassa...</p>
<p>“Точно также, царь богов, что-либо хорошо сказанное – всё это слово Благословенного, Араханта, Правильно Пробуждённого...
<p class="text-end">
an8.8
</p>
</p>';
$mainscrollmodalheader = 'Нужно научиться разбираться, что хорошо сказано <a href=/r/?s=Evameva%E1%B9%81&q=an8.8#6.7>an8.8</a>, а что — плохо, иначе:';
$mainscrollmodal = '<p class="">Из <a href=/r/?s=va%E1%B9%87%E1%B9%87a&q=an2.130-140#an2.134:1.3>an2.13</a> </br>

<h4 class="pli-lang">Ananuvicca apariyogāhetvā avaṇṇārahassa vaṇṇaṁ bhāsati, </h4>
</br>
Без изучения и тщательного рассмотрения он хвалит того, кто заслуживает порицания.</br>
</br>
<h4 class="pli-lang">ananuvicca apariyogāhetvā vaṇṇārahassa avaṇṇaṁ bhāsati.  </h4>
</br>
Без изучения и тщательного рассмотрения он порицает того, кто заслуживает похвалы.</br>
</br>
<h4 class="pli-lang">Imehi kho, bhikkhave, dvīhi dhammehi samannāgato bālo abyatto asappuriso khataṁ upahataṁ attānaṁ pariharati, sāvajjo ca hoti sānuvajjo ca viññūnaṁ, bahuñca apuññaṁ pasavatīti.  </h4>
</br>
Обладая этими двумя качествами, глупый, несведущий, нечистый человек держит себя в изувеченном и искалеченном состоянии. Он достоин порицания и упрёков со стороны мудрых, и он порождает множество неблага.</br>
</br>
';
} else {
  
$fntmessage = '<p class="font-italic text-center pli-lang ">
Katamañca, bhikkhave, dukkhaṁ?</p>
<p>Что такое, монахи, боль?
<p class="text-end">
dn22 mn141
</p>
</p>';

$mainscrollmodalheader = 'Определение Dukkha в Суттах';
$mainscrollmodal = '<p >Из <a href=/r/?q=dn22&s=dukkha&lang=pli-rus#18.18>dn22</a> <a href=/r/?q=mn141&s=dukkha&lang=pli-rus#16.1>mn141</a></br><h4 class="pli-lang">Katamañca, bhikkhave, dukkhaṁ?</h4></br>
Что такое, монахи, боль?</br>
</br>
<p class="pli-lang">Yaṁ kho, bhikkhave, <strong>kāyikaṁ</strong> dukkhaṁ <strong>kāyikaṁ</strong> asātaṁ kāyasamphassajaṁ dukkhaṁ asātaṁ vedayitaṁ,</p></br>
<p>Любая, монахи, <strong>телесная / осязаемая</strong> боль, <strong>телесный / осязаемый</strong> дискомфорт, боль и дискомфорт чувствуемый от затронутости осязанием,</br>
</br>
<p class="pli-lang">idaṁ vuccati, bhikkhave, dukkhaṁ.</p></br>
это называется болью.</br>
</br>
<h4 class="pli-lang">Katamañca, bhikkhave, domanassaṁ?</h4></br>
А что такое "страдание" / стресс / тягота / недовольство?</br>
</br>
<p class="pli-lang">Yaṁ kho, bhikkhave, <strong>cetasikaṁ</strong> dukkhaṁ <strong>cetasikaṁ</strong> asātaṁ manosamphassajaṁ dukkhaṁ asātaṁ vedayitaṁ,</p></br>
Любая, монахи, <strong>ментальная</strong>  боль, <strong>ментальный</strong> дискомфорт, боль и дискомфорт чувствуемый от затронутости мышлением,
</br>
</br>
<p class="pli-lang">idaṁ vuccati, bhikkhave, domanassaṁ.</p></br>
– вот что называется "страданием".</br></p>
<p class="text-end"></p>'; 
}
$carouseltitle = 'Интересные Запросы';

$slides = [
         
          [
        'title' => 'Три вида Зависимого Возникновения',
        'desc' => 'Последовательности из <span title="dn15">10</span>, <span title="dn14, sn12.65, sn12.67">11</span> и <span title="sn12.2 в этой подборке и др. суттах, самая известная и распространненная схема">12</span> условий',
        'link' => '/ru/?q=%28N%C4%81mar%C5%ABpapaccay%C4%81+vi%C3%B1%C3%B1%C4%81%E1%B9%87a%7Csn12.2.%2AVibha%E1%B9%85gasutt%29&p=-kn',
    ],         
          [
        'title' => 'Татхагата не признавал, что Пробудился в наивысшее, пока не...',
        'desc' => 'Список для самопроверки ищущим Пробуждение',
        'link' => '/ru/?q=y%C4%81vak%C4%ABva%C3%B1.%2AAnuttara%E1%B9%81+samm%C4%81sambodh&p=-kn',
    ],
          [
        'title' => 'Крайние сроки на Пробуждение для монахов и мирян от Будды',
        'desc' => 'Максимум 7 и 10 лет, соответственно',
        'link' => '/assets/example/(viharanto-yathaa-mayaanusi.t.tha.m-eva.m-bhaaveyya)_suttanta_pali-ru_3-16.html',
    ],
           [
        'title' => 'Определение понятия dukkha в суттах',
        'desc' => 'Может ли быть, чтобы терминология в Учении Будды была не сквозной?',
        'link' => '/assets/example/kata.,-dukkha.m-question_suttanta_pali-ru_3-3.html',
    ],
               [
        'title' => 'Виды личностей в Учении Татхагаты',
        'desc' => 'Начиная от 3 видов и до 10',
        'link' => '/ru/?q=Pugg.*saṁvijjam.*lokasmiṁ',
    ],        
           [
        'title' => 'Упадок и Не-упадок в Учении Татхагаты',
        'desc' => 'Пример: Остановится на полпути - это упадок',
        'link' => '/ru/?q=Parihānametaṁ',
    ],        
    
                    [
        'title' => 'Благородные "Средства Передвижения"',
        'desc' => 'Когда ... сделано средством передвижения',
        'link' => '/ru/?q=Yānīkat',
    ],
      [
        'title' => 'До моего пробуждения',
        'desc' => 'Будда делится размышлениями и практиками, которые привели его к Пробуждению',
        'link' => '/ru/?q=Pubb.*sambodh',
    ],
                [
        'title' => 'Джатаки из Сутт',
        'desc' => 'Будда и некотооые ученики, о своих прошлых жизнях',
        'link' => '/ru/?q=(bhūtapubbāha.*ahos|ahaṁ tena samayena.*ahos)',
    ],
    [
        'title' => 'Благородный Глоссарий',
        'desc' => 'Различные понятия в очищении благородного (Ariyassa vinaye)',
        'link' => '/ru/?q=Ariyassa vinaye',
    ],
    [
        'title' => 'Пища для размышлений',
        'desc' => 'Все случаи из Сутт, когда спрашивают: "Как вы думаете?"',
        'link' => '/assets/example/ta.m-ki.m-ma~n~n_suttanta_pali-ru_218-610.html',
    ],
    [
        'title' => 'Я научу вас благородному ...',
        'desc' => 'Что такое благородное мытьё, слабительное, рвотное, путь и самадхи',
        'link' => '/ru/?q=\bariy.*desessā',
    ],
	    [
        'title' => 'Комментарии Дхаммы по Дхамме',
        'desc' => 'Примеры правильных комментариев из Сутт.',
        'link' => '/ru/?q=-la10 vuttamidaṁ',
    ],
    [
        'title' => 'Бывает такой период...',
        'desc' => 'Различные события, которые периодически происходят',
        'link' => '/ru/?q=Hoti kho so.*samayo',
    ],
    [
        'title' => 'Я не отрицаю это...',
        'desc' => 'Интересные уточнения и нюансы с этой фразой',
        'link' => '/ru/?q=Nes.*natth.*vadāmi',
    ],
];

$read = 'читать';

$transwarning = ' <i class="fa-solid fa-triangle-exclamation "></i> <b>Пожалуйста, Помните!</b><br><br> Переводы, словари и комментарии сделаны не Буддой! Они часто содержат фундаментальные ошибки главных положений его Учения и противоречия. Их нужно изучать внимательно и критически. 
 <br><br>
 Самое важное в Учении Будды лучше изучить <strong>самостоятельно по Суттам на Пали</strong>. Хорошей отправной точной будет Серединная Практика и Четыре Благородные Истины. Например, несколько абзацев из <strong>sn56.11</strong>.';

$anamemlearnpali = 'Learn Pali Переводы';
$anamelearnsanskrit = 'Джеймс Велан. Пали и Санскрит';

$anamemolds = 'Переводы Майкла Олдса'; 
$anameasc = 'Статьи на Dhammadana.org';
$anameati = 'Accesstoinsight.org Патимоккха';
$anamehist = 'История';
$anameuseful = 'Полезное';
$anamedpd = 'Пали-Англ для mDict';
$anamedpdru = 'Пали-Рус для GoldenDict';

$anameresearch = 'Исследование';
$anameread = 'Чтение';
$anamestudy = 'Изучение';
$anamematerials = 'Грамматика';
$anamecases = 'Падежи';
$anameconj = 'Спряжения';
$anametextbook = 'Курс по Пали';
$anameothermat = 'Другие Материалы';
$anamesdiff = 'Сравнить Две Сутты';
$anametools = 'Инстр.';

$aboutheader = 'О Проекте';
$aboutprp = '<div class="col-lg-4 ms-auto"><p class="lead">Dhamma.Gift это поисковая система Освобождения. Точный Поиск в текстах Дхаммы и Винаи Палийского Канона с результатами в удобных таблицах с построчными переводами и ссылками на другие сайты. Вы можете искать понятия, определения, метафоры, объяснения, людей, места и другое описанное в Суттах и Винае на Пали, Русском, Тайском и Английском.</p></div>
<div class="col-lg-4 me-auto"><p class="lead">Если вы разработчик или просто хотите помочь с развитием сайта - будем вам крайне рады.<br><br>Проект не нуждается, в материальной помощи, но если вы хотите поучаствовать в оплате за доменное имя, пожалуйста, свяжитесь через Telegram, по почте или через Github - ссылки внизу страницы, блок "Контакты". </p></div>';
$prongh = ' Проект на GitHub';
$premail = ' Особенности Dhamma.Gift';
$prekeyfeatures = 'keyFeaturesRu.html';

$headerexamples = 'Примеры';
$examplelist = '<li>Определение понятия <a href="/ru/?q=-la1+Kata.*,+dukkhaṁ[,\\\\?]">dukkha</a> на Пали и Русском. Запрос: <a href="/ru/?q=-la1+Kata.*,+dukkhaṁ[,\\\\?]">-la1 Kata.*, dukkhaṁ[,\\\\?]</a>
             </li>
<li>Сутта, в которой Будда говорит, что не делает <a href="/ru/?q=dvayagāminī">двусмысленных (dvayagāminī) утверждений</a> на Пали со ссылками на Русский перевод</li>
           
<li>Все сутты со словом <a href="/ru/?q=восьмеричн">Восьмеричный</a> Благородный Путь на Русском</li>
 
<li>Сутты со словом <a href="/ru/?q=нравственность">нравственность</a> на Русском</li>

<li>Все сутты, где упомянут <a href="/ru/?q=Сарипутт">Сарипутта</a> на Русском</li>

<li>Все сутты, где упомянут <a href="./assets/example/moggallaa-exc-(sikhaamoggall|akamoggall)_suttanta_pali-ru_75-621.html">Моггаллана</a> на Пали со ссылками на Русский</li>

<li>Все варианты словосочетания <a href="/ru/?q=paṭiccasamuppād">paṭiccasamuppado</a> на Пали со ссылками на Русские переводы</li>

<li>Все сутты где, упоминается об <a href="/ru/?q=океан">океане</a> на Русском</li>

<li>Все сутты с <a href=./assets/example/seyyathaapi_suttanta_pali-ru_597-1861.html>метафорами с seyyathāpi</a> со ссылками на Русские переводы. Для всех сравнениий на Пали используйте запрос: <a href=/ru/?q=(seyyathāpi|adhivacan|ūpama|opama)>(seyyathāpi|adhivacan|ūpama|opama)</a> </li> ';

$howtoheader = 'Как Искать?';

$contactheader = 'Контакты';
$contaccalltoaction = 'Всесторонний взгляд на Четыре Благородные Истины<br>
		в Палийских Суттах и Винае.<br> 
    Поймите наст<a target="_blank" class="text-white text-decoration-none" href=/r/?q=sn51.20&lang=pli>о</a>ящие Четыре Благородные Истины<br> 
   и п<a target="_blank" class="text-white text-decoration-none" href=/r/?q=bu-pm>о</a>л<a class="text-white text-decoration-none" target=_blank href=/r/?q=sn35.70&lang=pli>о</a>жите к<a target=_blank class="text-white text-decoration-none" href=/r/?q=mn77&lang=pli>о</a>нец б<a class="text-white text-decoration-none" href="/scripts/countdowntable.php">о</a>ли.';
                               							
$demovideo = 'Обучающие Видео';	
$demovideolink = 'https://youtube.com/playlist?list=PLFJDP30qrYJ2rknY6fEVR3jQxpZd1S6lX&si=7O06E2lcmPxaEVX2';
$demovideoimg = '/assets/img/video1ru.webp';
$demovideoimg2 = '/assets/img/video2ru.webp';

$basics = 'Основы ';

$basicscontent = '<p class="mb-4"><strong>Совет #0</strong><br>
										Поиск производится на Пали, Русском, Английском и Тайском в материалах SuttaCentral.net и дополнительно thebuddhaswords.net, то есть если того или иного перевода или определенных слов нет на этих ресурсах здесь их также не будет.<br>
										К примеру в переводах с theravada.ru может не быть слова "мораль", но есть слово "нравственность".<br>
										Логика поика следующая: если вы ищете на Русском, то поиск производится только в русских переводах. На тайском - сначала поиск на пали, потом в тайских переводах. На латинице: сначала пали, потом англ переводы tbw, потом построчные переводы Suttacentral.net. 
										<br><br>
									 <strong>Совет #1</strong><br>
Для поиска на Пали вы можете печатать латинскими буквами, варианты слов встречающихся в четырех никаях (ДН, МН, СН, АН) будут предлагаться автоматически.<br>
При желании вы можете копировать специальные символы отсюда ā ī ū ḍ ḷ ṃ ṁ ṇ ṅ ñ ṭ или из памятки по Regex, иконка-шестеренки.
<br><br>
<strong>Совет #2 Кхуддака Никая</strong><br>
									 Поиск делается во всех суттах ДН, МН, СН, АН. Крайне рекомендуется сначала разобраться с терминами и понятиями, так как они изложены в этих четырех сборниках текстов. И только при необходимости обращаться к малому собранию текстов (КН), так как в него также входят поздние работы.<br>
									 Запустите поиск с опцией -kn, чтобы также искать в следующих книгах КН: Дхаммапада, Удана, Итивуттака, Суттанипата, Тхерагатха, Тхеригатха. Другие книги КН не используются в поиске даже с параметром -kn. Вы можете использовать другие поисковые сайты для поиска в Джатаках и остальных книгах КН.
									 <br>
									 Пример #1: -kn jamm 
									 <br>
									 Этот запрос выведет все совпадения по корню jamm из DN, MN, SN, AN + перечисленные книги KN.
																		 <br>
									 Пример #2: jamm 
									 <br>
									 Выведет совпадения только из DN, MN, SN, AN.
									 <br><br>
<strong>Совет #3 Виная</strong><br> 
      Если вы хотите искать в текстах Винаи добавьте -vin к поисковому запросу. К примеру, чтобы искать совпадение по cetana в Винае запрос должен выглядеть так: -vin cetana <br><br>
			<strong>Совет #4</strong><br>
   Если результатов поиска слишком мало: попробуйте искать сбово без приставки, или без окончания, или только корень. 
<br><br>
<strong>Совет #5</strong><br>
Сделайте упор на Пали, используйте другие языки во вторую очередь. Пали - это язык на котором записаны самые древние тексты связанные с Дхаммой и Будда говорил на языке более близком или ставшим в последствии Пали, он гарантированно не говорил ни на Русском, ни на английском.	
<br><br>
<strong>Совет #6</strong><br>Результаты поиска на Пали - это: таблица совпадений по Суттам/Текстам с цитатами и таблица по словам. Используйте оба типа результатов, чтобы повысить пользу для вас. Для доугих языков таблицы по словам тоже генерируются, но могут работать некорректно.<br><br>
<strong>Совет #7</strong><br>Минимальная длина поискового запроса - 3 символа. Но если возможно ищите более длинные шаблоны. Так вы получите более точные результаты.<br><br>
<strong>Совет #8</strong><br> 
Мы рекомендуем искать на Пали. Так вы получите наилучшие результаты и вы разовьёте очень важную привычку - не полагаться слепо на переводы. Но очевидно, вы также можете получить некоторые преимущества от поисков на других языках. Если вы ищете животных, растения и т.п. К примеру, в текстах на Пали используется как минимум четыре разных слова. Тогда как на русском и английском это "змея" и "гадюка".<br><br>
									<strong>Совет #9</strong><br>
Если запрос завершается ошибкой из-за таймаута, попробуйте более длинный поисковый запрос или более специфичное слово.  <br><br>
	<strong>Совет #10 Быстрые переходы</strong><br>
   Также как на <a href="https://Dhamma.Gift/r/">Dhamma.Gift Read</a> или <a href="https://Dhamma.Gift/read">Dhamma.Gift/read</a> вы можете вводить идентификаторы сутт так как они используются на suttacentral.net и вместо поиска вы перейдете в Палийский текст сутты, с возможностью быстрого переключения на построчный Английский перевод.<br>
   Через строку поиска можно перейти в сутты dn, mn, sn, an, ud из kn и тексты Винаи. <br><br>
<!--								  <strong>Совет #11</strong><br>
                                   !!!Временно отключён!!! Если запрос завершается ошибкой из-за таймаута и вы не можете использовать  более длинный поисковый запрос, попробуйте <a href="./bg.php">Фоновый Режим</a>. Он может помочь.<br><br>  -->
<p class="mb-4"><strong>Что именно подсчитывается в колонке Mtphr из таблицы результатов?</strong><br>
										Подсчитываются совпадения по всему тексту, без привязки к критерию поиска:<br>
										"seyyathāpi|adhivacan|ūpama|opama|opamma"<br>
										Игнорируются:<br>
    "adhivacanasamphass|adhivacanapath|ekarūp|tathārūpa|āmarūpa|\brūpa|evarūpa|\banopam|\battūpa|\bnillopa|opamaññ"<br>
    Создайте issue на github или напишите по почте, если вы найдёте другие критерии.
    <br><br>                    
</p>';


$advanced = 'для Продвинутых';
$advancedcontent = '<strong>Совет #1</strong><br>
Опция применима только для поисков на пали или английском! Если вы хотите найти определенное слово в определенной сутте, самьютте, никае - запустите поиск в таком виде: Sn17.*seyyathāpi
<br>Запрос из примера выведет в таблицы все метафоры и сравнения из Sn17.<br>
Если вы хотите найти разные слова в определенной сутте или группе сутт, запрос должен выглядеть так, включая кавычки:
"Sn51.*(seyyathāpi|adhivacan|ūpama|opama)" 
<br>данный запрос выгрузит все метафоры, сравнения, перефразы и примеры из Sn51
<br><br>
<strong>Совет #2</strong><br>
Чтобы добавить вариации используйте [], к примеру запрос nand[iī] выведет в таблицы совпадения по обоим вариантам nandi и nandī.
<br>
По умолчанию такая вариация установлена для буквы "е", она автоматически преобразуется в [ёе], если вам требуется найти совпадения только с "е", соответственно, то запрос можно сделать в таком виде: [е], к примеру впер[е]д.
<br>
С буквой ё поиск можно осуществлять без доп. символоа.
<br><br>
<strong>Совет #3</strong><br>
Если вы хотите найти слова начинающиеся или заканчивающиеся с определенного шаблона, используйте \\\\b в начале и\или в конце шаблона поиска, к примеру<strong>\\\\bkummo\\\\b</strong> выведет в таблицы только kummo и пропустит kummova и любые другие совпадения<br><br>
<strong>Совет #4</strong><br>
Чтобы исключить один шаблон из результатов другого шаблона используйте аргумент -exc.<br>
Пример: dundubh -exc devadundubh - этот запрос позволит вам выгрузить совпадения по словам похожим на dundubh, но без devadundubh<br><br>
<strong>Совет #5</strong><br>
Вы можете использовать регулярные выражения (regex) синтаксиса GNU grep -E. С использованием escape-последовательности (\\\\) они должны работать. 
Специальные ИИ могут сгенерировать регулярное выражение для Grep, к примеру <a href="https://codepal.ai/regex-generator" target=_blank>здесь</a>.
Почитайте, поизучайте regex в интернете.<br><br>

	<strong>Совет #6</strong><br>
Почитайте на сайте проекта или в интернете о <a target="_blank" href="https://datatables.net/">DataTables</a>, результаты, которые вы получаете из текстов выводятся с помощью них.<br><br>
								   
<strong>Совет #7 Подборки</strong><br>
Вы можете создавать подборки текстов. <br>
Примеры запросов:<br> 
"sn42.8|sn20.5" (включая кавычки) выведет в одну таблицу две Сутты полностью<br>
"Sn20.1" (включая кавычки) выведет Sn20.1 sn20.10 sn20.11 и тд в одну таблицу<br>
"Sn20.1\\\\b" (включая кавычки) выведет только одну Сутту
<br><br>

<strong>Как работает опция "Опр" - Определение</strong><br>
Если эта опция активирована поиск выполняется по следующим критериям:<br>
grep -E -A1 -Eir "${defpattern}.*nāma|an1\..*${defpattern}|An2.*Dv.*${defpattern}|An3.*(Tis|Tay|Tī).*${defpattern}|An4.*(Cattā|Cata).*${defpattern}|An5.*Pañc.*${defpattern}|An6.*cha.*${defpattern}|An7.*Satta.*${defpattern}|An8.*Aṭṭh.*${defpattern}|An9.*Nav.*${defpattern}|an1[10].*das.*${defpattern}|Seyyathāpi.*${defpattern}|${defpattern}[^\s]{0,3}sutta|(dn3[34]|mn4[34]).*(Dv|Tis|Tay|Tī|Cattā|Cata|Pañc|cha|Satta|Aṭṭh|Nav|das).{0,20}${defpattern}|\bKas.{0,60}${defpattern}.{0,9}\?|Katth.*${defpattern}.*daṭṭhabb|\bKata.{0,20}${defpattern}.{0,9}\?|Kiñ.*${defpattern}.{0,9} vadeth|${defpattern}.*adhivacan|vucca.{2,5} ${defpattern}{0,7}|${defpattern}.{0,15}, ${defpattern}.*vucca|${defpattern}.{0,9} vacan|Yadapi.*${defpattern}.*tadapi.*${defpattern}" --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,vv} <br>
Пожалуйста, создайте issue на github или напишите по почте, если вы найдёте другие критерии.<br><br> ';

$closemodal = 'Закрыть Окно';

$head2recomlinks = "Полезные Ссылки ";
$detailonline = 'онлайн';
$detailoffline = 'оффлайн';
$detailonandoffline = 'онлайн и оффлайн';
$detailapp = 'приложение';
$detailtable = 'таблица';
$detailtextbook = 'учебник';

$header5fdgoffline = 'Dhamma.Gift Оффлайн Версия';

$pfdg = 'Точный поиск по Суттам и Винае';
$pfdgoffline = 'Оффлайн версия и инструкция по установке. Android, Linux, Windows';

$head5othermat = 'Учебные материалы на русском и английском';
$pothermat = 'Подборка учебников и таблиц';

$pconj = 'Спряжения неправильно переведены реже чем падежи, но все же встречаются';
$smcheckpali = 'Обязательно сверяйтесь с Пали';

$pcases = 'В англ. переводах и соответственно русских переводах с англ. языка падежи часто переведены неправильно';
$ptextbook = 'Рекомендуемый Учебник';

$pthru = 'Самая полная коллекция Русских переводов Суттанты';
$pthsu = 'Много вариантов переводов. Построчно Пали-Англ-Русский.';
$smthsu = 'Особенно рекомендован для изучения текстов Дигха Никаи';

$pdpr = 'Мощный инструмент для исследования Сутт и изучения Пали. И альетрантивный поиск';
$smdpr = 'Встроенный Пали-Англ словарь';

$ptbw = 'Полная коллекция Пали-Англ переводов по абзацам';
$smtbw = 'Пали-Англ словарь встроен';
$psc = 'Самая полная коллекция построчных переводов Типитаки Пали-Англ';
$smsc = 'Пали-Англ словарь можно включить в настройках';

$mainpageextrasourceslink = 'MenuRead,MenuEnglish,MenuRussian'; 
$mainpageextrasourcestitle = 'Полный список сайтов '; 
$mainpageextrasourcesdesc = 'в подменю "Английские" и "Русские" под строкой поиска'; 

$mainpageextrasearchlink = 'MenuEnglish,tools'; 
$mainpageextrasearchtitle = 'Полный список ресурсов'; 
$mainpageextrasearchdesc = 'в подменю "Инструменты" под строкой поиска'; 

$mainpageextrastudylink = 'materials'; 
$mainpageextrastudytitle = 'Полный список материалов'; 
$mainpageextrastudydesc = 'в подменю "Обучение" под строкой поиска'; 

$psclight = 'Основная часть текстов в Пали-Русском построчном сопоставлении';
$smsclight = '4 никаи полностью АН, ДН, МН, СН';
$ptamilcube = 'Из КН: ud, iti, snp, dhp, thag, thig';

$head5words = 'Все Пали слова из Суттанты (кроме КН) и Винаи';
$pwords = 'По алфавиту с указанием количества';

$pwids = 'Прекрасная онлайн коллекция словарей. Помимо Пали -  многие духовные традиции Индии';
$smwisd = 'Очень полезно для сложных понятий';

$pdpd = 'Объёмный и удобный Пали-Англ словарь и грамматика Пали';
$smdpd = 'Доступны версии: Онлайн, ПК, Linux, Mac, Android, IOS';

$head5pts = 'Словарь Pali Text Society';
$ppts = 'Один из самых известных Пали-Англ словарей';

$head5cse = 'Google от Dhamma.Gift';
$psce = 'Google поиск по рекомендованным ресурсам';
$smcse = 'Особенно удобен для поисков на Wisdomlib';

$head5plikeyboard = 'Pali раскладка';
$pplikeyboard = 'Перед установкой Пали-плагина установите O keyboard';
$smplikeyboard = 'для активации: Язык - Транслитерация - Pali (IAST)';
$head5suttadiff = 'Сравнить Две Сутты';
$psuttadiff = 'Показывает разницу между двумя текстами. Пали или Англ.';
$head5listdiff = 'Сравнить Два Списка Сутт'; 
$plistdiff = 'Показывает разницу между двумя списками текстов в формате sn56.22 dn22 sn12.2'; 
$head5makelist = 'Сделать список из  строки';
$pmakelist = 'Создавайте списки феноменов, учений, переводов и т.п.'; 

$pt2s = 'Преобразование Русс и Англ текстов в речь';
$smt2s = 'для прослушивания текстов Dhamma.Gift Read, theravada.ru и др.';

$pscvoice = 'Преобразование Пали и Англ текстов в речь';
$smscvoice = 'для прослушивания текстов suttacentral.net';

$title404 = 'Ошибка 404';
$p404 = ' Страница не найдена. Но';
$link404 = '/r/?q=sn38.4';
$hreftext404 = 'На Главную';

$dpddesc = 'Digital Pali Dictionary Онлайн';

$dpdpart = '<h3>Скачать Словарь "DPD"</h3>
<a target="_blank" href="https://digitalpalidictionary.github.io/"><p>Сайт DPD</p></a>

<a target="_blank" href="https://digitalpalidictionary.github.io/rus/"><p>DPD Русская Версия</p></a>
<h3>Скачать Оболочку mDict</h3>
';

$defaults = '

<!-- Словарь Onlick Popup -->
<a title="Всплывающий по клику словарь" class="common-size-icon4 toggle-dict-btn text-decoration-none text-black">  <img src="/assets/svg/comment.svg" alt="Всплывающий по клику словарь" class="dictIcon"></img></a>
<a title="Настройки" id="settingsButton" data-bs-toggle="modal" data-bs-target="#settings" href="javascript:void(0);" class="toggle-icon text-decoration-none text-muted">
<img id="gearRead" alt="Настройки" src="/assets/svg/gear.svg" class="common-size-icon4"></img>
</a>

<div class="">
<a title="Помощь" data-bs-toggle="modal" data-bs-target="#paliLookupInfo" id="helpMessage" href="javascript:void(0);" class="toggle-icon text-decoration-none text-muted">
<img id="helpsc" alt="Помощь" src="/assets/svg/question.svg" class="common-size-icon4"></img>
</a>
<!-- Модальное окно "Настройки" -->
<div class="modal fade" id="settings" tabindex="-1" aria-labelledby="settingsLabel" aria-hidden="true" data-bs-focus="false">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h2 class="modal-title" id="settingsLabel">Настройки</h2>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
</div>
<div class="modal-body">
<div class="mb-2">
<!-- Дропдаун для выбора системы письма -->
<label for="script-select"><h5 style="text-align: left;">Система письма:</h5></label>
<select class="dropdown droponmain rounded-pill text-black border-2 border-secondary text-center input-group-append" id="script-select">
<option value="ISOPali">ISOPali</option>
<option value="Devanagari">Devanagari</option>
<option value="Thai">Thai</option>
</select>
&nbsp;<strong>Alt+L</strong>

</div>
<div class="mb-2">
<!-- Дропдаун для выбора системы письма -->
<label for="dict-select"><h5 style="text-align: left;">Словарь по клику:</h5></label>
<select class="dropdown droponmain rounded-pill text-black border-2 border-secondary text-center input-group-append" id="dict-select">
<option value="standalonebwru">DPD Встроенный</option>
<option value="standalonebw">DPD Встроенный Англ</option>
<option value="dpdFullRu">DPD Онлайн</option>
<option value="dpdFull">DPD Онлайн Англ</option>
<option value="dpdCompactRu">DPD Онлайн мини</option>
<option value="dpdCompact">DPD Онлайн мини Англ</option>
<option value="searchonly">Только Поиск</option>
<option value="dictTango">DictTango Android</option>
<option value="mdict">Mdict IOS</option>
</select> <a href="/assets/common/dictHelpRu.html">?</a>
</div>


<div class="mb-2">
<div class="d-flex">
<label class="form-check-label me-2" for="removePunctCheckbox">
<h5 class="mb-0">Убрать пунктуацию из Пали</h5>
</label>
<input class="form-check-input setting-checkbox" type="checkbox" id="removePunctCheckbox" data-key="removePunct">
&nbsp;  <strong>Alt+.</strong>

</div>

</div>
<!--        <div class="mb-2">
                    <label for="reader-select"><h5 style="text-align: left;">Интерфейс:</h5></label>
                    <select class="dropdown droponmain rounded-pill text-black border-2 border-secondary text-center input-group-append" id="reader-select">
                        <option value="st">Стандартный</option>
                        <option value="ml">Мульти</option>
                        <option value="d">"Деванагари"</option>
                        <option value="mem">Для запоминания</option>
                        <option value="rv">Реверс</option>
                        <option value="fr">Полный Реверс</option>
                    </select>
                </div> -->

<h5 style="text-align: left;">Выберите Режим Чтения:</h5>
<div class="container">


<!-- Стандартный -->
<div class="row align-items-center mb-2">
<div class="col-auto">
<input class="form-check-input mt-2 border-secondary" name="reader" type="radio" id="stRadio" value="st"> &nbsp;
<a id="stDemo" href="/r/?q=sn56.11"><strong>Стандартный</strong></a>

</div>
<div class="col text-end">
Два языка: пали, русс
</div>
</div>

<!-- Мульти -->
<div class="row align-items-center mb-2">
<div class="col-auto">
<input class="form-check-input mt-2 border-secondary" name="reader" type="radio" id="mlRadio" value="ml"> &nbsp;
<a id="mlDemo" href="/ml/?q=dn22"> <strong>Мульти</strong></a>

</div>
<div class="col text-end">
Три языка: пали, русс, англ
</div>
</div>

<!-- Деванагари -->
<div class="row align-items-center mb-2">
<div class="col-auto">
<input class="form-check-input mt-2 border-secondary" name="reader" type="radio" id="dRadio" value="d">
&nbsp;
<a id="dDemo" href="/d/?q=sn12.2"><strong>"Деванагари"</strong></a>

</div>
<div class="col text-end">
Деванагари или тайский скрипт + пали латиницей
</div>

</div>

<!-- Скрытая часть -->
<div id="collapseInterfaces" class="collapse">
<div class="row align-items-center mb-2">
<div class="col-auto">
<input class="form-check-input mt-2 border-secondary" name="reader" type="radio" id="memRadio" value="mem">
&nbsp;
<a id="memDemo" href="/memorize/?q=an10.46">              <strong>Для запоминания</strong>
</a>
</div>
<div class="col text-end">
Текст сокращен до первых букв каждого слова
</div>
</div>

<div class="row align-items-center mb-2">
<div class="col-auto">
<input class="form-check-input mt-2 border-secondary" name="reader" type="radio" id="rvRadio" value="rv">
&nbsp;
<a id="rvDemo" href="/rev/?q=sn35.236"><strong>Реверс</strong></a>

</div>
<div class="col text-end">
Текст снизу вверх
</div>
</div>

<div class="row align-items-center mb-2">
<div class="col-auto">
<input class="form-check-input mt-2 border-secondary" name="reader" type="radio" id="frRadio" value="fr">
&nbsp;
<a id="frDemo" href="/frev/?q=sn22.59"><strong>Полный Реверс</strong>
</a>
</div>
<div class="col text-end">
Как предыдущий + слова слева направо
</div>
</div>
<p class="mb-2">
Клик <strong>по названию</strong> - перейти один раз, <strong>по радио кнопке</strong> - сделать по умолчанию.
</p>
<!--    <div class="row align-items-center mb-2">
                            <div class="col-auto">
                                <input class="form-check-input mt-2 border-secondary" name="reader" type="radio" id="thRadio" value="fr"> &nbsp;
                                <a id="frDemo" href="/read/th?q=mn44"><strong>Thai</strong></a>
                            </div>
                            <div class="col text-end">
                                Two languages: Pali, Thai
                            </div>
                        </div>
                          <div class="row align-items-center mb-2">
                        <div class="col-auto">
                            <input class="form-check-input mt-2 border-secondary" name="reader" type="radio" id="mlRadio" value="mlth"> &nbsp;
                            <a id="mlDemo" href="/read/mlth.html?q=sn44.1"><strong>Thai Multi</strong></a>
                        </div>
                        <div class="col text-end">
                            Three languages: Pali, Thai, English
                        </div>
                    </div>
                    -->

</div>

<!-- Кнопка "Показать ещё" -->
<div class="text-end mb-2">
<button class="btn btn-sm btn-secondary rounded-pill" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInterfaces" aria-expanded="false" aria-controls="collapseInterfaces">
Другие
</button>
</div>
</div>

</div>
<div class="modal-footer">

<!-- Кнопки "Применить" и "Сбросить" -->
<div class="text-end">
<button type="button" class="btn btn-sm  rounded-pill btn-secondary " id="reset-button">Сбросить</button>
<button type="button" class="btn btn-sm btn-light border-secondary rounded-pill" id="apply-button">Применить</button>
<button type="button" class="btn-sm  btn-secondary rounded-pill" data-bs-dismiss="modal">Закрыть</button>
</div>

</div>
</div>
</div>
</div>
';
 

}
else {
$lang = "en";
$installpwa = "Install DG";
$canonicalPage = "https://Dhamma.Gift/";
$installpwalong = "Install DG";
$htmllang = "en";
$mainpage = '/';
$mainpagenoslash = '';
$readerPage = '/read';
$mainreadlink = '/read.php';
$searchcaption = 'Search';
$clearaption = 'Clear';

$btnsave = 'Set Defaults';
$btnreset = 'Reset';
$copyrightnote = 'The materials on this website are distributed under the <a class="text-white text-decoration-none me-0" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Attribution-NonCommercial-ShareAlike 4.0 International">CC BY-NC-SA 4.0</a> license, but Pali texts and English Translations from SuttaCentra.net, the works of A. Y. Syrkin and TheBuddhasWords.net are subject to different terms. Please check with the copyright holders for their usage conditions.';

$ifRuLitTrn = '';
$gearbutton = 'extra settings';

$maintitle = 'Precise Search in Pali Suttas and Vinaya';
$metadesc = 'Precise Search in Buddhas Teaching in Pali Suttas and Vinaya. Liberation Search Engine. All-Round Perspective on Dhamma of the Noble One Search in Pali Suttanta and Vinaya. Find Different Translations. ';
$metakeywords = 'Buddha, dhamma, pitaka, sutta, suttas, vinaya, patimokkha, pratimoksa, Buddhism, pali Canon, dharma';
$titletwit = 'Precise Search in Buddha Dhamma, in Pali Suttas and Vinaya. ';
$ogdesc = 'Liberation Search Engine. Search in Buddha Dhamma, Suttas and Vinaya in Pali, English, Russian and Thai';
$oglocale = 'en_US';
$ogshare = 'https://Dhamma.Gift/assets/img/social_sharing_gift.jpg';

$linksothermat = 'https://drive.google.com/drive/folders/1nrNtb_4s27nJGq61tpigf_b2sO_KOnVG';

$menu = 'Menu';
$menumain = 'Main';

$menuread = 'Read';
$menuhist = 'Search History';
$menuhowto = 'How To';
$menuabout = 'About';
$menulinks = 'Useful Links';
$menucontact = 'Contacts';

$poweredby = 'Powered by NI';
$tooltippoweredby = 'Natural Intelligence, Dhamma Intelligence';

$tooltiptitle = 'In Pāḷi, English, Russian, සිංහල & ไทย';
$title = 'Search for Truth';
$tooltippli = 'Default search. In Suttas of AN, SN, MN, DN + partially KN. Anguttara Nikaya, Samyutta Nikaya, Majjhimma Nikaya, Digha Nikaya + partially Khudakka Nikaya';
$radiopli = '4 Nikayas';
$tooltipdef = 'Search for definitions in the 4 main Pali Nikayas. Find meanings, quantities, types, and metaphors associated with the term. Requires standard phrasing for definitions. If no results are found in Suttas, Vinaya texts are automatically searched. Study related Suttas for a comprehensive view. See "Advanced" for more details.';
$radiodef = 'Def';

$tooltipsml = 'Search for similes, metaphors, and symbols related to the search term in four main Pali Nikayas. Requires standard phrasing for definitions.';
$radiosml = 'Sml';

$tooltipsearchbar = '<strong>Autosuggestions</strong>: Start typing at least 3 characters - suggestions will appear with Pali words of the Mahasangiti Edition. From the Four Nikāyas (DN, MN, SN, AN), from the part of KN (Dhp, Iti, Ud, Snp) and all Vinaya divisions. Does not include variants from other editions.
<br><br>
<strong>Match count</strong> e.g., mettā 27 shows how many times the word appears in texts listed above. For broader results, search for words in their base form without prefixes or case endings.
<br><br>
<strong>Open texts</strong>: Enter a reference e.g., sn56.11, DN 22, Sn 12 2, an10.46, mn141 - you will also see the Pāli text name in suggestions.
<br><br>
<strong>Search and reading history</strong>: Click the empty search bar or press space. This history is stored on this device only.
<br><br>
<strong>History search</strong>: When entering 1-2 characters, your filtered search & reading history will be shown.
<br><br>
<strong>Hotkeys:</strong><br>
<strong>Press /</strong> to activate the search field.
<br>
<strong>Ctrl + 1</strong> Main Search Page toggle (En / Ru).
<br>
<strong>Ctrl + 2</strong> Main Reading Page Table of Contents (En / Ru).
<br>
<strong>Ctrl + 3</strong> Open Dict.Dhamma.Gift.
<br>
<strong>Alt + 1</strong> Reading Interface (En / Ru).
';

$tooltiptextype = '<strong>Pāḷi*</strong> - 4 Nikayas + 6 KN books: Udana (Ud), Dhammapada (Dhp), Itivuttaka (Iti), Suttanipāta (Snp), Theragāthā (Thag), Therigatha (Thig)<br><br>
<strong>4 Nikayas</strong> - Anguttara Nikaya (AN), Samyutta Nikaya (SN), Majjhimma Nikaya (MN), Digha Nikaya (DN). Search in Root texts (Mula)
<br><br>
<strong>Vinaya*</strong> - Search in  Vinaya Vibhangas and Patimokkhas in Pali and English. <br><br>
<strong>+ 6 KN books</strong> - 4 Nikayas + 6 KN books: Udana (Ud), Dhammapada (Dhp), Itivuttaka (Iti), Suttanipāta (Snp), Theragāthā (Thag), Therigatha (Thig)<br><br>
<strong>+ all KN</strong> - 4 Nikayas + search in Pali in all books of KN<br><br>
<strong>+ Kd & Pvr</strong> - Vinaya + Khandhaka & Parivara<br><br>
<strong>TBW</strong> - search in theBuddhasWords.net materials<br><br>
<strong>SC.net</strong> - search in SuttaCentral.net english translations
 <br><br>
<strong>Theravada.ru</strong> - search on theravada.ru in Russian translations';
$tooltipknread = 'Part of KN';
$tooltipsearchtype = '<strong>Default</strong> - all matches grouped by texts<br><br>
<strong>Dictionary</strong> - search word in Dict.Dhamma.Gift<br><br>

<strong>Words</strong> - search results grouped by words (works only for Pali in 4 Nikayas)<br><br>
<strong>Definitions</strong> - Search for several main definitions in 4 main Nikayas in Pali. What is it, how many and what types, metaphors. Works only if definition was given in standard phrases. <br><br>
<strong>Similes</strong> - Sesrch for similies, metaphors, symbols, of the search term in Pali in 4 main Nikayas. Works only if definition was given in standard phrases.<br><br>
<strong>All definitions</strong> - Search for all definitions. For all-round view studying all related Suttas is recommended. See Advanced for details.<br><br>
<strong>Top-5 or 10</strong> - Top-X texts with the biggest number of matches. In case if you don\'t need all matches. 
';
$listdefall  = "All definitions";
$listnm10 = "Top-10";
$listnm = "Top-5";
$listdef = "Definitions";
$dictLookup = "Dictionary";
$listwords = "Words";
$listsml = "Similes";
$liststd = "All matches";

$tooltipvin = 'Search in Pali Vinaya';
$radiovin = 'Vinaya*';
$tooltipkn = '+ search in Pali Khuddaka Nikaya: dhp, iti, ud, snp, thag, thig';
$radiokn = 'Pāḷi*';
//+ 6 KN books
$tooltiponl = 'X Y ... Finds texts containing only both and more matches for X, Y ... Without this option only texts where X Y are standing next to each other will be found';
$checkboxonl = 'Any distance';
$tooltipnonl = 'Search for X Y ... on any distance within one text. By default only texts containing X Y ... next to each other will be found.';
$checkboxnonl = 'A B';
$tooltipen = 'Search in an, sn, mn, dn in English line by line translations by B. Sujato as on Suttacentral.net. Without this option search will start with Pali texts, then sc.net texts, then thebuddhaswords.net translations';
$radioen = 'SC.net';
$radiotru = 'Theravada.ru';
$tooltipltr= "+ search in Pali in all books of kn including later texts";
$radioltr = "+ all KN ";
$radiovinall = "+ Kd & Pvr";
$tooltipth = "(optional) Search in an, sn, mn, dn in Thai Suttacentral.net translations. Without this option default search will start with Pali texts, then with sc.net Thai translations";
$radioth = "ไทย";
$tooltipru = "(optional) Search in an, sn, mn, dn in Russain Suttacentral.net translations";
$radioru = "Rus";
$tooltiptbw = "Search in all contents of TheBuddhasWords.net";
$radiotbw = "TBW";

$monktype = array("monk" => "imassa ca bhikkhuno",
"senior monk" => "tassa ca therassa",
"Sangha" => "tassa ca saṅghassa"
);

$randomKey = array_rand($monktype);
$randomValue = $monktype[$randomKey];

$howtosearchquotetooltip = '';
$howtosearchquote = '<p class="pli-lang">Tāni ce sutte osāriyamānāni vinaye sandassiyamānāni na ceva sutte osaranti, na ca vinaye sandissanti, niṭṭhamettha gantabbaṃ: "addhā, idaṃ na ceva tassa bhagavato vacanaṃ; ' . $randomValue . ' duggahita"nti. Iti hetaṁ, bhikkhave, chaḍḍeyyātha.</p>
<p>If they (teachings, practices, methods, quotes, stories, anything associated with the Buddha) are not found in the Suttas and are not exhibited in the Vinaya, you should draw the conclusion: ‘Clearly this is not the word of the Blessed One. It has been wrongly understood by that ' . $randomKey . '.’ And so, monks, you should reject it.
</p>
<p class="text-end"><a target=_blank href=/read/?q=dn16&s=Tāni&lang=pli-rus#4.8.6>dn16</a> <a target=_blank href=/read/?q=an4.180&s=Tāni&lang=pli-rus#2.7>an4.180</a></p>';
$tooltipvindef = 'Search for definitions in Pali Vinaya. What is it, how many and what types. Works only if definition was given in standard phrases. For all-round view studing all related Rules is recommended. See Advanced for details';
$radiovindef = "DefV";
$tooltipla = "Add $defaultla lines before and after match";
//$checkboxla = "+" . $defaultla * 2 . " lines";
$checkboxla = "+" . $defaultla . " lines";
$regexMemoh5 = 'RegEx Memo';

$lax = "search for X, add $defaultla next line to output after lines containing X";
$lbx = "search for X, add $defaultla previous lines to output before lines containing X";
$exc = "search for X, exclude Y and Z";
$excfew = 'search for X, exclude Y ending with "ti" and "nti"';
$begin = 'begins with X or';
$end = 'ends';
$anynumber = 'any number of symbols between X and Y';
$fewsymbols = 'from 0 to 10 symbols';
$nextwords = 'next words X и Y, with variable ending of X';
$fewwords = 'distance of 0 to 2 words between X (any ending) and Y';
$variants = 'multiple variants';
$optionalletter = 'letter in [ ]? is optional';
$variantsexc = 'search for tatt excluding tatth';
$metaphorssmlletter = 'search for all metaphors in Samyutta 56';
$searchfewwords = 'search for few different patterns at the same time';
$inallnikaya = 'find X in all Majjhimma Nikaya';
$inonesutta = 'find Y in DN22 only';
$regexlink = 'AI can generate RegEx for grep -Ei, e.g. <a class="text-white" href="https://chat.openai.com/" target=_blank>ChatGPT</a>, <a class="text-white" href="https://chat.deepseek.com/" target=_blank>DeepSeek</a>, <a class="text-white" href=" https://claude.ai/" target=_blank>Claude AI</a>, <a class="text-white" href="https://codepal.ai/regex-generator" target=_blank>Codepal.ai</a><br>';

$regexMemo = '
          <p style="text-align: left;">
     <!--  <strong>-onl "(X|Y|...)"</strong> - find texts containing only all of the X, Y ... etc patterns<br> -->

</p>          ';
$titlehowtovideo = 'How-To Video';
$linkhowtovideo = 'https://youtu.be/Jle0XDs_roc?si=-FJFTpdOwZ4lIdo3';
$titledeschowtovideo = 'How to search in Pali Suttas and Vinaya with Dhamma.Gift';

$carouseltitle = 'Top Interesting Queries';

$slides = [
[
    'title' => 'Three Types of Dependent Origination',
    'desc' => 'Sequences of <span title="dn15">10</span>, <span title="dn14, sn12.65, sn12.67">11</span> and <span title="sn12.2 in this set and many other suttas, the most well-known and common formula">12</span> conditions',
    'link' => '/?q=%28N%C4%81mar%C5%ABpapaccay%C4%81+vi%C3%B1%C3%B1%C4%81%E1%B9%87a%7Csn12.2.%2AVibha%E1%B9%85gasutt%29&p=-kn',
],       
           [
        'title' => 'Tathagata didn\'t claim the Highest Awakening as long as...',
        'desc' => 'For all those aspiring for Liberation',
        'link' => '/?q=y%C4%81vak%C4%ABva%C3%B1.%2AAnuttara%E1%B9%81+samm%C4%81sambodh&p=-kn',
    ], 
           [
        'title' => 'Deadlines for Awakening for monks and layity from Buddha.',
        'desc' => 'up to 7 or 10 years, accordingly',
        'link' => '/assets/example/(viharanto-yathaa-mayaanusi.t.tha.m-eva.m-bhaaveyya)_suttanta_pali_3-16.html',
    ],
               [
        'title' => 'Definition of dukkha in suttas',
        'desc' => 'Is it possible that terminology in not throughout in the Buddhas Teaching?',
  'link' => '/assets/example/kata.,-dukkha.m-question_suttanta_pali_3-3.html',
    ],
    
                   [
        'title' => 'Types of individuals in Tathagatas Teaching',
        'desc' => 'Starting from 3 types up to 10',
        'link' => '/?q=Pugg.*saṁvijjam.*lokasmiṁ',
    ],        
           [
        'title' => 'Decline and Non-decline in Tathagatas Teaching',
        'desc' => 'E.g. stopping half-way is a case of decline',
        'link' => '/?q=Parihānametaṁ',
    ],    
                        [
        'title' => 'Noble "Vehicles"',
        'desc' => 'When ... made a vehicle',
        'link' => '/?q=Yānīkat',
    ],
          [
        'title' => 'Before my Awakening',
        'desc' => 'Thoughts and practices that led the unawakened Bodhisatta to Buddhahood',
        'link' => '/?q=Pubb.*sambodh',
    ],
    
                [
        'title' => 'Jatakas from Suttas',
        'desc' => 'Buddha and his followers, on their past lifes',
        'link' => '/?q=(bhūtapubbāha.*ahos|ahaṁ tena samayena.*ahos)',
    ],
    [
        'title' => 'Noble Glossary',
        'desc' => 'Specified Terms in the purification of the noble one (Ariyassa vinaye)',
        'link' => '/?q=Ariyassa vinaye',
    ],
    [
        'title' => 'What do you think?',
        'desc' => 'All Suttas when "What do you think?" was asked by Buddha and his disciples',
        'link' => '/assets/example/ta.m-ki.m-ma~n~n_suttanta_pali_218-610.html',
    ],
    [
        'title' => 'I will teach a noble...',
        'desc' => 'What is noble cleansing, purgative, emetic, the path, and samadhi',
       'link' => '/?q=\bariy.*desessā',
    ],
		    [
        'title' => 'Dhamma Commentaries',
        'desc' => 'Examples, of the proper commentaries: which lead to the goal.',
        'link' => '/?q=-la10 vuttamidaṁ',
    ],
    [
        'title' => 'There comes a time...',
        'desc' => 'Various recurring events described in Suttas',
        'link' => '/?q=Hoti kho so.*samayo',
    ],
    [
        'title' => 'I don’t deny it.',
        'desc' => 'Curious clarifications and details containing this phrase.',
        'link' => '/?q=Nes.*natth.*vadāmi',
    ],
];

$read = 'read';

$fntmessage = 'All-round view on Four Noble Truths<br>
        in Pali Suttas and Vinaya.<br>
        Understand the real meaning <br>
        of Four Noble Truths<br>
        and finish the pain.';
	
$mainscrollmodalheader = 'Definition of Dukkha in Suttas';

$mainscrollmodal = '<p class="">From <a href="/read/?q=dn22&s=dukkha&lang=pli-eng#18.18">dn22</a> <a href="/read/?q=mn141&s=dukkha&lang=pli-eng#16.1">mn141</a></br>
<h4 class="pli-lang">Katamañca, bhikkhave, dukkhaṁ?</h4>And what is pain?</br></br><p class="pli-lang">Yaṁ kho, bhikkhave, <strong>kāyikaṁ</strong> dukkhaṁ <strong>kāyikaṁ</strong> asātaṁ kāyasamphassajaṁ dukkhaṁ asātaṁ vedayitaṁ,</p><p>Whatever is experienced as  <strong>bodily</strong> pain, <strong>bodily</strong> discomfort, pain or discomfort born of bodily contact, </p></br>
<p class="pli-lang">idaṁ vuccati, bhikkhave, dukkhaṁ.</p>
<p>that is called pain.</p>
</br>
<h4 class="pli-lang">Katamañca, bhikkhave, domanassaṁ?</h4>
<p>And what is stress / "suffering"?</p></br>

<p class="pli-lang">Yaṁ kho, bhikkhave, <strong>cetasikaṁ</strong> dukkhaṁ <strong>cetasikaṁ</strong> asātaṁ manosamphassajaṁ dukkhaṁ asātaṁ vedayitaṁ,</p>
<p>Whatever is experienced as <strong>mental</strong> pain, <strong>mental</strong> discomfort, pain or discomfort born of mental contact, that is called distress,</p>
</br>
<p class="pli-lang">idaṁ vuccati, bhikkhave, domanassaṁ.</p>
<p>that is called stress.</p>';

        
$transwarning = '<i class="fa-solid fa-triangle-exclamation "></i> <b>Please remember!</b><br><br> Translations, dictionaries and commentaries were not made by the Buddha! Be scrutinizing and critical reading them.<br><br> 
The most important fundamentals of the Buddha’s Teaching are best learned<strong> on one’s own from the Suttas in Pali</strong>. A solid starting point is the Middle Practice and the Four Noble Truths, such as a few paragraphs from <strong>sn56.11</strong>.';   

$transwarning = '<i class="fa-solid fa-triangle-exclamation "></i> <b>Please Remember!</b><br><br> Translations, dictionaries and commentaries do not originate directly from the Buddha himself! Approach them with scrutiny and critical thinking.<br><br> To acquire the fundamental teachings of the Buddha, it is highly recommended to engage in the <strong>direct study of Suttas in Pali</strong>. At the very least, concentrate on understanding the Middle Practice and the Four Noble Truths. For instance, consider delving into a dedicated section from <strong>sn56.11</strong>.';


$anamemlearnpali = 'Learn Pali Guides';
$anamelearnsanskrit = 'James Whelan. Pali & Sanskrit';

$anamemolds = 'Translations by M. Olds';
$anameasc = 'Articles at Dhammadana.org';
$anameati = 'Accesstoinsight.org patimokkha';
$anamehist = 'History';
$anameuseful = 'Useful Links';
$anamedpd = 'Pali for mDict';

$anameresearch = 'Research';
$anameread = 'Read';
$anamestudy = 'Study';
$anamematerials = 'Materials';
$anamecases = 'Cases';
$anameconj = 'Conjugations';
$anametextbook = 'Pali Textbook';
$anameothermat = 'Other Materials';
$anamesdiff = 'Sutta Difference';
$anametools = 'Tools';

$aboutheader = 'About Project';
$aboutprp = '<div class="col-lg-4 ms-auto"><p class="lead">Dhamma.Gift is a Liberation Search Engine for Dhamma and Vinaya, core of the Pali Canon. </br></br>Search results in informative tables with line by line translations and external links. You can search in Pali, English, Russian, Thai for meanings, definitions, metaphors, explanations, people, places, and more as described in the Suttas and Vinaya. </p></div>
<div class="col-lg-4 me-auto"><p class="lead">
Software developers, contributors, or anyone willing to help are warmly welcomed.
<br><br>
The project does not require financial support, but if you would like to contribute toward domain name expenses or contribute with your help in website development, feel free to reach out using any of the contacts listed in the "Contacts" section below.
</p></div>';
$prongh = ' Project on GitHub';
$premail = ' Dhamma.Gift key features';
$prekeyfeatures = 'keyFeatures.html';

$headerexamples = 'Examples';
$examplelist = '<li>Definition of the <a href="/?q=-la1+Kata.*,+dukkhaṁ[,\\\\?]">dukkha</a> in Pali with quotes in English. Query is: <a href="/?q=-la1+Kata.*,+dukkhaṁ[,\\\\?]">-la1 Kata.*, dukkhaṁ[,\\\\?]</a>
</li>

 <li>Sutta where Buddha says that he doesn\'t make <a href="/?q=dvayagāminī">ambiguous (dvayagāminī) statements</a> in Pali with English quote</li>

<li>All variants of the word <a href="/?q=paṭiccasamuppād">paṭiccasamuppado</a> in Pali with quotes in English</li>
            
<li>All suttas about <a href="/?q=eightfold">Eightfold</a> Path in English</li>
<li>All suttas that took place or related to <a href="/assets/example/สาวัตถี_suttanta_th_913-1168.html">Savathi</a> in Thai</li>
<li>All suttas where <a href="/ru/?q=Сарипутт">Sariputta</a> was mentioned in Russian</li>

<li>All suttas where <a href="./assets/example/moggallaa-exc-(sikhaamoggall|akamoggall)_suttanta_pali_75-621.html">Moggallana</a> was mentioned in Pali and English</li>
    
<li>All suttas about or containing the word <a href="?q=ocean">ocean</a> in English</li>
<li>All Suttas with <a href=./assets/example/(seyyathaapi-adhivacan-uupama-opama)_suttanta_pali_647-2186.html>metaphors & similies</a> in Pali and English</li>   ';
$howtoheader = 'How to Search';

$contactheader = 'Contacts';
$contaccalltoaction = 'Find the Noble Eightfold Path.<br>
Understand the Four Noble Truths.<br>Dhamma - is Actuality.';
 $demovideo = 'Demo Videos';  
 $demovideolink = 'https://youtube.com/playlist?list=PLFJDP30qrYJ2H2lYWREQHF1FVggRYsDB9&si=SIOe2dVFFAApudsw';
 $demovideoimg = '/assets/img/video1en.webp';
 $demovideoimg2 = '/assets/img/video1en.webp';

 $basics = 'Tips & Tricks';
 $basicscontent = '<p class="mb-4"><strong>Tip #0</strong><br>Search available in Pali, English, Russian and Thai materials of SuttaCentral.net and also in thebuddhaswords.net. If some text is not presented there, you wont be able to find it.<br>
Also, e.g. if "sankhara" is translated as "formation" in thw materials you won\'t find it in suttacentral.net, as it\'s translated as "choice" and vice-versa.<br>
The following logic is applied: if you search in Roman script: 1st is Pali, then tbw materials, then Suttacentral.net materials. In Thai script - 1st is Pali, then Thai translations. In Cyrillic - Russian translations only.
<br><br>
<strong>Tip #1</strong><br>
Use special characters ā ī ū ḍ ṁ ṁ ṇ ṅ ñ ṭ<br><br>
<strong>Tip #2 Khuddaka NIkaya</strong><br>
Search is performed in All DN, MN, SN, AN. use <strong>-kn</strong> option if you also want to include results from the following books of KN: Dhammapada, Udāna, Itivuttaka, Suttanipāta, Theragāthā, Therīgāthā. Other books of KN will not be used in the search even with option. You may use alternative services to make searches in Jatakas and other book of KN.<br>
Example #1: -kn jamm
<br>Will search in DN, MN, SN, AN + books of KN listed above
<br>
Example #2: jamm
<br>Will search in DN, MN, SN, AN only.
<br><br>

<strong>Tip #3 Vinaya</strong><br> 
if you\'re willing to search in Vinaya add -vin to your search request. For pali vinaya search for cetana the line will look like: -vin cetana <br><br>

<strong>Tip #4 Stem</strong><br>
Use stem of the word for broader results with or without prefixes or endings. 
<br><br>
<strong>Tip #5</strong><br>
Prefer Pali to other languages. Pali is the language in which the oldest Dhamma related texts are written.	
<br><br>
<strong>Tip #6</strong><br>
For Pali search results you have two options: results sorted by Suttas/Texts with quotes and by words. Use both to get some extra details.<br><br>
<strong>Tip #7</strong><br>Minimal length of search pattern is 3 symbols. But if possible search for longer patterns. Then you will get more precise results.<br><br>
<strong>Tip #8</strong><br> 
We highly recommend to search in Pali. As it will give the best results, and you will develop a very important habit to look into Pali and do not rely blindly on the translations. But obviously you can get some benefits from searches in translations. If you are looking for animals, plants, etc. There are at least 4 different pali words for a snake but in Russian or English - it\'s just "a snake" or "a viper". <br><br>

<strong>Tip #9</strong><br>
if your request fails due to timeout try longer search pattern.  <br><br>
<strong>Tip #10</strong><br>
if your request fails due to timeout, and you can\'t use longer search pattern try <a href="./bg.php">Background Mode</a>. It might work.
<br><br> 
<strong>What is Mtphr count in result table?</strong><br>
Matches in all text, not connected to search pattern:<br>
"seyyathāpi|adhivacan|ūpama|opama|opamma"<br>
Following words are ignored:<br>
"adhivacanasamphass|adhivacanapath|ekarūp|tathārūpa|āmarūpa|\brūpa|evarūpa|\banopam|\battūpa|\bnillopa|opamaññ"<br>
Create an issue on github or send an email, if you\'ll find other criteria.
<br><br>
</p>';


$ctaButtons =' <div class="d-flex flex-wrap flex-column flex-sm-row justify-content-center align-items-center my-3 mb-2">
    
    <button class="ms-2 mb-2 p-0 border-0 bg-transparent" id="installPWA" style="cursor:pointer;">
        <img src="/assets/img/buttons/pwa-cta.png" class="img-fluid" style="max-width: 200px;" title="Install Dhamma.gift as progressive web app">
    </button>

    <a class="ms-2 mb-2" href="https://t.me/dgift_bot">
        <img src="/assets/img/buttons/telegram-cta.png" class="img-fluid" style="max-width: 200px;" title="Open DGift_bot. Or type @DGift_bot in any Telegram chat or group">
    </a>

    <a class="ms-2 mb-2" href="https://play.google.com/store/apps/details?id=gift.dhamma.twa">
        <img src="/assets/img/buttons/google-play-cta.png" class="img-fluid" style="max-width: 200px;" title="Download from Google Play">
    </a>

    <a class="ms-2 mb-2" href="/assets/apk/dhamma.gift-latest.apk">
        <img src="/assets/img/buttons/apk-cta.png" class="img-fluid" style="max-width: 200px;" title="Download APK. If you need build-in browser search and share functions, which Google removes from Play Market version">
    </a>
    
    <a class="ms-2 mb-2" href="https://chromewebstore.google.com/detail/dhammagift-search-and-wor/dnnogjdcmhbiobpnkhdbfnfjnjlikabd">
        <img src="/assets/img/buttons/chrome-cta.png" class="img-fluid" style="max-width: 200px;" title="Download from Chrome Web Store. Supports Chrome, Edge, Opera, Brave, Vivaldi, and Yandex Browser.">
    </a>

    <a class="ms-2 mb-2" href="https://addons.mozilla.org/en-US/firefox/addon/dhamma-gift/">
        <img src="/assets/img/buttons/firefox-cta.png" class="img-fluid" style="max-width: 200px;" title="Download from Firefox Add-ons">
    </a>

    <a class="ms-2 mb-2" href="https://microsoftedge.microsoft.com/addons/detail/dhammagift-search-and-wo/aokegkhdaijkikbdocanadeghllhfmhj">
        <img src="/assets/img/buttons/edge-cta.png" class="img-fluid" style="max-width: 200px;" title="Download from Microsoft Edge Store">
    </a>
    
</div>


<script>
let deferredPrompt;

window.addEventListener(\'beforeinstallprompt\', (e) => {
// Prevent automatic banner display
e.preventDefault();
deferredPrompt = e;

// Show the button
const installBtn = document.getElementById(\'installPWA\');
installBtn.style.display = \'inline-block\';

installBtn.addEventListener(\'click\', () => {
if (deferredPrompt) {
deferredPrompt.prompt();
deferredPrompt.userChoice.then((choiceResult) => {
if (choiceResult.outcome === \'accepted\') {
console.log(\'Installation accepted\');
} else {
console.log(\'Installation declined\');
}
deferredPrompt = null;
});
}
});
});
</script>';




$advanced = 'Advanced';
$advancedcontent = '<strong>Tip #1</strong><br>
If you want to find some word in particular sutta, samyutta or nikaya run search like this: Sn17.*seyyathāpi
<br>This example will search for all similies and metaphors in all Sn17.<br><br>
<strong>Tip #2</strong><br>
To add variations you may add [], e.g. nand[iī] this will search for both nandi and nandī matches.
<br><br>

<strong>Tip #3</strong><br>
If you want to find words beginning or ending from some pattern use \\\\b before and/or in the end of the pattern. e.g. <strong>\\\\bkummo\\\\b</strong> will search for only kummo and will skip kummova and any other<br><br>
<strong>Tip #4</strong><br>
You may use regexes that are applicable in GNU grep -E statements. With proper escaping (\\\\) they should work. 
Specialized AI can generate RegEx for Grep, e.g. <a href="https://codepal.ai/regex-generator" target=_blank>here</a>.
Read and study regex to boost your search abilities.<br><br>
<strong>Tip #5</strong><br>
Read about <a target="_blank" href="https://datatables.net/">DataTables</a> on project webpage or elswhere. Results are generated in datatables.<br><br>

<strong>How "Def" option works?</strong><br>
With Def following search will run:<br>
grep -E -A1 -Eir "${defpattern}.*nāma|an1\..*${defpattern}|An2.*Dv.*${defpattern}|An3.*(Tis|Tay|Tī).*${defpattern}|An4.*(Cattā|Cata).*${defpattern}|An5.*Pañc.*${defpattern}|An6.*cha.*${defpattern}|An7.*Satta.*${defpattern}|An8.*Aṭṭh.*${defpattern}|An9.*Nav.*${defpattern}|an1[10].*das.*${defpattern}|Seyyathāpi.*${defpattern}|${defpattern}[^\s]{0,3}sutta|(dn3[34]|mn4[34]).*(Dv|Tis|Tay|Tī|Cattā|Cata|Pañc|cha|Satta|Aṭṭh|Nav|das).{0,20}${defpattern}|\bKas.{0,60}${defpattern}.{0,9}\?|Katth.*${defpattern}.*daṭṭhabb|\bKata.{0,20}${defpattern}.{0,9}\?|Kiñ.*${defpattern}.{0,9} vadeth|${defpattern}.*adhivacan|vucca.{2,5} ${defpattern}{0,7}|${defpattern}.{0,15}, ${defpattern}.*vucca|${defpattern}.{0,9} vacan|Yadapi.*${defpattern}.*tadapi.*${defpattern}" --exclude-dir={ab,bv,cnd,cp,ja,kp,mil,mnd,ne,pe,ps,pv,tha-ap,thi-ap,vv} <br>
Please, create an issue on github or send an email, if you\'ll find other criteria.<br><br> ';


$defaults = '<!-- Dictionary OnClick Popup -->
<a alt="onclick popup dictionary" title="onclick popup dictionary" class="common-size-icon4 toggle-dict-btn text-decoration-none text-black">
<img src="/assets/svg/comment.svg" class="dictIcon"></img>
</a>

<!-- Settings Button -->
<a alt="Settings" title="Settings" id="settingsButton" data-bs-toggle="modal" data-bs-target="#settings" href="javascript:void(0);" class="toggle-icon text-decoration-none text-muted">
<img id="gearRead" src="/assets/svg/gear.svg" class="common-size-icon4"></img>
</a>


<!-- Модальное окно "Настройки" -->
<div class="modal fade" id="settings" tabindex="-1" aria-labelledby="settingsLabel" aria-hidden="true" data-bs-focus="false">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h2 class="modal-title" id="settingsLabel">Settings</h2>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<div class="mb-2">
<!-- Dropdown for script selection -->
<label for="script-select"><h5 style="text-align: left;">Script system:</h5></label>
<select class="dropdown droponmain rounded-pill text-black border-2 border-secondary text-center input-group-append" id="script-select">
<option value="ISOPali">ISOPali</option>
<option value="Devanagari">Devanagari</option>
<option value="Thai">Thai</option>
</select>
&nbsp;  <strong>Alt+L</strong>
</div>

<div class="mb-2">
<!-- Дропдаун для выбора режима словаря -->
<label for="dict-select"><h5 style="text-align: left;">On click dictionary:</h5></label>
<select class="dropdown droponmain rounded-pill text-black border-2 border-secondary text-center input-group-append" id="dict-select">
<option value="standalonebw">DPD Built-in</option>
<option value="standalonebwru">DPD Built-in Rus</option>
<option value="dpdFull">DPD Online </option>
<option value="dpdFullRu">DPD Online Rus</option>
<option value="dpdCompact">DPD Onilne mini </option>
<option value="dpdCompactRu">DPD Online mini Rus</option>
<option value="searchonly">Search Only</option>
<option value="dictTango">DictTango Android</option>
<option value="mdict">Mdict IOS</option>

</select> <a href="/assets/common/dictHelp.html">?</a>
</div>

<div class="mb-2">
<div class="d-flex">
<label class="form-check-label me-2" for="removePunctCheckbox">
<h5 class="mb-0">Remove punctuation from Pali </h5>
</label>
<input class="form-check-input setting-checkbox" type="checkbox" id="removePunctCheckbox" data-key="removePunct">&nbsp; <strong>Alt+.</strong>
</div>

</div>
<h5 style="text-align: left;">Select Reading Mode: </h5>
<div class="container">
<!-- Standard -->
<div class="row align-items-center mb-2">
<div class="col-auto">
<input class="form-check-input mt-2 border-secondary" name="reader" type="radio" id="stRadio" value="st"> &nbsp;
<a id="stDemo" href="/read/?q=sn56.11"><strong>Standard</strong></a>
</div>
<div class="col text-end">
Two languages: Pali, English
</div>
</div>

<!-- Multi -->
<div class="row align-items-center mb-2">
<div class="col-auto">
<input class="form-check-input mt-2 border-secondary" name="reader" type="radio" id="mlRadio" value="ml"> &nbsp;
<a id="mlDemo" href="/ml/?q=dn22"><strong>Multi</strong></a>
</div>
<div class="col text-end">
Three languages: Pali, Russian, English
</div>
</div>

<!-- Devanagari -->
<div class="row align-items-center mb-2">
<div class="col-auto">
<input class="form-check-input mt-2 border-secondary" name="reader" type="radio" id="dRadio" value="d"> &nbsp;
<a id="dDemo" href="/d/?q=sn12.2"><strong>"Devanagari"</strong></a>
</div>
<div class="col text-end">
Devanagari or Thai script + Pali in Latin
</div>
</div>

<!-- Hidden Section -->
<div id="collapseInterfaces" class="collapse">
<div class="row align-items-center mb-2">
<div class="col-auto">
<input class="form-check-input mt-2 border-secondary" name="reader" type="radio" id="memRadio" value="mem"> &nbsp;
<a id="memDemo" href="/memorize/?q=an10.46"><strong>For Memorization</strong></a>
</div>
<div class="col text-end">
Text shortened to the first letters of each word
</div>
</div>
<div class="row align-items-center mb-2">
<div class="col-auto">
<input class="form-check-input mt-2 border-secondary" name="reader" type="radio" id="rvRadio" value="rv"> &nbsp;
<a id="rvDemo" href="/rev/?q=sn35.236"><strong>Reverse</strong></a>
</div>
<div class="col text-end">
Text from bottom to top
</div>
</div>
<div class="row align-items-center mb-2">
<div class="col-auto">
<input class="form-check-input mt-2 border-secondary" name="reader" type="radio" id="frRadio" value="fr"> &nbsp;
<a id="frDemo" href="/frev/?q=sn22.59"><strong>Full Reverse</strong></a>
</div>
<div class="col text-end">
Like the previous one + words from left to right
</div>
</div>
<p class="mb-2">
Click <strong>title</strong> to go once or click <strong>radio button</strong> to set as default.
</p>
</div>

<!-- "Show More" Button -->
<div class="text-end mb-2">
<button class="btn btn-sm btn-secondary rounded-pill" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInterfaces" aria-expanded="false" aria-controls="collapseInterfaces">
Others
</button>
</div>
</div>
</div>
<div class="modal-footer">
<!-- "Apply" and "Reset" Buttons -->
<div class="text-end">
<button type="button" class="btn btn-sm rounded-pill btn-secondary" id="reset-button">Reset</button>
<button type="button" class="btn btn-sm btn-light border-secondary rounded-pill" id="apply-button">Apply</button>
<button type="button" class="btn-sm btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
</div>
';

$closemodal = 'Close Window';

$head2recomlinks = 'Recommended Links';
$detailonline = 'online';
$detailoffline = 'offline';
$detailonandoffline = 'online & offline';
$detailapp = 'app';
$detailtable = 'table';
$detailtextbook = 'textbook';

$header5fdgoffline = 'Dhamma.Gift Offline Edition';
$pfdg = 'All encompassing search within all Suttas and Vinaya';
$pfdgoffline = 'Offline version & setup instruction. Android, Linux, Windows';

$head5othermat = 'Materials for studying Pali in English and Russian';
$pothermat = 'Collection of textbooks and tables';

$pconj = 'Conjugations sometimes mistranslated';
$smcheckpali = 'Check Pali original';

$pcases = 'Cases are mistranslated pretty often';

$ptextbook = 'Highly recommended';
$pthru = 'The most complete translation of Suttanta in Russian';
$pthsu = 'Multiple translation options. Pali-English-Russian line-by-line';
$smthsu = 'Especially recommended for studying Digha Nikaya';

$pdpr = 'Profound online tool for Pali readings and alternative search';
$smdpr = 'Built-in Pali-English dictionary';
$ptbw = 'Very impressive paragraph-by-paragraph Pali-English collection';
$smtbw = 'Pali-English on hover dictionary built-in';
$psc = 'The most complete line-by-line Pali-English collection';
$smsc = 'Pali-English dictionary can be turned on in settings';


$mainpageextrasourceslink = 'MenuRead,MenuEnglish'; 
$mainpageextrasourcestitle = 'Full list'; 
$mainpageextrasourcesdesc = 'in the "External" submenu, under the search bar'; 

$mainpageextrasearchlink = 'MenuEnglish,tools'; 
$mainpageextrasearchtitle = 'Full list'; 
$mainpageextrasearchdesc = 'in the "Tools" submenu, under the search bar'; 

$mainpageextrastudylink = 'materials'; 
$mainpageextrastudytitle = 'Full list'; 
$mainpageextrastudydesc = 'in the "Study" submenu, under the search bar'; 


$psclight = 'All Sutta and Vinaya texts in quick lightweight reading interface';
$smsclight = 'Pali-English Line-by-line';
$ptamilcube = 'On-click fullscale Pali Lookup';
$head5words = 'All Pali words from Suttanta (except KN) & Vinaya';
$pwords = 'In alphabetical order with count number';
$pwids = 'Big online collection of dictionaries. Not only Pali, but multiple spiritual traditions of India';
$smwisd = 'Very helpful for difficult terms';

$head5cse = 'Google from Dhamma.Gift';
$psce = 'Search with Google within recommended resources';
$smcse = 'Especially convenient for Wisdomlib';

$pdpd = 'The biggest and quickest dictionary and pali grammar';
$smdpd = 'Available for PC, Linux, Mac, Android, IOS';

$head5dpdru = 'DPD Russian Version';
$pdpdru = 'Smaller Pali-Russian Dictionary based on DPD';
$smdpdru = '';


$head5pts = 'Pali Text Society Dictionary';
$ppts = 'One of the most famous Pali English dictionaries';

$head5plikeyboard = 'Pali Layout';
$pplikeyboard = 'Install "O keyboard" itself before installing plug-in';
$smplikeyboard = 'to add Pali: Language - Transliteration - Pali (IAST)';

$head5suttadiff = 'Compare Two Suttas';
$psuttadiff = 'Finds difference between two texts.';
$head5listdiff = 'Compare Two Lists of Suttas'; 
$plistdiff = 'Finds difference between two lists of suttas in this format: sn56.22 dn22 sn12.2'; 
$head5makelist = 'Line to List';
$pmakelist = 'Create Lists of phenomena, teachings, translations etc'; 


$pt2s = 'Text-to-Speech generator for English and Russian';
$smt2s = 'Listen to Dhamma.Gift Read, theravada.ru & other';
$pscvoice = 'Generates Pali & English text-to-speech';
$smscvoice = 'for suttacentral.net texts';

$title404 = '404 Error';
$p404 = ' Page not found. But';
$link404 = '/read/?q=sn38.4';
$hreftext404 = 'Go Home';

$dpddesc = 'Digital Pali Dictionary Online';

$dpdpart = '<h3>Download DPD</h3>
<a target="_blank" href="https://digitalpalidictionary.github.io/"><p>DPD Official</p></a>

<a target="_blank" href="https://digitalpalidictionary.github.io/rus/"><p>DPD Russian Edition</p></a>
<h3>Download MDict</h3>
';

}
if (strpos($_SERVER['REQUEST_URI'], "/th") !== false){
$lang = "th";
$htmllang = "th";
$mainpage = '/th';
$mainpagenoslash = '/th';
$readerPage = $mainpage . '/read';
$mainreadlink = '/th/read.php';
}
$menuuseful = 'Search,MenuRead,MenuEnglish,history,MenuDict,MenuRussian,tools,materials';


$ctaButtons .='<script>
let deferredPrompt;

window.addEventListener(\'beforeinstallprompt\', (e) => {
// Prevent automatic banner display
e.preventDefault();
deferredPrompt = e;

// Show the button
const installBtn = document.getElementById(\'installPWA\');
installBtn.style.display = \'inline-block\';

installBtn.addEventListener(\'click\', () => {
if (deferredPrompt) {
deferredPrompt.prompt();
deferredPrompt.userChoice.then((choiceResult) => {
if (choiceResult.outcome === \'accepted\') {
console.log(\'Installation accepted\');
} else {
console.log(\'Installation declined\');
}
deferredPrompt = null;
});
}
});
});
</script>';



?>
