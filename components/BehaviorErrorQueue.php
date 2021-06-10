<?php


namespace app\components;


use app\models\Manager;
use yii\base\Behavior;
use yii\queue\Queue;


class BehaviorErrorQueue extends Behavior
{

    public function events()
    {
        return [
            Queue::EVENT_AFTER_ERROR => 'afterErrorSend',
        ];
    }


    public function afterErrorSend($event) {

        return \Yii::$app->mailer->compose(
            'views/contact-admin-html', ['event' => $event])->setTo([\Yii::$app->params['managerEmail'] => 'Менеджеру-админу'])
            ->setSubject('Сообщение о событии в очереди EVENT_AFTER_EXEC')
            ->send();
    }
}