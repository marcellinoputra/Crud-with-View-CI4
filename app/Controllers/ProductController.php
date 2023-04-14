<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModels;

class ProductController extends ResourceController
{
    use ResponseTrait;


    public function getAllProduct()
    {
        $model = new ProductModels();
        $result = $model->findAll();

        if ($result) {
            $response = [
                "status" => 200,
                "data" => $result,
                "message" => "Successfully Get Product Data"
            ];
            return $this->respond($response);
        } else {
            $response = [
                "status" => 400,
                "message" => "Failed Get Product Data"
            ];
            return $this->respond($response, 400);
        }
    }

    public function insertProduct()
    {
        $rules = [
            'nama' => "required|min_length[10]",
            'title' =>  "required|min_length[10]",
            'gambar' =>  "required|min_length[10]"
        ];

        $message = [
            'nama' => [
                'required' => 'Nama is Required'
            ],
            'title' => [
                'required' => 'Title is Required'
            ],
            'gambar' => [
                'required' => 'Gambar is Required'
            ]
        ];

        if (!$this->validate($rules, $message)) {
            $response = [
                'status' => 400,
                'error' => true,
                'message' => $this->validator->getErrors(),
                'data' => []
            ];
            return $this->respond($response, 400);
        } else {
            $productModels = new ProductModels();
            $data = [
                'nama' => $this->request->getVar('nama'),
                'title' => $this->request->getVar('title'),
                'gambar' => $this->request->getVar('gambar')
            ];
            $result = $productModels->save($data);

            if ($result) {
                $response = [
                    "status" => 201,
                    "message" => "Successfully Add Product Data"
                ];
                return $this->respondCreated($response);
            } else {
                $response = [
                    "status" => 400,
                    "message" => "Failed Adding Product Data"
                ];
                return $this->respond($response, 400);
            }
        }
    }

    public function getProductById($id)
    {
        $model = new ProductModels();
        $data = $model->where("id", $id)->findAll();
        return $this->respond($data);
    }

    public function getProductByName($name)
    {
        $model = new ProductModels();
        $data = $model->where("nama", $name)->findAll();
        return $this->respond($data);
    }

    public function editProductDataByID($id)
    {
        $db = \Config\Database::connect();
        $model = new ProductModels();
        $data = [
            "nama" => $this->request->getVar("nama"),
            "title" => $this->request->getVar("title"),
            "gambar" => $this->request->getVar("gambar")
        ];
        $result = $db->table('product');
        $result->where('id', $id);
        $result->update($data);

        if ($result) {
            $response = [
                "status" => 201,
                "message" => "Successfully Updated"
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => 400,
                "message" => "Cannot Updated"
            ];
            return $this->respond($response, 400);
        }
    }

    public function deleteProductById($id)
    {
        $model = new ProductModels();
        $result = $model->delete($id);

        if ($result) {
            $response = [
                "status" => 201,
                "message" => "Successfully Deleted"
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                "status" => 400,
                "message" => "Cannot Deleted"
            ];
            return $this->respond($response, 400);
        }
    }
}
