<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\App;
use App\Models\KomikModel;
use CodeIgniter\CodeIgniter;

class Komik extends BaseController
{
    protected $komikModel;
    protected $home = '/komik';

    public function __construct()
    {
        //if used on almost all place, this caller can be place in BaseController
        $this->komikModel = new KomikModel();
    }

    public function index()
    {
        $data['title'] = 'Komik';
        $data['komik'] = $this->komikModel->getKomik();

        return view('komik/lst_komik', $data);
    }

    public function detail($slug)
    {
        $data = [
            'title' => "Detail Komik",
            'komik' => $this->komikModel->getKomik($slug)
        ];

        if (!$data['komik']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Komik ' . $slug . ' tidak dijumpai.');
        }

        return view('komik/detail', $data);
    }

    public function create()
    {
        helper('form');
        $data = [
            'title' => 'Daftar Komik Baru',
            'action' => 'komik/insert',
            'komik' => null,
        ];

        return view('komik/frm_komik', $data);
    }

    public function insert()
    {
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => 'Sila isi {field}.',
                    'is_unique' => '{field} sudah wujud.'
                ]
            ],
            'penulis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Who's the writer?"
                ]
            ],
            'penerbit' => 'required',
            'sampul' => [
                // 'rules' => 'uploaded[sampul]|max_size[sampul, 1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'rules' => 'max_size[sampul, 1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    // 'uploaded' => "Sampul wajib dimuatknaik.",
                    'max_size' => "Fail tidak boleh melebih 1mb.",
                    'is_image' => "Hanya file gambar dibenarkan.",
                    'mime_in' => "Salah",
                ]
            ]
        ])) {

            return redirect()->to('/komik/create')->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'book.png';
            $fileSampul->move('img', $namaSampul);
        } else {
            //region use ori fileSampul name
            $fileSampul->move('img');
            $namaSampul = $fileSampul->getName();
            //endregion

            //region randomize fileSampul name
            // $namaSampul = $fileSampul->getRandomName();
            // $fileSampul->move('img', $namaSampul);
            //endregion
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $insert = [
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ];

        $this->komikModel->save($insert);

        session()->setFlashdata('pesan', 'Komik berjaya ditambah.');
        return redirect()->to($this->home);
    }

    public function kemaskini($slug)
    {
        helper('form');
        $data = [
            'title' => "Kemaskini Komik",
            'action' => 'komik/update/',
            'validation' =>  $this->validator,
            'komik' => $this->komikModel->getKomik($slug),
        ];

        return view('komik/frm_komik', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul, id, ' . $id . ']',
                'errors' => [
                    'required' => 'Sila isi {field}.',
                    'is_unique' => '{field} sudah wujud.'
                ]
            ],
            'penulis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Who's the writer?"
                ]
            ],
            'penerbit' => 'required',
            'sampul' => [
                // 'rules' => 'uploaded[sampul]|max_size[sampul, 1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'rules' => 'max_size[sampul, 1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    // 'uploaded' => "Sampul wajib dimuatknaik.",
                    'max_size' => "Fail tidak boleh melebih 1mb.",
                    'is_image' => "Hanya file gambar dibenarkan.",
                    'mime_in' => "Salah",
                ]
            ]
        ])) {

            return redirect()->to('/komik/kemaskini/' . $this->request->getVar('slug'))->withInput();
        }

        $sampulLama = $this->request->getVar('sampulLama');
        $fileSampul = $this->request->getFile('sampul');

        if ($fileSampul->getError() == 4) {
            $namaSampul = $sampulLama != '' ? $sampulLama : 'book.png';
        } else {
            //region use ori fileSampul name
            $fileSampul->move('img');
            $namaSampul = $fileSampul->getName();
            //endregion

            //region randomize fileSampul name
            // $namaSampul = $fileSampul->getRandomName();
            // $fileSampul->move('img', $namaSampul);
            //endregion

            if ($sampulLama != '') {
                unlink('img/' . $sampulLama);
            }
        }


        $slug = url_title($this->request->getVar('judul'), '-', true);
        $update = [
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul,
        ];

        $this->komikModel->save($update);

        session()->setFlashdata('pesan', 'Komik telah dikemaskini.');
        return redirect()->to($this->home);
    }

    public function delete($id)
    {
        //region delete pic in server too
        $komik = $this->komikModel->find($id);
        if ($komik['sampul'] != 'book.png') {
            unlink('img/' . $komik['sampul']);
        }
        // endregion

        $this->komikModel->delete($id);
        session()->setFlashdata('pesan', 'Komik telah dihapuskan dari rekod.');
        return redirect()->to($this->home);
    }
}
