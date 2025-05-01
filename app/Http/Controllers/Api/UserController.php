<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel;

class UserController extends Controller
{
    public function index()
    {
        return UserModel::all();
    }

    public function store(Request $request)
    {
        $User = UserModel::create($request->all());
        return response()->json($User, 201);
    }

    public function show(UserModel $User)
    {
        return response()->json($User);
    }

    public function update(Request $request, UserModel $User)
    {
        $User->update($request->all());
        return response()->json($User);
    }

    public function destroy(UserModel $User)
    {
        $User->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}
