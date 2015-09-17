<?php

namespace app\models;

use Yii;
use yii\validators\ExistValidator;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\components\Mailer;
use app\components\wordpress\WpCheckPasswordComponent;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property integer $status
 * @property string $email
 * @property string $password
 * @property string $authKey
 * @property string $password_reset_token
 *
 * @property Status[] $statuses
 */
class Users extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    protected $mailer;

    public function init() {
        $this->mailer = \Yii::$container->get(Mailer::className());
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['first_name', 'last_name', 'email', 'password', 'auth_key', 'password_reset_token'], 'string', 'max' => 255],
            [['gender'], 'string', 'max' => 11],
            [['email', 'first_name', 'last_name', 'password', 'gender'], 'required'],
            [['email'], 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'gender' => Yii::t('app', 'Gender'),
            'status' => Yii::t('app', 'Status'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatuses()
    {
        return $this->hasMany(Status::className(), ['created_by' => 'id']);
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
         return static::findOne(['id' => $id]);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        //return static::findOne(['password_reset_token' => $token]);
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['email' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
        return true;
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        if(empty($this->password)){
            $WpCheckPassword = new WpCheckPasswordComponent();
            return $WpCheckPassword->wp_check_password($password,$this->wp_hash);
        }else{
            return Yii::$app->security->validatePassword($password, $this->password);
        }
        return false;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Send confirmation after user finishes signing up a new account
     **/
    public function sendWelcomeMessage() {
        $this->mailer->sendWelcomeMessage($this);
    }

    /**
     * Send reset password link
     **/
    public function sendResetPasswordLink() {
        $this->mailer->sendResetPasswordLink($this);
    }

    /**
     * Get role's name for validation
     **/
    public function getLoginAccess() {
        $result = false;
        if($this->usersRoles) {
            foreach ($this->usersRoles as $value) {
                if (strtolower($value->role->name) == 'admin') {
                    $result = true;
                }
            }
        }
        return $result;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersRoles()
    {
        return $this->hasMany(UsersRoles::className(), ['user_id' => 'id']);
    }
}