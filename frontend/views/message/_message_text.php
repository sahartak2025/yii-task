<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Message;
/* @var $model Message */

?>
<p class="<?=$model->messageClass?>"><?=Html::encode($model->message)?>
    <?php if (!Yii::$app->user->isGuest &&  Yii::$app->user->identity->isAdmin && $model->incorrect == Message::NO):?>
        <a href="<?=Url::toRoute(['message/incorrect', 'id' => $model->id, 'incorrect' => Message::YES])?>" class="incorrect" title="Move Message to Incorrect messages list "><i class="fa fa-ban"
                                                                                    aria-hidden="true"></i> </a>
    <?php endif?>
</p>
<span class="time_date"> <?=$model->messageCreatedAt?></span>