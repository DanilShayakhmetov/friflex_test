<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string|null $token
 * @property string|null $role
 * @property string|null $created_at
 *
 * @property Order[] $orders
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const ROLE_ADMIN = 'admin';
    const ROLE_MANAGER = 'manager';
    const ROLE_CUSTOMER = 'customer';

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password', 'token', 'role'], 'string', 'max' => 255],
            [['role'], 'default', 'value' => self::ROLE_CUSTOMER],
            [['username'], 'unique'],
        ];
    }

    public static function findIdentity($id): ?IdentityInterface
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null): ?IdentityInterface
    {
        return self::findOne(['token' => $token]);
    }

    public static function findByUsername(string $username):  ?self
    {
        return self::findOne(['username' => $username]);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthKey(): ?string
    {
        return $this->token;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public static function createUser(string $username, string $password): self
    {
        $user = new self();
        $user->username = $username;
        $user->password = Yii::$app->security->generatePasswordHash($password);
        $user->token = Yii::$app->security->generateRandomString();
        $user->role = self::ROLE_CUSTOMER;
        $user->save(false);

        return $user;
    }

    public function isRoleAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isRoleManager(): bool
    {
        return $this->role === self::ROLE_MANAGER;
    }

    public function isRoleCustomer(): bool
    {
        return $this->role === self::ROLE_CUSTOMER;
    }
}
