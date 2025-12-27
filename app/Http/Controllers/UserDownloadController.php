<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDownloadController extends Controller
{
    public function index()
    {
        return view('user.download');
    }
}
