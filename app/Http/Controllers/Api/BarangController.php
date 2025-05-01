<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangModel;
class BarangController extends Controller
{
    public function index()
    {
        return BarangModel::all();
    }

    public function store(Request $request)
    {
        $Barang = BarangModel::create($request->all());
        return response()->json($Barang, 201);
    }

    public function show(BarangModel $Barang)
    {
        return response()->json($Barang);
    }

    public function update(Request $request, BarangModel $Barang)
    {
        $Barang->update($request->all());
        return response()->json($Barang);
    }

    public function destroy(BarangModel $Barang)
    {
        $Barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}
