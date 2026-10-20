<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table         = 'comments';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'user_id',
        'name',
        'subtitle',
        'stars',
        'comment',
        'status',
        'created_at'
    ];
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    public function getApprovedComments($limit = 10)
    {
        return $this->where('status', 'approved')
                    ->orderBy('id', 'DESC')
                    ->findAll($limit);
    }

    public function getCommentsByUser(int $userId): array
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
