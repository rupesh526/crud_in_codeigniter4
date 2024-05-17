<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AddressModel;
use CodeIgniter\Controller;

class Users extends Controller
{
    protected $userModel;
    protected $addressModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->addressModel = new AddressModel();
    }

    public function index()
    {
        $pager = \Config\Services::pager();
        $data = [
            'users' => $this->userModel->paginate(2),
            'pager' => $this->userModel->pager
        ];
        return view('users/index', $data);
    }

    public function create()
    {
        helper('form');
        if ($this->request->getMethod() == 'POST') 
        {
            $validation_rules = [
                'name'              => 'required',
                'email'             => 'required|valid_email|is_unique[users.email]',
                'mobile_number'     => 'required|max_length[10]',
                'gender'            => 'required',
                'dob'               => 'required',
                'age'               => 'required|integer|greater_than_equal_to[20]|less_than_equal_to[100]'
            ];
            if($this->validate($validation_rules))
            {   
                $userData = [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'mobile_number' => $this->request->getPost('mobile_number'),
                    'gender' => $this->request->getPost('gender'),
                    'dob' => $this->request->getPost('dob'),
                    'age' => $this->request->getPost('age')
                ];
                
                $this->userModel->save($userData);
                $id_user = $this->userModel->insertID();

                $addresses = $this->request->getPost('addresses');
                foreach ($addresses as &$address) {
                    $address['id_user'] = $id_user;
                }
                $this->addressModel->createAddressBatch($addresses);
            }
            else
            {
                // Validation failed, show errors
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }

        return redirect()->to('/users'); 
    }

    public function edit($id)
    {
        helper('form');

        $data['user'] = $this->userModel->find($id);
        $data['addresses'] = $this->addressModel->getAddresses($id);

        if ($this->request->getMethod() == 'POST') 
        {
            $validation_rules = [
                'name'          => 'required',
                'email'         => 'required|valid_email|is_unique[users.email,users.id_user,'.$id.']',
                'mobile_number' => 'required|max_length[10]',
                'gender'        => 'required',
                'dob'           => 'required',
                'age'           => 'required|integer|greater_than_equal_to[20]|less_than_equal_to[100]'
            ];

            if($this->validate($validation_rules))
            {   
                $userData = [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'mobile_number' => $this->request->getPost('mobile_number'),
                    'gender' => $this->request->getPost('gender'),
                    'dob' => $this->request->getPost('dob'),
                    'age' => $this->request->getPost('age')
                ];

                $this->userModel->update($id, $userData);

                $this->addressModel->where('id_user', $id)->delete();
                $addresses = $this->request->getPost('addresses');
                foreach ($addresses as &$address) {
                    $address['id_user'] = $id;
                }
                $this->addressModel->createAddressBatch($addresses);
                return redirect()->to('/users');
            }
            else
            {
                // Validation failed, show errors
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }

        return view('users/edit', $data);
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        $this->addressModel->where('id_user', $id)->delete();
        return redirect()->to('/users');
    }

    public function search()
    {
        $pager = \Config\Services::pager();
        $search = $this->request->getPost('search');

        $data = [
            'users' => $this->userModel->searchUsers($search, 2, 0),
            'pager' => $pager
        ];

        return view('users/index', $data);
    }
}
