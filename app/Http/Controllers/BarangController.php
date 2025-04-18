<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        $kategori_id = \App\Models\KategoriModel::all(); // Sesuaikan dengan model kategori Anda
        return view('barang.barang', compact('kategori_id'));
    }

    public function getBarangs(Request $request)
    {
        if ($request->ajax()) {
            $query = BarangModel::with('kategori');

            if ($request->kategori_id) {
                $query->where('kategori_id', $request->kategori_id);
            }

            return DataTables::of($query)
            ->addColumn('kategori_nama', function ($barang) {
                return $barang->kategori ? $barang->kategori->kategori_nama : '-';
            })
            ->rawColumns(['kategori_nama'])
            ->make(true);

        }
    }
    public function create_ajax()
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();

        return view('barang.create_ajax')
            ->with('kategori', $kategori);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id' => 'required|integer',
                'barang_nama' => 'required|string|min:3|max:100',
                'barang_kode' => 'required|string|min:6|max:6|unique:m_barang,barang_kode',
                'harga_beli' => 'required|integer',
                'harga_jual' => 'required|integer',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            try {
                BarangModel::create([
                    'kategori_id' => $request->kategori_id,
                    'barang_nama' => $request->barang_nama,
                    'barang_kode' => $request->barang_kode,
                    'harga_beli' => $request->harga_beli,
                    'harga_jual' => $request->harga_jual
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Data barang berhasil disimpan'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi error: ' . $e->getMessage()
                ], 500);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Request tidak valid'
        ], 400);
    }

    public function edit_ajax(String $id){
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();

        return view('barang.edit_ajax', ['barang' => $barang, 'kategori' => $kategori]);
    }

    public function update_ajax(Request $request, String $id){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id' => 'required|integer',
                'barang_nama' => 'required|string|min:3|max:100',
                'barang_kode' => 'required|string|min:6|max:6',
                'harga_beli' => 'required|integer',
                'harga_jual' => 'required|integer',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
            $check = BarangModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status'  => true,
                    'message' => 'Data barang berhasil diupdate'
                ]);
            }
        }else{
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        return redirect('/barang');
    }

    public function confirm_ajax(String $id){
        $barang = BarangModel::find($id);
        return view('barang.confirm_ajax', ['barang' => $barang]);
    }

    public function delete_ajax(Request $request, String $id){
        $barang = BarangModel::find($id);
        $barang->delete();
        if ($barang) {
            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil dihapus'
            ]);
        }else{
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        return redirect('/barang');
    }
}
