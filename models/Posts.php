<?php

namespace app\models;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\Posts;
use app\models\LoginForm;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $title
 * @property string $data
 * @property integer $create_time
 * @property integer $update_time
 */
class Posts extends \yii\db\ActiveRecord
{
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'data'], 'required'],
            [['data'], 'string'],
            [['create_time', 'update_time'], 'integer'],
            [['title'], 'string', 'max' => 255],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'data' => Yii::t('app', 'Data'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
    }    

}
