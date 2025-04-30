# DostavkaEdi
## Это бэкэнд часть приложения, она выполнена на Laravel, с использованием, Docker, Nginx

## Первый запуск приложения
Для начала у вас долже быть установлен и запущен [Docker desktop](https://www.docker.com/products/docker-desktop/ "Официальный сайт")

Далее докачиваем все необходимое 

`` composer install ``

Далее билдим через докер

`` docker-compose build ``

И поднимаем контейнеры

`` docker-compose up -d ``

Выполняем миграции и заполняем базу данными

````
docker exec -it delivery_app php artisan migrate
docker exec -it delivery_app php db:seed
````

## Последующие запуски

Просто поднимайте контейнеры

`` docker-compose up -d ``
