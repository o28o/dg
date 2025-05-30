# Standard Library
import json
import os
import logging
import re
import sys

# Telegram Core
from telegram import (
    Update,
    InlineQueryResultArticle,
    InputTextMessageContent,
    MenuButtonWebApp,
    WebAppInfo,
    BotCommand,
    InlineKeyboardButton,
    InlineKeyboardMarkup,
    error
)

# Telegram Extensions
from telegram.ext import (
    Application,
    CommandHandler,
    MessageHandler,
    InlineQueryHandler,
    CallbackQueryHandler,
    filters,
    CallbackContext,
)


WELCOME_MESSAGES = {
    "en": (
        "✨ Welcome to Dhamma Gift Bot!\n\n"
        "❓ <b>How to use:</b>\n\n"
        "💬 <b>Call me in any chat or group:</b>\n"
        "⌨️ Type @dgift_bot or @dhammagift_bot and start typing a word to search or sutta reference (e.g. <code>sn12.2</code>)\n\n"
        "💡 Suggestions will appear for Pali words and sutta references\n\n"
        "🤓 You can use Velthuis transliteration for diacritics: <code>.t .d .n ~n aa ii uu</code> → <code>ṭ ḍ ṇ ñ ā ī ū</code>\n\n"
        "💬 <b>In this private chat:</b>\n"
        "Simply send me a word or reference (e.g. <code>saariputta</code> or <code>mn10</code>)\n\n\n"
        "Following commands available:\n"
        "/start - this message\n"
        "/extra - Mini App links\n"
        "/help - Dhamma.gift help will be here\n\n"
        "Change Bots language 👇 Изменить язык \n"
    ),
    "ru": (
        "Добро пожаловать в Dhamma Gift Bot!\n\n"
        "🔍 <b>Как использовать:</b>\n\n"
        "💬 <b>Вы можете вызвать меня в любом чате или группе:</b>\n"
        "⌨️ Напишите @dgift_bot или @dhammagift_bot и начните печатать слово или номер сутты (например, <code>sn12.2</code>)\n"
        "💡 Я предложу варианты палийских слов и ссылок на сутты\n\n"
        "🤓 Также Вы можете использовать транслитерацию Velthuis для диакритики: <code>.t .d .n ~n aa ii uu</code> → <code>ṭ ḍ ṇ ñ ā ī ū</code>\n\n"
        "💬 <b>В этом личном чате:</b>\n"
        "Просто отправьте мне слово или номер сутты (например, <code>saariputta</code> или <code>mn10</code>)\n\n\n"
        "Доступны следующие команды:\n"
        "/start - это сообщение\n"
        "/extra - ссылки на Mini Apps\n"
        "/help - здесь будет документация Dhamma.gift\n\n"
        "Изменить язык Бота 👇 Change Language\n"

    )
}

EXTRA_MESSAGES = {
    "ru": (
        "Мини Приложения на Русском. Вы можете закрепить это сообщение для быстрого доступа:\n\n"
        "🔎 Поиск\n"
        "http://t.me/dgift_bot/find\n"
        "📖 Чтение\n"
        "http://t.me/dgift_bot/read\n"
        "🌐 Словарь\n"
        "http://t.me/dgift_bot/dict\n\n"
    ),
    "en": (
        "Mini Applications in English. You may want to pin this message for quick access:\n\n"
        "🔎 Search\n"
        "http://t.me/dhammagift_bot/find\n"
        "📖 Read\n"
        "http://t.me/dhammagift_bot/read\n"
        "🌐 Dictionary\n"
        "http://t.me/dhammagift_bot/dict\n\n"
    )
}

# === Загрузка конфига ===
config_path = sys.argv[1] if len(sys.argv) > 1 else "config.json"
with open(config_path, "r") as f:
    config = json.load(f)

bot_name = config.get("NAME", "default_bot")
TOKEN = config.get("TOKEN", "")
if not TOKEN:
    raise ValueError(f"Token not found in {config_path}")

