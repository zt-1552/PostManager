<?php

/** @var $this \yii\web\View */
/** @var $link string */

?>
    <h1>Задание для размещения в соцсетях</h1>


        <h3>ID поста: <?= $sender->id ?></h3>
        <h3>Название компании: <?= $sender->company_name ?></h3>
        <h3>Должность: <?= $sender->position ?></h3>
            <?php if(isset($sender->descriptivePost))  {?>

                <h3>Описание должности: <?= $sender->descriptivePost->position_description ?></h3>
                <h3>Зарплата: <?= $sender->descriptivePost->salary ?></h3>
                <h3>Дата старта: <?= $sender->descriptivePost->dateStart ?></h3>
                <h3>Дата окончания: <?= $sender->descriptivePost->dateEnd ?></h3>

            <?php } ?>

            <?php if(isset($sender->contactPost))  {?>
<!--                <p> --><?//= $sender->contactPost->contact_name ?><!-- объект <p>-->
<!--                --><?//= $sender->contactPost['contact_name'] ?><!--  аррай <p>-->
<!--                --><?//= $sender->contactPost->attributes['contact_name'] ?><!--  атрибютес аррай'-->

                    <h3>Контактное имя: <?= $sender->contactPost->contact_name ?></h3>
                    <h3>Контактный Email: <?= $sender->contactPost->company_email ?></h3>
            <?php } ?>

        <?php foreach ($sender->postsQueues as $queue): ?>
            <h3>дата отправки: <?= $queue->datePostAt ?></h3>
        <?php   endforeach; ?>