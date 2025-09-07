<?php

namespace app\controllers\admin;

use app\controllers\AdminController;
use app\models\Product;
use yii\web\NotFoundHttpException;

class ProductController extends AdminController
{
    /**
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = Product::findOne(['id' => $id]);

        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if (\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('@app/views/product/update', [
            'model' => $model,
        ]);
    }
}