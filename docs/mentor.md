Все запросы требуют токен авторизации в Headers

## Информация о наставнике
Адрес **/v1/cabinet/get-mentor**

GET запрос

Ответ:
```
{
  "success": true,
  "data": {
    "id": 2,
    "rating": 0,
    "user": "Ярков Никита",
    "organization": {
      "id": 1,
      "title": "Тестовая организация",
      "description": "Описание ацушщарушкопршыукршпоукшп",
      "logo": "",
      "address": "щушкоапщзшкопзщышукопщзушкопщзушкопщзукшоп",
      "location": "58.606952, 49.682148"
    }
  }
}
```
## Список откликов на вакансию
Адрес **/v1/cabinet/list-replies**

GET запрос

Ответ:
```
{
  "success": true,
  "data": [
    {
      "id": 1,
      "status": 0,
      "user": {
        "name": "Журавлев Игорь",
        "info": {
          "user_id": 9,
          "firstname": "Игорь",
          "middlename": "Александрович",
          "position": null,
          "lastname": "Журавлев",
          "age": "1997-05-13 23:09:00",
          "city": "Киров",
          "full_address": "г Киров, ул Володарского, д 12",
          "avatar": "/storage/source/user/default_avatar.png",
          "locale": "ru-RU",
          "gender": 1,
          "phone": "+79532312312",
          "country_id": 192,
          "role": 1,
          "scores": 124
        }
      }
    }
  ]
}
```