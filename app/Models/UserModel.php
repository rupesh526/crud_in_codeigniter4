<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['name', 'email', 'mobile_number', 'gender', 'dob', 'age'];

    public function getUsers($limit, $offset)
    {
        return $this->findAll($limit, $offset);
    }

    public function searchUsers($search, $limit, $offset)
    {
        return $this->like('name', $search)
                    ->orLike('email', $search)
                    ->findAll($limit, $offset);
    }
}
