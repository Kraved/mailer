<b>Mailer</b>

Приложение для рассылок почтовых сообщений.
Простой спамер сообщений, с возможностью импорта списка почтовых адресов из txt файла, либо с сайта(парсер).


Проект разработан на фреймворке Laravel 6.17

Установка:
1. Клонировать проект с https://github.com/Kraved/mailer.git
2. Установить зависимости composer(composer install)
3. Установить зависимости NPM(npm install)
4. Создать пустую базу для приложения
5. Сгенерировать ключ приложения(php artisan key:generate)
6. Переименовать .env.example в .env, и заполнить его необходимыми данными(Раздел БД, раздел почта, основной раздел)
7. Выполнить миграцию (php artisan migrate --seed). 
8. Создать временную директорию и назначить на нее права (mkdir -p storage/app/public/tmp && sudo chown -R www-data:www-data storage/app/public) 
9. Добавить символьную ссылку на публичный диск (php artisan storage:link)
10. [Опционально] Установить, и настроить Supervisor для работы с очередями БД.

База заполнится тестовыми данными(список почтовых адресов), а так же пользователем admin с паролем admin.
Готово.

