<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\jui\DatePicker;
use app\inc\MyFunction;

$this->title = 'Страница с формой';
?>
    <div class="site-index container">

        <div class="body-content row">

            <div class="col-md-12">

                <?php
                $dataNow = date("d.m.Y H:i:s");
                echo '<h1> Текущая дата: '.$dataNow.'</h1>';
//                echo '<h3> Через 3 месяца: ' . date("d.m.Y", strtotime($dataNow ."+3 Month")) . '</h3></br>';
//                echo '<h3> Через 3 месяца: ' . date("d.m.Y", strtotime(date("d.m.Y") ."+3 Month")) . '</h3></br>';
                ?>



                <?php Pjax::begin()?>


                <?php  $form = ActiveForm::begin([
                    'id' => 'FormOrderID',
                    'enableClientValidation' => true,
                    'enableAjaxValidation' => true,
                    'validationUrl' => Url::toRoute('manager/validation'),
                    'options' => [
                        'class' => 'form-horizontal',
                        'data-pjax' => true,
                    ],
                    'fieldConfig' => [
                        'template' => "{label} \n <div class='col-md-5'> {input} </div> \n <div class='col-md-5'>{hint} </div> \n <div class='col-md-5'> {error} </div>",
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    ]
                ]); ?>

                <?php
                $this->registerJs('$("#manager-type_form").on({
                        "change": function () {
                            var type_form = $(this);
                            var first = $(".form-field-first");
                            var second = $(".form-field-second");
                            var third = $(".form-field-third");

                            if ((type_form.val()) === "contact") {
                                first.show();
                                second.show();
                                if(third.is(":visible")) {
                                    third.hide();
                                }
                            }
                            if ((type_form.val()) === "descriptive") {
                                first.show();
                                third.show();
                                if(second.is(":visible")) {
                                    second.hide();
                                }
                            }
                        }
                    });', yii\web\View::POS_READY);
                ?>

                <?= $form->field($model, 'type_form')->dropDownList(['contact' => 'contact', 'descriptive' => 'descriptive'], ['prompt'=>'Выберите форму']);  ?>
                <div class="form-field-first" style="display: none;">
                    <?= $form->field($model, 'company_name')->input('text', ['placeholder' => 'Название компании', 'value' => 'Название компании'])  ?>
                    <?= $form->field($model, 'position')->input('text', ['placeholder' => 'Должность', 'value' => 'должность'])  ?>
                </div>
                <div class="form-field-second" style="display: none;">
                    <?= $form->field($model, 'contact_name')->input('text', ['placeholder' => 'contact_name_placeholder', 'value' => 'имя'])  ?>
                    <?= $form->field($model, 'company_email')->input('text', ['placeholder' => 'company_email_placeholder'])  ?>
                </div>
                <div class="form-field-third" style="display: none;">
                    <?= $form->field($model, 'salary')->input('text', ['placeholder' => 'company_email_placeholder', 'value' => '300'])  ?>
                    <?= $form->field($model, 'position_description')->input('text', ['placeholder' => 'position_description_placeholder', 'value' => 'position_descr'])  ?>

                    <?= $form->field($model, 'dateStart')->widget(DatePicker::class, [
                        'language' => 'ru',
//        'dateFormat' => 'dd.mm.yyyy',
                        'options' => [
//                            'placeholder' => date("d.m.Y"),
                            'class'=> 'form-control',
                            'autocomplete'=>'off',
                            'format' => 'dd.mm.yyyy'
                        ],
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                            'yearRange' => '2015:2050',
                            //'showOn' => 'button',
                            //'buttonText' => 'Выбрать дату',
                            //'buttonImageOnly' => true,
                            //'buttonImage' => 'images/calendar.gif'
                        ]])->label('') ?>

                    <?= $form->field($model, 'dateEnd')->widget(DatePicker::class, [
                        'language' => 'ru',
//        'dateFormat' => 'dd.mm.yyyy',
                        'options' => [
//                            'placeholder' => date("d.m.Y", strtotime(date("d.m.Y") ."+3 Month")),
                            'class'=> 'form-control',
                            'autocomplete'=>'off',
                            'format' => 'dd.mm.yyyy',
                            'readonly' => 'readonly'
                        ],
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                            'yearRange' => '2015:2050',
                            'autoclose' => true,
                            'todayHighlight' => true,
                            'clientEvents' => [
                                'changeDate' => false
                            ],

                         ]])->label('') ?>

                </div>


                <div class="form-group form-field-first" style="display: none;">

                    <?= $form->field($model, 'datePostAt')->widget(DatePicker::class, [
                        'language' => 'ru',
//        'dateFormat' => 'dd.mm.yyyy',
                        'options' => [
//                            'placeholder' => date("d.m.Y"),
                            'class'=> 'form-control',
                            'autocomplete'=>'off',
                            'format' => 'dd.mm.yyyy'
                        ],
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
//                            'yearRange' => '2015:2050',
                            //'showOn' => 'button',
                            //'buttonText' => 'Выбрать дату',
                            //'buttonImageOnly' => true,
                            //'buttonImage' => 'images/calendar.gif'
                        ]])->label('Post At') ?>

                    <div class="col-md-5 col-md-offset-2">
                        <?= Html::submitButton('Заказать', ['class' =>'btn btn-primary btn-lg center-block']) ?>
                    </div>
                </div>

                <?php  $form = ActiveForm::end(); ?>

                <?php if(Yii::$app->session->hasFlash('success')): ?>

                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                        <?= Yii::$app->session->getFlash('success'); ?>
                    </div>

                    <?php
                    $this->registerJs('$(".alert").animate({opacity: 1.0}, 15000).fadeOut("slow")', yii\web\View::POS_READY);
                    ?>


                <?php endif; ?>

                <?php if(Yii::$app->session->hasFlash('danger')): ?>

                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                        <?= Yii::$app->session->getFlash('danger'); ?>
                    </div>

                    <?php
                    $this->registerJs('$(".alert").animate({opacity: 1.0}, 15000).fadeOut("slow")', yii\web\View::POS_READY);
                    ?>


                <?php endif; ?>

<!--                --><?php //echo '<pre>' . var_dump($model->scenarios(), 1) . '</pre>'; ?>
<!--                --><?php //echo '<pre>' . print_r($model, 1) . '</pre>'; ?>
<!--                <hr>-->

                <?php Pjax::end()?>


            </div>

        </div>
    </div>

<?php