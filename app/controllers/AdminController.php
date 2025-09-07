<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class AdminController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // только авторизованные пользователи
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity && Yii::$app->user->identity->role === User::ROLE_ADMIN;
                        }
                    ],
                ],
            ],
        ];
    }
}
