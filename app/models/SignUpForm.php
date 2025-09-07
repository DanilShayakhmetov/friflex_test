<?php

namespace app\models;

use yii\base\Model;

class SignUpForm extends Model
{
    public string $username = '';
    public string $password = '';

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['username', 'string', 'max' => 255],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function signup(): ?User
    {
        if (!$this->validate()) {
            return null;
        }

        return User::createUser($this->username, $this->password);
    }
}
