<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModels extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'id';
    protected $allowedFields = ["nama", "title", "gambar"];

    // protected $db;

    // public function __construct(ConnectionInterface &$db)
    // {
    //     $this->db = &$db;
    // }

    // public function list()
    // {
    //     return $this->db
    //         ->table('product')
    //         ->get()
    //         ->getResult();
    // }

    // public function getProduct($id)
    // {
    //     return $this->db
    //         ->table('product')
    //         ->where(["id" => $id])
    //         ->get()->getRow();
    // }

    // public function updateProduct($id, $data)
    // {
    //     return $this->db
    //         ->table('product')
    //         ->where(["id" => $id])
    //         ->set($data)
    //         ->update();
    // }
}
