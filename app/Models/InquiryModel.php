<?php

namespace App\Models;

use CodeIgniter\Model;

class InquiryModel extends Model
{
    protected $table         = 'inquiries';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'user_id',
        'name',
        'contact',
        'message',
        'status',
        'created_at'
    ];
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    public function getInquiriesByUser(int $userId): array
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
