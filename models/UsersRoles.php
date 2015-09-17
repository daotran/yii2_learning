<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_roles".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $role_id
 *
 * @property Roles $role
 * @property Users $user
 */
class UsersRoles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_roles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'role_id'], 'required'],
            [['user_id', 'role_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'role_id' => Yii::t('app', 'Role ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Roles::className(), ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
