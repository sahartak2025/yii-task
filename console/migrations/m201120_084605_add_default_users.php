<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m201120_084605_add_default_users
 */
class m201120_084605_add_default_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $userRoles = [
            User::ROLE_USER => 'user',
            User::ROLE_ADMIN => 'admin',
        ];
        foreach ($userRoles as $role => $name) {
            $user = new User();
            $user->role = $role;
            $user->username = $name;
            $user->status = User::STATUS_ACTIVE;
            $user->email = $name.'@gmail.com';
            $user->setPassword($name.'_pass');
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
            $user->save();
        }


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201120_084605_add_default_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201120_084605_add_default_users cannot be reverted.\n";

        return false;
    }
    */
}
