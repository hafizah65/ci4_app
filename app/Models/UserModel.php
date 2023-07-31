<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $allowedFields    = ['nama', 'alamat', 'soft_delete'];
    protected $useTimestamps = true;

    public function searchBy($keyword)
    {

        // $builder = $this->table('users');
        // $builder->like('nama', $keyword);
        // return $builder;

        return $this->like('nama', $keyword)->orLike('alamat', $keyword);
    }
}
