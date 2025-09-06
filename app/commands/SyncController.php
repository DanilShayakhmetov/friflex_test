<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\helpers\Json;
use app\models\Product;

class SyncController extends Controller
{
    public function actionProducts()
    {
        $url = 'https://dummyjson.com/products';
        $json = file_get_contents($url);
        $data = Json::decode($json);

        if (!empty($data['products'])) {
            foreach ($data['products'] as $item) {
                $product = Product::findOne(['id' => $item['id']]);
                if (!$product) {
                    $product = new Product();
                    $product->id = $item['id'];
                }
                $product->name = $item['title'];
                $product->price = $item['price'];
                $product->save(false);
            }
        }

        echo "Products synced!\n";
    }
}

