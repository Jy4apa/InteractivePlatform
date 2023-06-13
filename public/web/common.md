Вход в административную панель по ссылке: https://api-devplus.ru/backend
Учетные записи для входа:

Суперадмин
login: webmaster
password: webmaster

Менеджер
login: manager
password: manager

Все backend запросы. По полочкам разложены в папке корневой директории docs/
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
## Кабинет
Адрес **/v1/cabinet/get-info**

GET запрос

Ответ:
```
{
  "success": true,
  "data": {
    "email": "xjyx20210@mail.ru",
    "role": 0,
    "scores": 0
  }
}
```
## Страны
Адрес **/v1/cabinet/countries**

GET запрос

Ответ:
```
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Андорра"
    },
    {
      "id": 2,
      "name": "Объединенные Арабские Эмираты"
    },
    {
      "id": 3,
      "name": "Афганистан"
    },
    ...
  ]
}
```
## Специализации
Адрес **/v1/cabinet/specializations**

GET запрос

Ответ:
```
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "HR, управление персоналом"
    },
    {
      "id": 2,
      "title": "PR, пресс-служба"
    },
    {
      "id": 3,
      "title": "Администрирование, координация деятельности"
    },
    ...
  ]
}
```
## Профиль
Адрес **/v1/cabinet/profile**

GET запрос

Ответ:
```
{
  "success": true,
  "data": {
    "firstname": "niCk",
    "middlename": null,
    "lastname": "Ярков",
    "gender": null,
    "phone": null,
    "age": "863786700000",
    "city": null,
    "full_address": null,
    "country_id": {
      "value": 192,
      "list": [
        {
          "id": 1,
          "name": "Андорра"
        },
        {
          "id": 2,
          "name": "Объединенные Арабские Эмираты"
        },
        {
          "id": 3,
          "name": "Афганистан"
        },
        ...
      ]
    },
    "education": [
      {
        "level": 1,
        "name": "ВятГУ",
        "address": "г. Киров, ул. Володарского 154",
        "city": "Киров",
        "speciality": "Программист",
        "date_start": 2020,
        "date_end": 2024
      }
    ],
    "experience": [
      {
        "income": 100000,
        "name": "Россельхоз",
        "post": "Курьер",
        "date_start": 2020,
        "date_end": 2025,
        "responsibilities": "Доставка еды",
        "key_skills": [
          1,
          2,
          3,
          4
        ]
      },
      ...
    ],
    "scores": 82
  }
}
```
## Редактирование профиля
Адрес **/v1/cabinet/update-profile**

POST запрос

Пример json запрос:
```
{
  "phone": "+7999999999"
}
```
В теле запроса можно посылать любое количество полей, но только из того списка, который можно получить из get запроса **/api/cabinet/profile**:

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
## Обновление пароля
Адрес **/v1/cabinet/change-password**

POST запрос

Пример json запроса:
```
{
  "password": 123456,
  "password_confirm": 123456
}
```

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
  "error": "Undefined index: password"
}
```
## Получить эссе
Адрес **/v1/cabinet/essay?id="id"**

GET запрос

Параметры:
- id - query параметр, передающийся в адресной строке. Пример **/v1/cabinet/essay?id=2**

Ответ:
```
{
  "success": true,
  "data": {
    "id": 2,
    "topic": "Test",
    "text": "test text"
  }
}
```
Ответ с ошибкой:
```
{
  "success": false,
  "error": "Нет эссе с таким идентификатором"
}
```
## Список эссе пользователя
Адрес **/v1/cabinet/essay**

GET запрос

Ответ:
```
{
  "success": true,
  "data": [
    {
      "id": 2,
      "topic": "Test",
      "text": "test text"
    },
    {
      "id": 3,
      "topic": "Test2",
      "text": "qwerty"
    }
  ]
}
```
## Создать эссе
Адрес **/v1/cabinet/essay**

POST запрос

Параметры:
- topic - тема эссе
- text - текст эссе

Пример запроса:
```
{
  "topic": "Test2",
  "text": "qwerty"
}
```

Ответ:
```
{
  "success": true
}
```
## Редактировать эссе
Адрес **/v1/cabinet/essay**

PUT запрос

Параметры:
- topic - тема эссе
- text - текст эссе

Пример запроса:
```
{
  "id": 2,
  "topic": "Test2",
  "text": "qwerty"
}
```

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
  "error": "Нет эссе с таким идентификатором"
}
```
## Удалить эссе
Адрес **/v1/cabinet/delete-essay/"id"**

DELETE запрос

