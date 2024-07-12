## Описание API  

### 1. Создание пользователя  
1.1) Метод запроса: POST  
1.2) URL: /api/users/create  
1.3) Требуемые поля запроса: "login", "email", "password"  
1.4) Опциональные поля запроса:  "first_name", "last_name"  


### 2. Редактирование пользователя  
2.1) Метод запроса: PATCH  
2.2) URL: /api/users/{user_id}/change  
2.3) Требуемые поля запроса: отсутствуют  
2.4) Опциональные поля запроса: "first_name", "last_name"  


### 3. Удаление пользователя  
3.1) Метод запроса: DELETE  
3.2) URL: /api/users/{user_id}/delete  
3.3) Требуемые поля запроса: отсутствуют  
3.4) Опциональные поля запроса: отсутствуют  
 

### 4. Получение пользователя  
4.1) Метод запроса: GET  
4.2) URL: /api/users/{user_id}/info  
4.3) Параметры запроса: отсутствуют  


### 5. Получение токена доступа  
5.1) Метод запроса: POST  
5.2) URL: /api/login  
5.3) Требуемые поля запроса: "login", "password"  
5.4) Опциональные поля запроса: отсутствуют


## Предварительная конфигурация  

1) composer install
2) php bin/console doctrine:database:create --env=test
3) php bin/console doctrine:database:create  
4) php bin/console doctrine:migrations:migrate --env=test
5) php bin/console doctrine:migrations:migrate
6) php bin/console doctrine:fixtures:load --env=test
7) php bin/console doctrine:fixtures:load  
8) php bin/console lexik:jwt:generate-keypair


После выполнения перечисленных действия будут сгенерированы ключи шифрования токенов и будут созданы данные для основной и тестовой базы данных.  

## Аутентификационные данные  
1) Логин: "first_user"
2) Пароль: "111222555"
