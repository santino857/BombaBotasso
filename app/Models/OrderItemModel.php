<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table         = 'order_items';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal'
    ];
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    /**
     * Obtiene los productos vinculados a un pedido con los detalles de cada corte
     */
    public function getItemsByOrder(int $orderId): array
    {
        return $this->select('order_items.*, products.name as product_name, products.tag, products.image')
                    ->join('products', 'products.id = order_items.product_id', 'left')
                    ->where('order_items.order_id', $orderId)
                    ->findAll();
    }
}
