<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table          = 'products';
    protected $primaryKey     = 'id';
    protected $allowedFields   = [
        'name',
        'description',
        'price',
        'tag',
        'image',
        'whatsapp_msg',
        'active'
    ];
    protected $returnType     = 'array';
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';

    public function getActiveProducts()
    {
        return $this->where('active', 1)->orderBy('id', 'ASC')->findAll();
    }
}