# === Настройка логирования ===
class TelegramTokenFilter(logging.Formatter):
    """Форматтер для маскировки Telegram bot токенов в логах"""
    @staticmethod
    def _mask_token(text: str) -> str:
        return re.sub(
            r'(https?://api\.telegram\.org)/bot[^/]+/',
            r'\1/botTOKEN/',
            text,
            flags=re.IGNORECASE
        )

    def format(self, record):
        original = super().format(record)
        return self._mask_token(original)

logging.basicConfig(
    level=logging.INFO,
    format="%(asctime)s - %(name)s - %(levelname)s - %(message)s",
    handlers=[logging.FileHandler(f"{bot_name}.log"), logging.StreamHandler()],
)

# Применяем наш форматтер ко всем обработчикам
for handler in logging.root.handlers:
    handler.setFormatter(
        TelegramTokenFilter(
            fmt=handler.formatter._fmt if hasattr(handler.formatter, '_fmt') else None,
            datefmt=handler.formatter.datefmt if hasattr(handler.formatter, 'datefmt') else None
        )
    )

logger = logging.getLogger(__name__)


# === Константы ===
#USER_DATA_FILE = "user_data.json"
USER_DATA_FILE = f"user_data_{bot_name}.json"
DEFAULT_LANG = "en"  # Английский по умолчанию

# === Функции для работы с JSON-хранилищем ===
def load_user_data() -> dict:
    """Загружает данные пользователей из файла"""
    if not os.path.exists(USER_DATA_FILE):
        return {}
    
    try:
        with open(USER_DATA_FILE, "r", encoding="utf-8") as f:
            return json.load(f)
    except Exception as e:
        logger.error(f"Ошибка загрузки user_data: {e}")
        return {}

def save_user_data(user_id: int, key: str, value: str):
    """Сохраняет данные пользователя в файл"""
    try:
        data = load_user_data()
        user_id_str = str(user_id)
        
        if user_id_str not in data:
            data[user_id_str] = {}
        
        data[user_id_str][key] = value
        
        with open(USER_DATA_FILE, "w", encoding="utf-8") as f:
            json.dump(data, f, indent=2, ensure_ascii=False)
    except Exception as e:
        logger.error(f"Ошибка сохранения user_data: {e}")

def get_user_lang(user_id: int) -> str:
    """Возвращает сохраненный язык пользователя"""
    data = load_user_data()
    return data.get(str(user_id), {}).get("lang", DEFAULT_LANG)

def get_user_share_lang(user_id: int) -> str:
    """Возвращает сохраненный язык для шейринга пользователя"""
    data = load_user_data()
    return data.get(str(user_id), {}).get("share_lang", get_user_lang(user_id) or DEFAULT_LANG)

# === Загрузка словаря ===
def load_words():
    try:
        path = os.path.join("assets", "sutta_words.txt")
        with open(path, "r", encoding="utf-8") as f:
            words = [line.strip() for line in f if line.strip()]
            
            # Создаем словарь: {нормализованное_слово: [оригинальные_слова]}
            normalized_dict = {}
            for word in words:
                norm_word = normalize(word)
                if norm_word not in normalized_dict:
                    normalized_dict[norm_word] = []
                normalized_dict[norm_word].append(word)
            
            # Также сохраняем оригинальный список слов для обратной совместимости
            logger.info(f"Загружено {len(words)} слов для автокомплита, создано {len(normalized_dict)} нормализованных форм")
            return {
                "original_words": words,
                "normalized_dict": normalized_dict
            }
    except Exception as e:
        logger.error(f"Ошибка загрузки словаря: {e}")
        return {
            "original_words": [],
            "normalized_dict": {}
        } 

# Заменяем старую строку:
# WORDS = load_words()

# На новую:
WORDS = load_words().get("original_words", [])

