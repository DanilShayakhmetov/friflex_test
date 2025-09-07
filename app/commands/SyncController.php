<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\commands;

use app\components\services\ParserInterface;
use yii\console\Controller;

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
            $result = $this->parser->sync($data);
            echo "Products({$result}) synced!\n";
        } else {

            echo "Error - empty data!\n";
        }
    }
}

