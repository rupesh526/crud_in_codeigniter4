<?php

namespace App\Models;

use CodeIgniter\Model;

class AddressModel extends Model
{
    protected $table = 'addresses';
    protected $primaryKey = 'address_id';
    protected $allowedFields = ['id_user', 'address', 'city', 'state', 'pincode'];

    public function getAddresses($id_user)
    {
        return $this->where('id_user', $id_user)->findAll();
    }

    public function createAddressBatch($data)
    {
        return $this->insertBatch($data);
    }
}
