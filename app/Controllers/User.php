<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        //if used on almost all place, this caller can be place in BaseController
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $keyword = $this->request->getVar('keyword');

        //carian function ni still ad loophole since dia akan reset when change pagination/page
        if ($keyword) {
            $data['currentPage'] = 1;
            $user = $this->userModel->searchBy($keyword);
        } else {
            $data['currentPage'] = $this->request->getVar('page_user') ?: 1;
            $user = $this->userModel;
        }
        $data['title'] = 'Pengguna';
        // $data['user'] = $this->userModel->findAll();
        //test again
        $data['user'] = $user->paginate(10, 'user');
        $data['pager'] = $this->userModel->pager;

        return view('user/lst_user', $data);
    }
}
