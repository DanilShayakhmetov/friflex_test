<?php

namespace app\controllers\api;

use yii\rest\ActiveController;
use app\models\Order;

class OrderController extends ActiveController
{
    public $modelClass = Order::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Включаем аутентификацию по токену (пример, можно JWT)
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::class,
        ];

        return $behaviors;
    }
}
