<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\commands;

use app\components\services\ParserInterface;
use yii\console\Controller;
use app\models\Product;

class SyncController extends Controller
{
    private ParserInterface $parser;

    public function __construct($id, $module, ParserInterface $parser, $config = [])
    {
        $this->parser = $parser;
        parent::__construct($id, $module, $config);
    }

    public function actionProducts()
    {
        $data = $this->parser->fetchData();

        if (!empty($data)) {
            foreach ($data as $item) {
                $product = Product::findOne(['id' => $item['id']]);
                if (!$product) {
                    $product = new Product();
                    $product->id = $item['id'];
                }
                $product->name = $item['title'];
                $product->price = $item['price'];
                $product->description = $item['description'];
                $product->save(false);
            }

            echo "Products synced!\n";
        } else {

            echo "Error - empty data!\n";
        }
    }
}

