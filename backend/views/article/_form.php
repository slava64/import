<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Article $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'key2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'import_id')->textInput() ?>

    <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
        'hideSearch' => true,
        'data' => \common\models\Category::getMap(),
        'options' => ['placeholder' => 'Category...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?>

    <?= $form->field($model, 'service_id')->widget(Select2::classname(), [
        'hideSearch' => true,
        'data' => \common\models\Service::getMap(),
        'options' => ['placeholder' => 'Service...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
