# Rest API
Для запуска проекта неоходимо:
- Настроить файл `.env`, для подключения к БД, для отправки почты. Путь к сохраненным картинкам
```sh
API_FULL_PATH=
```
- Установить пакеты
```sh
$ compser install
```
- Создать хранилие для изображений
```sh
$ php artisan storage:link
```
- Создать таблицы в БД
```sh
$ php artisan migrate
```