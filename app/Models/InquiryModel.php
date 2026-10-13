<?php

namespace App\Models;

use CodeIgniter\Model;

class InquiryModel extends Model
{
    protected $table          = 'inquiries';
    protected $primaryKey     = 'id';
    protected $allowedFields   = [
        'name',
        'contact',
        'message',
        'status',
        'created_at'
    ];
    protected $returnType     = 'array';
    protected $useTimestamps  = false;
}
