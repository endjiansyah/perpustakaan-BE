<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function login(Request $request)
    {
        $user = User::query()
            ->where("email", $request->input("email"))
            ->first();

        // cek user berdasarkan email (availability user)
        if ($user == null) {
            return response()->json([
                "status" => false,
                "message" => "email tidak ditemukan",
                "data" => null
            ]);
        }

        // cek password
        if (!Hash::check($request->input("password"), $user->password)) {
            return response()->json([
                "status" => false,
                "message" => "password salah",
                "data" => null
            ]);
        }

        // buat token untuk authorisasi
        $token = $user->createToken("auth_token");
        return response()->json([
            "status" => true,
            "message" => "nyoh",
            "data" => [
                "auth" => [
                    "token" => $token->plainTextToken,
                    "token_type" => 'Bearer'
                ]
            ]
        ]);
    }

    function getUser(Request $request)
    {
        $user = $request->user();
        return response()->json([
            "status" => true,
            "message" => "nyoh",
            "data" => $user
        ]);
    }
}