def normalize(text: str) -> str:
    """Нормализация текста с учетом возможных замен"""
    if not text:
        return text
  
    # Кэширование результатов для повторного использования
    if not hasattr(normalize, "cache"):
        normalize.cache = {}
    
    if text in normalize.cache:
        return normalize.cache[text]
    
    text_lower = text.lower()
    replacements = [
        ("aa", "a"), ("ii", "i"), ("uu", "u"),
        ('"n', "n"), ("~n", "n"),
        (".t", "t"), (".d", "d"), (".n", "n"),
        (".m", "m"), (".l", "l"), (".h", "h")
    ]
    for pattern, repl in replacements:
        text_lower = text_lower.replace(pattern, repl)
    
    result = (
        text_lower.replace("ṁ", "m").replace("ṃ", "m")
        .replace("ṭ", "t").replace("ḍ", "d")
        .replace("ṇ", "n").replace("ṅ", "n")
        .replace("ñ", "n").replace("ā", "a")
        .replace("ī", "i").replace("ū", "u")
        .replace(".", " ")
    )
    
    normalize.cache[text] = result
    return result
    
def autocomplete(prefix: str, max_results: int = 29) -> list[str]:
    try:
        if not hasattr(autocomplete, "word_data"):
            autocomplete.word_data = load_words()
        
        normalized_dict = autocomplete.word_data.get("normalized_dict", {})
        original_words = autocomplete.word_data.get("original_words", [])
        
        prefix_n = normalize(prefix)
        
        # Сначала ищем слова, которые начинаются с префикса
        starts_with = []
        for norm_word, orig_words in normalized_dict.items():
            if norm_word.startswith(prefix_n):
                starts_with.extend(orig_words)
        
        # Затем ищем слова, которые содержат префикс (но не начинаются с него)
        contains = []
        for norm_word, orig_words in normalized_dict.items():
            if prefix_n in norm_word and not norm_word.startswith(prefix_n):
                contains.extend(orig_words)
        
        # Удаляем дубликаты (если один оригинал попал в оба списка)
        starts_with = list(dict.fromkeys(starts_with))
        contains = list(dict.fromkeys(contains))
        
        # Сортируем результаты (сначала начинающиеся с префикса, затем содержащие)
        starts_with_sorted = sorted(starts_with, key=lambda x: normalize(x))
        contains_sorted = sorted(contains, key=lambda x: normalize(x))
        
        # Объединяем результаты
        suggestions = (starts_with_sorted + contains_sorted)[:max_results]
        logger.debug(f"Автокомплит для '{prefix}': найдено {len(suggestions)} вариантов")
        return suggestions
    except Exception as e:
        logger.error(f"Ошибка автокомплита: {e}")
        return []
# === Создание клавиатуры с кнопками ===
def create_keyboard(query: str, lang: str = "en", is_inline: bool = False) -> InlineKeyboardMarkup:
    base = "https://dhamma.gift"
    search_url = f"{base}/{'' if lang == 'en' else 'ru/'}?p=-kn&q={query.replace(' ', '+')}"
    dict_url = f"https://dict.dhamma.gift/{'' if lang == 'en' else 'ru/'}search_html?q={query.replace(' ', '+')}"

    label_dict = "📘 Dictionary" if lang == "en" else "📘 Словарь"
    label_site = "🔎 Dhamma.gift En" if lang == "en" else "🔎 Dhamma.gift Ru"
    toggle_label = "RU" if lang == "en" else "EN"  # Инвертировано, так как DEFAULT_LANG=en

    callback_prefix = "inline_" if is_inline else ""

    keyboard = [
        [
            InlineKeyboardButton(text=toggle_label, callback_data=f"{callback_prefix}toggle_lang:{lang}:{query}"),
            InlineKeyboardButton(text=label_dict, url=dict_url),
        ],
        [
            InlineKeyboardButton(text=label_site, url=search_url),
        ]
    ]

    return InlineKeyboardMarkup(keyboard)

