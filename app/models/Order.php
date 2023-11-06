<?php
class Order extends Model
{
    public string $table = "user_items";
    public array $columns =
    [
        'id',
        'user_id',
        'item_id',
        'amount',
        'price',
        'created_at',
    ];

    public function purchase(int $user_id, CartItem $cart_item)
    {
        $values = $cart_item->getItems();
        if (!$values) return;

        $posts = [];
        foreach ($values as $value) {
            $posts['user_id'] = $user_id;
            $posts['item_id'] = $value['item']['id'];
            $posts['price'] = $value['item']['price'];
            $posts['amount'] = $value['amount'];
            $posts['total_price'] = $posts['price'] * $posts['amount'];
            $this->save($posts);
        }
        $cart_item->clear();
    }

    public function histories(int $user_id)
    {
        $values = $this->getWithItem();
        if (!$values) return;
        $orders = array_filter(
            $values,
            function ($value) use ($user_id) {
                return $value['user_id'] == $user_id;
            }
        );
        return $orders;
    }

    public function getWithItem()
    {
        $item = new Item();
        $items = $item->get();
        $item_ids = array_column($items, 'id');

        $orders = $this->get();
        if (!$orders) return;
        foreach ($orders as $key => $order) {
            $index = array_search($order['item_id'], $item_ids);
            $orders[$key]['item'] = $items[$index];
        }

        return $orders;
    }
}
