<?php

use kartik\editable\Editable;
use lo\widgets\modal\ModalAjax;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\RegionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>






<?php
$this->title = 'Apples';
$this->params['breadcrumbs'][] = $this->title;
?>





<div class="apple-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Apple', ['create-random'], ['class' => 'btn btn-success']) ?>
    </p>
    <p align="right"><?php
        if(Yii::$app->controller->action->id === 'index'){
        echo Html::a('<span class="glyphicon glyphicon-trash"></span> Removed', ['deleted'], ['class' => 'btn btn-sm btn-danger']);
        }else{
        echo Html::a('<span class="glyphicon glyphicon-folder-close"></span> Active', ['index'], ['class' => 'btn btn-sm btn-success']);
        }
        ?></p>
    <br>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['attribute' => 'color',
                'contentOptions' => function ($model) {
                    return ['style' => 'background-color:' . $model->color];
                },
            ],
            ['attribute' => 'status',
                'value' => function ($model) {
                    return $model->statusLabel;
                }
            ],
            ['attribute' => 'size',
                'value' => function ($model) {
                    return $model->size * 100 . '%';
                }
            ],
            ['attribute' => 'fallen_at',
                'value' => function ($model) {
                    return $model->fallen_at ? \Yii::$app->formatter->asDatetime($model->fallen_at, "php:d-m-Y  H:i:s") : '';
                }
            ],
            ['attribute' => 'created_at',
                'value' => function ($model) {
                    return $model->created_at ? \Yii::$app->formatter->asDatetime($model->created_at, "php:d-m-Y  H:i:s") : '';
                }
            ],
            ['attribute' => 'deleted_at',
                'value' => function ($model) {
                    return $model->deleted_at ? \Yii::$app->formatter->asDatetime($model->deleted_at, "php:d-m-Y  H:i:s") : '';
                }
            ],


            ['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 8.7%'],
                'visible' => Yii::$app->user->isGuest ? false : true,
                'buttons' => [
                    'view' => function ($key, $model) {
                        return Html::a('FALL', ['apple/fall', 'id' => $model->id], ['class' => 'btn btn-primary']);
                    },
                    'update' => function ($key, $model) {
                        return ModalAjax::widget([
                            'id' => 'pre-order' . $model->id,
                            'header' => 'EAT',
                            'toggleButton' => [
                                'label' => 'EAT',
                                'class' => 'btn btn-success'
                            ],
                            'url' => Url::to(['apple/eat', 'id' => $model->id]), // Ajax view with form to load
                            'ajaxSubmit' => true, // Submit the contained form as ajax, true by default
                            'size' => ModalAjax::SIZE_LARGE,
                            'options' => ['class' => 'header-primary', 'tabindex' => false],
                            'autoClose' => true,
                            'pjaxContainer' => '#grid-pre-order-pjax',

                        ]);
                    },
                    'delete' => function ($key, $model) {
                        //return Html::a('REMOVE', ['apple/remove', 'id' => $model->id], ['class' => 'btn btn-danger']);
                    },
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