Параметр "id" сообщает об id эссе

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
  "error": "Нет эссе с таким идентификатором"
}
```
## Добавить образование
Адрес **/v1/cabinet/add-education**

POST запрос

Параметры:
- level - уровень образования
- name - название заведения
- address - адрес
- city - город
- speciality - специальность
- date_start - год начала обучения
- date_end - год окончания обучения

Ответ:
```
{
  "success": true
}
```
## Добавить опыт работы
Адрес **/v1/cabinet/add-experience**

POST запрос

Параметры:
- income - зароботная плата
- name - название организации
- post - должность
- responsibilities - Обязанности
- key_skills - ключевые навыки (отправлять массивом)
- date_start - год начала обучения
- date_end - год окончания обучения

Ответ:
```
{
  "success": true
}
```
## Список вакансий
Адрес **/v1/cabinet/list-vacancy**

GET запрос

Ответ:
```
{
  "success": true,
  "data": [
    {
      "id": 1,
      "direction": {
        "direction_id": null,
        "list": {
          "1": "IT-город",
          "2": "Медийный город",
          "3": "Социальный город",
          "4": "Комфортная городская среда",
          "5": "Правовое пространство",
          "6": "Городская экономика",
          "7": "HR-город"
        }
      },
      "intern_id": null,
      "mentor_id": 5,
      "organization": "Департамент тестов",
      "income": 100000,
      "title": "test",
      "address": null,
      "geo_lat": 123.2342,
      "geo_lon": 1646584,
      "description": null,
      "schedule": null,
      "status": 1
    }
  ]
}
```
## Список направлений для стажировки
Адрес **/v1/cabinet/directions**

GET запрос

Ответ:
```
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "IT-город"
    },
    {
      "id": 2,
      "title": "Медийный город"
    },
    {
      "id": 3,
      "title": "Социальный город"
    },
    ...
  ]
}
```
## Получить информацию о кандидате
Адрес **/v1/cabinet/get-candidate**

GET запрос

Ответ:
```
{
  "success": true,
  "data": {
    "id": 1,
    "order_status": 0,
    "testing_status": "Не пройдено",
    "order": {
      "id": 1,
      "status": "В обработке",
      "direction": "Медийный город"
    }
  }
}
```
## Подача заявки кандидата
Адрес **v1/cabinet/create-candidate-order**

POST запрос

Параметры:
- direction - id направления, по которому хотел бы стажироваться кандидат (необязательное поле)

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
  "error": "Прием заявок завершен"
}
```
## Изменение направления стажировки
Адрес **/v1/cabinet/update-direction/"id"**

POST запрос

QUERY параметры:
- id - id заявки

POST параметры:
- direction - id направления стажировки

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
  "error": "Произошла ошибка, попробуйте ещё раз"
}
```
## Получение вакансии
Адрес **v1/cabinet/get-vacancy/"id"**

GET запрос

Параметры:
- id - идентификатор вакансии организации

Ответ:
```
{
  "success": true,
  "data": {
    "id": 2,
    "direction": {
      "direction_id": null,
      "list": {
        "1": "IT-город",
        "2": "Медийный город",
        "3": "Социальный город",
        "4": "Комфортная городская среда",
        "5": "Правовое пространство",
        "6": "Городская экономика",
        "7": "HR-город"
      }
    },
    "intern_id": null,
    "mentor_id": 5,
    "organization": "Департамент тестов",
    "income": 150000,
    "title": "test",
    "address": "Kirov",
    "geo_lat": 42.468465646,
    "geo_lon": 42.468465646,
    "description": null,
    "schedule": null,
    "status": 0,
    "is_publish": 0
  }
}
```
## Создание вакансии
Адрес **v1/cabinet/create-vacancy**

POST запрос

Параметры:
- direction_id - id направления
- mentor_id - id наставника
- income - стоимость
- title - название
- geo_lat - координата lat
- geo_lon - координата lon
- description - описание
- schedule - график работы

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
  "error": "Вам не разрешено выполнять данное действие"
}
```
## Редактирование вакансии
Адрес **/v1/cabinet/update-vacancy/"id"**

POST запрос

QUERY Параметры:
- id - id вакансии

POST Параметры:
- direction_id - id направления
- mentor_id - id наставника
- income - стоимость
- title - название
- geo_lat - координата lat
- geo_lon - координата lon
- description - описание
- schedule - график работы

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
  "error": "Вам не разрешено выполнять данное действие"
}
```
## Список вакансий организации
Адрес **/v1/cabinet/organization/list-vacancy**

GET запрос

Ответ:
```
{
  "success": true,
  "data": [
    {
      "id": 2,
      "direction": {
        "direction_id": null,
        "list": {
          "1": "IT-город",
          "2": "Медийный город",
          "3": "Социальный город",
          "4": "Комфортная городская среда",
          "5": "Правовое пространство",
          "6": "Городская экономика",
          "7": "HR-город"
        }
      },
      "intern_id": null,
      "mentor_id": 5,
      "organization": "Департамент тестов",
      "income": 150000,
      "title": "test",
      "address": "Kirov",
      "geo_lat": 42.468465646,
      "geo_lon": 42.468465646,
      "description": null,
      "schedule": null,
      "status": 0,
      "is_publish": 0
    }
  ]
}
```
## Подтвердить вакансию и опубликовать
Адрес **/v1/cabinet/approve-vacancy/"id"**

POST запрос

Параметры:
- id - идентификатор вакансии

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
  "error": "Вам не разрешено выполнять данное действие"
}
```
## Отклонить вакансию
Адрес **/v1/cabinet/cancel-vacancy/"id"**

POST запрос

Параметры:
- id - идентификатор вакансии

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
  "error": "Вам не разрешено выполнять данное действие"
}
```
## Список всех заявок кандидатов
Адрес **/v1/cabinet/list-candidate**

GET запрос

Ответ:
```
{
  "success": true,
  "data": [
    {
      "candidate_id": 1,
      "firstname": "Никита",
      "lastname": "Ярков",
      "email": "xjyx105@mail.ru",
      "order_status": 0,
      "testing_status": "Не пройдено",
      "order": {
        "id": 1,
        "status": "Отменено",
        "direction": null
      },
      "scores": 0,
      "is_recommended": 0
    }
  ]
}
```