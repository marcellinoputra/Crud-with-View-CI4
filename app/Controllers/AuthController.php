<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsersModels;

class AuthController extends ResourceController
{
    use ResponseTrait;

    public function getAllUsers()
    {
        $usersModel = new UsersModels();
        $result = $usersModel->findAll();

        if ($result) {
            $response = [
                "status" => 200,
                "data" => $result,
                "message" => "Successfully Get Users Data"
            ];
            return $this->respond($response);
        } else {
            $response = [
                "status" => 400,
                'errors' => true,
                "message" => "Failed Get Users Data"
            ];
            return $this->respond($response, 400);
        }
    }

    public function signUp()
    {
        $rules = [
            'name' => "required|min_length[5]",
            'username' => "required|min_length[5]",
            'password' => "required|min_length[8]"
        ];

        $message = [
            'name' => [
                'required' => 'Name is Required'
            ],
            'username' => [
                'required' => 'Username is Required'
            ],
            'password' => [
                'required' => 'Passowrd is Required'
            ]
        ];

        $password = password_hash(base64_encode(hash('sha256', $this->request->getVar('password'), true)), PASSWORD_BCRYPT);

        if (!$this->validate($rules, $message)) {
            $response = [
                'status' => 400,
                'error' => true,
                'message' => $this->validator->getErrors(),
                'data' => []
            ];
            return $this->respond($response, 400);
        } else {
            $usersModels = new UsersModels();
            $data = [
                'name' => $this->request->getVar('name'),
                'username' => $this->request->getVar('username'),
                'password' => $password
            ];
            $result = $usersModels->save($data);


            if ($result) {
                $response = [
                    "status" => 201,
                    "message" => "Successfully SignUp"
                ];
                return $this->respondCreated($response);
            } else {
                $response = [
                    "status" => 400,
                    "message" => "Failed SignUp"
                ];
                return $this->respond($response, 400);
            }
        }
    }

    public function signIn()
    {
        $usersModels = new UsersModels();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $findUsers = $usersModels->where("username", $username)->first();
        $authPass = password_hash(base64_encode(hash('sha256', $this->request->getVar('password'), true)), PASSWORD_BCRYPT);

        $authVerif = password_verify(base64_encode(hash('sha256', $password, true)), $authPass);

        if ($authVerif) {
            $response = [
                "status" => 200,
                "data" => [
                    'id' => $findUsers['id'],
                    'name' => $findUsers['name'],
                    'username' => $findUsers['username'],
                    'password' => $findUsers['password']
                ],
                "mesasge" => "Successfully Retrieve Data"
            ];
            return $this->respond($response);
        } else {
            $response = [
                "status" => 400,
                'error' => true,
                "mesasge" => "Wrong Password"
            ];
            return $this->respond($response, 400);
        }
    }
}
