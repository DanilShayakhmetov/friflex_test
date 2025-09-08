<?php

namespace app\controllers\api;

use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use app\models\Order;

class OrderController extends ActiveController
{
    public $modelClass = Order::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        return $behaviors;
    }
}
