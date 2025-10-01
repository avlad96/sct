## Требования

- PHP >= 8.2
- MySQL >= 8.0
- Composer >= 2.x
- Meilisearch
- Docker & Docker Compose (для локальной разработки с Sail)

## API документация

В проекте подключена документация с использованием [Scribe](https://github.com/knuckleswtf/scribe). Доступна по адресу:

```
/api/v1/docs
```

## Локальная разработка (с Sail)

1. Клонировать репозиторий:

```
git clone https://github.com/avlad96/sct.git
```

2. Установить зависимости:

```
composer install
```

3. Создать `.env` файл и настроить параметры окружения:

```
cp .env.example .env
```

4. Запустить Sail и собрать контейнеры:

```
./vendor/bin/sail up -d
```

5. Сгенерировать ключ приложения:

```
./vendor/bin/sail artisan key:generate
```

6. Запустить миграции и сидер:

```
./vendor/bin/sail artisan migrate --seed
```

7. Синхронизировать настройки индексов Meilisearch для корректного полнотекстового поиска и поиска по локации:

```
./vendor/bin/sail artisan scout:sync-index-settings
```
