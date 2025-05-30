import json
import os
import logging
from telegram import Update, InlineQueryResultArticle, InputTextMessageContent
from telegram.ext import (
    Application,
    CommandHandler,
    MessageHandler,
    InlineQueryHandler,
    filters,
    CallbackContext,
)

# === Настройка логирования ===
logging.basicConfig(
    level=logging.INFO,
    format="%(asctime)s - %(name)s - %(levelname)s - %(message)s",
    handlers=[logging.FileHandler("bot.log"), logging.StreamHandler()],
)
logger = logging.getLogger(__name__)

# === Загрузка конфигурации ===
try:
    with open("config.json", "r") as config_file:
        config = json.load(config_file)
        TOKEN = config.get("TOKEN", "")
        if not TOKEN:
            raise ValueError("Токен не найден в config.json")
except Exception as e:
    logger.error(f"Ошибка загрузки конфига: {e}")
    raise

# === Загрузка словаря ===
def load_words():
    try:
        path = os.path.join("assets", "sutta_words.txt")
        with open(path, "r", encoding="utf-8") as f:
            words = [line.strip() for line in f if line.strip()]
            logger.info(f"Загружено {len(words)} слов для автокомплита")
            return words
    except Exception as e:
        logger.error(f"Ошибка загрузки словаря: {e}")
        return []

WORDS = load_words()

# === Нормализация текста ===
def normalize(text: str) -> str:
    return (
        text.lower()
        .replace("ṁ", "m")
        .replace("ṃ", "m")
        .replace("ṭ", "t")
        .replace("ḍ", "d")
        .replace("ṇ", "n")
        .replace("ñ", "n")
        .replace("ā", "a")
        .replace("ī", "i")
        .replace("ū", "u")
    )

# === Автокомплит ===
def autocomplete(prefix: str, max_results: int = 10) -> list[str]:
    try:
        prefix_n = normalize(prefix)
        suggestions = [
            word for word in WORDS if normalize(word).startswith(prefix_n)
        ][:max_results]
        logger.debug(f"Автокомплит для '{prefix}': найдено {len(suggestions)} вариантов")
        return suggestions
    except Exception as e:
        logger.error(f"Ошибка автокомплита: {e}")
        return []

# === Обработчики команд ===
async def start(update: Update, context: CallbackContext):
    user = update.effective_user
    logger.info(f"Команда /start от {user.id} ({user.full_name})")
    await update.message.reply_text(
        "Добро пожаловать! Используйте:\n"
        "• @dhammagift_bot слово - подсказки в любом чате\n"
        "• /find - поиск сутт\n"
        "• /dict - поиск в словаре"
    )

async def find(update: Update, context: CallbackContext):
    query = " ".join(context.args) if context.args else ""
    logger.info(f"Поиск: {query} от {update.effective_user.id}")
    if not query:
        await update.message.reply_text("Пример: /find sn12.2 или /find метта")
        return
    url = f"https://dhamma.gift/ru/?q={query.replace(' ', '+')}"
    await update.message.reply_text(f"🔍 Поиск: {query}\n{url}")

async def dict_search(update: Update, context: CallbackContext):
    query = " ".join(context.args) if context.args else ""
    logger.info(f"Словарь: {query} от {update.effective_user.id}")
    if not query:
        await update.message.reply_text("Пример: /dict metta или /dict любовь")
        return
    url = f"https://dpdict.net/ru/search_html?q={query.replace(' ', '+')}"
    await update.message.reply_text(f"📚 Словарь: {query}\n{url}")

# === Инлайн-режим ===
async def inline_query(update: Update, context: CallbackContext):
    query = update.inline_query.query.strip()
    if not query or len(query) < 2:  # Игнорируем слишком короткие запросы
        return

    logger.info(f"Инлайн-запрос: '{query}' от {update.inline_query.from_user.id}")
    suggestions = autocomplete(query, max_results=8)

    results = []
    for word in suggestions:
        results.append(
            InlineQueryResultArticle(
                id=word,
                title=word,
                input_message_content=InputTextMessageContent(word),
                description=f"Нажмите, чтобы отправить '{word}'",
            )
        )

    await update.inline_query.answer(results, cache_time=10)

# === Обработка обычных сообщений ===
async def handle_message(update: Update, context: CallbackContext):
    text = update.message.text.strip()
    user = update.effective_user
    logger.info(f"Сообщение от {user.id}: {text}")

    if text.endswith("?"):  # Поиск в словаре
        await dict_search(update, context)
    else:  # Обычный поиск
        await find(update, context)

# === Запуск бота ===
def main():
    logger.info("Запуск бота...")
    try:
        app = Application.builder().token(TOKEN).build()

        # Команды
        app.add_handler(CommandHandler("start", start))
        app.add_handler(CommandHandler("find", find))
        app.add_handler(CommandHandler("dict", dict_search))

        # Инлайн-режим
        app.add_handler(InlineQueryHandler(inline_query))

        # Обычные сообщения
        app.add_handler(MessageHandler(filters.TEXT & ~filters.COMMAND, handle_message))

        logger.info("Бот запущен")
        app.run_polling()
    except Exception as e:
        logger.critical(f"Ошибка запуска: {e}")

if __name__ == "__main__":
    main()