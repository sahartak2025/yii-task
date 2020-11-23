<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
$roleNames = User::ROLE_NAMES;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email:email',
            [
                'attribute' => 'role',
                'value' => function($model) use ($roleNames){
                    return $roleNames[$model->role];
                },
                'filter' => $roleNames
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{changeRole}',
                'buttons'=>[
                    'changeRole'=>function ($url, $model) use ($roleNames) {
                        return Html::a('Change Role to '.$roleNames[$model->changeRoleTo],
                            \yii\helpers\Url::to(['user/change-role', 'id' => $model->id]),
                            ['class' => 'btn btn-success btn-xs custom_button']);
                    },
                ],
            ],
            ]
    ]); ?>


</div>
