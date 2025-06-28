// responsiveVoicePlayer.js

document.addEventListener('DOMContentLoaded', function() {
    // Получаем элемент div, который должен содержать текст для озвучивания
    const voiceTextContent = document.getElementById('voiceTextContent');

    // Если элемент не найден, выходим, чтобы избежать ошибок на страницах, где он не нужен
    if (!voiceTextContent) {
        // console.log("Элемент с ID 'voiceTextContent' не найден. Функционал ResponsiveVoice не будет активирован.");
        return;
    }

    // Создаем контейнер для кнопок, если его еще нет
    let voiceControlsDiv = document.getElementById('voiceControls');
    if (!voiceControlsDiv) {
        voiceControlsDiv = document.createElement('div');
        voiceControlsDiv.id = 'voiceControls';
        voiceControlsDiv.style.marginTop = '20px'; // Добавляем немного отступа
        // Вставляем кнопки после текстового контента
        voiceTextContent.parentNode.insertBefore(voiceControlsDiv, voiceTextContent.nextSibling);
    }

    // Создаем кнопки
    const buttons = [
        { id: 'playEnglish', text: 'Play (English)', action: 'play', lang: 'US English' },
        { id: 'playRussian', text: 'Play (Русский)', action: 'play', lang: 'Russian' },
        { id: 'pauseVoice', text: 'Pause', action: 'pause' }, // Изменил id, чтобы избежать конфликтов
        { id: 'resumeVoice', text: 'Resume', action: 'resume' }, // Изменил id
        { id: 'stopVoice', text: 'Stop', action: 'stop' } // Изменил id
    ];

    buttons.forEach(btnConfig => {
        let button = document.getElementById(btnConfig.id);
        if (!button) { // Создаем кнопку, только если её нет
            button = document.createElement('button');
            button.id = btnConfig.id;
            button.textContent = btnConfig.text;
            button.className = 'btn btn-primary btn-sm me-2 mb-2'; // Bootstrap классы для стилизации
            voiceControlsDiv.appendChild(button);
        }

        button.addEventListener('click', function() {
            const text = voiceTextContent.innerText; // Получаем текст из div

            if (text.trim() === '') {
                // alert("На странице нет текста для озвучивания."); // Можно убрать, если текст всегда есть
                return;
            }

            switch (btnConfig.action) {
                case 'play':
                    // Проверяем, существует ли responsiveVoice и готов ли он к использованию
                    if (typeof responsiveVoice !== 'undefined' && responsiveVoice.isPlaying()) {
                        responsiveVoice.cancel(); // Останавливаем предыдущее воспроизведение, если есть
                    }
                    if (typeof responsiveVoice !== 'undefined') {
                        responsiveVoice.speak(text, btnConfig.lang);
                    } else {
                        console.error("ResponsiveVoice.js не загружен или не инициализирован.");
                    }
                    break;
                case 'pause':
                    if (typeof responsiveVoice !== 'undefined' && responsiveVoice.isPlaying()) {
                        responsiveVoice.pause();
                    }
                    break;
                case 'resume':
                    if (typeof responsiveVoice !== 'undefined' && responsiveVoice.isPaused()) {
                        responsiveVoice.resume();
                    }
                    break;
                case 'stop':
                    if (typeof responsiveVoice !== 'undefined' && (responsiveVoice.isPlaying() || responsiveVoice.isPaused())) {
                        responsiveVoice.cancel();
                    }
                    break;
            }
        });
    });

    // Опционально: можно добавить стили для кнопок, если не используете Bootstrap
    // Например:
    // voiceControlsDiv.querySelectorAll('button').forEach(btn => {
    //     btn.style.padding = '10px 20px';
    //     btn.style.fontSize = '16px';
    //     btn.style.marginRight = '10px';
    //     btn.style.cursor = 'pointer';
    // });

    }
