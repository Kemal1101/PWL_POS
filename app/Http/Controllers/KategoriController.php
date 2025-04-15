<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel;
use Illuminate\Contracts\Cache\Store;
use Illuminate\View\View;
use App\Http\Requests\StorePostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{

    public function index(){
        return view('kategori.kategori');
    }
    public function getKategoris(Request $request)
    {
        if ($request->ajax()) {
            $query = KategoriModel::all();

            return DataTables::of($query)->make(true);
        }
    }

    public function create_ajax()
    {
        return view('kategori.create_ajax');
    }
    public function store(StorePostRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated = $request->validate([
            'kategori_kode' => 'bail|required|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required',
        ]);
        KategoriModel::create($validated);
        return redirect('/kategori');
    }

    public function store_ajax(Request $request)
    {
        // Cek apakah request berupa AJAX atau ingin JSON response
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_nama' => 'required|string|min:3|max:100',
                'kategori_kode' => 'required|string|min:4|max:4',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status: false = gagal, true = berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }

            // Simpan user dengan hashing password untuk keamanan
            KategoriModel::create([
                'kategori_nama' => $request->kategori_nama,
                'kategori_kode' => $request->kategori_kode,
            ]);

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
        $kategori = KategoriModel::find($id);

        return view('kategori.edit_ajax', ['kategori' => $kategori]);
    }

    public function update_ajax(Request $request, String $id){
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_nama' => 'required|string|min:3|max:100',
                'kategori_kode' => 'required|string|min:4|max:4',
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,    // respon json, true: berhasil, false: gagal
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors()  // menunjukkan field mana yang error
                ]);
            }

            $check = KategoriModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else{
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(String $id){
        $kategori = KategoriModel::find($id);
        return view('kategori.confirm_ajax', ['kategori' => $kategori]);
    }

    public function delete_ajax(Request $request, String $id){
        $kategori = KategoriModel::find($id);
        $kategori->delete();
        if ($kategori) {
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
        return redirect('/kategori');
    }
}
