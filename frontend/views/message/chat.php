<?php

use yii\widgets\ActiveForm;
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model common\models\Message */



$this->title = 'Chat';

?>
<div class="container">
    <h3 class=" text-center">Chat</h3>
    <div class="messaging">
        <div class="inbox_msg">
            <div class="mesgs col-md-8 col-md-offset-2">
                <div class="msg_history">
                    <?= \yii\widgets\ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemView' => '_message',
                    ]);?>

                </div>
                <?php if (!Yii::$app->user->isGuest): ?>
                    <?php $form = ActiveForm::begin(['action' => 'message/create']); ?>

                    <div class="type_msg">
                        <div class="input_msg_write">
                            <?= $form->field($model, 'message')->input('text', ['class' => 'write_msg', 'placeholder' => 'Type a message'])->label(false) ?>

                            <button class="msg_send_btn" type="submit"><i class="fa fa-paper-plane-o"
                                                                          aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <?php ActiveForm::end() ?>
                <?php endif; ?>
            </div>
        </div>


    </div>
</div>