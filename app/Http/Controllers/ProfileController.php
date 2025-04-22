<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $username = $user->username;
        $destinationPath = public_path('usersphoto');
        $filename = $username . '.png';
        $fullPath = $destinationPath . '/' . $filename;

        // Hapus file lama jika ada
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }

        // Simpan file baru
        $photo = $request->file('photo');
        $photo->move($destinationPath, $filename);

        return redirect('/profile');
    }

}
