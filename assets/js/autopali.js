function uniCoder(textInput) {
    if (!textInput || textInput === "") return textInput;
    return textInput
        .replace(/aa/g, "ā")
        .replace(/ii/g, "ī")
        .replace(/uu/g, "ū")
        .replace(/\"n/g, "ṅ")
        .replace(/\~n/g, "ñ")
        .replace(/\.t/g, "ṭ")
        .replace(/\.d/g, "ḍ")
        .replace(/\.n/g, "ṇ")
        .replace(/\.m/g, "ṃ")
        .replace(/\.l/g, "ḷ")
        .replace(/\.h/g, "ḥ");
}

document.addEventListener('DOMContentLoaded', function() {
    let paliauto = document.getElementById("paliauto");

    if (paliauto) {
        paliauto.addEventListener("input", function () {
            let textInput = paliauto.value;
            let convertedText = uniCoder(textInput);
            paliauto.value = convertedText;
        });

        // Добавляем обработчик клика по пустому инпуту
        paliauto.addEventListener("click", function() {
            if (paliauto.value === "") {
                // Триггерим событие поиска с пустым запросом
                $(paliauto).autocomplete("search", "");
            }
        });
    }
 
    $.ajax({
        url: "/assets/texts/sutta_words.txt",
        dataType: "text",
        success: function(data) {
            var accentMap = {
                "ā": "a",
                "ī": "i",
                "ū": "u",
                "ḍ": "d",
                "ḷ": "l",
                "ṃ": "ṁ",
                "ṁ": "n",
                "ṁ": "m",
                "ṅ": "n",
                "ṇ": "n",
                "ṭ": "t",
                "ñ": "n",
                "ññ": "n",
                "ss": "s",
                "aa": "a",
                "ii": "i",
                "uu": "u",
                "dd": "d",
                "kk": "k",
                "ḍḍ": "d",
                "ḷḷ": "l",
                "ṇṇ": "n",
                "ṭṭ": "t",
                "cc": "c",
                "pp": "p",
                "cch": "c",
                "ch": "c",
                "kh": "k",
                "ph": "p",
                "th": "t",
                "ṭh": "t"
            };

            var normalize = function(term) {
                var ret = "";
                for (var i = 0; i < term.length; i++) {
                    ret += accentMap[term.charAt(i)] || term.charAt(i);
                }
                return ret;
            };

            var allWords = data.split('\n');

            $("#paliauto").autocomplete({
                position: {
                    my: "left bottom",
                    at: "left top",
                    collision: "flip"
                },
                minLength: 0,
                multiple: /[\s\*]/,
                source: function(request, response) {
                    var terms = request.term.split(/[\|\s\*]/);
                    var lastTerm = terms.pop().trim();
                    var minLengthForSearch = 3;

                    // Если терм пустой — показываем всю историю
                    if (!lastTerm) {
                        var history = JSON.parse(localStorage.getItem("localSearchHistory")) || [];
                        var historyKeys = history.map(([key]) => key);
                        response(historyKeys);
                        return;
                    }

                    // Получаем историю для подсказок, даже если терм короткий
                    var history = JSON.parse(localStorage.getItem("localSearchHistory")) || [];
                    var historyKeys = history.map(([key]) => key);

                    // Фильтруем историю по введённому началу строки
                    var filteredHistory = historyKeys.filter(key => 
                        key.toLowerCase().startsWith(lastTerm.toLowerCase())
                    );

                    // Если длина запроса меньше минимальной — показываем только фильтрованную историю
                    if (lastTerm.length < minLengthForSearch) {
                        response(filteredHistory);
                        return;
                    }

                    var normalizedTerm = normalize(lastTerm);
                    var re = $.ui.autocomplete.escapeRegex(normalizedTerm);
                    var modifiedRe = re.replace(/([a-zA-Z])/g, "$1{1,2}");
                    var matchbeginonly = new RegExp("^" + modifiedRe, "i");
                    var matchall = new RegExp(modifiedRe, "i");

                    var listBeginOnly = $.grep(allWords, function(value) {
                        value = value.label || value.value || value;
                        var normalizedValue = normalize(value);
                        return matchbeginonly.test(normalizedValue);
                    });

                    var listAll = $.grep(allWords, function(value) {
                        value = value.label || value.value || value;
                        var normalizedValue = normalize(value);
                        return matchall.test(normalizedValue);
                    });

                    listAll = listAll.filter(function(el) {
                        return !listBeginOnly.includes(el);
                    });

                    var maxRecord = 1000;
                    var resultList = listBeginOnly.concat(listAll).slice(0, maxRecord);

                    response(resultList);
                },
                focus: function(event, ui) {
                    return false;
                },
                select: function(event, ui) {
                    var terms = this.value.split(/([\|\s\*])/);
                    terms.pop();
                    
                    var selectedValue = ui.item.value;
                    if (/\s+\d+$/.test(selectedValue)) {
                        selectedValue = selectedValue.split(/\s+/)[0];
                    }
                    
                    terms.push(selectedValue);

                    for (var i = 1; i < terms.length; i += 2) {
                        if (terms[i] === "*") {
                            terms[i] = "*";
                        } else if (terms[i] === "|") {
                            terms[i] = "|";
                        } else {
                            terms[i] = " ";
                        }
                    }

                    this.value = terms.join("");
                    
                    // Сохраняем в историю
                    var history = JSON.parse(localStorage.getItem("localSearchHistory")) || [];
                   // history.unshift([selectedValue]);
                   // localStorage.setItem("localSearchHistory", JSON.stringify(history));
                    
                    return false;
                }
            }).autocomplete("widget").addClass("fixed-height");
        }
    });
});

