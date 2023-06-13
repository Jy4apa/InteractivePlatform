Все запросы требуют токен авторизации в Headers

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
## Редактирование вакансии
Адрес **/v1/cabinet/edit-vacancy/"id"**

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