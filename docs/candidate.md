Все запросы требуют токен авторизации в Headers

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