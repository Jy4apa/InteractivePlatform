![Alt text](public/logo.png?raw=true "talent-mos-logo")
# Dev+
[https://github.com/Jy4apa/Platform](https://github.com/Jy4apa/Platform)

### Backend

- Production (branch: master) [https://api-devplus.ru/backend](https://api-devplus.ru/backend)


## Локальное развертывание через Docker

1. В корне проекта создать файл .env и скопировать в него содержимое из файла .env.example
2. Добавить на своём компьютере в файл hosts следующие поддомены (для Linux запустить команду из терминала "sudo nano /etc/hosts")
```
127.0.0.1       backend.platform.local
127.0.0.1       api.platform.local
127.0.0.1       storage.platform.local
```
3. Запустить сборку проекта
```
docker-compose up --build
```
Дальнейшие действия производить в контейнере с проектом
```
docker exec -it <имя контейнера> bash
```
4. Установить зависимости в корне приложения
```
composer install --prefer-dist --ignore-platform-reqs -o
```
5. Все миграции выполняются из папки app/console
```
cd console
php yii migrate
php yii rbac-migrate
```

## Настройка локальной базы данных
1. При необходимости развертывания дампа базы данных, необходимо положить сам дамп в папку storage/temp
   После этого распаковать дамп в контейнере с базой данных
```
docker exec -it <имя контейнера базы данных> bash
mysql -u "platform" -p "platform" <"temp/dump/dump.sql"
```
2. При возникновении ошибки развертывания поменяйте в дампе utf8mb4_0900_ai_ci на utf8mb4_general_ci
3. Если не работают отчеты в админке, то установите в контейнере с базой другой sql_mode под правами root
```
# Включаем синтаксис MYSQL под правами root
mysql -u "root" -p "platform"
# В консоли MYSQL вводим команду
SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
```

