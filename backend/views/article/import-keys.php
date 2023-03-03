<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\form\ImportKeysForm $model */

$this->title = 'Import Keys';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Import Keys';
?>
<div class="article-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="article-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'keys')->textarea(['rows' => 5]) ?>

        <?= $form->field($model, 'separator')->widget(Select2::classname(), [
            'hideSearch' => true,
            'data' => \common\models\form\ImportKeysForm::getSeparators(),
            'options' => ['placeholder' => 'Separator...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);?>

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

</div>
