<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table          = 'orders';
    protected $primaryKey     = 'id';
    protected $allowedFields   = [
        'customer_name',
        'customer_phone',
        'customer_address',
        'total',
        'status',
        'notes',
        'items_summary'
    ];
    protected $returnType     = 'array';
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
}
