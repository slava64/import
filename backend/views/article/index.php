<?php

use common\models\Article;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\ArticleSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Import Keys', ['import-keys'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=Html::beginForm();?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'key',
            'key2',
            [
                'attribute' => 'link',
                'format' => 'raw',
                'value' => function(Article $model) {
                    if (!empty($model->link)) {
                        return Html::a(
                            $model->link,
                            $model->link,
                            ['target' => '_blank']
                        );
                    }
                }
            ],
            'import_id',
            ['attribute' => 'category.name', 'filter' => \common\models\Category::getMap()],
            ['attribute' => 'service.name', 'filter' => \common\models\Service::getMap()],
            ['attribute' => 'public_at', 'format' => ['date', 'php:d-m-Y H:i:s']],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Article $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <div class="form-group">
        <label><?= Html::checkbox("future"); ?> Отложенная публикация</label>
    </div>

    <div class="form-group">
        <label class="form-label">Интервал дат отложенной публикация</label>
        <?= DatePicker::widget([
        'name' => 'future_from',
        'value' => date("d-m-Y"),
        'type' => DatePicker::TYPE_RANGE,
        'name2' => 'future_to',
        'value2' => date("d-m-Y"),
        'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd-mm-yyyy'
        ]
        ]);?>
    </div>

    <!--<div class="form-group">
        <label class="control-label">10% статей распределить дальше на N кол-во месяцев</label>
        <?= Select2::widget([
        'name' => 'future_month',
        'hideSearch' => true,
        'data' => [0, 3, 6, 12, 18, 24, 36, 48, 60],
        ]);?>
    </div>-->

    <div class="form-group">
        <?= Html::submitButton('Delete', [
                'class' => 'btn btn-success',
                'name' =>'delete', 'value' => '1',
                'onclick' => "return confirm('Confirm action?')"
        ]) ?>
        <?= Html::submitButton('Import', [
                'class' => 'btn btn-success',
                'name' =>'import', 'value' => '1',
                'onclick' => "return confirm('Confirm action?')"
        ]) ?>
        <?= Html::submitButton('All import', [
            'class' => 'btn btn-success',
            'name' =>'import-all', 'value' => '1',
            'onclick' => "return confirm('Confirm action?')"
        ]) ?>
    </div>

    <?=Html::endForm();?>
</div>
