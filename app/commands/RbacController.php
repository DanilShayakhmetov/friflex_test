<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        echo "RBAC очищен...\n";

        // 1) Создаем роли
        $admin = $auth->createRole('admin');
        $manager = $auth->createRole('manager');
        $customer = $auth->createRole('customer');

        $auth->add($admin);
        $auth->add($manager);
        $auth->add($customer);

        echo "Роли созданы...\n";

        // 2) Создаем права
        $editProduct = $auth->createPermission('editProduct');
        $editProduct->description = 'Редактировать товар';
        $auth->add($editProduct);

        $viewOrder = $auth->createPermission('viewOrder');
        $viewOrder->description = 'Просматривать заказы';
        $auth->add($viewOrder);

        $updateOrderStatus = $auth->createPermission('updateOrderStatus');
        $updateOrderStatus->description = 'Изменять статус заказа';
        $auth->add($updateOrderStatus);

        $createOrder = $auth->createPermission('createOrder');
        $createOrder->description = 'Создавать заказ';
        $auth->add($createOrder);

        echo "Права созданы...\n";

        // 3) Связываем роли и права
        $auth->addChild($admin, $editProduct);
        $auth->addChild($admin, $viewOrder);
        $auth->addChild($admin, $updateOrderStatus);
        $auth->addChild($admin, $createOrder);

        $auth->addChild($manager, $viewOrder);
        $auth->addChild($manager, $updateOrderStatus);

        $auth->addChild($customer, $createOrder);

        echo "Роли и права связаны...\n";

        // 4) Присваиваем роли существующим пользователям и генерируем токены
        $users = User::find()->all();

        foreach ($users as $user) {
            // Если токена нет, генерируем
            if (empty($user->token)) {
                $user->token = Yii::$app->security->generateRandomString(64);
                $user->save(false);
                echo "Токен сгенерирован для пользователя {$user->username}: {$user->token}\n";
            }

            if (strpos(strtolower($user->role), 'admin') !== false) {
                $role = $admin;
            } elseif (strpos(strtolower($user->role), 'manager') !== false) {
                $role = $manager;
            } else {
                $role = $customer;
            }

            $auth->assign($role, $user->id);
            echo "Роль '{$role->name}' назначена пользователю {$user->username}\n";
        }

        echo "RBAC и назначение ролей завершены!\n";
    }
}
