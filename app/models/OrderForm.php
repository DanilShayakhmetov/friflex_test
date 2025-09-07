<?php

namespace app\models;

use yii\base\Model;

class OrderForm extends Model
{
    public $name;
    public $status;
    public $items = []; // массив OrderItemForm

    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            ['items', 'safe'],
        ];
    }

    public function save()
    {
        $order = new Order();
        $order->name = $this->name;
        $order->status = $this->status ?: Order::STATUS_NEW;
        $order->date = date('Y-m-d H:i:s');
        $order->user_id = \Yii::$app->user->id ?? null;
        $totalPrice = 0;

        if (!$order->save()) {
            \Yii::error($order->errors, __METHOD__);
            return false;
        }

        foreach ($this->items as $itemData) {
            $id = $itemData['product_id'];
            $product = Product::findOne($id);
            $item = new OrderItem();
            $item->product_id = $id;
            $item->order_id = $order->id;
            $item->count = $itemData['count'];
            $item->price = $product->price;
            $item->description = $product->description;
            if ($item->save()) {
                $totalPrice += $item->count * $item->price;
            } else {
                \Yii::error($item->errors, __METHOD__);
            }
        }

        $order->total_price = $totalPrice;
        $order->save(false, ['total_price']);

        return $order;
    }

}