# === Форматирование текста с кликабельными ссылками ===
def format_message_with_links(text: str, query: str, lang: str = "en") -> str:
    base = "https://dhamma.gift"
    search_url = f"{base}/{'' if lang == 'en' else 'ru/'}?p=-kn&q={query.replace(' ', '+')}"
    dict_url = f"https://dict.dhamma.gift/{'' if lang == 'en' else 'ru/'}search_html?q={query.replace(' ', '+')}"

    label_dict = "📘 Dictionary" if lang == "en" else "📘 Словарь"
    label_site = "🔎 Dhamma.gift" if lang == "en" else "🔎 Dhamma.gift"

    links_text = (
        f'<a href="{search_url}">{label_site}</a> | '
        f'<a href="{dict_url}">{label_dict}</a>'
    )
    return f"\n{text}\n\n{links_text}"
    
async def set_menu_button(update: Update, lang: str):
    """Устанавливает кнопку меню в зависимости от языка"""
    user_id = update.effective_user.id
    button_text = "DG ru" if lang == "ru" else "DG en"
    button_url = "https://dhamma.gift/ru/?source=pwa" if lang == "ru" else "https://dhamma.gift/?source=pwa"
    
    # Создаем объект WebAppInfo с URL
    web_app_info = WebAppInfo(url=button_url)
    menu_button = MenuButtonWebApp(text=button_text, web_app=web_app_info)
    
    try:
        await update.get_bot().set_chat_menu_button(
            chat_id=user_id,
            menu_button=menu_button
        )
        logger.info(f"Установлена кнопка меню для {user_id}: {button_text} ({button_url})")
    except Exception as e:
        logger.error(f"Ошибка установки кнопки меню: {e}")

async def update_menu_button(user_id: int, lang: str, bot):
    """Обновляет кнопку меню в списке чатов"""
    button_text = "DG ru" if lang == "ru" else "DG en"
    button_url = "https://dhamma.gift/ru/?source=pwa" if lang == "ru" else "https://dhamma.gift/?source=pwa"
    
    menu_button = MenuButtonWebApp(
        text=button_text,
        web_app=WebAppInfo(url=button_url)
    )
    
    try:
        await bot.set_chat_menu_button(
            chat_id=user_id,
            menu_button=menu_button
        )
        logger.info(f"Обновлена кнопка меню для {user_id}: {button_text}")
    except Exception as e:
        logger.error(f"Ошибка обновления кнопки меню: {e}")
        
async def start(update: Update, context: CallbackContext):
    user = update.effective_user
    logger.info(f"Command /start from {user.id} ({user.full_name})")

    # Get or set default language
    user_lang = get_user_lang(user.id) or 'en'
    context.user_data["lang"] = user_lang

    # Create single toggle button
    keyboard = [
        [
            InlineKeyboardButton(
                "Русский" if user_lang == 'en' else "English",
                callback_data=f"lang_set:{user_lang}"
            )
        ]
    ]

    try:
        # Send welcome message
        await update.message.reply_text(
            WELCOME_MESSAGES[user_lang],
            reply_markup=InlineKeyboardMarkup(keyboard),
            parse_mode="HTML",
            disable_web_page_preview=True
        )
        
        # Set menu button with error handling
        try:
            await set_menu_button(update, user_lang)
        except Exception as menu_error:
            logger.error(f"Menu setup error for {user.id}: {menu_error}")
            try:
                await update.message.reply_text(
                    "⚠️ Menu setup error. Please try later.",
                    parse_mode="HTML"
                )
            except:
                pass

    except Exception as e:
        logger.error(f"Error in start for {user.id}: {e}")
        try:
            await context.bot.send_message(
                chat_id=user.id,
                text="🚫 An error occurred. Please try again.",
                parse_mode="HTML"
            )
        except:
            pass

    # Set bot commands
    try:
        from telegram import BotCommand
        commands = [
            BotCommand("start", "Start bot"),
            BotCommand("help", "Help"),
            BotCommand("extra", "Extra features")
        ]
        if user_lang == 'ru':
            commands = [
                BotCommand("start", "Запустить бота"),
                BotCommand("help", "Помощь"),
                BotCommand("extra", "Дополнительно")
            ]
        await context.bot.set_my_commands(commands)
    except Exception as commands_error:
        logger.error(f"Command setup error for {user.id}: {commands_error}")

