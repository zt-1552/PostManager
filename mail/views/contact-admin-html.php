<?php

/** @var $this \yii\web\View */
/** @var $link string */

?>
    <h1>Сообщение о сбое в очереди Queue</h1>


       <h3>Это объект $Event->job, при отправке которого возникла ошибка": <?= print_r($event->job, 1) ?></h3>
