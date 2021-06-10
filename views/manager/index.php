<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\jui\DatePicker;

$this->title = 'Страница с формой';
?>
    <div class="site-index container">

        <div class="body-content row">

            <div class="col-md-12">

                <?php
//                echo '<h1> Текущая дата: '.date("d.m.Y H:i:s").'</h1>';
                echo '<h1>Форма для отложенного размещения постов в социальных сетях</h1>';
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
                        <?= $form->field($model, 'company_name')->input('text')  ?>
                        <?= $form->field($model, 'position')->input('text')  ?>
                    </div>
                    <div class="form-field-second" style="display: none;">
                        <?= $form->field($model, 'contact_name')->input('text')  ?>
                        <?= $form->field($model, 'company_email')->input('text')  ?>
                    </div>
                    <div class="form-field-third" style="display: none;">
                        <?= $form->field($model, 'salary')->input('text')  ?>
                        <?= $form->field($model, 'position_description')->input('text')  ?>

                        <?= $form->field($model, 'dateStart')->widget(DatePicker::class, [
                            'language' => 'ru',
                            'options' => [
                                'class'=> 'form-control',
                                'autocomplete'=>'off',
                                'format' => 'dd.mm.yyyy'
                            ],
                            'clientOptions' => [
                                'changeMonth' => true,
                                'changeYear' => true,
                                'yearRange' => '2021:2050',
                            ]])->label('Дата начала') ?>

                        <?= $form->field($model, 'dateEnd')->widget(DatePicker::class, [
                            'language' => 'ru',
                            'options' => [
                                'class'=> 'form-control',
                                'autocomplete'=>'off',
                                'format' => 'dd.mm.yyyy',
                            ],
                            'clientOptions' => [
                                'changeMonth' => true,
                                'changeYear' => true,
                                'yearRange' => '2021:2050',
                                'clientEvents' => [
                                    'changeDate' => false
                                ],

                             ]])->label('Дата окончания') ?>
                    </div>
                     <div class="form-field-first" style="display: none;">
                        <?= $form->field($model, 'datePostAt')->widget(DatePicker::class, [
                    'language' => 'ru',
                    'options' => [
                        'class'=> 'form-control',
                        'autocomplete'=>'off',
                        'format' => 'dd.mm.yyyy'
                    ],
                    'clientOptions' => [
                        'changeMonth' => true,
                        'changeYear' => true,
                        'yearRange' => '2021:2050',
                    ]])->label('Дата размещения') ?>
                     </div>

                    <div class="form-group form-field-first" style="display: none;">
                        <div class="col-md-5 col-md-offset-2">
                            <?= Html::submitButton('Отправить', ['class' =>'btn btn-primary btn-lg center-block']) ?>
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


                <?php Pjax::end()?>


            </div>

        </div>
    </div>

<?php