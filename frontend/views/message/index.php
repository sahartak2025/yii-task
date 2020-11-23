<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Message;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Messages';
$this->params['breadcrumbs'][] = $this->title;
$incorrectLabels = Message::INCORRECT_LABELS;
?>
<div class="message-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Message', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'user',
                'value' => function($model){
                    return $model->user->username;
                },
            ],
            'message:ntext',
            [
                'attribute' => 'incorrect',
                'value' => function($model) use ($incorrectLabels){
                    return $incorrectLabels[$model->incorrect];
                },
                'filter' => $incorrectLabels

            ],
             //'updated_at',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{changeRole}',
                'buttons'=>[
                    'changeRole'=>function ($url, $model) {
                        return Html::a('Back to chat ',
                            \yii\helpers\Url::to(['message/incorrect', 'id' => $model->id, 'incorrect' => Message::NO]),
                            ['class' => 'btn btn-success btn-xs custom_button']);
                    },
                ],
            ],
            ],
    ]); ?>


</div>
