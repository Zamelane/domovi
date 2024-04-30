# Domovi (backend part)

## Установка для разработки (OSPanel)

Необходимо:
* Установить [git](https://git-scm.com/download/win)
* В настойках OSPanel во вкладке "Модули" установить PHP 8.1 или выше и MySQL 5.7 или выше
* В настойках OSPanel во вкладке "Сервер" установить "Свой Path + Win Path" для видимости команды `git`

Откройте консоль OSPanel и введите следующие команды (по очереди):
```bat
cd domains
git clone https://github.com/zamelane/domovi domovi.ru
cd domovi.ru
composer update & composer i
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
```
После можно перезапускать OSPanel для видимости нового домена.

Для доступа к веб-сайту просто через домен в корне проекта необходимо создать файл с названием `.htaccess` и заполнить следующим содержимым:
```apacheconf
RewriteEngine on
RewriteRule (.*)? /public/$1
```

## Обновление

```bat
git pull
composer update & composer i
php artisan migrate:fresh --seed
```

## Подсказки классов при разработке

1. Установите помощника (уже установлен, поэтому можно пропустить):

```bat
composer require --dev barryvdh/laravel-ide-helper
```

2. Сгенерируйте подсказки для моделей:

```bat
php artisan ide-helper:models
php artisan ide-helper:models --reset
```

3. Сгенерируйте подсказки кода для методов фасадов:

```bat
php artisan ide-helper:generate
```

4. Сгенерируйте подсказки по коду для классов-контейнеров:

```bat
php artisan ide-helper:meta
```
