<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Test extends BaseController
{
    public function index()
    {
        $data['title'] = 'Home';
        return view('static/home', $data);
    }

    public function test($nama, $umur=0){
        echo "Nama saya $nama, berumur $umur";
    }

    public function about(){
        $data['title'] = 'About Me';
        return view('static/about', $data);
    }
}
