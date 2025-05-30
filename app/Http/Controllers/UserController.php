<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddPostRequest;
use App\Models\LevelModel;
use App\Models\UserModel;
use Dotenv\Util\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showProfile()
    {
        $user = UserModel::with('level')->find(Auth::id());

        return view('profile', compact('user'));
    }


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
                ->addColumn('id', function ($user) {
                    return $user->user_id;
                })
                ->rawColumns(['level_nama']) // Pastikan kolom bisa di-render sebagai teks
                ->make(true);
        }
    }

    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.create_ajax')
            ->with('level', $level);
    }

    public function store_ajax(Request $request)
    {
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

    public function edit_ajax(String $id){
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    public function update_ajax(Request $request, String $id){
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,'.$id.',user_id',
                'nama'     => 'required|max:100',
                'password' => 'nullable|min:6|max:20'
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

            $check = UserModel::find($id);
            if ($check) {
                if(!$request->filled('password') ){ // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('password');
                }
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
        $user = UserModel::find($id);
        return view('user.confirm_ajax', ['user' => $user]);
    }

    public function delete_ajax(Request $request, String $id){
        $user = UserModel::find($id);
        $user->delete();
        if ($user) {
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
        return redirect('/user');
    }

    public function import()
     {
         return view('user.import');
     }

     public function import_ajax(Request $request)
     {
         if($request->ajax() || $request->wantsJson()){
             $rules = [
                 // validasi file harus xls atau xlsx, max 1MB
                 'file_barang' => ['required', 'mimes:xls,xlsx', 'max:1024']
             ];

             $validator = Validator::make($request->all(), $rules);
             if($validator->fails()){
                 return response()->json([
                     'status' => false,
                     'message' => 'Validasi Gagal',
                     'msgField' => $validator->errors()
                 ]);
             }

             $file = $request->file('file_barang');  // ambil file dari request

             $reader = IOFactory::createReader('Xlsx');  // load reader file excel
             $reader->setReadDataOnly(true);             // hanya membaca data
             $spreadsheet = $reader->load($file->getRealPath()); // load file excel
             $sheet = $spreadsheet->getActiveSheet();    // ambil sheet yang aktif

             $data = $sheet->toArray(null, false, true, true);   // ambil data excel

             $insert = [];
             if(count($data) > 1){ // jika data lebih dari 1 baris
                 foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke-1 adalah header
                        $level_nama = $value['C'];

                        // Cari level_id berdasarkan level_nama
                        $level = LevelModel::where('level_nama', $level_nama)->first();

                        if ($level) {
                            $insert[] = [
                                'nama' => $value['A'],
                                'username' => $value['B'],
                                'level_id' => $level->level_id,
                                'password' => Hash::make($value['D']), // Hash password biar aman
                                'created_at' => now(),
                            ];
                        } else {
                            // Nama level tidak ditemukan
                            // Bisa ditambahkan ke array error atau log
                            Log::warning("Level '$level_nama' tidak ditemukan pada baris ke-$baris.");
                        }
                    }
                 }

                 if(count($insert) > 0){
                     // insert data ke database, jika data sudah ada, maka diabaikan
                     UserModel::insertOrIgnore($insert);
                 }

                 return response()->json([
                     'status' => true,
                     'message' => 'Data berhasil diimport'
                 ]);
             }else{
                 return response()->json([
                     'status' => false,
                     'message' => 'Tidak ada data yang diimport'
                 ]);
             }
         }
         return redirect('/');
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

    public function export_excel(){
        // ambil data User yang akan di export
        $user = UserModel::select('nama', 'username', 'level_id')
            ->orderBy('nama')
            ->with('level')
            ->get();

        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        // ambil sheet yang aktif

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Username');
        $sheet->setCellvalue('D1', 'Level');

        $sheet->getStyle('A1:D1')->getFont()->setBold(true); // bold header
        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($user as $key => $value) {
            $sheet->setCellValue('A'.$baris, $no);
            $sheet->setCellValue('B'.$baris, $value->nama);
            $sheet->setCellValue('C'.$baris, $value->username);
            $sheet->setCellValue('D'.$baris, $value->level->level_nama);
            $baris++;
            $no++;
        }
        foreach(range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        $sheet->setTitle('Data User'); // set title sheet

        $writer = IOFactory :: createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data User '.date('Y-m-d H:i:s').'.xlsx';

        header('Content-Type: application/vnd. openxmlformats-officedocument. spreadsheetml. sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header ('Cache-Control: max-age=0');
        header ('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s' ) . ' GMT' );
        header ('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf(){
        $user = UserModel :: select('level_id', 'nama','username')
            ->orderBy('nama')
            ->with('level')
            ->get();

        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('user.export_pdf', ['user' => $user]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render();

        return $pdf->stream('Data User '.date('Y-m-d H:i:s').'.pdf');
    }
}
