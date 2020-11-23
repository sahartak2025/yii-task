<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int $user_id
 * @property string $message
 * @property int|null $incorrect
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 */
class Message extends \yii\db\ActiveRecord
{

    const YES = 1;
    const NO = 0;

    const INCORRECT_LABELS = [
        self::NO => 'No',
        self::YES => 'Yes'
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'message'], 'required'],
            [['user_id', 'incorrect', 'created_at', 'updated_at'], 'integer'],
            [['message'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'message' => 'Message',
            'incorrect' => 'Incorrect',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Return chat query (show incorrect messages only for admins)
     * @return \yii\db\ActiveQuery
     */
    public static function getChatQuery()
    {
        $query = Message::find();
        if (Yii::$app->user->isGuest || !Yii::$app->user->identity->isAdmin) {
            $query->where(['incorrect' => Message::NO]);
        }
        return $query;
    }

    /**
     * Returns formatted message crated_at field
     * @return string
     */
    public function getMessageCreatedAt() :string
    {
        return date('Y-m-d H:i:s', $this->created_at);
    }
    /**
     * Returns message class if user s admin or message is incorrect
     * @return string
     */
    public function getMessageClass() :string
    {
        if ($this->incorrect == self::YES) {
            return 'msg-text-danger';
        }
        if ($this->user->isAdmin) {
            return 'msg-text-success';
        }
        return '';
    }
}
