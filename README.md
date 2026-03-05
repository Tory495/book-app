<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Book App Yii 2</h1>
    <br>
</p>

Устанавливаем зависимости:
```bash
composer install
```
Запускаем изолированное окружение докера:
```bash
docker compose up -d --build
```
Меняем креды для бд:
```bash
nano common/config/main-local.php
```
Забуриваемся в один из докер-контейнеров (например в backend):
```bash
docker exec -it book-app-backend-1 bash
```
Инициализируем приложение (пока в режиме development):
```bash
php init
```
Запускаем миграции:
```bash
php yii migrate
```
Rbac:
```bash
php yii migrate --migrationPath=@yii/rbac/migrations
```
```bash
php yii rbac/init
```
Rbac ручная передача прав:
```bash
php yii rbac/assign *USER_ID*
```