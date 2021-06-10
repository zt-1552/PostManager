<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\Manager;
use app\models\SendEmail;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ManagerController extends Controller
{

    public $layout = 'managerLayout.php';

    private $_transaction;

    /**
     * Lists all Post models.
     * @return mixed
     */

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'view' => '@app/views/manager/error.php'
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == 'error') {
            $this->layout = 'errorLayout.php';
        }
        return parent::beforeAction($action);
    }


    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }


    public function actionIndex()
    {
        $model = new Manager();


        $model->load(Yii::$app->request->post());


        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($model->validate()) {
                //добавление начато
                $post_model = Yii::$app->request->post('Manager');

                $model->contact_name = $post_model['contact_name'];
                $model->company_email = $post_model['company_email'];

                $model->position_description = $post_model['position_description'];
                $model->salary = $post_model['salary'];
                $model->dateStart = $post_model['dateStart'];
                $model->dateEnd = $post_model['dateEnd'];

                $model->datePostAt = $post_model['datePostAt'];
                //добавление оконченно
                $this->_transaction = Yii::$app->db->beginTransaction();
                    $model->save();
                    $exception = Yii::$app->errorHandler->exception;
                    if ($exception !== null) {
                        $this->_transaction->rollBack();
                    } else {
                        $this->_transaction->commit();
                        Yii::$app->session->setFlash('success', 'Данные успешно отправлены через Ajax и сохранены');
                        }
                if ($model->datePostAt === date('d.m.Y')) {
                    Yii::$app->queue->push(new SendEmail([
                        'post_id' => $model->id,
                    ]));
//                    $res = $model->sendMail($model->id);// Можно включить эту часть кода (строки 105-107 нужно закоментить), сообщения будут отправляться сразу, но тогда
//                    if ($res) {                         // будет немного тормозить страница с формой после нажатия кнопки "Отправить"
//
//                        Yii::$app->session->setFlash('success', 'Данные успешно сохранены и отправлены на почту');
//                    } else {
//                        Yii::$app->session->setFlash('danger', 'Данные сохранены, но не отправлены на почту');
//                      }
                } else {
                    $delaySend = strtotime($model->datePostAt) - strtotime('now');
                    Yii::$app->queue->delay($delaySend)->push(new SendEmail([
                        'post_id' => $model->id,
                    ]));

                }

                $model = new Manager();
            } else {
                Yii::$app->session->setFlash('danger', 'Данные не отправлены');
                var_dump($model->getErrors());
                return ActiveForm::validate($model);
            }

        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }


    public function actionValidation(){
        $model = new Manager();

        if(Yii::$app->request->isAjax && $model->load(Yii::$app->
            request->post())){
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


}


