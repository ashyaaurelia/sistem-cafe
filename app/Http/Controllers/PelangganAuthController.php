<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PelangganAuthController extends Controller
{
    // registrasi pelanggan
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nomor_hp' => 'required|string|unique:users,nomor_hp',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $pelanggan = User::create([
            'name' => $request->name,
            'username' => $request->nomor_hp,
            'nomor_hp' => $request->nomor_hp,
            'email' => null,
            'password' => $request->password,
            'role' => 'pelanggan',
            'wajib_ganti_password' => false,
        ]);

        return response()->json([
            'message' => 'Registrasi berhasil',
            'pelanggan' => $pelanggan,
        ], 201);
    }

    // login pelanggan
    public function login (Request $request)
    {
        $request->validate([
            'nomor_hp' => 'required|string',
            'password' => 'required|string',
        ]);

        $pelanggan = User::where('nomor_hp', $request->nomor_hp)->where('role', 'pelanggan')->first();

        if(!$pelanggan || !Hash::check($request->password, $pelanggan->password)){
            return response()->json([
                'message' => 'Nomor HP atau password salah',
            ], 401);
        }

        $token = $pelanggan->createToken('token-pelanggan')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'wajib_ganti_password' => $pelanggan->wajib_ganti_password,
            'pelanggan' => $pelanggan,
        ]);
    }

    // logout pelanggan
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil',
        ]);
    }

    // ganti password pelanggan
    public function gantiPassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|string|min:8|confirmed',
        ]);

        $pelanggan = $request->user();

        if(!Hash::check($request->password_lama, $pelanggan->password)){
            return response()->json([
                'message' => 'Password lama salah',
            ], 400);
        }

        $pelanggan->update([
            'password' => $request->password_baru,
            'wajib_ganti_password' => false,
        ]);

        return response()->json([
            'message' => 'Password berhasil diganti',
        ]);
    }
}