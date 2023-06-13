Все запросы требуют токен авторизации в Headers

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

Query фильтр параметры:
- page - номер страницы пагинации
- count - количество позиций на странице
- direction_id - id направления стажировки
- title - часть названия вакансии

Ответ:
```
{
  "success": true,
  "data": [
    {
      "id": 4,
      "direction": {
        "direction_id": 2,
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
      "mentor_id": {
        "value": null,
        "list": [
          {
            "id": 1,
            "rating": null,
            "user": "Иванов Иван"
          }
        ]
      },
      "organization": "Тестовая организация",
      "income": 22222,
      "title": "test12",
      "reply": 0,
      "address": "г Москва, ул Поварская, д 52/55 стр 1",
      "geo_lat": 55.7582,
      "geo_lon": 37.58695,
      "description": "Описание Описание Описание Описание Описани Описание Описание Описание Описание Описание",
      "schedule": "20 часов в неделю",
      "status": 1,
      "is_publish": 1
    }
  ],
  "pagination": {
    "pages_count": 1,
    "vacancies_count": 1,
    "page_size": 2
  }
}
```