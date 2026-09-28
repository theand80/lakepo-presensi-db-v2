<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HariKegiatanController extends Controller
{
    //
    public function setHariKegiatan()
    {
        //
        return view('admin.kegiatan.setHariKegiatan');
    }
    public function ImportAsnYgMengikutiKegiatan()
    {
        //
        return view('admin.kegiatan.importAsnYgIkutHariKegiatan');
    }
}
