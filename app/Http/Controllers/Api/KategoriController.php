<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriModel;

class KategoriController extends Controller
{
    public function index()
    {
        return KategoriModel::all();
    }

    public function store(Request $request)
    {
        $Kategori = KategoriModel::create($request->all());
        return response()->json($Kategori, 201);
    }

    public function show(KategoriModel $Kategori)
    {
        return response()->json($Kategori);
    }

    public function update(Request $request, KategoriModel $Kategori)
    {
        $Kategori->update($request->all());
        return response()->json($Kategori);
    }

    public function destroy(KategoriModel $Kategori)
    {
        $Kategori->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}
