<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table          = 'comments';
    protected $primaryKey     = 'id';
    protected $allowedFields   = [
        'name',
        'subtitle',
        'stars',
        'comment',
        'status',
        'created_at'
    ];
    protected $returnType     = 'array';
    protected $useTimestamps  = false; // Handled manually or via default

    public function getApprovedComments($limit = 10)
    {
        return $this->where('status', 'approved')
                    ->orderBy('id', 'DESC')
                    ->findAll($limit);
    }
}
