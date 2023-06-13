## Регистрация
Адрес **/v1/signup**

POST запрос

Пример json запроса:

```
{
  "username": "tester",
  "email": "test@gmail.com",
  "password": "123qwe",
  "password_confirm": "123qwe"
}
```

Ответ:

```
{
  "success": true
}
```

Ответ с ошибкой полей:

```
{
  "success": false,
  "field_errors": {
    "email": "This email address has already been taken."
  }
}
```

Ответ с ошибкой:

```
{
  "success": false,
  "error": "Error message"
}
```
## Авторизация
Адрес **/v1/login**

POST запрос

Пример json запроса:

Поле "identity" может быть логином, либо эмейлом
Поле "rememberMe" принимает true/false. Если true, то токен живет месяц иначе 1 час. По умолчанию, если поле не посылается, то "rememberMe" = false.
```
{
  "identity": "test",
  "password": "123qwe"
  "rememberMe": true
}
```
```
{
  "identity": "test@gmail.com",
  "password": "123qwe"
}
```

Ответ:

```
{
  "success": true,
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6IkhHb1RyVkt3a2lKc2VcL1UrZzFkNUtPSlBRMyt3dFVkRGNMQkswVFVnXC9SMD0ifQ.eyJpc3MiOiJodHRwOlwvXC9lcGljbG90dG8ubG9jYWwiLCJhdWQiOiJodHRwOlwvXC9lcGljbG90dG8ubG9jYWwiLCJqdGkiOiJIR29UclZLd2tpSnNlXC9VK2cxZDVLT0pQUTMrd3RVZERjTEJLMFRVZ1wvUjA9IiwiaWF0IjoxNjQ2MzY3MTYzLCJleHAiOjE2NDYzNzA3NjMsInVpZCI6eyJ1c2VybmFtZSI6Ikp5NGExIiwiZXhwaXJlcyI6MTY0NjM3MDc2M319.2HgKi3sT-twtRIlfFPrxBkss-PJR7iqj0-ArUcAeeEg"
}
```

Ответ с ошибкой полей:

```
{
  "success": false,
  "field_errors": {
    "password": "Incorrect username or password."
  }
}
```

Ответ с ошибкой:

```
{
  "success": false,
  "error": "Error message"
}
```
## Выход из системы
Адрес **/v1/logout**

POST запрос

Ответ:
```
{
  "success": true
}
```
Ответ с ошибкой:
```
{
  "success": false,
  "error": "Error message"
}
```