async def handle_language_selection(update: Update, context: CallbackContext):
    query = update.callback_query
    await query.answer()

    user_id = query.from_user.id
    current_lang = query.data.split(':')[1]
    new_lang = 'ru' if current_lang == 'en' else 'en'

    # Сохраняем основной язык бота
    save_user_data(user_id, 'lang', new_lang)
    # Также сохраняем этот язык как язык для шейринга (если он не был установлен ранее)
    if not get_user_share_lang(user_id):
        save_user_data(user_id, 'share_lang', new_lang)
    
    context.user_data['lang'] = new_lang

    # Создаем кнопку для нового языка
    keyboard = [
        [
            InlineKeyboardButton(
                "Русский" if new_lang == 'en' else "English",
                callback_data=f"lang_set:{new_lang}"
            )
        ]
    ]

    # Редактируем сообщение с новым языком
    await query.edit_message_text(
        text=WELCOME_MESSAGES[new_lang],
        reply_markup=InlineKeyboardMarkup(keyboard),
        parse_mode="HTML"
    )
    
    # Обновляем кнопку меню
    await set_menu_button(update, new_lang)

    # Обновляем команды бота
    try:
        commands = [
            BotCommand("start", "Start bot"),
            BotCommand("help", "Help"),
            BotCommand("extra", "Extra features")
        ]
        if new_lang == 'ru':
            commands = [
                BotCommand("start", "Запустить бота"),
                BotCommand("help", "Помощь"),
                BotCommand("extra", "Дополнительно")
            ]
        await context.bot.set_my_commands(commands)
    except Exception as commands_error:
        logger.error(f"Command update error for {user_id}: {commands_error}")

async def extra_command(update: Update, context: CallbackContext):
    """Handler for /extra command showing mini-applications"""
    user = update.effective_user
    user_id = user.id
    
    # Get user language
    lang = get_user_lang(user_id) or DEFAULT_LANG
    
    # Create keyboard with toggle button
    keyboard = [
        [
            InlineKeyboardButton(
                "English" if lang == "ru" else "Русский",
                callback_data=f"extra_toggle:{lang}"
            )
        ]
    ]
    
    # Send message with appropriate language
    await update.message.reply_text(
        EXTRA_MESSAGES[lang],
        reply_markup=InlineKeyboardMarkup(keyboard),
        disable_web_page_preview=True
    )

async def handle_extra_toggle(update: Update, context: CallbackContext):
    """Handler for language toggle in /extra command"""
    query = update.callback_query
    await query.answer()
    
    user_id = query.from_user.id
    current_lang = query.data.split(':')[1]
    new_lang = 'en' if current_lang == 'ru' else 'ru'
    
    # Update user language preference
    save_user_data(user_id, 'lang', new_lang)
    context.user_data['lang'] = new_lang
    
    # Create updated keyboard
    keyboard = [
        [
            InlineKeyboardButton(
                "English" if new_lang == "ru" else "Русский",
                callback_data=f"extra_toggle:{new_lang}"
            )
        ]
    ]
    
    # Edit message with new language
    await query.edit_message_text(
        text=EXTRA_MESSAGES[new_lang],
        reply_markup=InlineKeyboardMarkup(keyboard),
        disable_web_page_preview=True
    )

def uniCoder(text):
    if not text:
        return text
    replacements = [
        ("aa", "ā"), ("ii", "ī"), ("uu", "ū"),
        ('"n', "ṅ"), ("~n", "ñ"),
        (".t", "ṭ"), (".d", "ḍ"), (".n", "ṇ"),
        (".m", "ṃ"), (".l", "ḷ"), (".h", "ḥ")
    ]
    for pattern, repl in replacements:
        text = text.replace(pattern, repl)
    return text

