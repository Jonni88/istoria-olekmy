# История Олёкмы

Цифровой музей и архив истории Олёкминского района. WordPress сайт с архивом событий, фотографий и газет.

## Возможности MVP 1.0

✅ **События** — архив исторических событий с датами, местами, описанием  
✅ **Фотоархив** — архивные фотографии с альбомами и темами  
✅ **Архив газет** — выпуски газет в PDF  
✅ **REST API** — для интеграции с программой обработки газет  

## Установка

### Требования
- WordPress 6.x
- PHP 8.0+
- MySQL 5.7+

### 1. Установка WordPress

```bash
# Скачать WordPress
wget https://wordpress.org/latest.tar.gz
tar -xzf latest.tar.gz
```

### 2. Установка темы

```bash
# Скопировать тему
cp -r wp-content/themes/istoria-olekmy /path/to/wordpress/wp-content/themes/

# Активировать тему в админке WordPress
# Внешний вид → Темы → История Олёкмы → Активировать
```

### 3. Установка плагина

```bash
# Скопировать плагин
cp -r wp-content/plugins/olekmy-core /path/to/wordpress/wp-content/plugins/

# Активировать плагин
# Плагины → История Олёкмы - Core → Активировать
```

### 4. Установка зависимостей

В админке WordPress установите плагины:
- **ACF (Advanced Custom Fields)** — для кастомных полей
- **Custom Post Type UI** — (опционально, для управления CPT)

### 5. Настройка

1. Создайте меню "Главное" в Внешний вид → Меню
2. Установите статическую главную страницу в Настройки → Чтение

## Импорт данных

### Импорт событий из CSV

Формат CSV:
```csv
external_id,event_date,title,description,place,issue_external_id,page_no,source_quote
EVENT001,1985-03-15,Открытие школы,В селе открылась новая школа,с. Хатассы,ISSUE001,5,В селе Хатассы состоялось торжественное открытие
```

Используйте плагин **WP All Import** для загрузки CSV.

### REST API Endpoints

```
GET /wp-json/olekmy/v1/events/this-day/{day}/{month}
# Получить события на конкретный день

GET /wp-json/olekmy/v1/photos/random
# Случайная фотография

GET /wp-json/olekmy/v1/issues/latest
# Последние выпуски газет
```

## Структура

```
wp-content/
├── plugins/
│   └── olekmy-core/          # Плагин с CPT и ACF
│       └── olekmy-core.php
└── themes/
    └── istoria-olekmy/       # Тема сайта
        ├── style.css
        ├── functions.php
        ├── header.php
        ├── footer.php
        ├── front-page.php
        └── single-event.php
```

## Custom Post Types

| Тип | Описание |
|-----|----------|
| `event` | Исторические события |
| `photo` | Архивные фотографии |
| `issue` | Выпуски газет |
| `place` | Места на карте |
| `exhibit` | Музейные экспонаты |

## Лицензия

MIT
