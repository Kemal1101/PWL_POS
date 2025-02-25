<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function show($name, $umur, $nim)
    {
        return view('profil', compact('name', 'umur', 'nim'));
    }
}