# === Инлайн-режим ===
async def inline_query(update: Update, context: CallbackContext):
    query = update.inline_query.query.strip()
    if not query:
        return

    user_id = update.inline_query.from_user.id
    logger.info(f"Инлайн-запрос: '{query}' от {user_id}")

    # Get interface language (for bot UI)
    interface_lang = get_user_lang(user_id) or DEFAULT_LANG
    # Get share language (for content)
    share_lang = get_user_share_lang(user_id) or interface_lang
    
    suggestions = autocomplete(query, max_results=29)
    results = []
    converted_text = uniCoder(query)
    
    if converted_text:
        results.append(InlineQueryResultArticle(
            id="user_input",
            title=f"✏️ Send: {converted_text}" if interface_lang == "en" else f"✏️ Отправить: {converted_text}",
            input_message_content=InputTextMessageContent(
                format_message_with_links(converted_text, converted_text, lang=share_lang),
                parse_mode="HTML",
                disable_web_page_preview=True
            ),
            description="Your text with converted symbols" if interface_lang == "en" else "Ваш текст с преобразованными символами",
            reply_markup=create_keyboard(converted_text, lang=share_lang, is_inline=True)
        ))

    for idx, word in enumerate(suggestions[:29]):
        results.append(InlineQueryResultArticle(
            id=f"dict_{idx}",
            title=word,
            input_message_content=InputTextMessageContent(
                format_message_with_links(word, word, lang=share_lang),
                parse_mode="HTML",
                disable_web_page_preview=True
            ),
            description=f"Click to send '{word}'" if interface_lang == "en" else f"Нажмите, чтобы отправить '{word}'",
            reply_markup=create_keyboard(word, lang=share_lang, is_inline=True)
        ))

    await update.inline_query.answer(results, cache_time=10)    

# === Обработчик сообщений с защитой от None ===
async def handle_message(update: Update, context: CallbackContext):
    try:
        if not update.message or not update.message.text:
            logger.warning("Received update without message or text")
            return
            
        text = update.message.text.strip()
        user = update.effective_user
        logger.info(f"Message from {user.id}: {text}")

        IGNORE_INLINE_BOTS = ["dgift_bot", "dhammagift_bot", "cakkhu_bot"]
        
        if update.message.via_bot and update.message.via_bot.username in IGNORE_INLINE_BOTS:
            logger.info(f"Ignoring message from inline bot: {update.message.via_bot.username}")
            return

        if re.search(r'http[s]?://(?:[a-zA-Z]|[0-9]|[$-_@.&+]|[!*\\(\\),]|(?:%[0-9a-fA-F][0-9a-fA-F]))+', text):
            lang = get_user_lang(user.id) or DEFAULT_LANG
            reply = {
                "en": "Please send me just the word or text without URLs. I'll help you with word analysis or translation.",
                "ru": "Пожалуйста, пришлите мне только слово или текст без URL. Я помогу вам с анализом слова или переводом."
            }[lang]
            await update.message.reply_text(reply)
            return

        # Get interface language for bot responses
        interface_lang = get_user_lang(user.id) or DEFAULT_LANG
        # Get share language for content
        share_lang = get_user_share_lang(user.id) or interface_lang
        
        converted_text = uniCoder(text)
        
        if converted_text == text and len(text) < 5 and text.isalpha():
            suggestions = autocomplete(text)
            if suggestions:
                reply = {
                    "en": "Possible variants:\n" + "\n".join(f"- {w}" for w in suggestions),
                    "ru": "Возможные варианты:\n" + "\n".join(f"- {w}" for w in suggestions)
                }[interface_lang]
                await update.message.reply_text(reply)
                return

        message_text = format_message_with_links(converted_text, converted_text, lang=share_lang)
        keyboard = create_keyboard(converted_text, lang=share_lang)
        
        await update.message.reply_text(
            message_text,
            reply_markup=keyboard,
            parse_mode="HTML",
            disable_web_page_preview=True
        )
        
    except Exception as e:
        logger.error(f"Error in handle_message: {e}")
