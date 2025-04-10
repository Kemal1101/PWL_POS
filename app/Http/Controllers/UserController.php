<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddPostRequest;
use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $level_id = \App\Models\LevelModel::all(); // Sesuaikan dengan model level Anda
        return view('user.User', compact('level_id'));
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $query = UserModel::with('level');

            if ($request->level_id) {
                $query->where('level_id', $request->level_id);
            }

            return DataTables::of($query)
                ->addColumn('level_nama', function ($user) {
                    return $user->level ? $user->level->level_nama : '-'; // Pastikan mengakses properti level_nama
                })
                ->rawColumns(['level_nama']) // Pastikan kolom bisa di-render sebagai teks
                ->make(true);
        }
    }

    public function create_ajax(){
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.create_ajax')
                ->with('level', $level);
    }

    public function store_ajax(Request $request) {
        // Cek apakah request berupa AJAX atau ingin JSON response
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'nama' => 'required|string|max:100',
                'password' => 'required|min:6'
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
            UserModel::create([
                'level_id' => $request->level_id,
                'username' => $request->username,
                'nama' => $request->nama,
                'password' => bcrypt($request->password) // Enkripsi password
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

    public function tambah()
    {
        return view('User_Tambah');
    }

    public function tambah_simpan(UserAddPostRequest $request): RedirectResponse
    {
        dd($request->all());
        $validated = $request->validated();
        $validated['password'] = Hash::make($request->password);
        UserModel::create($validated);
        return redirect('/user');
    }

    public function ubah($id)
    {
        $user = UserModel::find($id);
        return view('User_Ubah', ['data' => $user]);
    }

    public function ubah_simpan(Request $request, $id)
    {
        $user = UserModel::find($id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make($request->password);
        $user->level_id = $request->level_id;
        $user->save();

        return redirect('/user');
    }

    public function hapus($id)
    {
        $user = UserModel::find($id);
        $user->delete();
        return redirect('/user');
    }
}
