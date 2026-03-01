<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DownloadController extends Controller
{
    public function index()
    {
        return view('admin.download');
    }
}
