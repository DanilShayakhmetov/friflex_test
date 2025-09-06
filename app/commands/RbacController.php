<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        // Роли
        $admin = $auth->createRole('admin');
        $manager = $auth->createRole('manager');
        $customer = $auth->createRole('customer');

        $auth->add($admin);
        $auth->add($manager);
        $auth->add($customer);

        // Права
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

        // Связываем роли и права
        $auth->addChild($admin, $editProduct);
        $auth->addChild($admin, $viewOrder);
        $auth->addChild($admin, $updateOrderStatus);
        $auth->addChild($admin, $createOrder);

        $auth->addChild($manager, $viewOrder);
        $auth->addChild($manager, $updateOrderStatus);

        $auth->addChild($customer, $createOrder);
    }
}
