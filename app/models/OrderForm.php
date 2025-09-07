<?php

namespace app\models;

use yii\base\Model;
use app\models\Order;
use app\models\OrderItem;

class OrderForm extends Model
{
    public $name;
    public $status;
    public $items = []; // массив OrderItemForm

    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            ['items', 'safe'], // массив продуктов
        ];
    }

    public function save()
    {
        $order = new Order();
        $order->name = $this->name;
        $order->status = $this->status ?: Order::STATUS_NEW;
        $order->date = date('Y-m-d H:i:s');

        // Привязка к пользователю (например, текущий авторизованный)
        $order->user_id = \Yii::$app->user->id ?? null;

        // Общая сумма
        $totalPrice = 0;

        if (!$order->save()) {
            \Yii::error($order->errors, __METHOD__);
            return false;
        }

        // Сохранение позиций
        foreach ($this->items as $itemData) {
            $item = new OrderItem();
            $item->order_id = $order->id;
            $item->product_id = $itemData['product_id'];
            $item->count = $itemData['count'];
            $item->price = $itemData['price'];
            if ($item->save()) {
                $totalPrice += $item->count * $item->price;
            } else {
                \Yii::error($item->errors, __METHOD__);
            }
        }

        // Обновляем общую сумму заказа
        $order->total_price = $totalPrice;
        $order->save(false, ['total_price']);

        return $order;
    }

}

