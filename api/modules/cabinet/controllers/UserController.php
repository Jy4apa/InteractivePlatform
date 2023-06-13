<?php

namespace api\modules\cabinet\controllers;

use api\controllers\BaseController;
use api\modules\cabinet\models\Essay;
use api\modules\cabinet\models\InternshipDirection;
use api\modules\cabinet\models\Specialization;
use api\modules\cabinet\models\UserProfile;
use api\modules\intern\models\Intern;
use api\modules\member\models\Vacancy;
use common\models\Candidate;
use common\models\Country;
use common\models\Education;
use common\models\Experience;
use common\models\search\VacancySearch;
use common\modules\user\models\ChangePasswordForm;
use Yii;
use yii\data\Pagination;
use yii\rest\OptionsAction;
use yii\web\Response;

class UserController extends BaseController
{

    public function init()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        parent::init();
    }
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'options' => [
                'class' => OptionsAction::class,
                'collectionOptions' => ['GET', 'POST', 'HEAD', 'OPTIONS'],
                'resourceOptions' => ['GET', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
            ]
        ];
    }

    public function actionGetInfo(): array
    {
        $user = Yii::$app->user->identity;
        $essay = Essay::find()->where(['user_id' => $user->id])->one();
        if ($essay)
            $checkEssay = true;
        else $checkEssay = false;

        $checkPhone = $user->userProfile->phone != null;
        $education = Education::find()->where(['user_id' => $user->id])->one();
        $experience = Experience::find()->where(['user_id' => $user->id])->one();
        if ($checkPhone && $education && $experience)
            $checkQuestionnaire = true;
        else $checkQuestionnaire = false;

        if ($user)
            return ['success' => true, 'data' => [
                'email' => $user->email,
                'role' => $user->userProfile->role,
                'scores' => $user->userProfile->scores,
                'firstname' => $user->userProfile->firstname,
                'lastname' => $user->userProfile->lastname,
                'essay' => $checkEssay,
                'questionnaire' => $checkQuestionnaire
            ]];
        else {
            Yii::$app->response->setStatusCode(421);
            return ['success' => false, 'error' => 'Не удалось идентифицировать пользователя'];
        }
    }

    public function actionCountries(): array
    {
        $countriesArray = Country::find()->select(['title', 'id'])->indexBy('id')->column();
        $countries = [];

        $locale = Yii::$app->user->identity ? Yii::$app->user->identity->userProfile->locale : 'ru-RU';
        foreach ($countriesArray as $key => $value)
            $countries[] = [
                'id' => $key,
                'name' => \Yii::t('countries', $value, null, $locale)
            ];

        return ['success' => true, 'data' => $countries];
    }

    public function actionSpecializations(): array
    {
        $specializations = Specialization::find()->all();
        return ['success' => true, 'data' => $specializations];
    }

    public function actionDirections(): array
    {
        $directions = InternshipDirection::find()->all();
        return ['success' => true, 'data' => $directions];
    }

    public function actionProfile(): array
    {
        $profile =  UserProfile::findOne(['user_id' => Yii::$app->user->identity->id]);
        return ['success' => true, 'data' => $profile];
    }

    public function actionUpdateProfile(): array
    {
        $user = Yii::$app->user->identity;
        $profile = UserProfile::findOne(['user_id' => $user->id]);
        $params = Yii::$app->request->post();
        $params['age'] = date('Y-m-d H:i:s', $params['age']);
        $experiences = null;
        $educations = null;
        if (Yii::$app->request->post('educations'))
        {
            $educations = Yii::$app->request->post('educations');
            unset($params['educations']);
        }
        if (Yii::$app->request->post('experiences'))
        {
            $experiences = Yii::$app->request->post('experiences');
            unset($params['experiences']);
        }
        try {
            if ($profile->load($params, '') && $profile->validate())
                $profile->save();
            else
            {
                $response = ['success' => false];
                Yii::$app->response->setStatusCode(422);
                $modelErrors = $profile->getErrors();
                foreach ($modelErrors as $fieldError => $errors)
                {
                    $response['error'] = $errors[0];
                    break;
                }
                return $response;
            }

            // Education
            if ($educations)
            {
                $countEducations = count($educations);
                $userEducations = Education::find()->where(['user_id' => $user->id])->all();
                $countUserEducations = $userEducations ? count($userEducations): 0;
                $i = 0;
//            if ($countUserEducations > $countEducations)
//            {
//                $count = $countUserEducations - $countEducations;
//                for ($j = 0; $j < $count; $j++)
//                    $userEducations[-1]->delete();
//            }
                for (; $i < $countEducations; $i++)
                {
                    $education = $i >= $countUserEducations ? new Education() : $userEducations[$i];
                    if ($education->load($educations[$i], '') && $education->validate())
                    {
                        $education->user_id = $user->id;
                        $education->save();
                    }
                    else
                    {
                        $response = ['success' => false];
                        Yii::$app->response->setStatusCode(422);
                        $modelErrors = $education->getErrors();
                        foreach ($modelErrors as $fieldError => $errors)
                        {
                            $response['error'] = $errors[0];
                            break;
                        }
                        return $response;
                    }
                }
            }

            // Experience
            if ($experiences)
            {
                $countExperiences = count($experiences);
                $userExperiences = Experience::find()->where(['user_id' => $user->id])->all();
                $countUserExperiences = $userExperiences ? count($userExperiences): 0;
                $j = 0;
//            if ($countUserExperiences > $countExperiences)
//            {
//                $count = $countUserExperiences - $countExperiences;
//                for ($j = 0; $j < $count; $j++)
//                    $userExperience[-1]->delete();
//            }
                for (; $j < $countExperiences; $j++)
                {
                    $experience = $j >= $countUserExperiences ? new Experience() : $userExperiences[$j];
                    if ($experience->load($experiences[$j], '') && $experience->validate())
                    {
                        $experience->user_id = $user->id;
                        $experience->save();
                    }
                    else
                    {
                        $response = ['success' => false];
                        Yii::$app->response->setStatusCode(422);
                        $modelErrors = $experience->getErrors();
                        foreach ($modelErrors as $fieldError => $errors)
                        {
                            $response['error'] = $errors[0];
                            break;
                        }
                        return $response;
                    }
                }
            }
            return ['success' => true];
        }
        catch (\Exception $exception)
        {
            Yii::$app->response->setStatusCode(500);
            return ['success' => false, 'error' => $exception->getMessage()];
        }
    }

    public function actionChangePassword(): array
    {
        $user = Yii::$app->user->identity;
        $response = ['success' => false];
        try {
            $model = new ChangePasswordForm();

            $model->setUser($user);
            $model->attributes = Yii::$app->request->post();

            if ($model->validate() && $model->save()) {
                return ['success' => true];
            }
            Yii::$app->response->setStatusCode(422);
            $modelErrors = $model->getErrors();
            foreach ($modelErrors as $fieldError => $errors)
            {
                $response['error'] = $errors[0];
                break;
            }

            return $response;
        }
        catch (\Exception $exception)
        {
            Yii::$app->response->setStatusCode(500);
            return ['success' => false, 'error' => $exception->getMessage()];
        }
    }

    public function actionEssay(): array
    {
        try {
            $user = Yii::$app->user->identity;
            $essays = $user->getEssay($user->id);
            if (Yii::$app->request->isPost)
            {
                if (count($essays) < 3)
                {
                    $essay = new Essay();
                    if ($essay->load(Yii::$app->request->post(), '') && $essay->validate())
                    {
                        $essay->user_id = $user->id;
                        $essay->save();
                        return ['success' => true];
                    }
                    else return ['success' => false, 'error' => 'Не удалось сохранить эссе'];
                }
                else return ['success' => false, 'error' => 'Может быть максимум 3 эссе'];
            }
            elseif (Yii::$app->request->isPut)
            {
                $essay = Essay::findOne(Yii::$app->request->post('id'));
                if ($essay)
                {
                    if ($essay->user_id === $user->id)
                    {
                        if ($essay->load(Yii::$app->request->post(), '') && $essay->validate())
                        {
                            $essay->save();
                            return ['success' => true];
                        }
                        else return ['success' => false, 'error' => 'Не удалось сохранить эссе'];
                    }
                    else
                    {
                        Yii::$app->response->setStatusCode(403);
                        return ['success' => false, 'У вас нет доступа к этому эссе'];
                    }
                }
                else return ['success' => false, 'error' => 'Нет эссе с таким идентификатором'];
            }
            else
            {
                if (isset(Yii::$app->request->queryParams['id']))
                {
                    $essay_id = Yii::$app->request->queryParams['id'];
                    $essay = Essay::findOne($essay_id);
                    if ($essay)
                    {
                        if ($essay->user_id === $user->id)
                            return ['success' => true, 'data' => $essay];
                        else
                        {
                            Yii::$app->response->setStatusCode(403);
                            return ['success' => false, 'У вас нет доступа к этому эссе'];
                        }
                    }
                    else return ['success' => false, 'error' => 'Нет эссе с таким идентификатором'];
                }
                else return ['success' => true, 'data' => $essays];
            }
        }
        catch (\Exception $exception)
        {
            Yii::$app->response->setStatusCode(500);
            return ['success' => false, 'error' => 'Server error'];
        }
    }

    public function actionDeleteEssay($id): array
    {
        try {
            if (Yii::$app->request->isDelete)
            {
                $user = Yii::$app->user->identity;
                $essay = Essay::findOne($id);
                if ($essay)
                {
                    if ($essay->user_id === $user->id)
                    {
                        $essay->delete();
                        return ['success' => true];
                    }
                    else
                    {
                        Yii::$app->response->setStatusCode(403);
                        return ['success' => false, 'У вас нет доступа к этому эссе'];
                    }
                }
                else return ['success' => false, 'error' => 'Нет эссе с таким идентификатором'];
            }
            else
            {
                Yii::$app->response->setStatusCode(400);
                return ['success' => false, 'error' => 'Неверный метод запроса'];
            }
        }
        catch (\Exception $exception)
        {
            Yii::$app->response->setStatusCode(500);
            return ['success' => false, 'error' => 'Server error'];
        }
    }

    public function actionAddEducation(): array
    {
        try {
            $user = Yii::$app->user->identity;
            $educations = Yii::$app->request->post('educations');
            $countEducations = count($educations);
            $userEducations = Education::find()->where(['user_id' => $user->id])->all();
            $countUserEducations = $userEducations ? count($userEducations): 0;
            $i = 0;
            if ($countUserEducations > $countEducations)
            {
                $count = $countUserEducations - $countEducations;
                for ($j = 0; $j < $count; $j++)
                    $userEducations[-1]->delete();
            }
            for (; $i < $countEducations; $i++)
            {
                $education = $i >= $countUserEducations ? new Education() : $userEducations[$i];
                if ($education->load($educations[$i], '') && $education->validate())
                    $education->save();
                else
                {
                    $response = ['success' => false];
                    Yii::$app->response->setStatusCode(422);
                    $modelErrors = $education->getErrors();
                    foreach ($modelErrors as $fieldError => $errors)
                    {
                        $response['error'] = $errors[0];
                        break;
                    }
                    return $response;
                }
            }
            return ['success' => true];
        }
        catch (\Exception $exception)
        {
            Yii::$app->response->setStatusCode(500);
            return ['success' => false, 'error' => 'Возникла внутрення ошибка сервера'];
        }
    }

    public function actionAddExperience(): array
    {
        try {
            $user = Yii::$app->user->identity;
            $experience = new Experience();
            $experience->user_id = $user->id;
            $experience->key_skills = [];
            $experience->load(Yii::$app->request->post(), '');
            if ($experience->validate() && $experience->save())
                return ['success' => true];
            else
            {
                $response = ['success' => false];
                Yii::$app->response->setStatusCode(422);
                $modelErrors = $experience->getErrors();
                foreach ($modelErrors as $fieldError => $errors)
                {
                    $response['error'] = $errors[0];
                    break;
                }
                return $response;
            }
        }
        catch (\Exception $exception)
        {
            Yii::$app->response->setStatusCode(500);
            return ['success' => false, 'error' => 'Возникла внутрення ошибка сервера'];
        }
    }

    public function actionListVacancy(): array
    {
        try {
            $user = Yii::$app->user->identity;
            $searchModel = new VacancySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $user->id);
            $count = (int)Yii::$app->request->get('count') ? (int)Yii::$app->request->get('count') : 10;
            $count = min($count, 100);
            $page = intval(Yii::$app->request->get('page')) > 1 ? intval(Yii::$app->request->get('page')) - 1 : 0;
            $pages = new Pagination([
                'totalCount' => $dataProvider->query->count(),
                'pageSize' => $count,
                'page' => $page
            ]);

            return [
                'success' => true,
                'data' => $dataProvider->query->offset($pages->offset)->limit($count)->all(),
                'pagination' => [
                    'pages_count' => $pages->pageCount,
                    'vacancies_count' => intval($pages->totalCount),
                    'page_size' => $count
                ],
            ];
        }
        catch (\Exception $exception)
        {
            Yii::$app->response->setStatusCode(500);
            return ['success' => false, 'Не удалось получить список вакансий'];
        }
    }

    public function actionNextStage(): array // TODO Тестовый кейс
    {
        $candidate = Candidate::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
        if ($candidate)
        {
            $candidate->order_status += 1;
            $candidate->save();

            $profile = Yii::$app->user->identity->userProfile;
            $profile->scores += rand(1, 100);
            if ($candidate->order_status == Candidate::ORDER_STATUS_CHAMPIONSHIP)
            {
                $profile->role = UserProfile::ROLE_INTERN;
                $intern = new Intern();
                $intern->user_id = $profile->user_id;
                $intern->save();
            }
            $profile->save();
            return ['success' => true];
        }
        return ['success' => false, 'error' => 'Что-то не получилось'];
    }
}