<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $secret_key
 * @property string $auth_key
 * @property integer $status
 * @property integer $role
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_WAIT = 5;
    const STATUS_ACTIVE = 10;

    const ROLE_USER = 0;
    const ROLE_ADMIN = 1;

    public $password;
    public $section;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],

            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_WAIT, self::STATUS_DELETED]],
            ['role', 'default', 'value' => self::ROLE_USER],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
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
        return static::findOne(['username' => $username]);
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
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
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


    public function getAvailableSections()
    {
        return Section::find()
            ->joinWith('users')
            ->where([Subscription::tableName().'.user_id' => $this->id])
            ->all();
    }

    public function hasAccessFor(Section $section)
    {
        $subscription = Subscription::findOne([
            'user_id' => $this->id,
            'section_id' => $section->id,
        ]);

        return $subscription ? true : false;
    }

    public function addSection(Section $section)
    {
//        $subscriptionExists = Subscription::findOne([
//            'user_id' => $this->id,
//            'section_id' => $section->id,
//        ]);

//        if(!$subscriptionExists) {
            $subscription = new Subscription();

            $subscription->load(['Subscription' => [
                'user_id' => $this->id,
                'section_id' => $section->id,
            ]]);

            return $subscription->save();
//        }

//        return true;
    }

    public function deleteUserSections() {
        Subscription::deleteAll(['user_id' => $this->id]);
    }

    public function getDate($date)
    {
        return Yii::$app->formatter->asDate($date, 'medium');
    }


    public static function findByEmailConfirmToken($email_confirm_token)
    {
        return static::findOne(['secret_key' => $email_confirm_token, 'status' => self::STATUS_WAIT]);
    }

    public function generateEmailConfirmToken()
    {
        $this->secret_key = Yii::$app->security->generateRandomString();
    }

    public function removeEmailConfirmToken()
    {
        $this->secret_key = null;
    }
}