async def toggle_language(update: Update, context: CallbackContext):
    query = update.callback_query
    try:
        await query.answer()
        user = query.from_user
        user_id = user.id
        
        try:
            parts = query.data.split(':')
            if len(parts) < 3:
                raise ValueError("Invalid callback_data format")
            
            is_inline = parts[0] == 'inline_toggle_lang'
            current_lang = parts[1]
            search_query = ':'.join(parts[2:])[:256]
        except Exception as parse_error:
            logger.error(f"Ошибка разбора callback_data: {parse_error} | Данные: {query.data}")
            await query.message.reply_text("⚠️ Ошибка обработки запроса")
            return

        new_lang = 'ru' if current_lang == 'en' else 'en'
        
        # Save the share language preference
        save_user_data(user_id, 'share_lang', new_lang)
        
        try:
            message_text = format_message_with_links(search_query, search_query, lang=new_lang)
            reply_markup = create_keyboard(search_query, lang=new_lang, is_inline=is_inline)
        except Exception as prep_error:
            logger.error(f"Ошибка подготовки сообщения для {user_id}: {prep_error}")
            await query.message.reply_text("⚠️ Ошибка формирования ответа")
            return

        try:
            await query.edit_message_text(
                text=message_text,
                reply_markup=reply_markup,
                parse_mode="HTML",
                disable_web_page_preview=True
            )
        except telegram.error.BadRequest as e:
            if "Message is not modified" not in str(e):
                logger.error(f"Ошибка редактирования сообщения для {user_id}: {e}")
                await query.message.reply_text("⚠️ Ошибка обновления сообщения")
            return

    except Exception as global_error:
        logger.critical(f"Критическая ошибка в toggle_language: {global_error}")
        try:
            await query.message.reply_text("⚠️ Произошла непредвиденная ошибка")
        except:
            pass
def main():
    logger.info(f"Starting bot {bot_name}...")  # Используем bot_name, загруженное выше
    try:
        # Инициализация и дальнейший код, используя bot_name и TOKEN
        app = Application.builder().token(TOKEN).build()

        # Создаем папку assets если ее нет
        os.makedirs("assets", exist_ok=True)

        # Инициализируем бота
        app = Application.builder().token(TOKEN).build()

        # Регистрируем обработчики
        app.add_handler(CommandHandler("start", start))
        app.add_handler(CallbackQueryHandler(handle_language_selection, pattern="^lang_set:"))
        app.add_handler(InlineQueryHandler(inline_query))
        app.add_handler(CommandHandler("extra", extra_command))
        app.add_handler(CallbackQueryHandler(handle_extra_toggle, pattern=r"^extra_toggle:"))  
        app.add_handler(MessageHandler(filters.TEXT & ~filters.COMMAND, handle_message))
        app.add_handler(CallbackQueryHandler(toggle_language, pattern=r"^toggle_lang:"))
        app.add_handler(CallbackQueryHandler(toggle_language, pattern=r"^inline_toggle_lang:"))

        # Проверяем наличие файла словаря
        if not os.path.exists(os.path.join("assets", "sutta_words.txt")):
            logger.warning("Sutta words file not found! Autocomplete will not work")

        logger.info(f"Bot {bot_name} is running and ready to handle updates")
        app.run_polling()
    except Exception as e:
        logger.critical(f"Bot {bot_name} failed to start: {e}")
        raise

if __name__ == "__main__":
    # Запускаем бота
    try:
        main()
    except KeyboardInterrupt:
        logger.info(f"Bot {bot_name} stopped by user")
    except Exception as e:
        logger.critical(f"Fatal error: {e}")