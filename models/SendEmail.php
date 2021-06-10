<?php


namespace app\models;

use yii\base\BaseObject;
use yii\queue\JobInterface;


class SendEmail extends BaseObject implements JobInterface
{

    public $post_id;

    public function execute($queue)
    {
        $sendEmail = new Manager();
        $sendEmail->sendMail($this->post_id);
    }

}