function randPlaceholder(theLanguage) {

          if ( theLanguage === "en") {

            tasks = ["Start with Sn56.11", "Read sn22.79", "Think about mn28", "Practice in dn22", "Dukkha defined in dn22", "Saṅkhārā in mn44", "For example sn12.2", "Practices in an4.162", "Practices in an4.163", "\"The all\" is in sn35.23"]; 
          } else if  ( theLanguage === "ru") {
            tasks = ["Начните с Sn56.11", "Прочтите sn22.79", "Подумайте над mn28", "Практика в dn22", "Dukkha в dn22", "Saṅkhārā в mn44", "К примеру sn12.2", "Практики в an4.162", "Практики в an4.163", "\"Всё\" в sn35.23"];
          }

const random = Math.floor(Math.random() * tasks.length);
// console.log(random, tasks[random]);
document.getElementById('paliauto').placeholder = tasks[random];
}

function randCallToAction() {
   var theLanguage = $('html').attr("lang");
 
  if(theLanguage == "en"){
  //  console.log("your html contains en");
    var tasks = ["The 1st is Sn56.11", "Read sn22.87", "Ponder on mn28", "Dukkha in Suttas is?", "How many Jhanas in Suttas?",  "Real meaning of Pañña is?", "Dukkha is defined in dn22", "Saṅkhārā in mn44", "Why Tathagata is like ocean?", "Why Dhamma is like Ocean?", "Why Tathagata is like elephant?", "What is the ocean?", "What is the all?", "Difference between dukkha and dukkha ariyasacca?", "Cow in Suttas symbolizes - ..."];
}  else if  ( theLanguage == "ru") {
 //  console.log("your html contains ru");
    var tasks = ["1ая - это Sn56.11", "Прочти sn22.87", "Подумай над mn28", "Dukkha в Суттах - это?", "Сколько джхан в Суттах?", "Pañña на самом деле - это ...?", "Определение dukkha есть в dn22", "Saṅkhārā в mn44", "Почему Татхагата, как слон?", "Почему Дхамма, как Океан?", "Почему Татхагата, как Океан?", "Что такое океан?", "Что такое 'всё'?", "Разница между dukkha и dukkha ariyasacca", "Корова в суттах символизирует - ...?"];
          }
const random = Math.floor(Math.random() * tasks.length);
// console.log(random, tasks[random]);
let defaultTitle = document.title
window.onblur = () => {
   //change title, blink title, whatever
   document.title = tasks[random]
}
window.onfocus = () => {
   //back to default title
   document.title = defaultTitle
}
}

function randPlaceholderOnMain() {
   var theLanguage = $('html').attr("lang");
  if(theLanguage == "en"){
    var words = ["Kāyagat","Seyyathāpi","Samudd","Cūḷanik", "elephant", "ocean", "satipaṭṭhānā"];
    var suttas = ["Sn56.11","Dn22","Sn 12 2", "An4 163"]; 
    var or = " or ";
    var example = "e.g. ";
}  else if  ( theLanguage == "ru") {
    var words = ["Kāyagat","Seyyathāpi","Samudd","Cūḷanik", "Suññat", "Mūsik", "Hatthī", "Слон", "дрессировщик", "satipaṭṭhānā"];
    var suttas = ["Sn 56 11","Dn22","Сн12.2", "an4 163"];
    var or = " или ";

    var example = "пр. ";
          }
const randomW = Math.floor(Math.random() * words.length);
const randomS = Math.floor(Math.random() * suttas.length);
// console.log(words[randomW], suttas[randomS]);
document.getElementById('paliauto').placeholder = example + words[randomW] + or + suttas[randomS];
}
