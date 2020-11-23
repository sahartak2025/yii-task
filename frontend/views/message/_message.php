<?php
$user = $model->user;
?>
<?php if (Yii::$app->user->isGuest ||  Yii::$app->user->id == $model->user_id):?>
    <div class="outgoing_msg">
        <div class="sent_msg">
            <?=$this->render('_message_text',compact('model'))?>

        </div>
    </div>
<?php else:?>
    <div class="incoming_msg">
        <div class="incoming_msg_img">
            <img src="/img/<?=$user->img?>" title="<?=$user->username?>"
                 alt="sunil"></div>
        <div class="received_msg">
            <div class="received_withd_msg">
                <?=$this->render('_message_text',compact('model'))?>
            </div>
        </div>
    </div>

<?php endif?>




<br>