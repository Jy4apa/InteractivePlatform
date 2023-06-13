<?php

namespace console\controllers;

use common\models\Candidate;
use common\models\CandidateOrder;
use common\models\Education;
use common\models\Essay;
use common\models\Experience;
use common\models\InternshipDirection;
use common\models\Specialization;
use common\models\User;
use common\models\UserProfile;
use GuzzleHttp\Client;
use Yii;
use yii\console\Controller;
use yii\helpers\Json;

class TestController extends Controller
{
    public function init()
    {
        parent::init();
    }

    public function actionCheckTest()
    {
        $a = Experience::findOne(5);
        var_dump($a->attributes);
    }

    public function actionUsers($countUsers)
    {
        $testUser = User::find()->where(['like', 'username', 'test'])->orderBy('id DESC')->one();
        if ($testUser == null)
            $testName = 'test0';
        else $testName = $testUser->username;
        $testNumber = (int)mb_substr($testName, 4);

        $client = new Client(['base_uri' => 'http://nginx']); // если проект развернут в докере

        // Генерируем $countUsers пользователей
        for ($j = 0; $j < $countUsers; $j++) {
            $testNumber += 1;

            $testData = [
                'username' => 'test' . $testNumber,
                'email' => 'test' . $testNumber . '@go.cs',
                'password' => '1234qwer',
                'password_confirm' => '1234qwer',
                'agreement_accepted' => 1,
            ];

            $user = new User();
            $user->attributes = $testData;
            $user->setPassword('1234qwer');
            $user->save();
            $user->status = User::STATUS_ACTIVE;

            $user->save();

            $cities = ['Киров', 'Москва', 'Санкт-Петербург', 'Ижевск', 'Пермь', 'Казань', 'Нижний Новгород'];
            $lastnames = ['Петров', 'Иванов', 'Сидоров', 'Медведев', 'Юркин', 'Пупкин', 'Пушилов', 'Земцов', 'Веснецкий'];
            $firstnames = ['Иван', 'Даниил', 'Артем', 'Илья', 'Кирилл', 'Максим', 'Александр', 'Андрей', 'Олег'];
            $profileData = [
                'city' => $cities[array_rand($cities)],
                'lastname' => $lastnames[array_rand($lastnames)],
                'firstname' => $firstnames[array_rand($firstnames)],
                'age' => date('Y-m-d H:i:s', rand(94694400, 1199145600)),
                'country_id' => 192,
                'phone' => '+79' . rand(000000000, 999999999),
                'scores' => rand(0, 1000)
            ];

            $user->afterSignup($profileData);

            $data = [
                'identity' => $user->email,
                'password' => '1234qwer'
            ];
            $response = $client->request(
                'POST',
                '/api/v1/login',
                [
                    \GuzzleHttp\RequestOptions::JSON => $data
                ]
            );
            $token = Json::decode($response->getBody()->getContents())['token'];

            $essay = new Essay();
            $essay->user_id = $user->id;
            $essay->topic = 'Topic';
            $essay->text = 'text';
            $essay->save();

            $educationNames = ['ВятГУ', 'МГУ', 'СпбГУ', 'Колледж'];
            $educationSpeciality = ['Программист', 'Финансист', 'Историк', 'Краевед'];
            $education = new Education();
            $education->user_id = $user->id;
            $education->level = rand(0, 8);
            $education->name = $educationNames[array_rand($educationNames)];
            $education->address = $user->userProfile->city;
            $education->city = $user->userProfile->city;
            $education->speciality = $educationSpeciality[array_rand($educationSpeciality)];
            $dateStart = rand(1991, 2023);
            $education->date_start = $dateStart;
            $education->date_end = $dateStart + 4;
            $education->save();

            $organizationNames = ['Организация тестов', 'Департамет отладки', 'Министерство разработчиков'];
            $posts = ['Разработчик', 'Хакер', 'Тестировщик', 'Аналитик', 'Чей-то родственник'];
            $keySkills = [];
            for ($i = 0; $i < 10; $i++)
            {
                $number = rand(1, 15);
                if (!in_array($number, $keySkills))
                    $keySkills[] = $number;
            }
            $experience = new Experience();
            $experience->user_id = $user->id;
            $experience->income = rand(10000, 200000);
            $experience->date_start = time() * 1000;
            $experience->date_end = time() * 1000;
            $experience->name = $organizationNames[array_rand($organizationNames)];
            $experience->post = $posts[array_rand($posts)];
            $experience->responsibilities = 'Тест';
            $experience->key_skills = $keySkills;
            $experience->save();

            $headers = [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/x-www-form-urlencoded'
            ];
            $params = [
                'direction' => rand(1, 7)
            ];
            $result = $client->request(
                'POST',
                '/api/v1/cabinet/create-candidate-order',
                [
                    'headers' => $headers,
                    \GuzzleHttp\RequestOptions::FORM_PARAMS => [
                        'direction' => $params
                    ]
                ],
            );
        }
    }
}
