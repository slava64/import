<?php

use common\models\Article;
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
            'import_id',
            ['attribute' => 'category.name', 'filter' => \common\models\Category::getMap()],
            ['attribute' => 'service.name', 'filter' => \common\models\Service::getMap()],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Article $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

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
